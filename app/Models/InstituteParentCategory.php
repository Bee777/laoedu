<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstituteParentCategory extends Model
{
    protected $fillable = ['child_id', 'parent_id'];
}
