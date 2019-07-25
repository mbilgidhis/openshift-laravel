<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Project;
use Validator;

class ProjectController extends Controller
{
    public function __construct() {}

    public function index(Request $request) {
    	$data = array();
    	$data['projects'] = \App\Project::paginate(10);

    	return view('partials.project.index', $data);
    }

    public function show(Request $request, $id) {
    	$data = array();
    	$data['project'] = Project::findOrFail($id);
    	return view('partials.project.show', $data);
    }

    public function create(Request $request) {
    	return view('partials.project.create');
    }

    public function store(ProjectRequest $request) {
    	$project = new Project();

    	$project->name = $request->name;
    	$project->project_code = $request->code;
        $project->pm_sales = $request->pmsales;
    	$project->description = $request->description;
    	$project->created_by = $request->user()->id;

    	if( $project->save() )
    		return redirect(route('project.show', $project->id))->with('success', 'Successfully created project.');
    }

    public function update(ProjectRequest $request) {
    	$project = Project::findOrFail($request->id);

    	$project->name = $request->name;
    	$project->description = $request->description;
    	$project->project_code = $request->code;
        $project->pm_sales = $request->pmsales;
    	$project->updated_by = $request->user()->id;

    	if( $project->save() ) 
    		return redirect(route('project.show', $project->id))->with('success', 'Successfully updated project.');
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
                    'id' => 'required|integer'
                ]);

        if ($validator->fails())
            return redirect(route('project.index'))->withErrors($validator);

        $project = Project::findOrFail($request->input('id'));
        $project->deleted_by  = $request->user()->id;
        $project->save();

        if( $project->delete() )
            return redirect(route('project.index'))->with('success', 'Successfully deleted project.');
    }
}
