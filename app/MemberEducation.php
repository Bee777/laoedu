<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberEducation extends Model
{
    public function degree()
    {
        return $this->belongsTo(EducationDegree::class, 'education_degree_id');
    }
}
