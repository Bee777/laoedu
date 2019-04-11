<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutJaol extends Model
{
    public static function getAbout() {
        return self::select('description')->first();
    }
}
