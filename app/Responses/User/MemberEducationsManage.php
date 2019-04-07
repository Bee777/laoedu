<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 2/25/2019
 * Time: 11:03 PM
 */

namespace App\Responses\User;

use App\EducationDegree;
use App\Http\Controllers\Helpers\Helpers;
use App\MemberEducation;
use App\User;
use Illuminate\Contracts\Support\Responsable;
use Validator;

class MemberEducationsManage implements Responsable
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
            if ($request->exists('educations')) {
                $user = $request->user();
                $educations = $request->get('educations');

                //check if admin return back
                if (User::isAdminUser($user)) {
                    return response()->json(['success' => true, 'data' => $data]);
                }
                $memberEducations = $user->educations();
                if (count($educations) > 0) {
                    $edit = [];
                    $add = [];
                    $rules = [
                        'degree' => 'required|max:191',
                        'study_field' => 'required|max:191',
                        'university' => 'required|max:191',
                        'year_of_graduated' => 'required|max:191'];

                    foreach ($educations as $education) {
                        if (isset($education['id'])) {
                            $old = MemberEducation::find($education['id']);
                            if (isset($old)) {
                                $edit[] = $old->id;
                                $validator = Validator::make($education, $rules);
                                if ($validator->passes()) {
                                    $old->study_field = $education['study_field'];
                                    $old->university_graduation = $education['university'];
                                    $old->year_of_graduation = $this->getYear($education['year_of_graduated']);
                                    $old->education_degree_id = $this->getEducationDegree($education['degree']);
                                    $old->save();
                                    $data[] = $education;
                                }
                            }
                            continue;
                        }
                        $add[] = $education;
                    }
                    MemberEducation::where('user_id', $user->id)->whereNotIn('id', $edit)->delete();//delete removed item
                    foreach ($add as $education) {//save new data
                        $new = new MemberEducation();
                        $validator = Validator::make($education, $rules);
                        if ($validator->passes()) {
                            $new->study_field = $education['study_field'];
                            $new->university_graduation = $education['university'];
                            $new->year_of_graduation = $this->getYear($education['year_of_graduated']);
                            $new->education_degree_id = $this->getEducationDegree($education['degree']);
                            $new->user_id = $user->id;
                            $new->save();
                            $data[] = $education;
                        }
                    }
                } else {
                    $memberEducations->delete();
                }
                return response()->json(['success' => true, 'data' => $data]);
            }
            return response()->json(['success' => false, 'msg' => 'There is no actions.']);
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

    public function getEducationDegree($id)
    {
        $old = EducationDegree::find($id);
        if (isset($old)) {
            return $old->id;
        }
        return null;
    }
}
