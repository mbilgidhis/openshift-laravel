<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Actual extends Model
{
	use SoftDeletes, LogsActivity;

	protected $fillable = ['title', 'description', 'actual_date_start', 'actual_date_end', 'code', 'color', 'site', 'pm_sales', 'overtime', 'actual_category_id', 'plan_id', 'project_id','user_id', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'];

	protected static $logFillable = true;

	protected function overtime() {
		return $this->hasMany('App\OvertimeDetail');
	}

	public function createdBy() {
	    return $this->belongsTo('App\User', 'created_by', 'id');
	}

	public function updatedBy() {
	    return $this->belongsTo('App\User', 'updated_by', 'id');
	}

	public function deletedBy() {
	    return $this->belongsTo('App\User', 'deleted_by', 'id');
	}

	public function parent() {
		return $this->belongsTo('App\PlanCategory', 'parent_id', 'id');
	}

    public function plan() {
        return $this->belongsTo('App\Plan');
    }

    public function project() {
    	return $this->belongsTo('App\Project');
    }

    public function category() {
        return $this->belongsTo('App\ActualCategory', 'actual_category_id', 'id');
    }
}
