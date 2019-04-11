<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    public static $uploadPath = '/assets/images/sponsors/';
    public static function getSponsor($limit = 0)
    {
        // return self::select('name','link','description', 'image')->limit($limit)->orderBy('id', 'desc')->where('status', 'open')->get();
        $sponsors = self::select('name','link','description','image')->limit($limit)->orderBy('id', 'desc')->where('status', 'open')->get();
        $sponsors->map(function ($sponsor) {

            $sponsor->image = url('/assets/images/sponsors') . '/' . $sponsor->image;
            unset($sponsor->user);
            $sponsor->setRelations([]);
            return $sponsor;
        });
        return $sponsors;
    }
}
