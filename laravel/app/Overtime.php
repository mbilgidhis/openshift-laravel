<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Overtime extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = ['period', 'user_id', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'];

    protected static $logFillable = true;

    public function owner() {
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function details() {
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
}
