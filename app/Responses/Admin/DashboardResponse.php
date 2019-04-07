<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 3/2/2019
 * Time: 2:46 PM
 */

namespace App\Responses\Admin;


use App\Dictionary;
use App\EducationDegree;
use App\Http\Controllers\Helpers\Helpers;
use App\MemberCareer;
use App\Posts;
use App\User;
use Illuminate\Contracts\Support\Responsable;

class DashboardResponse implements Responsable
{

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
            $data['latest_members_count'] = User::join('user_types', 'user_types.user_id', 'users.id')->whereIn('user_types.type_user_id', User::getNonAdminUserIds())->count();
            $data['events_count'] = $this->getPostsCount('event');
            $data['scholarships_count'] = $this->getPostsCount('scholarship');
            $data['activities_count'] = $this->getPostsCount('activity')['all'];
            $data['news_count'] = $this->getPostsCount('news')['all'];
            $data['dictionaries_count'] = Dictionary::count();

            if (User::isAdminUser($request->user())) {
                $data['members_government_none_government_count'] = $this->getMembersGovernmentNoneGovernmentCount();
                $data['members_degrees_count'] = $this->getMembersDegreeCount();
            }

            return response()->json(['data' => $data]);
        }
    }

    public function getPostsCount($type): array
    {
        $data = [];
        $data['active'] = Posts::where('type', $type)->where('status', 'open')->count();
        $data['all'] = Posts::where('type', $type)->count();
        return $data;
    }

    public function getMembersGovernmentNoneGovernmentCount()
    {
        $query = User::join('user_types', 'user_types.user_id', 'users.id')
            ->join('member_careers', 'member_careers.user_id', '=', 'users.id')
            ->join('organizes', 'organizes.id', '=', 'member_careers.organize_id')
            ->whereIn('user_types.type_user_id', User::getNonAdminUserIds());

        $government = clone $query;
        $government = $government->where('organizes.government_organize', 'yes')->get();
        $government_count = $government->filter(function ($data) {
            $currentCareerEndDate = MemberCareer::where('user_id', $data->user_id)->max('end_date');
            return $currentCareerEndDate === $data->end_date;
        })->count();

        $none_government = clone $query;
        $none_government = $none_government->where('organizes.government_organize', 'no')->get();
        $none_government_count = $none_government->filter(function ($data) {
            $currentCareerEndDate = MemberCareer::where('user_id', $data->user_id)->max('end_date');
            return $currentCareerEndDate === $data->end_date;
        })->count();

        $data = [];
        $data['government'] = [
            'title' => 'Government',
            'count' => ['text' => 'Members', 'value' => $government_count]
        ];
        $data['none-government'] = [
            'title' => 'None-Government',
            'count' => ['text' => 'Members', 'value' => $none_government_count]
        ];
        return collect($data)->values();
    }

    public function getMembersDegreeCount()
    {
        $data = [];

        $query = User::join('user_types', 'user_types.user_id', 'users.id')
            ->join('member_educations', 'member_educations.user_id', '=', 'users.id')
            ->join('education_degrees', 'education_degrees.id', '=', 'member_educations.education_degree_id')
            ->whereIn('user_types.type_user_id', User::getNonAdminUserIds());

        $degrees = EducationDegree::orderBy('id', 'desc')->get();
        foreach ($degrees as $degree) {
            $temp = clone $query;
            $data[] = [
                'title' => $degree->name,
                'count' => ['text' => 'Members', 'value' => $temp->where('education_degrees.id', $degree->id)->count()]
            ];
            unset($temp);
        }
        return collect($data)->chunk(2)->values();
    }
}
