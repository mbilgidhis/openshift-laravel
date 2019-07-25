<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PlanCategoryRequest;
use App\PlanCategory;
use Validator;

class PlanCategoryController extends Controller
{
    public function __construct() {}

    public function index(Request $request) {
    	$data = array();
    	$data['categories'] = PlanCategory::paginate(10);

    	return view('partials.plan-category.index', $data);
    }

    public function create(Request $request) {
		$data = array();
		return view('partials.plan-category.create', $data);
    }

    public function store(PlanCategoryRequest $request) {
		$category              = new PlanCategory();
		$category->name        = $request->name;
		$category->description = $request->description;
        $category->created_by  = $request->user()->id;

    	if( $category->save() )
    		return redirect(route('plan-category.show', $category->id))->with('success', 'Successfully created new category.');
    }

    public function show(Request $request, $id) {
        $data = array();
        $data['category'] = PlanCategory::findOrFail($id);

        return view('partials.plan-category.show', $data);
    }

    public function update(PlanCategoryRequest $request) {
		$category = PlanCategory::findOrFail($request->id);
		$category->name = $request->name;
		$category->description = $request->description;
	    $category->updated_by  = $request->user()->id;

		if( $category->save() )
			return redirect(route('plan-category.show', $category->id))->with('success', 'Successfully updated category.');
    }

    public function delete(Request $request) {
    	$validator = Validator::make($request->all(), [
    	            'id' => 'required|integer'
    	        ]);

    	if ($validator->fails())
    	    return redirect(route('plan-category.index'))->withErrors($validator);

    	$category = PlanCategory::findOrFail($request->input('id'));
    	$category->deleted_by  = $request->user()->id;
    	$category->save();

    	if( $category->delete() )
    	    return redirect(route('plan-category.index'))->with('success', 'Successfully deleted category.');
    }
}
