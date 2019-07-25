<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Validator;

class RoleManagementController extends Controller
{
    public function __construct() {

    }

    public function index(Request $request) {
    	$data = array();
    	$data['roles'] = Role::paginate(10);
    	return view('partials.role-management.index', $data);
    }

    public function create(Request $request) {
    	return view('partials.role-management.create');
    }

    public function insert(Request $request) {
    	$validator = Validator::make($request->all(), [
    	            'name' => 'required|string|unique:roles'
    	        ]);

    	if ( $validator->fails() )
    	    return redirect(route('role-management.index'))->withErrors($validator);

    	$role = new Role;
    	$role->name = strtolower($request->name);
    	$role->guard_name = 'web';

    	if( $role->save() ) {
    		return redirect(route('role-management.show', $role->id))->with('success', 'Successfully created role.');
    	}
    }

    public function show(Request $request, $id) {
    	$data = array();
    	if ( $id == 1 )
    		return abort(403);
    	$data['role'] = Role::findOrFail($id);
    	$data['permissions'] = Permission::get();

    	return view('partials.role-management.show', $data);
    }

    public function update(Request $request) {
    	$validator = Validator::make($request->all(), [
    	            'id' => 'required|integer'
    	        ]);

    	if ( $validator->fails() )
    	    return redirect(route('role-management.show', $request->id))->withErrors($validator);

    	if( $request->id == 1 )
    	    return redirect(route('role-management.show', $request->id))->with('fail', 'Can not update super admin.');

    	$role = Role::findOrFail($request->id);

    	$permissions = [];
    	foreach ($request->all() as $key => $value) {
    	    if( stristr($key, 'permissions_') ) {
    	        $permission = explode('_', $key);
    	        array_push($permissions, $permission[1]);
    	    }
    	}

    	if( $role->syncPermissions($permissions) ) {
    		return redirect()->back()->with('success', 'Successfully updated role.');
    	}
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
                    'id' => 'required|integer'
                ]);

        if ($validator->fails())
            return redirect(route('role-management.index'))->withErrors($validator);

        if( in_array($request->id, array(1,2,3,4)) )
            return redirect(route('role-management.index'))->with('fail', 'Can not delete default role.');

        $role = Role::findOrFail($request->id);

        if( $role->delete() )
            return redirect(route('role-management.index'))->with('success', 'Successfully deleted role.');
    }
}
