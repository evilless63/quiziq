<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['id','name', 'rounds', 'date'];

    public function teams(){
        return $this->belongsToMany('App\Team');
    }
}
