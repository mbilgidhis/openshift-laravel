<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;
use App\Actual;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChangePassword;
use Validator;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set('Asia/Jakarta');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $start = ( $request->query('start') ) ? $request->query('start') : null;
        $end   = ( $request->query('end') ) ? $request->query('end') : null;
        $day = Carbon::now();
        $limit = $day->format('Y-m-d');

        $starting = $day->subDays(14);
        $now = $day->format('c');

        if ( $request->user()->hasPermissionTo('view_dashboard_all') ) {
            // Plan based on end date 
            $plans = Plan::with('user')
                            ->where('end', '>=', $limit)
                            ->get();

            $outdated = Plan::with('user')
                            ->where('end', '<', $limit)
                            ->doesnthave('actuals', 'or')
                            ->get();
        } else if( $request->user()->hasPermissionTo('view_dashboard_staff') ) {      
            $plans = Plan::where('end', '>=', $limit)
                            ->where('user_id', $request->user()->id)
                            ->orWhere('created_by', $request->user()->id)
                            ->get();

            $outdated = Plan::where('end', '<', $limit)
                        ->where(function($query) use($request) {
                            $query->where('user_id', $request->user()->id);
                            $query->orWhere('created_by', $request->user()->id);
                        })
                         ->doesnthave('actuals', 'or')
                         ->get();
        } else {
            $plans = Plan::whereNull('id')->get();
            $actuals = Actual::whereNull('id')->get();
            $outdated = Plan::whereNull('id')->get();
        }
        
        $jabatan = getJabatan($request);

        return view('home', [
                'plans' => $plans,
                // 'actuals' => $actuals,
                'outdated' => $outdated,
                'jabatan' => $jabatan,
                'start' => $start,
                'end' => $end,
                'now' => $now,
        ]);
    }

    public function profile(Request $request) {
        $data = array();
        $data['user'] = \App\User::with('information')->findOrFail($request->user()->id);
        return view('profile', $data);
    }

    public function changePassword(ChangePassword $request) {
        $user = \App\User::find(Auth::id());
        $hashedPassword = $user->password;

        if (Hash::check($request->current, $hashedPassword)) {
            //Change the password
            $user->fill([
                'password' => Hash::make($request->password),
                'updated_by' => Auth::id(),
            ])->save();
    
            return redirect()->back()->with('success', 'Password has been updated.');
        }
        return redirect()->back()->with('fail','Your current password is wrong.');
    }

    public function updateProfile(Request $request) {
        $validator = Validator::make($request->all(), [
                    'phone' => 'nullable|string',
                    'address' => 'nullable|string',
                ]);

        if ($validator->fails())
            return redirect(route('profile'))->withErrors($validator);

        $user = \App\User::findOrFail(Auth::id());

        $update = array(
                'phone' => $request->phone,
                'address' => $request->address
            );

        if( $user->information()->update($update) )
            return redirect()->back()->with('success', 'Succesfully updated profile.');
    }

    public function example() {
        return view('example');
    }
}
