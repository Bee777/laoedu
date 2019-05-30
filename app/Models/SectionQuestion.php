<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectionQuestion extends Model
{
    use SoftDeletes;
    protected $fillable = ['schema', 'question_order', 'section_id'];
}
