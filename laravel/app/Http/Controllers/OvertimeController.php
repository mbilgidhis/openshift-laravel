<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Overtime;
use App\OvertimeDetail;
use App\User;

use App\Http\Requests\OvertimeClaimCreateRequest;

use Carbon\Carbon;
use DB;

class OvertimeController extends Controller
{
    public function __construct() {

    }

    /**
     * Overtime
     */
    public function index(Request $request) {
    	$data = array();
        $owner = null;
    	if( $request->user()->hasRole(['admin', 'super admin', 'manager'])) {
            if( $request->query('owner') ) {
                if( $request->query('owner') ) {
                    $owner = $this->checkOwner($request->query('owner'));
                }
            }

            if( $owner != null )
                $overtimes = Overtime::with('owner')->where('user_id', $owner)->paginate(10);
            else
        		$overtimes = Overtime::with('owner')->paginate(10);
    	} else if( $request->user()->hasRole('staff') ){
    		$overtimes = Overtime::with('owner')->where('user_id', $request->user()->id)->paginate(10);
    	} else {
    		$overtimes = Overtime::whereNull('id')->paginate(10);
    	}

    	$data['overtimes'] = $overtimes;
        $data['users'] = User::get();
        $data['owner'] = $owner;
    	return view('partials.overtime.index', $data);
    }

    public function claim(Request $request) {
        $data = array();
        $data['overtimes'] = OvertimeDetail::where('user_id', $request->user()->id)->where('claimed', 0)->get();
        return view('partials.overtime.claim', $data);
    }

    public function createClaim(OvertimeClaimCreateRequest $request) {
        $claim = new Overtime;
        $claim->period = Carbon::create($request->period);
        $claim->user_id = $request->user()->id;
        $claim->created_by = $request->user()->id;

        if( $claim->save() ) {
            $details = OvertimeDetail::whereIn('id', $request->id)->update(['overtime_id' => $claim->id, 'claimed' => 1]);
            return redirect()->route('overtime.show', $claim->id)->with('success', 'Successfully created new claim.');
        } else {
            return redirect()->route('overtime.create')->with('fail', 'Failed to create new claim.');
        }
    }

    public function showClaim(Request $request, $id) {
        return Overtime::with('details', 'owner')->findOrFail($id);
    }

    /**
     * Unclaimed Controller Below
     */
    public function unclaimedIndex(Request $request) {
    	$data = array();
        $owner = null;
    	if( $request->user()->hasRole(['admin', 'super admin', 'manager'])) {
            if( $request->query('owner') ) {
                $owner = $this->checkOwner($request->query('owner'));
            }

            if( $owner != null )
                $overtimes = OvertimeDetail::with('owner')->where('user_id', $owner )->where('claimed', 0)->paginate(10);
            else
    		  $overtimes = OvertimeDetail::with('owner')->where('claimed', 0)->paginate(10);
    	} else if( $request->user()->hasRole('staff') ){
    		$overtimes = OvertimeDetail::with('owner')->where('user_id', $request->user()->id)->where('claimed', 0)->paginate(10);
    	} else {
    		$overtimes = OvertimeDetail::whereNull('id')->where('claimed', 0)->paginate(10);
    	}

    	$data['overtimes'] = $overtimes;
    	$data['users'] = User::get();
        $data['owner'] = $owner;
    	return view('partials.overtime.unclaimed.index', $data);
    }

    protected function checkOwner( $owner ) {
        if( is_numeric($owner) ) {
            if( $owner > 0 ) {
                return (int)$owner;
            } else {
                abort(403);
            }
        }
        return null;
    }

}
