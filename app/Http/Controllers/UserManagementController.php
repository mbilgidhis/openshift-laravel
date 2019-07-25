<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\CreateUser;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreated;
use Carbon\Carbon;
use App\Imports\UsersImport;
use App\Http\Requests\ImportUser;

class UserManagementController extends Controller
{
    public function __construct() {
    	 $this->middleware(['permission:user_management']);
    }

    public function index(Request $request) {
    	$data = array();
    	$data['users'] = \App\User::with('department')
    							->paginate(10);
    	return view('partials.user-management.index', $data );
    }

    public function create(Request $request) {
        $data = array();
        $data['departments'] = \App\Department::get();
        $data['teams'] = \App\Team::get();
        $data['roles'] = \Spatie\Permission\Models\Role::all();
        return view('partials.user-management.create', $data);
    }

    public function insert(CreateUser $request) {
        DB::beginTransaction();
        $random = Str::random(10);
        $user = new \App\User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($random);
        $user->department_id = $request->department_id;
        $user->team_id = $request->team_id;
        $user->created_by = $request->user()->id;
        $user->email_verified_at = Carbon::now();
        if( $request->filled('leader') )
            $user->is_leader = 1;
        else
            $user->is_leader = 0;
        
        if( !$user->save() ) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Fail to create new user.');
        }

        if( !$user->assignRole($request->role) ) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Fail to create new user.');
        }

        $information = new \App\UserInformation(['phone' => null, 'address' => null, 'created_by' => $request->user()->id ]);
        $user->information()->save($information);
        
        DB::commit();

        $data = array();
        $data['password'] = $random;

        Mail::to($user)->send(new UserCreated($data));

        return redirect(route('user-management.edit', $user->id))->with('success', 'Successfully created new user.');
    }

    public function edit(Request $request, $id) {
    	$data = array();
    	$data['user'] = \App\User::findOrFail($id);
    	$data['departments'] = \App\Department::get();
        $data['teams'] = \App\Team::get();
		$data['roles'] = \Spatie\Permission\Models\Role::get();
		$data['permissions'] = \Spatie\Permission\Models\Permission::get();

    	return view('partials.user-management.edit', $data);
    }

    public function update(UpdateUser $request){
        // return $request->all()
    	DB::beginTransaction();
    	$user = \App\User::findOrFail($request->id);
		$user->name          = $request->name;
		if( $request->filled('password') )
			$user->password      = Hash::make($request->password);
		$user->department_id = $request->department_id;
		$user->updated_by    = $request->user()->id;
        $user->team_id = $request->team_id;

        if( $request->filled('leader') )
            $user->is_leader = 1;
        else
            $user->is_leader = 0;

		if( !$user->save() ) {
			DB::rollBack();
			return redirect()->back()->with('fail', 'Fail updated user.');
		}

        if( !$user->syncRoles($request->input('role')) ) {
            DB::rollback();
            return redirect()->back()->with('fail', 'Fail updated user.');
        }

        if( $request->filled('mod_perm') ) {
    		$permissions = [];
    		foreach ($request->all() as $key => $value) {
    		    if( stristr($key, 'permissions_') ) {
    		        $permission = explode('_', $key);
    		        array_push($permissions, $permission[1]);
    		    }
    		}

    		if( !$user->syncPermissions($permissions) ) {
    			DB::rollBack();
    			return redirect()->back()->with('fail', 'Fail updated user.');
    		}
        }

		DB::commit();
    	return redirect()->back()->with('success', 'Successfully updated user.');
    }

    public function setStatus(Request $request) {
    	$validator = Validator::make($request->all(), [
    				'id' => 'required|integer',
    	            'status' => 'required|integer'
    	        ]);

    	if ($validator->fails())
    	    return redirect(route('user-management.index'))->withErrors($validator);

        if( $request->id == 1 )
            return redirect(route('user-management.index'))->with('fail', 'Can not disable super admin.');

    	$user = \App\User::findOrFail($request->id);
    	$user->active = $request->status;
    	$user->updated_by = $request->user()->id;

    	if( $user->save() ){
    		return redirect(route('user-management.index'))->with('success', 'Successfully updated user.');
    	}
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
                    'id' => 'required|integer'
                ]);

        if ($validator->fails())
            return redirect(route('user-management.index'))->withErrors($validator);

        if( $request->id == 1 )
            return redirect(route('user-management.index'))->with('fail', 'Can not delete super admin.');

        $user = \App\User::findOrFail($request->id);
        $user->deleted_by = $request->user()->id;
        $user->save();

        if( $user->delete() )
            return redirect(route('user-management.index'))->with('success', 'Successfully deleted user.');
    }

    public function import(Request $request) {
        $data = array();
        $data['departments'] = \App\Department::get();
        $data['teams']       = \App\Team::get();
        $data['roles']       = \Spatie\Permission\Models\Role::get();
        return view('partials.user-management.import', $data);
    }

    public function process(ImportUser $request) {
        try {
            $users = (new UsersImport)->toArray($request->file('file'));
        } catch (\Exception $e) {
            return redirect(route('user-management.import'))->with('fail', 'Failed to parse file');
        }
        $password = $request->password;
        // it uses index 0 because of the sheet
        foreach ($users[0] as $user) {
            DB::beginTransaction();
            $insert = new \App\User();
            $insert->name              = $user['name'];
            $insert->email             = $user['email'];
            $insert->email_verified_at = Carbon::now();
            $insert->created_by        = $request->user()->id;
            $insert->password          = Hash::make($request->password);
            $insert->department_id     = $request->department;
            $insert->team_id           = $request->team;

            if( !$insert->save() ) {
                DB::rollBack();
                return redirect()->back()->with('fail', 'Fail to import new user.');
            }

            if( !$insert->assignRole($request->role) ) {
                DB::rollBack();
                return redirect()->back()->with('fail', 'Fail to import new user.');
            }

            $information = new \App\UserInformation(['phone' => $user['phone'], 'address' => $user['address'], 'created_by' => $request->user()->id ]);

            $insert->information()->save($information);
            
            DB::commit();

            $data = array();
            $toUser = \App\User::find($insert->id);
            $data['password'] = $password;

            Mail::to($toUser)->send(new UserCreated($data));
        }
        return redirect(route('user-management.index'))->with('success', 'Successfully imported user.');
    }

    public function downloadExample(Request $request) {
        $file = storage_path('example.xlsx');

        return response()->download($file, 'example.xlsx');
    }
}
