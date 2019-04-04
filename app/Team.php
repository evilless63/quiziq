<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['id','name'];

    public function games(){
        return $this->belongsToMany('App\Game');
    }
}
