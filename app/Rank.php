<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $fillable = ['name', 'image_path', 'min_score'];

    public function teams(){
        return $this->belongsToMany('App\Team');
    }

}
