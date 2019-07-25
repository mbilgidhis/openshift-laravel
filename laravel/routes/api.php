<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function() {
    
});

Route::namespace('Api')->group(function() {
    // Route::resource('plan', 'PlanController');
    Route::get('plan-resource', 'PlanController@planResource')->name('api.plan-resource');
    Route::get('plan-event', 'PlanController@planEvent')->name('api.plan-event');
    // Route::resource('plan_event', 'PlanEventController');
    Route::resource('actual', 'ActualController');
    Route::resource('plan_category', 'PlanCategoryController');
    Route::resource('actual_category', 'ActualCategoryController');
});
