<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Totalscore extends Model
{
    public function games(){
        return $this->belongsToMany('App\Game');
    }

    public function teams(){
        return $this->belongsToMany('App\Team');
    }
}
