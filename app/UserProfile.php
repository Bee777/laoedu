<?php

namespace App;

use App\Http\Controllers\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed user
 */
class UserProfile extends Model
{
    protected $dates = ['date_of_birth'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
