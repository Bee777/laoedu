<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 2/25/2019
 * Time: 11:03 PM
 */

namespace App\Responses\User;

use App\CareerWorkDepartments;
use App\Department;
use App\Http\Controllers\Helpers\Helpers;
use App\MemberCareer;
use App\Organize;
use App\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class MemberCareersManage implements Responsable
{

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $data = [];
        if (Helpers::isAjax($request)) {
            if ($request->exists('careers')) {
                $user = $request->user();
                $careers = $request->get('careers');
                //check if admin return back
                if (User::isAdminUser($user)) {
                    return response()->json(['success' => true, 'data' => $data]);
                }
                $memberCareers = $user->careers();
                if (count($careers) > 0) {
                    $edit = [];
                    $add = [];
                    $rules = [
                        'member_of_state' => 'required|max:191',
                        'work_categories' => 'required|max:191|array',
                        'start_year' => 'required|max:191',
                        'end_year' => 'required|max:191'];
                    $rule_member_of_state = [
                        'government_agency' => 'required|max:191'];
                    foreach ($careers as $career) {
                        if (isset($career['id'])) {
                            $old = MemberCareer::find($career['id']);
                            if (isset($old)) {
                                $edit[] = $old->id;
                                $validator = Validator::make($career, $rules);
                                if ($validator->passes()) {
                                    $validator = $career['member_of_state'] ? Validator::make($career, $rule_member_of_state) : $validator;
                                    if ($validator->passes()) {
                                        $this->manageData($old, $career, 'edit');
                                        $data[] = $career;
                                    }
                                }
                            }
                            continue;
                        }
                        $add[] = $career;
                    }
                    MemberCareer::where('user_id', $user->id)->whereNotIn('id', $edit)->delete();//delete removed item
                    foreach ($add as $career) {//save new data
                        $new = new MemberCareer();
                        $validator = Validator::make($career, $rules);
                        if ($validator->passes()) {
                            $validator = $career['member_of_state'] ? Validator::make($career, $rule_member_of_state) : $validator;
                            if ($validator->passes()) {
                                $this->manageData($new, $career, 'insert');
                                $data[] = $career;
                            }
                        }
                    }
                } else {
                    $memberCareers->delete();
                }
                return response()->json(['success' => true, 'data' => $data]);
            }
            return response()->json(['success' => false, 'msg' => 'There is no actions.']);
        }
    }

    public function manageData($data, $request, $type): void
    {
        $member_of_state = $request['member_of_state'];
        $data->member_of_state = $member_of_state;
        if ($member_of_state) {
            $data->government_agency = $request['government_agency'];
        } else {
            $data->government_agency = null;
        }

        $data->organize_id = $this->getOrganizeId($request['type_of_organize']);
        $data->start_date = Helpers::toFormatDateString($this->getYear($request['start_year']) . '-01-01', 'Y-m-d');
        $data->end_date = Helpers::toFormatDateString($this->getYear($request['end_year']) . '-01-01', 'Y-m-d');

        if ($type === 'insert') {
            $data->user_id = Auth::user()->id;
        }
        $data->save();
        //save work categories
        $work_categories = $request['work_categories'];
        $data->work_categories()->delete();//delete old data
        foreach ($work_categories as $work_category) {
            if (isset($work_category['value'])) {
                $department = Department::find($work_category['value']);
                if (isset($department)) {
                    $work_category = new CareerWorkDepartments();
                    $work_category->department_id = $department->id;
                    $data->work_categories()->save($work_category);
                }
            }
        }
    }

    public function getYear($year)
    {
        $years = (new UserProfileOptions())->getYearsOptions();
        if (in_array((string)$year, $years, true)) {
            return $year;
        }
        return date('Y');
    }

    public function getOrganizeId($id)
    {
        $data = Organize::find($id);
        if (isset($data)) {
            return $data->id;
        }
        return null;
    }
}
