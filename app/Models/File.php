<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public static function getFile($limit = 0)
    {
        return self::select(['id', 'fileName', 'filePath', 'created_at', 'updated_at'])->limit($limit)->orderBy('updated_at', 'asc')->get();
    }
}
