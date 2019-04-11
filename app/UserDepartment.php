<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDepartment extends Model
{
    protected $fillable = ['id', 'department_id', 'user_id'];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
