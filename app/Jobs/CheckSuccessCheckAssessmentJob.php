<?php

namespace App\Jobs;

use App\Models\Assessment;
use App\Models\CheckAssessment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckSuccessCheckAssessmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $check_assessment;
    private $check_assessment_sections;

    /**
     * Create a new job instance.
     *
     * @param  $check_assessment
     */
    public function __construct($check_assessment)
    {
        $this->check_assessment = CheckAssessment::find($check_assessment->id);

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        #All changes from this behavior will make user changed status will not the same as user set it's will replace.
        #set check assessment status
        if ($this->check_assessment) {

            $check_sections = $this->check_assessment->checkAssessmentSections;
            $check_sections_count = count($check_sections);
            $check_sections_count_success = 0;

            foreach ($check_sections as $check_section) {
                $check_sections_questions = $check_section->checkAssessmentSectionQuestions;
                $check_sections_questions_count = count($check_sections_questions);
                $check_sections_questions_count_success = 0;
                foreach ($check_sections_questions as $check_sections_question) {
                    if ($check_sections_question->status === 'success') {
                        $check_sections_questions_count_success++;
                    }
                }
                #set section status
                if ($check_sections_questions_count_success === $check_sections_questions_count) {
                    $check_section->status = 'success';
                    $check_sections_count_success++;
                    $check_section->save();
                } else {
                    $check_section->status = 'checking';
                    $check_section->save();
                }
                #set section status
            }
            #set check assessment status
            if ($check_sections_count === $check_sections_count_success) {
                $this->check_assessment->status = 'success';
                $this->check_assessment->save();
            } else {
                $this->check_assessment->status = 'checking';
                $this->check_assessment->save();
            }
            #set check assessment status

            #set assessment status
            $assessment = Assessment::find($this->check_assessment->assessment_id);
            $all_check_assessments = CheckAssessment::where('assessment_id', $assessment->id)->get();
            $all_success_check_assessments = CheckAssessment::where('status', 'success')->where('assessment_id', $assessment->id)->get();
            if (count($all_check_assessments) === count($all_success_check_assessments)) {
                $assessment->status = 'success';
                $assessment->save();
            } else {
                $assessment->status = 'checking';
                $assessment->save();
            }
            #set assessment status
        }
        #set check assessment status

    }
}
