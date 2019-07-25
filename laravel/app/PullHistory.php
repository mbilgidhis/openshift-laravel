<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PullHistory extends Model
{
    protected $fillable = ['message', 'created_at', 'updated_at'];
}
