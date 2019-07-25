<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ActualCategory extends Model
{
	use SoftDeletes, LogsActivity;

	protected $fillable = ['name', 'description', 'parent_id', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'];

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
		return $this->belongsTo('App\ActualCategory', 'parent_id', 'id');
	}

	public function children() {
		return $this->hasMany('App\ActualCategory', 'parent_id', 'id');
	}

	public function childrenRecursive(){
	   return $this->children()->with('childrenRecursive');
	}

    public function actuals() {
        return $this->hasMany('App\Actual');
    }
}
