<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Str;

use Validator;

class PermissionManagementController extends Controller
{
	protected $default = [];

    public function __construct() {
    	$default = array();
    	for( $x = 1; $x <= 28; $x++ ) {
    		array_push($default, $x);
    	}
    	$this->default = $default;
    }

    public function index(Request $request) {
    	$data = array();
    	$data['permissions'] = Permission::paginate(10);
    	$data['default'] = $this->default;
    	return view('partials.permission-management.index', $data);
    }

    public function create(Request $request) {
    	return view('partials.permission-management.create');
    }

    public function insert(Request $request) {
    	$validator = Validator::make($request->all(), [
    	            'name' => 'required|string|unique:permissions'
    	        ]);

    	if ( $validator->fails() )
    	    return redirect(route('permission-management.index'))->withErrors($validator);

    	$permission = new Permission;
    	$permission->name = Str::snake(strtolower($request->name));
    	$permission->guard_name = 'web';

    	if( $permission->save() ) {
    		$role = Role::find(1);
    		$role->givePermissionTo($permission);
    		return redirect(route('permission-management.show', $permission->id))->with('success', 'Successfully created permission.');
    	}
    }

    public function show(Request $request, $id) {
    	$data = array();
    	$data['roles'] = Role::get();
    	$data['permission'] = Permission::findOrFail($id);

    	return view('partials.permission-management.show', $data);
    }

    public function update(Request $request) {
    	$validator = Validator::make($request->all(), [
    	            'id' => 'required|integer'
    	        ]);

    	if ( $validator->fails() )
    	    return redirect(route('permission-management.show', $request->id))->withErrors($validator);

    	$permission = Permission::findOrFail($request->id);

    	$roles = [];
    	foreach ($request->all() as $key => $value) {
    	    if( stristr($key, 'roles_') ) {
    	        $role = explode('_', $key);
    	        array_push($roles, $role[1]);
    	    }
    	}

    	if( $permission->syncRoles($roles) ) {
    		return redirect()->back()->with('success', 'Successfully updated permission.');
    	}
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
                    'id' => 'required|integer'
                ]);

        if ($validator->fails())
            return redirect(route('permission-management.index'))->withErrors($validator);

        if( in_array($request->id, $this->default) )
            return redirect(route('permission-management.index'))->with('fail', 'Can not delete default permission.');

        $permission = Permission::findOrFail($request->id);

        if( $permission->delete() )
            return redirect(route('permission-management.index'))->with('success', 'Successfully deleted permission.');
    }
}
