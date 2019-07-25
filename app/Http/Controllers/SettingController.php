<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Config;
use App\Holiday;

use App\Http\Requests\ConfigRequest;
use App\Http\Requests\HolidayCreateRequest;
use App\Http\Requests\HolidayUpdateRequest;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Validator;

class SettingController extends Controller
{
    /**
     * Sorry for inconcistencey with the model and controller name Lol. This controller is for config Model
     */
    
    public function __construct() {

    }

    public function index(Request $request) {
    	$data = array();
		$data['important'] = Config::getConfig('color.important')->first();
		$data['completed'] = Config::getConfig('color.completed')->first();
		$data['ongoing']   = Config::getConfig('color.ongoing')->first();
		$data['pending']   = Config::getConfig('color.pending')->first();
		$data['failed']    = Config::getConfig('color.failed')->first();
		$data['wstart']    = Config::getConfig('working.start')->first();
		$data['wend']      = Config::getConfig('working.end')->first();
        $data['overtime']  = Config::getConfig('overtime.start')->first();

    	return view('partials.setting.index', $data);
    }

    public function update(ConfigRequest $request) {
    	$config = new Config();

    	( $request->filled('important') ) ? $config->where('name', 'color.important')->update([ 'value' => $request->important]) : null; 
    	( $request->filled('completed') ) ? $config->where('name', 'color.completed')->update([ 'value' => $request->completed]) : null; 
    	( $request->filled('ongoing') ) ? $config->where('name', 'color.ongoing')->update([ 'value' => $request->ongoing]) : null; 
    	( $request->filled('pending') ) ? $config->where('name', 'color.pending')->update([ 'value' => $request->pending]) : null; 
    	( $request->filled('failed') ) ? $config->where('name', 'color.failed')->update([ 'value' => $request->failed]) : null; 
    	( $request->filled('start') ) ? $config->where('name', 'working.start')->update([ 'value' => $request->start]) : null; 
    	( $request->filled('end') ) ? $config->where('name', 'working.end')->update([ 'value' => $request->end]) : null; 
        ( $request->filled('overtime') ) ? $config->where('name', 'overtime.start')->update([ 'value' => $request->overtime]) : null; 

    	return redirect(route('setting.index'))->with('success', 'Successfully updated setting');
    }

    public function holiday(Request $request) {
        $data = array();
        $data['holidays'] = Holiday::whereYear('start', date('Y'))->orderBy('start', 'asc')->paginate(10);
        
        return view('partials.setting.holiday.index', $data);
    }

    public function create(Request $request) {
        return view('partials.setting.holiday.create');
    }

    public function insert(HolidayCreateRequest $request) {
        $holiday = new Holiday;

        $holiday->name = $request->name;
        $holiday->start = $request->date;
        $holiday->end = Carbon::create("$request->date")->addDay()->format('Y-m-d');
        $holiday->status = 'manual';
        $holiday->google_event_id = Str::random(20);

        if( $holiday->save() ) {
            return redirect(route('setting.holiday.index'))->with('success', 'Successfully created holiday.');
        }
    }

    public function show(Request $request, $id) {
        $data = array();

        $data['holiday'] = Holiday::findOrFail($id);
        return view('partials.setting.holiday.show', $data);
    }

    public function updateHoliday(HolidayUpdateRequest $request) {
        $holiday = Holiday::findOrFail($request->id);

        $holiday->name = $request->name;
        $holiday->start = $request->date;
        $holiday->end = Carbon::create("$request->date")->addDay()->format('Y-m-d');

        if( $holiday->save() ) {
            return redirect(route('setting.holiday.index'))->with('success', 'Successfully deleted holiday.');
        }
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
                    'id' => 'required|integer'
                ]);

        if ($validator->fails())
            return redirect(route('setting.holiday.index'))->withErrors($validator);

        $holiday = Holiday::findOrFail($request->id);

        if( $holiday->delete() )
            return redirect(route('setting.holiday.index'))->with('success', 'Successfully deleted actual.');
    }
}
