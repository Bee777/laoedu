<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $fillable = [
        'user_id', 'type_user_id'
    ];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function typeUser(){
        return $this->belongsTo('App\TypeUser', 'type_user_id');
    }
}
