<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Team extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = ['name', 'description', 'department_id'];

    protected static $logFillable = true;

    public function department() {
    	return $this->belongsTo('App\Department');
    }

    public function users() {
    	return $this->hasMany('App\User');
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
