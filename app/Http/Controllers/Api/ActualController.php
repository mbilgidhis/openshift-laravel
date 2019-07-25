<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actual;

class ActualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $actual = new Actual;

        $actual->groupId              = $request->groupId;
        $actual->allDay               = $request->allDay;
        $actual->start                = $request->start;
        $actual->end                  = $request->end;
        $actual->title                = $request->title;
        $actual->url                  = $request->url;
        $actual->classNames           = $request->classNames;
        $actual->editable             = $request->editable;
        $actual->startEditable        = $request->startEditable;
        $actual->durationEditable     = $request->durationEditable;
        $actual->resourceEditable     = $request->resourceEditable;
        $actual->rendering            = $request->rendering;
        $actual->overlap              = $request->overlap;
        $actual->constraint           = $request->constraint;
        $actual->backgroundColor      = $request->backgroundColor;
        $actual->borderColor          = $request->borderColor;
        $actual->textColor            = $request->textColor;
        $actual->extendedProps        = $request->extendedProps;
        $actual->source               = $request->source;

        if($actual->save()) {
            return jsend_success($actual);
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
        $actual = Actual::find($id);

        $actual->groupId              = $request->groupId;
        $actual->allDay               = $request->allDay;
        $actual->start                = $request->start;
        $actual->end                  = $request->end;
        $actual->title                = $request->title;
        $actual->url                  = $request->url;
        $actual->classNames           = $request->classNames;
        $actual->editable             = $request->editable;
        $actual->startEditable        = $request->startEditable;
        $actual->durationEditable     = $request->durationEditable;
        $actual->resourceEditable     = $request->resourceEditable;
        $actual->rendering            = $request->rendering;
        $actual->overlap              = $request->overlap;
        $actual->constraint           = $request->constraint;
        $actual->backgroundColor      = $request->backgroundColor;
        $actual->borderColor          = $request->borderColor;
        $actual->textColor            = $request->textColor;
        $actual->extendedProps        = $request->extendedProps;
        $actual->source               = $request->source;

        if($actual->save()) {
            return jsend_success($actual);
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
        $actual = Actual::find($id);

        if($actual->delete()) {
            return jsend_success($actual);
        }

        return jsend_error();
    }
}
