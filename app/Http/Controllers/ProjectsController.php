<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Projects;
use App\Models\Templates;
use App\Models\User;
use App\Models\UserEmailConfig;

class ProjectsController extends Controller
{

    protected $projects;
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $projects = Projects::where('user_id', Auth::user()->id)->get();
        $emailMethods = UserEmailConfig::where('user_id', Auth::user()->id)->get();

        $user = User::where('email', Auth::user()->email)->firstOrFail();
        // Za slucaj da vam potreba bearer token za testiranje. :)
        //$token = $user->createToken('auth_token')->plainTextToken; dd($token);

        return view('projects.index',compact(['projects', 'emailMethods']));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'project_name' => 'required|string',
            'user_emails_config_id' => 'required|numeric|string',
            'webhook_url' => 'url|nullable'
        ]);

        if ($validator->fails()) {
            return redirect('/projects')->with('msg', 'Validation Failed');   
        }

        Projects::create([
            'user_id' => Auth::user()->id,
            'project_name' => $request->project_name,
            'user_emails_config_id' => $request->user_emails_config_id,
            'webhook_url' => $request->webhook_url
        ]);
    
        return redirect('/projects')->with('msg', 'Project Created');
    }

    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'id' => 'numeric|requred',
            'project_name' => 'string|required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->with('msg', 'Validation Failed');   
        }

        $project = Projects::find($id);
        $project->project_name = $request->project_name;
        $project->save();

        return redirect('/projects')->with('msg', 'Project Updated');
    }

    public function edit(Request $request, $id) 
    {
        return view('projects.edit',compact('id'));
    }

    public function overview(Request $request, $id) 
    {

        $project = Projects::find($id);
        
        $templates = Templates::where('project_id', $project->id)->get();

        return view('projects.overview',compact(['id', 'project', 'templates']));
    }
}
