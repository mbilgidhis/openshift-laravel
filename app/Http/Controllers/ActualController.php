<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ActualRequest;
use App\Http\Requests\ActualCreateRequest;
use App\Http\Requests\ActualUpdateRequest;
use App\Actual;
use App\Plan;
use App\OvertimeDetail;
use App\Overtime;
use App\Config;
use App\Holiday;
use Carbon\Carbon;
use App\ActualCategory;
use Illuminate\Support\Str;
use Validator;

class ActualController extends Controller
{
    protected $overtime, $wstart, $wend;

    public function __construct() {
        date_default_timezone_set("Asia/Jakarta");
        $overtime = Config::getConfig('overtime.start')->first();
        $wstart   = Config::getConfig('working.start')->first();
        $wend     = Config::getConfig('working.end')->first();
        $this->overtime = $overtime->value;
        $this->wstart   = $wstart->value;
        $this->wend     = $wend->value;
    }

    public function create(Request $request, $plan_id)
    {
        $plan = Plan::find($plan_id);
        return view('partials.actual.form', [
            'plan' => $plan
        ]);
    }

    public function form(Request $request, $id) {
        $data = array();
        $data['plan'] = Plan::with('project')->findOrFail($id);
        $data['categories'] = ActualCategory::get();

        return view('partials.actual.form', $data);
    }

    public function store(ActualCreateRequest $request, $id) 
    {
        $plan = Plan::findOrFail($id);

        $actual = new Actual;
        $actual->title              = $request->title;
        $actual->description        = $request->description;
        // we need to validate the date
        $actual->actual_date_start  = date('Y-m-d H:i:s', strtotime("$request->actual_date $request->start"));
        $actual->actual_date_end    = date('Y-m-d H:i:s', strtotime("$request->actual_date $request->end"));
        $actual->code               = Str::random(10);
        $actual->color              = $plan->color;
        $actual->site               = ( $request->filled('site') ) ? $request->site : null;
        if( $plan->project )
            $actual->pm_sales           = ( $request->filled('pmsales') ) ? $request->pmsales : $plan->project->pm_sales; 
        $actual->actual_category_id = $request->category;
        $actual->plan_id            = $request->plan;
        $actual->project_id         = $plan->project_id;
        $actual->user_id            = $plan->user_id;
        $actual->created_by         = $request->user()->id;

        if($actual->save()) {
            // Calculate overtime
            $overtimeHours = 0;

            if( $this->checkDay($request) == 'Offday' ) {
                $overtimeHours = (float) $this->onlyOffday($request, $actual) + $overtimeHours;
            } else {
                if ( $request->start < $this->wstart ) {
                    $overtimeHours = (float)$this->beforeWork($request, $actual) + $overtimeHours;
                }

                if( $request->end > $this->overtime ) {
                    $overtimeHours =  (float)$this->afterWork($request, $actual) + $overtimeHours;
                }
            }

            $actual->overtime = $overtimeHours;
            $actual->save();
            return redirect()->route('plan.show', $plan->id)->with('success', 'Successfully added new actual.');
        }

    }

    public function show(Request $request, $id, $act) {
        $data = array();
        $data['plan'] = Plan::findOrFail($id);
        $data['categories'] = ActualCategory::get();
        $data['actual'] = Actual::findOrFail($act);

        return view('partials.actual.edit', $data);
    }

    public function update(ActualUpdateRequest $request, $id, $act) {
        $plan = Plan::findOrFail($id);
        $actual = Actual::findOrFail($act);
        $actual->title              = $request->title;
        $actual->description        = $request->description;
        $actual->actual_date_start  = date('Y-m-d H:i:s', strtotime("$request->actual_date $request->start"));
        $actual->actual_date_end    = date('Y-m-d H:i:s', strtotime("$request->actual_date $request->end"));
        $actual->actual_category_id = $request->category; 
        if( $plan->project )
            $actual->pm_sales       = ( $request->filled('pmsales') ) ? $request->pmsales : $plan->project->pm_sales; 
        $actual->site               = ( $request->filled('site') ) ? $request->site : null;
        $actual->updated_by         = $request->user()->id;

        // Calculate overtime
        
        $overtimeHours = 0;

        if( $this->checkDay($request) == 'Offday' ) {
            $overtimeHours = (float)$this->onlyOffday($request, $actual) + $overtimeHours;
        } else {
            if ( $request->start < $this->wstart ) {
              $overtimeHours = (float)$this->beforeWork($request, $actual) + $overtimeHours;
            }

            if( $request->end > $this->overtime ) {
              $overtimeHours =  (float)$this->afterWork($request, $actual) + $overtimeHours;
            }  
        }

        $actual->overtime = $overtimeHours;

        if($actual->save()) {
            return redirect()->route('plan.show', $plan->id)->with('success', 'Successfully updated actual.');
        }
    }

    protected function onlyOffday($request, $actual) {
        $start = Carbon::create("$request->actual_date $request->start");
        $end = Carbon::create("$request->actual_date $request->end");

        $diff = $start->floatDiffInHours($end);
        if( $this->saveToOvertime($request, $actual, $start, $end, $diff) ) 
            return $diff;
        else return 0;
    }

    protected function beforeWork($request, $actual) {
        $start = Carbon::create("$request->actual_date $request->start");
        if( $request->end < $this->wstart ) 
            $end = Carbon::create("$request->actual_date $request->end");
        else 
            $end = Carbon::create("$request->actual_date $this->wstart");

        $diff = $start->floatDiffInHours($end);
        if( $this->saveToOvertime($request, $actual, $start, $end, $diff) ) 
            return $diff;
        else return 0;
    }

    protected function afterWork($request, $actual) {
        $start = Carbon::create("$request->actual_date $this->overtime");
        $end = Carbon::create("$request->actual_date $request->end");

        $diff = $start->floatDiffInHours($end);
        if ( $this->saveToOvertime($request, $actual, $start, $end, $diff) )
            return $diff;
        else return 0;
    }

    protected function saveToOvertime($request, $actual, $start, $end, $diff) {
        $overtime = OvertimeDetail::updateOrCreate(
            [
                'actual_id' => $actual->id, 
                'start' => $start, 
                'end' => $end
            ],
            [
                'project_code' => $actual->project_code,
                'activity' => $actual->title,
                'start' => $start,
                'end' => $end,
                'type' => $this->checkDay($request),
                'pm_sales' => $actual->pm_sales,
                'user_id' => $actual->user_id,
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id,
            ]
        );
        if( $overtime ) 
            return true;
        else 
            return false;
    }

    protected function checkDay($request) {
        $actual_date = Carbon::create("$request->actual_date");
        $holiday = $this->getHoliday();
        if( $actual_date->isSunday() ) {
            return 'Offday';
        } else if( $actual_date->isSaturday() ) {
            return 'Offday';
        } else if ( in_array($request->actual_date, $holiday) ) {
            return 'Offday';
        } else {
            return 'Workday';
        }
    }

    protected function getHoliday() {
        $thisYear = date('Y');
        $holidays = Holiday::whereYear('start', $thisYear)->get();
        $arr = array();
        foreach($holidays as $holiday){
            array_push($arr, $holiday->start);
        }
        return $arr;
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
                    'id' => 'required|integer',
                    'plan' => 'required|integer'
                ]);

        if ($validator->fails())
            return redirect(route('plan.show', $request->plan))->withErrors($validator);

        $actual = Actual::findOrFail($request->id);
        $actual->deleted_by = $request->user()->id;
        $actual->save();

        if( $actual->delete() )
            return redirect(route('plan.show', $request->plan))->with('success', 'Successfully deleted actual.');
    }
}
