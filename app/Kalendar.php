<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kalendar extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
