<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public static function getBanners($limit = 0)
    {
        return self::select('name','description','link', 'image')->limit($limit)->orderBy('order', 'asc')->get();
    }
}
