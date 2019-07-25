<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ActualCategoryRequest;
use App\ActualCategory;
use Validator;

class ActualCategoryController extends Controller
{
    public function __construct() {}

    public function index(Request $request) {
    	$data = array();
    	$data['categories'] = ActualCategory::with('parent')
    							->paginate(10);

    	return view('partials.actual-category.index', $data);
    }

    public function show(Request $request, $id) {
    	$data = array();
    	$data['current'] = ActualCategory::findOrFail($id);
    	$categories = ActualCategory::with('childrenRecursive')
                                    ->whereNull('parent_id')
                                    ->get()->toArray();

    	$data['categories'] = makeTree($categories);

    	return view('partials.actual-category.show', $data);
    }

    public function create(Request $request) {
		$data = array();
		$categories = ActualCategory::with('childrenRecursive')
	                                ->whereNull('parent_id')
	                                ->get()->toArray();

		$data['categories'] = makeTree($categories);

		return view('partials.actual-category.create', $data);
    }

    public function store(ActualCategoryRequest $request) {
		$category              = new ActualCategory();
		$category->name        = $request->name;
		$category->description = $request->description;
		$category->parent_id   = $request->parent;
        $category->created_by  = $request->user()->id;

    	if( $category->save() )
    		return redirect(route('actual-category.show', $category->id))->with('success', 'Successfully created new category.');
    }

    public function update(ActualCategoryRequest $request) {
		$category = ActualCategory::findOrFail($request->id);
		$category->name = $request->name;
		$category->description = $request->description;
		$category->parent_id   = $request->parent;
	    $category->updated_by  = $request->user()->id;

		if( $category->save() )
			return redirect(route('actual-category.show', $category->id))->with('success', 'Successfully updated category.');
    }

    public function delete(Request $request) {
    	$validator = Validator::make($request->all(), [
    	            'id' => 'required|integer'
    	        ]);

    	if ($validator->fails())
    	    return redirect(route('actual-category.index'))->withErrors($validator);

    	$category = ActualCategory::findOrFail($request->input('id'));
    	$category->deleted_by  = $request->user()->id;
    	$category->save();

    	if( $category->delete() )
    	    return redirect(route('actual-category.index'))->with('success', 'Successfully deleted category.');
    }
}
