<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckAssessmentSectionQuestion extends Model
{
    protected $fillable = ['schema', 'section_id', 'status'];// section_id checking id
    public function toJsonDecode(){
        $decodeAnswer = json_decode($this->schema);
        $decodeAnswer->id = $this->id;
        $decodeAnswer->status = $this->status;
        $decodeAnswer->section_id = $this->section_id;
        $decodeAnswer->updated_at = $this->updated_at;
        unset($this->schema);
        return $decodeAnswer;
    }
}
