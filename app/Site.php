<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    public static $uploadPath = '/assets/images/';
    protected $fillable = [
        'id', 'key', 'value'
    ];
}
