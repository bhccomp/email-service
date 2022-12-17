<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserEmailConfig;
use App\Models\Projects;
use App\Models\Templates;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendEmailJob;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Log;
use App\Mail\EmailWithQueue;
use Config;

class UserEmailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('emails.index');
    }

    public function send(Request $request)
    {   

        $validator = Validator::make($request->all(), [
            'to' => 'required|regex:/(.+)@(.+)\.(.+)/i', 
            'subject' => 'required|string',
            'template_id' => 'required|string'
        ]);

        if ( $validator->fails() ) {    
            return response()->json([
                'error' => 'Please, provide valid parameters.',
            ], 422); 
        }

        dd(Auth::user()->email);

        $project = Projects::where('user_id', Auth::user()->id);
        $count = $project->count();
        
        if ($count < 1) {
            return response()->json([
                'error' => 'No projects available. Create and configure the project through UI and try again.'
            ], 404);            
        }

        $projectId = Templates::find($request->template_id)->project_id;
        $userId = Projects::find($projectId)->user_id;
        $webhookUrl = Projects::find($projectId)->webhook_url;

        if (Auth::user()->id != $userId) {
            return response()->json([
                'error' => 'Access not allowed'
            ], 403);            
        }

        $mail = UserEmailConfig::configuredEmail(Projects::find($projectId)->user_emails_config_id)->first();

        if (isset($mail->id)) {  

            $config = array(
                'driver'        => "SMTP",#$mail->driver,
                'transport'     => "SMTP",#$mail->driver,
                'host'          => $mail->host,
                'port'          => $mail->port,
                'name'          => $mail->name,
                'address'       => $mail->address,
                'from'          => $mail->name,
                'encryption'    => $mail->encryption,
                'username'      => $mail->username,
                'password'      => $mail->password,
                'project_id'    => $projectId,
                'webhook_url'   => $webhookUrl
            );
            Config::set('mail', $config); 
            
        }
        
        if (empty($config)) {
            return response()->json([
                'error' => 'internal error'
            ], 403);
        }

        $config['subject'] = $request->subject;
        $config['content'] = Templates::find($request->template_id)->content;

        $mail = new SendMail($config);
        Mail::to($request->to)->queue($mail);

        return response()->json([
            'success' => 'completed'
        ], 200);

    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'account_name' => 'required|string',
            'from_address' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'smtp_hostname' => 'required|string',
            'smtp_port' => 'required|numeric',
            'encryption_type' => 'required|string',
            'smtp_username' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'smtp_password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->with('msg', 'Validation Failed');   
        }

        UserEmailConfig::create([
            'name' => $request->account_name,
            'address' => $request->from_address,
            'driver' => 'smtp',
            'host' => $request->smtp_hostname,
            'port' => $request->smtp_port,
            'encryption' => $request->encryption_type,
            'username' => $request->smtp_username,
            'password' => $request->smtp_password,
            'user_id' => Auth::user()->id
            
        ]);
    
        return redirect('/projects')->with('msg', 'Email Method Created');
    }
}
