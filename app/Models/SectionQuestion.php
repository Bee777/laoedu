<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionQuestion extends Model
{
    protected $fillable = ['schema', 'question_order', 'section_id'];
}
