<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PlanSubCategory extends Model
{
	use SoftDeletes, LogsActivity;

    protected $fillable = ['name', 'description', 'plan_category_id', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'];

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

    public function parent() {
    	return $this->belongsTo('App\PlanCategory', 'plan_category_id', 'id');
    }

    public function plans() {
        return $this->hasMany('App\Plan');
    }
}
