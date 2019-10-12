<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class like extends Model
{
    protected $table = 'likes';

    // Relaciones de Muchos a Uno
    public function user(){
        return $this->belongsTo('App\user', 'user_id');
    }

    // Relaciones de Muchos a Uno
    public function image(){
        return $this->belongsTo('App\image', 'image_id');
    }
}
