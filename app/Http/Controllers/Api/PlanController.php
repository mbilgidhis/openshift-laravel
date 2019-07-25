<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Plan;
use App\PlanResource;
use Carbon\Carbon;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::get();
        $plans = $plans->map(function($item, $key){
            return [
                'id' => $item->id,
                'title' => $item->title
            ];
        });
        return $plans;
    }

    public function planResource()
    {
        $plans = Plan::get();
        $plans = $plans->map(function($item, $key){
            return [
                'id' => $item->id,
                'title' => $item->title
            ];
        });
        return $plans;
    }

    public function planEvent()
    {
        $plans = Plan::get();
        $plans = $plans->map(function($item, $key){
            return [
                'resourceId' => $item->id,
                'title' => $item->title,
                'start' => Carbon::parse($item->start)->format('Y-m-d'),
                'end' => Carbon::parse($item->end)->format('Y-m-d'),
                'url' => route('plan.show', $item->id),
                'backgroundColor' => $item->color
            ];
        });
        return $plans;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $planResource = new PlanResource;

        $planResource->resourceId = $request->id;
        $planResource->title = $request->title;

        // $plan->groupId              = $request->groupId;
        // $plan->allDay               = $request->allDay;
        // $plan->start                = $request->start;
        // $plan->end                  = $request->end;
        // $plan->title                = $request->title;
        // $plan->url                  = $request->url;
        // $plan->classNames           = $request->classNames;
        // $plan->editable             = $request->editable;
        // $plan->startEditable        = $request->startEditable;
        // $plan->durationEditable     = $request->durationEditable;
        // $plan->resourceEditable     = $request->resourceEditable;
        // $plan->rendering            = $request->rendering;
        // $plan->overlap              = $request->overlap;
        // $plan->constraint           = $request->constraint;
        // $plan->backgroundColor      = $request->backgroundColor;
        // $plan->borderColor          = $request->borderColor;
        // $plan->textColor            = $request->textColor;
        // $plan->extendedProps        = $request->extendedProps;
        // $plan->source               = $request->source;

        if($planResource->save()) {
            return jsend_success($planResource);
        }

        return jsend_error();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $plan = Plan::find($id);

        $plan->groupId              = $request->groupId;
        $plan->allDay               = $request->allDay;
        $plan->start                = $request->start;
        $plan->end                  = $request->end;
        $plan->title                = $request->title;
        $plan->url                  = $request->url;
        $plan->classNames           = $request->classNames;
        $plan->editable             = $request->editable;
        $plan->startEditable        = $request->startEditable;
        $plan->durationEditable     = $request->durationEditable;
        $plan->resourceEditable     = $request->resourceEditable;
        $plan->rendering            = $request->rendering;
        $plan->overlap              = $request->overlap;
        $plan->constraint           = $request->constraint;
        $plan->backgroundColor      = $request->backgroundColor;
        $plan->borderColor          = $request->borderColor;
        $plan->textColor            = $request->textColor;
        $plan->extendedProps        = $request->extendedProps;
        $plan->source               = $request->source;

        if($plan->save()) {
            return jsend_success($plan);
        }

        return jsend_error();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = Plan::find($id);
        if($plan->delete()) {
            return jsend_success($plan);
        }
        return jsend_error();
    }
}
