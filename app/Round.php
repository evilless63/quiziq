<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{

    protected $fillable = ['score'];

    public function games(){
        return $this->belongsToMany('App\Game');
    }

}
