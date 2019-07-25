<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PlanCategory;
use App\PlanSubCategory;
use Validator;
use App\Http\Requests\PlanSubCategoryRequest;

class PlanSubCategoryController extends Controller
{
    public function __construct() {

    }

    public function index(Request $request) {
    	$data = array();
    	$data['categories'] = PlanSubCategory::with('parent')->paginate(10);

    	return view('partials.plan-sub-category.index', $data);
    }

    public function create() {
        $data = array();
        $data['parents'] = PlanCategory::get();
    	return view('partials.plan-sub-category.create', $data);
    }

    public function store(PlanSubCategoryRequest $request) {
    	$planSubCategory                        = new PlanSubCategory();

    	$planSubCategory->name                  = $request->name;
        $planSubCategory->description           = $request->description;
        $planSubCategory->plan_category_id    = $request->parent;

    	$planSubCategory->created_by            = $request->user()->id;

    	if( $planSubCategory->save() )
    		return redirect(route('plan-sub-category.show', $planSubCategory->id))->with('success', 'Successfully created Plan Subcategory.');
    }

    public function show(Request $request, $id) {
        $data = array();
        $data['category'] = PlanSubCategory::findOrFail($id);
        $data['parents'] = PlanCategory::get();
        return view('partials.plan-sub-category.show', $data);
    }
    
    public function update(PlanSubCategoryRequest $request) {

        $planSubCategory = PlanSubCategory::findOrFail($request->id);
        
        $planSubCategory->name                  = $request->name;
        $planSubCategory->description           = $request->description;
        $planSubCategory->plan_category_id    = $request->parent;
        
    	$planSubCategory->updated_by            = $request->user()->id;

    	if( $planSubCategory->save() ) 
    		return redirect(route('plan-sub-category.show', $planSubCategory->id))->with('success', 'Successfully updated Plan Subcategory.');
    }

    public function delete(Request $request) {

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        if ($validator->fails())
            return redirect(route('plan-sub-category.index'))->withErrors($validator);

        $planSubCategory              = PlanSubCategory::findOrFail($request->input('id'));
        $planSubCategory->deleted_by  = $request->user()->id;
        $planSubCategory->save();

        if( $team->delete() )
            return redirect(route('plan-sub-category.index'))->with('success', 'Successfully deleted Plan Subcategory.');
    }
}
