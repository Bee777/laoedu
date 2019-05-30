<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckAssessment extends Model
{
    protected $fillable = ['status', 'assessment_id', 'user_id'];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
