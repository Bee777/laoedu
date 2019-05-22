<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 3/2/2019
 * Time: 2:46 PM
 */

namespace App\Responses\Admin;


use App\Http\Controllers\Helpers\Helpers;
use App\Models\Assessment;
use App\Models\AssessmentSection;
use App\Models\SectionQuestion;
use App\Responses\Admin\Schema\QuestionContentSchema;
use App\User;
use Illuminate\Contracts\Support\Responsable;

class AssessmentActionResponse implements Responsable
{
    private $actions;

    /**
     * AssessmentActionResponse constructor.
     * @param $actions
     */
    public function __construct($actions)
    {
        $this->actions = $actions;
    }


    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        if (Helpers::isAjax($request)) {
            $data = [];
            if ($this->actions === 'create') {
                $data = $this->create($request);
            }
            return response()->json(['data' => $data, 'success' => true]);
        }
        return response([], 202);
    }

    public function create($request)
    {
        $schemaString = json_encode($request->all());
        if (Helpers::isValidJson($schemaString)) {
            $schema = json_decode($schemaString);
            if (is_object($schema)) {
                //assessment
                $assessment = $schema->assessment;
                if (is_object($assessment)) {
                    $assessmentModel = new Assessment();
                    $assessmentModel->title = $assessment->title ?? '';
                    $assessmentModel->description = $assessment->description ?? '';
                    $assessmentModel->save();
                    //sections
                    $sections = $schema->sections;
                    if (is_array($sections)) {
                        foreach ($sections as $key => $section) {
                            if (is_object($section)) {
                                $sectionModel = new AssessmentSection();
                                $sectionModel->title = $section->title ?? '';
                                $sectionModel->description = $section->desc ?? '';
                                $sectionModel->section_order = $key;
                                $sectionModel->assessment_id = $assessmentModel->id;
                                $sectionModel->save();
                                $questions = $section->questions;
                                if (is_array($questions)) {
                                    foreach ($questions as $q_key => $question) {
                                        if (is_object($question)) {
                                            $questionModel = new SectionQuestion();
                                            $questionModel->question_order = $q_key;
                                            $questionSchema = new QuestionContentSchema();
                                            $questionSchema->build($question);
                                            $questionModel->schema = $questionSchema->toJson();
                                            $sectionModel->questions()->save($questionModel);
                                        }//question
                                    }
                                }//questions
                                $assessmentModel->sections()->save($sectionModel);
                            }//section
                        }
                    }//sections
                    return $this->getAssessmentSchema($assessmentModel);
                }//assessment
            }//schema

        }
        return [];
    }

    public function getAssessmentSchema(Assessment $assessmentModel)
    {
        $sections = $assessmentModel->sections;
        unset($assessmentModel->sections);
        $sections = $sections->map(function ($section, $key) {
            $section->desc = $section->description;
            $section->focusIndex = -1;
            $section->questionsJson();
            return $section;
        });
        return [
            'assessment' => $assessmentModel,
            'sections' => $sections
        ];
    }
}

