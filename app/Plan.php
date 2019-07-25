<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Carbon\Carbon;

class Plan extends Model
{
	use SoftDeletes, LogsActivity;

	protected $fillable = ['title', 'description', 'start', 'end', 'status', 'color', 'code', 'plan_category_id', 'plan_sub_category_id', 'user_id', 'project_id', 'important','created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'];

	protected static $logFillable = true;

	public function createdBy() {
	    return $this->belongsTo('App\User', 'created_by', 'id');
	}

	public function updatedBy() {
	    return $this->belongsTo('App\User', 'updated_by', 'id');
	}

	public function deletedBy() {
	    return $this->belongsTo('App\User', 'deleted_by', 'id');
	}

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function category() {
        return $this->belongsTo('App\PlanCategory', 'plan_category_id', 'id');
    }

    public function subcategory() {
    	return $this->belongsTo('App\PlanSubCategory', 'plan_sub_category_id', 'id');
    }

    public function actuals () {
    	return $this->hasMany('App\Actual');
    }

    public function project() {
    	return $this->belongsTo('App\Project');
	}

	public function getColorAttribute($value) {
		return strtoupper($value);
	}

	public function setColorAttribute($value){
		$this->attributes['color'] = strtolower($value);
	}

	// public function getStartAttribute($value) {
	// 	return Carbon::create($value);
	// }

	// public function getEndAttribute($value) {
	// 	return Carbon::create($value);
	// }
}
