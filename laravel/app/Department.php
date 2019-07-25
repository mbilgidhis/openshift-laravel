<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Department extends Model
{
	use SoftDeletes, LogsActivity;

	protected $fillable = [ 'name', 'description', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at' ];

	protected static $logFillable = true;

	public function members() {
		return $this->hasMany('App\User');
	}

	public function teams() {
		return $this->hasMany('App\Team');
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
}
