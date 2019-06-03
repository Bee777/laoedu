<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 6/3/2019
 * Time: 5:06 PM
 */

namespace App\Responses\Admin;


use App\Http\Controllers\Helpers\Helpers;
use App\Models\CheckAssessment;
use Illuminate\Contracts\Support\Responsable;

class CheckAssessmentActionResponse implements Responsable
{

    private $actions;
    private $options;


    /**
     * CheckAssessmentActionResponse constructor.
     * @param $actions
     * @param array $options
     */
    public function __construct($actions, $options = [])
    {
        $this->actions = $actions;
        $this->options = $options;
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
            if ($this->actions === 'change-status') {
                $data = $this->postChangeStatus($request);
            }
            if ($data) {
                return response()->json(['data' => $data, 'success' => true]);
            }
        }
        return response()->json(['data' => null, 'success' => false]);
    }

    public function postChangeStatus($request)
    {
        $check_assessment = CheckAssessment::find($request->id);
        if (isset($check_assessment) && $this->allowStatuses($request->status)) {
            $check_assessment->status = $request->status;
            $check_assessment->save();
            return $check_assessment;
        }
        return null;
    }

    public function allowStatuses($title)
    {
        $statuses = ['close', 'checking', 'success'];
        return in_array($title, $statuses, true);
    }
}
