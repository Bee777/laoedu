<?php

namespace App\Models;

use App\Responses\Admin\Schema\QuestionContentSchema;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentSection extends Model
{
    protected $fillable = ['title', 'description', 'section_order', 'assessment_id'];

    public function questions(): HasMany
    {
        return $this->hasMany(SectionQuestion::class, 'section_id');
    }

    public function questionsJson()
    {
        $questionsJson = [];
        $questions = $this->questions;
        unset($this->questions);
        foreach ($questions as $question){
            $questionsJson[] = json_decode($question->schema);
            unset($question->schema);
        }
        $this->questions = $questionsJson;
    }
}
