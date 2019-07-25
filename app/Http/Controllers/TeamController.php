<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Department;
use App\Http\Requests\TeamCreateRequest;
use App\Http\Requests\TeamUpdateRequest;
use Validator;

class TeamController extends Controller
{
    public function __construct() {

    }

    public function index(Request $request) {
    	$data = array();
    	$data['teams'] = Team::with('department')->paginate(10);

    	return view('partials.team.index', $data);
    }

    public function show(Request $request, $id) {
    	$data = array();
    	$data['team'] = Team::findOrFail($id);
        $data['departments']  = Department::get();
    	return view('partials.team.show', $data);
    }

    public function create() {
        $data = array();
        $data['departments']  = Department::get();
    	return view('partials.team.create', $data);
    }

    public function store(TeamCreateRequest $request) {
    	$team = new Team();

    	$team->name             = $request->name;
        $team->description      = $request->description;
        $team->department_id    = $request->department_id;

    	$team->created_by       = $request->user()->id;

    	if( $team->save() )
    		return redirect(route('team.show', $team->id))->with('success', 'Successfully created team.');
    }
    
    public function update(TeamUpdateRequest $request) {

    	$team = Team::findOrFail($request->id);

        $team->name             = $request->name;
        $team->description      = $request->description;
        $team->department_id    = $request->department_id;
        
    	$team->updated_by       = $request->user()->id;

    	if( $team->save() ) 
    		return redirect(route('team.show', $team->id))->with('success', 'Successfully updated team.');
    }

    public function delete(Request $request) {

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        if ($validator->fails())
            return redirect(route('team.index'))->withErrors($validator);

        $team = Team::findOrFail($request->input('id'));
        $team->deleted_by  = $request->user()->id;
        $team->save();

        if( $team->delete() )
            return redirect(route('team.index'))->with('success', 'Successfully deleted team.');
    }
}
