<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = ['name', 'value'];

    public function scopeGetConfig($query, $name) {
    	return $query->where('name', $name);
    }
}
