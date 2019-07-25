<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Holiday extends Model
{
    protected $fillable = ['name', 'start', 'end', 'link', 'status', 'google_event_id', 'created_at', 'updated_at'];

    public function getStartAttribute($value) {
    	return Carbon::create($value);
    }
}
