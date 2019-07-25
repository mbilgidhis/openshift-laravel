<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PlanRequest;
use App\Http\Requests\PlanCreateRequest;
use App\Http\Requests\PlanUpdateRequest;
use App\Plan;
use App\Actual;
use App\User;
use App\PlanCategory;
use App\Project;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use App\Config;
use App\PlanSubCategory;

class PlanController extends Controller
{
    protected $ongoing, $completed, $important, $failed, $pending;
    
    public function __construct() {
        date_default_timezone_set("Asia/Jakarta");
        $ongoing   = Config::getConfig('color.ongoing')->first();
        $completed = Config::getConfig('color.completed')->first();
        $important = Config::getConfig('color.important')->first();
        $failed    = Config::getConfig('color.failed')->first();
        $pending   = Config::getConfig('color.pending')->first();
        $this->ongoing   = $ongoing->value;
        $this->completed = $completed->value;
        $this->important = $important->value;
        $this->failed    = $failed->value;
        $this->pending   = $pending->value;
    }

    public function index(Request $request)
    {
        if( $request->user()->hasRole('staff') )
            $plans = Plan::with(['createdBy', 'user', 'category'])
                            ->where('user_id', $request->user()->id)
                            ->orWhere('created_by', $request->user()->id)
                            ->paginate(10);
        else
            $plans = Plan::with(['createdBy', 'user', 'category'])
                        ->paginate(10);

        return view('partials.plan.index', [
            'plans' => $plans
        ]);
    }

    public function create(Request $request) 
    {
        $data = array();
        $data['users'] = User::get();
        $data['categories'] = PlanCategory::get();
        $data['projects'] = Project::get();

        return view('partials.plan.create', $data);
    }
    
    public function store(PlanCreateRequest $request)
    {
        $plan                           = new Plan;
        $plan->title                    = $request->title;
        $plan->description              = $request->description;
        $plan->start                    = Carbon::createFromFormat('Y-m-d', $request->start);
        $plan->end                      = Carbon::createFromFormat('Y-m-d', $request->end);
        $plan->project_id               = $request->project;
        $plan->plan_category_id         = $request->category;
        $plan->plan_sub_category_id     = $request->subcategory;
        $plan->status                   = 'Ongoing';
        if( $request->has('assignee') )
            $plan->user_id              = $request->assignee;
        else
            $plan->user_id              = $request->user()->id;
        $plan->created_by               = $request->user()->id;
        $plan->code                     = Str::random(10);
        if( $request->filled('important') ) {
            $plan->color                    = $this->important;
            $plan->important                = 1;
        } else {
            $plan->color                    = $this->ongoing;
            $plan->important                = 0;
        }

        // Create new notification to user when being assign

        if($plan->save()){
            return redirect()->route('plan.show', $plan->id)->with('success', 'Succesfully created new plan.');
        }
    }

    public function show(Request $request, $id)
    {
        if ( $request->user()->hasRole('super admin') || $request->user()->hasRole('admin') ) {
            $plan = Plan::with(['actuals' => function($query){
                            $query->with('category');
                        }])
                        ->findOrFail($id);
            $disabled = '';
        }
        elseif( $request->user()->hasRole('staff') ) {
            $plan = Plan::with(['actuals' => function($query){
                            $query->with('category');
                        }])
                        ->where('id', $id)
                        ->where('user_id', $request->user()->id)
                        ->orWhere('created_by', $request->user()->id)
                        ->firstOrFail();
            $disabled = ( $plan->status !== 'Completed' ) ? '' : 'disabled';
        }

        $data = array();
        $data['plan'] = $plan;
        $data['categories'] = PlanCategory::get();
        $data['subs'] = PlanSubCategory::where('plan_category_id', $plan->category->id)->get();
        $data['projects'] = Project::get();
        $data['users'] = User::get();
        $data['disabled'] = $disabled;
        return view('partials.plan.edit', $data);  
    }

    public function update(PlanUpdateRequest $request) {
        $plan = Plan::findOrFail($request->id);

        $plan->title                    = $request->title;
        $plan->description              = $request->description;
        $plan->start                    = Carbon::createFromFormat('Y-m-d', $request->start);
        $plan->end                      = Carbon::createFromFormat('Y-m-d', $request->end);
        $plan->status                   = $request->status;
        $plan->project_id               = $request->project;
        $plan->plan_category_id         = $request->category;
        $plan->plan_sub_category_id     = $request->subcategory;
        $plan->updated_by               = $request->user()->id;


        switch ($request->status) {
            case 'Failed':
                $plan->color = $this->failed;
                break;
            case 'Completed':
                $plan->color = $this->completed;
                break;
            case 'Pending':
                $plan->color = $this->pending;
                break;
            default:
                $plan->color = $this->ongoing;
                break;
        }

        if( $request->filled('important') ) {
            $plan->color                    = $this->important;
            $plan->important                = 1;
        } else {
            $plan->important                = 0;
        }

        if($plan->save()){
            $actual = Actual::where('plan_id', $plan->id)->update(['color' => $plan->color]);
            return redirect()->route('plan.show', $plan->id)->with('success', 'Succesfully updated new plan.');
        }
    }

    public function resource(Request $request) {
        $day = Carbon::now();
        $starting = $day->subDays(28);

        if( $request->user()->hasPermissionTo('view_dashboard_all') ) {
            if( !$request->query('start') && !$request->query('end') )
                $plans = Plan::with('actuals', 'user')
                                ->where('start', '>=', $starting )
                                ->get();
            else
                $plans = Plan::with('actuals', 'user')
                                ->whereBetween('start', [$request->query('start'), $request->query('end')])
                                ->orWhereBetween('end', [$request->query('start'), $request->query('end')])
                                ->get(); 
        } else if( $request->user()->hasPermissionTo('view_dashboard_staff') ) { 
            if( !$request->query('start') && !$request->query('end') )
                $plans = Plan::with('actuals', 'user')
                                ->where('start', '>=', $starting )
                                ->where('user_id', $request->user()->id)
                                ->orWhere('created_by', $request->user()->id)
                                ->get();
            else 
                $plans = Plan::with('actuals', 'user')
                                ->where(function($query) use($request) {
                                    $query->whereBetween('start', [$request->query('start'), $request->query('end')]);
                                    $query->orWhereBetween('end', [$request->query('start'), $request->query('end')]);
                                })
                                ->where(function($query) use($request) {
                                    $query->where('user_id', $request->user()->id);
                                    $query->orWhere('created_by', $request->user()->id);
                                })
                                ->get();
        } else {
            $plans = Plan::with('actuals', 'user')->whereNull('id')->get();
        }

        $result = array();

        foreach ($plans as $plan) {
            $tplan = array();
            $tplan['id'] = $plan->code;
            $tplan['title'] = $plan->title;
            $tplan['eventColor'] = $plan->color;
            $tplan['assignee'] = ($plan->user !== null ) ? $plan->user->name : '';
            $tplan['children'] = array();
            foreach( $plan->actuals as $actual) {
                $tact = array();
                $tact['id'] = $actual->code;
                $tact['title'] = $actual->title;
                $tact['eventColor'] = $actual->color;
                $tact['assignee'] = null;
                array_push($tplan['children'], $tact);
            }
            array_push($result, $tplan);
        }

        return $result;
    }

    public function event(Request $request) {
        $day = Carbon::now();
        $starting = $day->subDays(28);

        $start = date('Y-m-d', strtotime($request->query('start')));
        $end = date('Y-m-d', strtotime($request->query('end')));
        // DB::enableQueryLog();

        if( $request->user()->hasPermissionTo('view_dashboard_all') ){
            if( !$request->query('start') && !$request->query('end') ){
                $plans = Plan::with('actuals', 'user')
                                ->where('start', '>=', $starting )
                                ->get();
            } else{
                $plans = Plan::with('actuals', 'user')
                                ->where('start', '<=', $end)
                                ->Where('end', '>=', $start)
                                ->get();
                
            }
        }else if( $request->user()->hasPermissionTo('view_dashboard_staff') ){ 
            if( !$request->query('start') && !$request->query('end') ){
                $plans = Plan::with('actuals', 'user')
                                ->where('start', '>=', $starting )
                                ->orWhere('user_id', $request->user()->id)
                                ->orWhere('created_by', $request->user()->id)
                                ->get();
            }else{
                $plans = Plan::with('actuals', 'user')
                                ->where('created_by', $request->user()->id)
                                ->orWhere('user_id', $request->user()->id)
                                ->where('start', '<=', $end)
                                ->where('end', '>=', $start)
                                ->get();
            }
        } else {
            $plans = Plan::with('actuals', 'user')->whereNull('id')->get();
        }
        // dd(DB::getQueryLog());

        $result = array();

        foreach ($plans as $plan) {
            $tplan = array();
            $tplan['resourceId'] = $plan->code;
            $tplan['title'] = $plan->title;
            $tplan['start'] = $plan->start;
            // I need to add 1 day to end date because bug(?) on plugin fulltimecalendar. The data given intentionally has extra one day
            // It's not a bug actually. Because when stating that ending on, for example January 1st, it will count as January 1st 00:00:00. We need to modify the result for this. 
            // Start manipulation
            $exp = explode('-', $plan->end);
            $additional = Carbon::createFromDate($exp[0], $exp[1], $exp[2]);
            $add = $additional->addDay();
            $add = $add->format('Y-m-d');
            // End manipulation
            $tplan['end'] = $add;
            $tplan['url'] = route('plan.show', $plan->id);
            $tplan['notes'] = 'End date intentionally has extra 1 day. Don\'t bother to check the real data.';
            foreach( $plan->actuals as $actual) {
                $tact = array();
                $tact['resourceId'] = $actual->code;
                $tact['title'] = $actual->title;
                $tact['start'] = $actual->actual_date_start;
                $tact['end'] = $actual->actual_date_end;
                $tact['url'] = route('plan.show', $plan->id);
                array_push($result, $tact);
            }
            array_push($result, $tplan);
        }

        return $result;
    }

    public function subCategory($id) {
        return PlanSubCategory::where('plan_category_id', $id)->get();
    }
}
