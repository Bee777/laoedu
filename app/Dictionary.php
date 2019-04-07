<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    public static function getDictionaries() {
        return self::select('lao', 'japanese','description')->orderBy('lao', 'asc')->get();
    }

    public function comments()
    {
        return $this->hasMany(DictionaryComment::class, 'dictionary_id');
    }
}
