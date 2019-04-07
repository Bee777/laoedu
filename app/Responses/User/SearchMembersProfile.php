<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 3/1/2019
 * Time: 8:49 PM
 */

namespace App\Responses\User;


use App\Http\Controllers\Helpers\Helpers;
use App\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;

class SearchMembersProfile implements Responsable
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
            $paginateLimit = ($request->exists('limit') && !empty($request->get('limit'))) ? $request->get('limit') : 15;
            $paginateLimit = Helpers::isNumber($paginateLimit) ? $paginateLimit : 15;
            $text = $request->get('q');

            $adminFields = User::isAdminUser(auth()->user()) ? ['user_profiles.phone_number'] : [];
            $fields = ['users.id', 'users.name', 'users.last_name', 'users.email', 'user_profiles.date_of_birth', 'user_profiles.marital_status'];
            $request->request->add(['fields' => array_merge($adminFields, $fields)]);
            $data = User::select(array_merge(['users.image'], $fields))->join('user_types', 'user_types.user_id', 'users.id')
                ->leftJoin('user_profiles', 'user_profiles.user_id', '=', 'users.id')
                ->leftJoin('member_educations', 'member_educations.user_id', '=', 'users.id')
                ->leftJoin('member_careers', 'member_careers.user_id', '=', 'users.id')
                ->whereIn('user_types.type_user_id', User::getNonAdminUserIds())->where('users.status', 'approved');
            $data->where(function ($query) use ($request, $text) {
                foreach ($request->fields as $k => $f) {
                    if ($f === 'user_profiles.date_of_birth') {
                        if (Helpers::isEngText($text)) {
                            $query->orWhere($f, 'LIKE', "%{$text}%");
                        } else {
                            continue;
                        }
                    }
                    $query->orWhere($f, 'LIKE', "%{$text}%");
                }
                $query->orWhere(
                    DB::raw("CONCAT (users.name, ' ', users.last_name)"),
                    'LIKE',
                    "%{$text}%"
                );
            });

            /*** @Filters Data * */
            $filters['marital_status'] = $request->get('marital_status');
            $filters['degree'] = $request->get('degree');
            $filters['type_of_organization'] = $request->get('type_of_organization');

            if (!empty($filters['marital_status']) && $filters['marital_status'] !== null && $request->exists('marital_status')) {
                $data->where('user_profiles.marital_status', $filters['marital_status']);
            }

            if (!empty($filters['degree']) && $filters['degree'] !== null && $request->exists('degree')) {
                $data->whereIn('member_educations.education_degree_id', [$filters['degree']]);
            }
            if (!empty($filters['type_of_organization']) && $filters['type_of_organization'] !== null && $request->exists('type_of_organization')) {
                $data->whereIn('member_careers.organize_id', [$filters['type_of_organization']]);
            }
            /*** @Filters Data * */

            $data = $data->groupBy('users.id')->orderBy('users.id', 'desc')->paginate($paginateLimit);
            $data->map(function ($d) {
                $d->thumb_image = "/assets/images/user_profiles/96x96-{$d->image}";
                $d->image = "/assets/images/user_profiles/{$d->image}";
                $d->marital_status = (new UserProfileOptions)->getTextMaritalStatus($d->marital_status);
                if (!User::isAdminUser(auth()->user())) {
                    $d->date_of_birth = Helpers::toFormatDateString($d->date_of_birth, 'd-m');
                }
                return $d;
            });
            $data->appends(['limit' => $request->exists('limit'), 'q' => $request->get('q')]);
            return response()->json(['data' => $data]);
        }
    }
}
