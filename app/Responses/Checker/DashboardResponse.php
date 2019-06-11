<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 3/2/2019
 * Time: 2:46 PM
 */

namespace App\Responses\Checker;


use App\Http\Controllers\Helpers\Helpers;
use App\Models\Assessment;
use App\Models\CheckAssessment;
use App\Traits\UserRoleTrait;
use App\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Auth;

class DashboardResponse implements Responsable
{
    use  UserRoleTrait;

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
            $data['latest_checker_count'] = User::join('user_types', 'user_types.user_id', 'users.id')
                ->where('user_types.type_user_id', $this->getTypeUserId('checker'))
                ->where('users.status', 'approved')->get()->count();
            $data['assessments'] = $this->getAssessmentCount();
            return response()->json(['data' => $data]);
        }
    }

    public function getAssessmentCount(): array
    {
        $data = [];
        $data['active'] = Assessment::where('status', 'opening')->count();
        $data['all'] = Assessment::all()->count();
        $data['close'] = Assessment::where('status', 'close')->count();
        $data['success'] = Assessment::where('status', 'success')->count();
        return $data;
    }
}