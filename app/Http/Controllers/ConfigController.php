<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;
use Validator;

class ConfigController extends Controller
{
    public function __construct() {

    }

    public function index(Request $request) {
    	$data = array();
    	$data['configs'] = Config::paginate(10);

    	return view('partials.config.index', $data);
    }

    public function show(Request $request, $id) {
    	$data = array();
    	$data['config'] = Config::findOrFail($id);
    	return view('partials.config.show', $data);
    }

    public function create() {
    	return view('partials.config.create');
    }

    public function store(Request $request) {
    	$config         = new Config();

    	$config->name   = $request->name;
        $config->value  = $request->value;

    	if( $config->save() )
    		return redirect(route('config.show', $config->id))->with('success', 'Successfully created config.');
    }
    
    public function update(Request $request) {

    	$config         = Config::findOrFail($request->id);
        
        $config->name   = $request->name;
        $config->value  = $request->value;

    	if( $config->save() ) 
    		return redirect(route('config.show', $config->id))->with('success', 'Successfully updated config.');
    }

    public function delete(Request $request) {

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        if ($validator->fails())
            return redirect(route('config.index'))->withErrors($validator);

        $config = Config::findOrFail($request->input('id'));

        if( $config->delete() )
            return redirect(route('config.index'))->with('success', 'Successfully deleted config.');
    }
}
