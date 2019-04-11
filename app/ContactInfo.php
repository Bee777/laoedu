<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    public static function getContactInfo() {
        return self::select('phone', 'email','address','facebook','googleplus','twitter')->first();
    }
}
