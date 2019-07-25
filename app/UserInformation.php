<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    protected $fillable = ['phone', 'address', 'user_id', 'created_by', 'updated_by'];

    protected static $logFillable = true;
    
    public function user() {
    	return $this->belongsTo('App\User');
    }
}
