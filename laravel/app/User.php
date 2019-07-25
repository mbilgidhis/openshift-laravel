<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, SoftDeletes, HasRoles, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'email_verified_at', 'active', 'is_leader', 'department_id', 'team_id', 'created_by', 'updated_by', 'deleted_by'
    ];

    protected static $logFillable = true;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function overtime() {
        return $this->hasMany('App\Overtime');
    }

    public function department() {
        return $this->belongsTo('App\Department');
    }

    public function team() {
        return $this->belongsTo('App\Team');
    }

    public function plans() {
        return $this->hasMany('App\Plan');
    }

    public function actuals() {
        return $this->hasManyThrough('App\Plan', 'App\Actual');
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

    public function information() {
        return $this->hasOne('App\UserInformation');
    }

    public function getActiveAttribute() {
        return ($this->attributes['active'] == 1) ? 'Yes' : 'No';
    }
    
    public function sendEmailVerificationNotification(){
        $this->notify(new \App\Notifications\VerifyEmailQueue);
    }

    public function sendPasswordResetNotification($token){
        $this->notify(new \App\Notifications\ForgotPasswordQueue($token));
    }
}
