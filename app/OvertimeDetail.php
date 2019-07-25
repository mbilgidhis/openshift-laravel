<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class OvertimeDetail extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = ['project_code', 'activity', 'start', 'end', 'type', 'pm_sales', 'claimed', 'overtime_id', 'actual_id', 'user_id', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'];

    protected static $logFillable = true;

    public function owner() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function overtime() {
    	return $this->belongsTo('App\Overtime');
    }

    public function actual() {
    	return $this->belongsTo('App\Actual');
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
