<?php

namespace App\Http\Controllers;

use App\Responses\Admin\DashboardResponse;
use App\Responses\FileResponse;
use App\Responses\IndexUserResponse;
use App\Responses\User\MemberCareersManage;
use App\Responses\User\MemberEducationsManage;
use App\Responses\User\SearchMembersProfile;
use App\Responses\User\UserActivityResponse;
use App\Responses\User\UserCredentials;
use App\Responses\User\UserEventResponse;
use App\Responses\User\UserNewsResponse;
use App\Responses\User\UserProfileManage;
use App\Responses\User\UserProfileOptions;
use App\Responses\User\UserProfileSingle;
use App\Responses\User\UserScholarshipResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Helpers\Helpers;
use Illuminate\Http\JsonResponse;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $rootView = 'main.user';

    protected $excepts = [
        'except' => [
        ]
    ];

    /**
     * @description @ApiMode Only admin, super admin and user can access and do works
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('api-mode-user-management:super_admin,admin,user', $this->excepts);
    }

    /**
     * @Responses and Actions api|web
     */
    /**
     * @param Request $request
     * @return IndexUserResponse
     */
    public function index(Request $request): IndexUserResponse
    {
        return new IndexUserResponse($this->options($request));
    }

    /**
     * @Responses and Actions api|web
     */

    /****@Responses  api only ***
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request)
    {
        $authUser = auth()->user();
        if (!isset($authUser)) {
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true, 'auth' => $authUser->transformUser()]);
    }

    /**
     * @Responses NewsAction
     */
    public function insertNews(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'image' => 'required|max:3000|mimes:jpeg,png,jpg,gif',
            'description' => 'required|string',
        ]);
        return new UserNewsResponse('insert');
    }

    public function updateNews(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'image' => 'max:3000|mimes:jpeg,png,jpg,gif',
            'description' => 'required|string',
        ]);
        return new UserNewsResponse('update');
    }

    public function deleteNews()
    {
        return new UserNewsResponse('delete');
    }
    /**
     * @Responses NewsAction
     */
    /**
     * @Responses ActivityAction
     */

    public function insertActivity(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'image' => 'required|max:3000|mimes:jpeg,png,jpg,gif',
            'activity_date' => 'required',
            'description' => 'required|string',
        ]);
        return new UserActivityResponse('insert');
    }

    public function updateActivity(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'image' => 'max:3000|mimes:jpeg,png,jpg,gif',
            'activity_date' => 'required',
            'description' => 'required|string',
        ]);
        return new UserActivityResponse('update');
    }

    public function deleteActivity()
    {
        return new UserActivityResponse('delete');
    }
    /**
     * @Responses ActivityAction
     */
    /**
     * @Responses EventAction
     */

    public function insertEvent(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'image' => 'required|max:3000|mimes:jpeg,png,jpg,gif',
            'start_event' => 'required',
            'end_event' => 'required',
            'place' => 'required',
            'hosted_by' => 'required',
            'description' => 'required|string',
        ]);
        return new UserEventResponse('insert');
    }

    public function updateEvent(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'image' => 'max:3000|mimes:jpeg,png,jpg,gif',
            'start_event' => 'required',
            'end_event' => 'required',
            'place' => 'required',
            'hosted_by' => 'required',
            'description' => 'required|string',
        ]);
        return new UserEventResponse('update');
    }

    public function deleteEvent()
    {
        return new UserEventResponse('delete');
    }
    /**
     * @Responses EventAction
     */
    /**
     * @Responses ScholarshipAction
     */
    public function insertScholarship(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'image' => 'required|max:3000|mimes:jpeg,png,jpg,gif',
            'deadline' => 'required',
            'place' => 'required',
            'scholarship_type' => 'required|string',
            'description' => 'required|string',
        ]);
        return new UserScholarshipResponse('insert');
    }

    public function updateScholarship(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'image' => 'max:3000|mimes:jpeg,png,jpg,gif',
            'scholarship_deadline' => 'required',
            'place' => 'required',
            'scholarship_type' => 'required|string',
            'description' => 'required|string',
        ]);
        return new UserScholarshipResponse('update');
    }

    public function deleteScholarship()
    {
        return new UserScholarshipResponse('delete');
    }
    /**
     * @Responses ScholarshipAction
     */


    /****@ResponsesSearches api and action  *** */
    /**
     * @param Request $request
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     */

    public function responseSearches(Request $request, $type): JsonResponse
    {
        $data = [];
        $paginateLimit = ($request->exists('limit') && !empty($request->get('limit'))) ? $request->get('limit') : 10;
        $paginateLimit = Helpers::isNumber($paginateLimit) ? $paginateLimit : 10;
        $text = $request->get('q');

        if ($type === 'dictionaries') {
            $fields = ['id', 'lao', 'japanese', 'description', 'created_at', 'updated_at'];
            $request->request->add(['fields' => $fields]);
            $data = Dictionary::select($fields);
            $data->where(function ($query) use ($request, $text) {
                foreach ($request->fields as $k => $f) {
                    if ($f === 'created_at' || $f === 'updated_at') {
                        if (Helpers::isEngText($text)) {
                            $query->orWhere($f, 'LIKE', "%{$text}%");
                        } else {
                            continue;
                        }
                    }
                    $query->orWhere($f, 'LIKE', "%{$text}%");
                }
            });
            $data = $data->orderBy('created_at', 'desc')->paginate($paginateLimit);
        } else if ($type === 'news') {
            $data = (new UserNewsResponse('get', ['text' => $text, 'limit' => $paginateLimit]))->get($request);
        } else if ($type === 'activity') {
            $data = (new UserActivityResponse('get', ['text' => $text, 'limit' => $paginateLimit]))->get($request);
        } else if ($type === 'event') {
            $data = (new UserEventResponse('get', ['text' => $text, 'limit' => $paginateLimit]))->get($request);
        } else if ($type === 'scholarship') {
            $data = (new UserScholarshipResponse('get', ['text' => $text, 'limit' => $paginateLimit]))->get($request);
        } else if ($type === 'downloadFiles') {
            $data = (new FileResponse('get', ['text' => $text, 'limit' => $paginateLimit]))->get($request);
        }
        if (count($data) > 0) {
            $data->appends(['limit' => $request->exists('limit'), 'q' => $request->get('q')]);
        }
        return response()->json(['data' => $data]);
    }
    /****@ResponsesSearches api and action  ** */

    /****@ResponsesMembersProfileSearch api and action  ** */
    public function responseSearchMembersProfile(Request $request): SearchMembersProfile
    {
        return new SearchMembersProfile();
    }
    /****@ResponsesMembersProfileSearch api and action  ** */

    /****@ResponsesUserProfile  api and action  *** */
    public function responseProfileOptions(Request $request): UserProfileOptions
    {
        return new UserProfileOptions();
    }

    public function responseProfileManage(Request $request): UserProfileManage
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'profile_image' => 'max:3000|mimes:jpeg,png,jpg,gif,svg',
            'phone_number' => 'max:191',
        ]);
        return new UserProfileManage($request);
    }

    /****@ResponsesUserProfile  api and action  *** */

    /*** @ResponsesMemberEducationsProfile */
    public function responseActionManageMemberEducations(Request $request)
    {
        $this->validate($request, [
            'educations' => 'array',
        ]);
        return new MemberEducationsManage();
    }

    /*** @ResponsesMemberEducationsProfile */

    /*** @ResponsesManageMemberCareers */
    public function responseActionManageMemberCareers(Request $request)
    {
        $this->validate($request, [
            'careers' => 'array',
        ]);
        return new MemberCareersManage();
    }
    /*** @ResponsesManageMemberCareers */

    /****@ResponsesUserCredentials  api and action  *** */

    public function responseCredentialsManage(Request $request)
    {

        $this->validate($request, ['current_password' => 'required|min:6|max:191']);

        $user = User::find(auth()->user()->id);//current user

        if ($this->isNeedToValidate($request, 'new_email')) {
            $this->validate($request, ['new_email' => 'email|max:191']);
            if ($this->userExists($request->get('new_email'))) {
                return response()->json(['errors' => ['new_email' => ['Your entered email already exists in our system.']]], 422);
            }
        }

        if ($this->isNeedToValidate($request, 'new_password')) {
            $this->validate($request, [
                'new_password' => 'confirmed|min:6|max:191|different:current_password',
                'password_confirmation' => 'min:6|max:191'
            ]);
        }

        if (!(isset($user) && Hash::check($request->get('current_password'), $user->password))) {
            return response()->json(['errors' => ['current_password' => ['Your entered current password is not match your current password.']]], 422);
        }
        //check if enter current password matched the current password
        return new UserCredentials($user);
    }

    public function isNeedToValidate($request, $name)
    {
        return $request->has($name) && $request->get($name) !== null && !empty($request->get($name));
    }
    /****@EndResponsesUserCredentials  api and action  *** */

    /****@ResponsesUserProfileSingle  api and action  *** */
    public function responseUserProfileSingle(Request $request, $user_id): UserProfileSingle
    {
        return new UserProfileSingle($user_id);
    }
    /****@EndResponsesUserProfileSingle  api and action  *** */

    /****@ResponsesDashboardData  api and action  *** */

    public function responseDashboardData(Request $request): DashboardResponse
    {
        return new DashboardResponse();
    }
    /****@ResponsesDashboardData  api and action  *** */


    /*** @postManagePostsStatus * */
    public function responseActionManagePostsStatus(Request $request)
    {
        $data = $this->validate($request, [
            'id' => 'required|max:191',
            'changeStatusTo' => 'required|max:191',
        ]);
        $info = Posts::where('id', $data['id'])->where('user_id', auth()->user()->id)->first();
        if (isset($info)) {
            if ($info->status === 'open' && $data['changeStatusTo'] === 'close') {
                $info->status = 'close';
            } else if ($info->status === 'close' && $data['changeStatusTo'] === 'open') {
                //check if post type is event or scholarship
                if ($info->type === 'event') {//set new dates for expired post
                    $this->validate($request, [
                        'start_event' => 'required',
                        'end_event' => 'required',
                    ]);
                    $info->start_date = Helpers::toFormatDateString($request->get('start_event'), 'Y-m-d H:i:s');
                    $info->deadline = Helpers::toFormatDateString($request->get('end_event'), 'Y-m-d H:i:s');
                } else if ($info->type === 'scholarship') {//set new date for expired post
                    $this->validate($request, [
                        'scholarship_deadline' => 'required',
                    ]);
                    $info->deadline = Helpers::toFormatDateString($request->get('scholarship_deadline'), 'Y-m-d H:i:s');
                }
                $info->status = 'open';
            }
            $info->save();
            return response()->json(['success' => true, 'msg' => 'The post status was successfully changed!']);
        }
        return response()->json(['success' => false, 'msg' => 'Failed to change the post status!']);
    }
    /*** @postManagePostsStatus * */
    /**
     * @Responses api only
     */

    /**
     * @Helper helper functions
     */

    /**
     * @return array
     */
    public function getSettings(): array
    {
        $settings = Site::select('id', 'key', 'value')
            ->whereNotIn('key', [])->get();
        $s = [];
        foreach ($settings as $setting) {
            $s[$setting->key] = $setting->value;
        }
        return $s;
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function options(Request $request): array
    {
        return [
            'settings' => $this->getSettings(),
            'rootView' => $this->rootView,
        ];
    }

    public static function isEngText($text): bool
    {
        return (strlen($text) === strlen(utf8_decode($text))); // is english
    }

    private function userExists($email): bool
    {
        $user = User::where('email', $email)->first();
        return isset($user);
    }

    /**
     * @Helper helper functions
     */
}
