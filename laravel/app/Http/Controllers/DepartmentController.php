<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DepartmentRequest;
use App\Department;
use Validator;

class DepartmentController extends Controller
{
	public function __construct() {}
	
    public function index(Request $request)
    {
    	$data = array();
    	$data['departments'] = Department::paginate(10);

        return view('partials.department.index', $data);
    }

    public function create(Request $request) {
    	return view('partials.department.create');
    }

    public function store(DepartmentRequest $request) {
		$department              = new Department();
		$department->name        = $request->name;
		$department->description = $request->description;
        $department->created_by  = $request->user()->id;

    	if( $department->save() )
    		return redirect(route('department.show', $department->id))->with('success', 'Successfully created new department.');
    }

    public function show(Request $request, $id) {
    	$data = array();
    	$data['department'] = Department::findOrFail($id);
    	return view('partials.department.show', $data);
    }

    public function update(DepartmentRequest $request) {
    	$department = Department::findOrFail($request->id);
    	$department->name = $request->name;
    	$department->description = $request->description;
        $department->updated_by  = $request->user()->id;

    	if( $department->save() )
    		return redirect(route('department.show', $department->id))->with('success', 'Successfully updated department.');
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
                    'id' => 'required|integer'
                ]);

        if ($validator->fails())
            return redirect(route('department.index'))->withErrors($validator);

        $department = Department::findOrFail($request->input('id'));
        $department->deleted_by  = $request->user()->id;
        $department->save();

        if( $department->delete() )
            return redirect(route('department.index'))->with('success', 'Successfully deleted department.');
    }
}
