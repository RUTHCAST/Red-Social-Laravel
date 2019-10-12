<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    protected $table = 'images';

    // Relaciones de Uno a Muchos

    public function comments(){
        return $this->hasMany('App\comment')->orderBy('id','desc');
    }


    public function likes(){
        return $this->hasMany('App\like');
    }

    // Relaciones de Muchos a Uno
    public function user(){
        return $this->belongsTo('App\user', 'user_id');
    }

}
