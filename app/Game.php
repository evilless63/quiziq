<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['id','name', 'rounds', 'date'];

    public function teams(){
        return $this->belongsToMany('App\Team');
    }

    public function rounds(){
        return $this->belongsToMany('App\Round');
    }

    public function totalscores(){
        return $this->belongsToMany('App\Totalscore');
    }

    public function totalscore_teams()
    {
        return $this->hasManyThrough('App\Team', 'App\Totalscore');
    }
}
