<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Templates;

class TemplatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $project_id)
    {
        $templates = Templates::where('id', $project_id)->get();

        return view('templates.index',compact(['templates', 'project_id']));
    }
    
    public function create(Request $request, $project_id) 
    {
        return view('templates.create',compact(['project_id']));
    }

    public function store(Request $request, $project_id)
    {

        $validator = Validator::make($request->all(), [
            'project_id' => 'numeric|string',
            'template_name' => 'required|string',
            'content' => 'required|string'
        ]);
        
        if ($validator->fails()) {
            return redirect()->with('msg', 'Validation Failed');   
        }

        Templates::create([
            'project_id' => $project_id,
            'template_name' => $request->template_name,
            'content' => htmlentities($request->content)
        ]);
    
        return redirect('/projects/overview/' . $project_id); 
    }

    public function edit(Request $request, $id) 
    {
        
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|string',
        ]);

        if ($validator->fails()) {
            return redirect()->with('msg', 'Validation Failed');   
        }

        $projectId = Templates::find($id)->project_id;
        $userId = Projects::find($projectId)->user_id;
        
        if (Auth::user()->id != $userId) {
            return redirect()->with('msg', 'Not Allowed!');
        }
        
        $template = Templates::find($id);
        $template->content = html_entity_decode($template->content);
        
        return view('templates.edit', compact(['template']));

    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'numeric|string',
            'template_name' => 'required|string',
            'content' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->with('msg', 'Validation Failed');   
        }
        
        $projectId = Templates::find($id)->project_id;
        $userId = Projects::find($projectId)->user_id;
        
        if (Auth::user()->id != $userId) {
            return redirect()->with('msg', 'Not Allowed!');
        }

        Templates::whereId($id)->update([
            'template_name' => $request->template_name,
            'content' => $request->content
        ]);
    
        return redirect('/projects')->with('msg', 'Template Edited');
    }
    
}
