<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Helpers\Helpers;
use App\Jobs\SendUserChangeStatus;
use App\Organize;
use App\Posts;
use App\Responses\IndexAdminResponse;
use App\Responses\ContactInfoResponse;
use App\Responses\AboutInfoResponse;
use App\Responses\OrganizeChartMemberResponse;
use App\Responses\OrganizeInfoResponse;
use App\Responses\NewsResponse;
use App\Responses\ActivityResponse;
use App\Responses\OrganizeChartRangeResponse;
use App\Responses\EventResponse;
use App\Responses\ScholarshipResponse;
use App\Responses\BannerResponse;
use App\Responses\FileResponse;
use App\Responses\SponsorResponse;

use App\Site;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Dictionary;

use App\SiteImage;

use App\News;


class AdminController extends Controller
{
    protected $rootView = 'main.admin';

    protected $excepts = [
        'except' => [
            'responseActionUploadImages', 'responseActionGetImages', 'responseActionDeleteImages'
        ]
    ];

    /**
     * @description @ApiMode Only admin and super admin can access and do works
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('api-mode-user-management:super_admin,admin', $this->excepts);
    }


    /**
     * @Responses and Actions api|web
     */
    /**
     * @param Request $request
     * @return IndexAdminResponse
     */
    public function index(Request $request): IndexAdminResponse
    {
        return new IndexAdminResponse($this->options($request));
    }

    /**
     * @Responses and Actions api|web
     */


    /**
     * @Responses and Actions api only
     * @SiteInfo Manger
     */
    public function responseActionManageSiteInfo(Request $request)
    {
        $this->validate($request, [
            'site_name' => 'required|max:191',
            'website_logo' => 'mimes:png,jpg,jpeg,svg,gif|max:2000',
            'favorite_icon' => 'mimes:png,jpg,jpeg,svg,gif|max:2000'
        ]);
        $oldData = Site::where('key', 'site_name')->first();
        if (isset($oldData)) {
            $oldData->value = $request->get('site_name');
            $oldData->save();
            $this->updateFreshVersion();
        }
        if ($request->hasFile('website_logo')) {
            $oldData = Site::where('key', 'website_logo')->first();
            if (isset($oldData)) {
                $file = $request->file('website_logo');
                $filename = md5(date('Y-m-d') . microtime()) . time() . '_site_info_.' . $file->getClientOriginalExtension();
                $location = public_path(Site::$uploadPath);
                $file->move($location, $filename);
                if ($oldData->value !== 'logo.png') {
                    Helpers::removeFile(Site::$uploadPath . $oldData->value);
                }
                $oldData->value = $filename;
                $oldData->save();
                //save for email logo same as website logo
                $oldData = Site::where('key', 'email_logo')->first();
                if (isset($oldData)) {
                    $oldData->value = $filename;
                    $oldData->save();
                }
                //save for email logo same as website logo
                $this->updateFreshVersion();
            }
        }
        if ($request->hasFile('favorite_icon')) {
            $oldData = Site::where('key', 'fav_icon')->first();
            if (isset($oldData)) {
                $file = $request->file('favorite_icon');
                $filename = md5(date('Y-m-d') . microtime()) . time() . '_site_info_.' . $file->getClientOriginalExtension();
                $location = public_path(Site::$uploadPath);
                $file->move($location, $filename);
                if ($oldData->value !== 'fav.png') {
                    Helpers::removeFile(Site::$uploadPath . $oldData->value);
                }
                $oldData->value = $filename;
                $oldData->save();
                $this->updateFreshVersion();
            }
        }

        return response()->json(['success' => true, 'data' => 'Saved successfully!']);
    }

    public function updateFreshVersion(): void
    {
        Site::where('key', 'fresh_version')->update(['value' => "?v" . md5(date('y-mm-dd h:i:sa'))]);
    }

    public function getSiteInfo()
    {
        $settings = $this->getSettings();
        $settings['website_logo'] = Site::$uploadPath . $settings['website_logo'];
        $settings['fav_icon'] = Site::$uploadPath . $settings['fav_icon'];
        return response()->json($settings);
    }

    /**
     * @Responses
     * @SiteInfo Manger
     * /
     *
     * /**
     * @Responses BannerAction
     */
    public function insertBanner(Request $request)
    {
        $this->validate($request, [
            'image' => 'max:3000|mimes:jpeg,png,jpg,gif',
        ]);
        return new BannerResponse("insert");
    }

    public function updateBanner(Request $request)
    {
        $this->validate($request, [
            'image' => 'max:3000|mimes:jpeg,png,jpg,gif',
        ]);
        return new BannerResponse('update');
    }

    public function deleteBanner()
    {
        return new BannerResponse('delete');
    }
    /**
     * @Responses BannerAction
     */
    /**
     * @Responses FileAction
     */
    public function insertFile(Request $request)
    {
        $this->validate($request, [
            'fileName' => 'required|string|max:191',
            'file' => 'required|max:10000|mimes:pdf,doc,docx,xlsx,pptx',
        ]);
        return new FileResponse("insert");
    }

    public function updateFile(Request $request)
    {
        $this->validate($request, [
            'fileName' => 'required|string|max:191',
            'file' => 'max:10000|mimes:pdf,doc,docx,xlsx,pptx',
        ]);
        return new FileResponse('update');
    }

    public function deleteFile()
    {
        return new FileResponse('delete');
    }
    /**
     * @Responses FileAction
     */
    /**
     * @Responses SponsorAction
     */
    public function insertSponsor(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'image' => 'required|max:3000|mimes:jpeg,png,jpg,gif',
        ]);
        return new SponsorResponse("insert");
    }

    public function updateSponsor(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'image' => 'max:3000|mimes:jpeg,png,jpg,gif',
        ]);
        return new SponsorResponse('update');
    }

    public function deleteSponsor()
    {
        return new SponsorResponse('delete');
    }
    /**
     * @Responses SponsorAction
     */
    /**
     * @Responses DictionaryAction
     */

    public function SaveDictionary(Request $request)
    {
        $this->validate($request, [
            'lao' => 'required|string|max:191',
            'japanese' => 'required|string|max:191',
            'description' => 'required|string|max:191',
        ]);
        $dictionary = new Dictionary();
        $dictionary->lao = $request->get('lao');
        $dictionary->japanese = $request->get('japanese');
        $dictionary->description = $request->get('description');
        $dictionary->save();

        return response()->json(['success' => true, 'msg' => 'The dictionary saved successfully!.', 'data' => $dictionary]);
    }

    public function UpdateDictionary(Request $request, $id)
    {
        $this->validate($request, [
            'lao' => 'required|string|max:191',
            'japanese' => 'required|string|max:191',
            'description' => 'required|string|max:191',
        ]);
        $dictionary = Dictionary::find($id);
        $dictionary->lao = $request->get('lao');
        $dictionary->japanese = $request->get('japanese');
        $dictionary->description = $request->get('description');
        $dictionary->save();
        return response()->json(['success' => true, 'msg' => 'The dictionary updated successfully!.', 'data' => $dictionary]);
    }

    public function DeleteDictionary($id)
    {
        $dictionary = Dictionary::find($id);
        $dictionary->delete();
        return response()->json(['success' => true, 'msg' => 'The dictionary deleted successfully!.']);
    }
    /**
     * @Responses DictionaryAction
     */

    /**
     * @Responses ContactAction
     */

    public function getContactInfo(Request $request)
    {
        return new ContactInfoResponse("get");
    }

    public function manageContactInfo(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|string|max:191',
            'email' => 'required|string|email|max:191',
            'address' => 'required|string',
        ]);
        return new ContactInfoResponse("manage");
    }
    /**
     * @Responses ContactAction
     */
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
        return new NewsResponse("insert");
    }

    public function updateNews(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'image' => 'max:3000|mimes:jpeg,png,jpg,gif',
            'description' => 'required|string',
        ]);
        return new NewsResponse('update');
    }

    public function deleteNews()
    {
        return new NewsResponse('delete');
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
        return new ActivityResponse('insert');
    }

    public function updateActivity(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'image' => 'max:3000|mimes:jpeg,png,jpg,gif',
            'activity_date' => 'required',
            'description' => 'required|string',
        ]);
        return new ActivityResponse('update');
    }

    public function deleteActivity()
    {
        return new ActivityResponse('delete');
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
            'description' => 'required|string',
        ]);
        return new EventResponse('insert');
    }

    public function updateEvent(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'image' => 'max:3000|mimes:jpeg,png,jpg,gif',
            'start_event' => 'required',
            'end_event' => 'required',
            'place' => 'required',
            'description' => 'required|string',
        ]);
        return new EventResponse('update');
    }

    public function deleteEvent()
    {
        return new EventResponse('delete');
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
        return new ScholarshipResponse('insert');
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
        return new ScholarshipResponse('update');
    }

    public function deleteScholarship()
    {
        return new ScholarshipResponse('delete');
    }
    /**
     * @Responses ScholarshipAction
     */
    /**
     * @Responses AboutAction
     */

    public function getAboutInfo(Request $request)
    {
        return new AboutInfoResponse('get');
    }

    public function manageAboutInfo(Request $request)
    {
        $this->validate($request, [
            'description' => 'string',
        ]);
        return new AboutInfoResponse('manage');
    }

    /**
     * @Responses AboutAction
     *     /**
     * 
    /**
     * @Responses PostsImageAction
     */

    public function responseActionUploadImages(Request $request): JsonResponse
    {
        return (new PostImageController())->upload($request);
    }

    public function responseActionGetImages(Request $request)
    {
        return (new PostImageController())->fetch($request);
    }

    public function responseActionDeleteImages(Request $request)
    {
        return (new PostImageController())->delete($request);
    }

    /**
     * @Responses PostsImageAction
     */

    /**
     * @Responses OrganizeAction
     */

    public function responseActionCreateOrganize(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'government_organize' => 'required|max:10',
        ]);
        $oldData = Organize::where('name', $request->get('name'))->first();
        if (isset($oldData)) {
            return response()->json(['errors' => ['name' => ['Your entered organize name already exists in our system.']]], 422);
        }
        $organize = Organize::CreateOrganize($request->get('name'), $request->get('government_organize') ? 'yes' : 'no');
        return response()->json(['success' => true, 'data' => $organize]);
    }

    public function responseActionUpdateOrganize(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'government_organize' => 'required|max:10',
        ]);
        $name = $request->get('name');
        $government_organize = $request->get('government_organize') ? 'yes' : 'no';
        $oldData = Organize::find($id);
        if (isset($oldData) && $oldData->name !== $name) {
            $exits = Organize::where('name', $name)->where('id', '!=', $id)->first();
            if (isset($exits)) {
                return response()->json(['errors' => ['organize_name' => ['Your entered organize name already exists in our system.']]], 422);
            }
        }
        $saved = Organize::UpdateOrganize($id, $name, $government_organize);
        return response()->json(['success' => $saved]);
    }

    public function responseActionDeleteOrganize(Request $request, $id)
    {
        $deleted = Organize::DeleteOrganize($id);
        return response()->json(['success' => $deleted]);
    }

    /**
     * @Responses OrganizeAction
     */

    /**
     * @Responses DepartmentAction
     */

    public function responseActionCreateDepartment(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
        ]);
        $oldData = Department::where('name', $request->get('name'))->first();
        if (isset($oldData)) {
            return response()->json(['errors' => ['name' => ['Your entered department name already exists in our system.']]], 422);
        }
        $department = Department::CreateDepartment($request->get('name'));
        return response()->json(['success' => true, 'data' => $department]);
    }

    public function responseActionUpdateDepartment(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
        ]);
        $name = $request->get('name');
        $oldData = Department::find($id);
        if (isset($oldData) && $oldData->name !== $name) {
            $exits = Department::where('name', $name)->where('id', '!=', $id)->first();
            if (isset($exits)) {
                return response()->json(['errors' => ['department_name' => ['Your entered department name already exists in our system.']]], 422);
            }
        }
        $saved = Department::UpdateDepartment($id, $request->get('name'));
        return response()->json(['success' => $saved]);
    }

    public function responseActionDeleteDepartment(Request $request, $id)
    {
        $deleted = Department::DeleteDepartment($id);
        return response()->json(['success' => $deleted]);
    }

    /**
     * @Responses DepartmentAction
     */

    /**
     * @todo reset user password
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function responseActionSendUserResetPasswordLink(Request $request, $id): JsonResponse
    {
        $this->validate($request, [
            'id' => ['required']
        ]);
        $user = User::find($id);
        if (isset($user) && (int)$id === (int)$request->get('id')) {

            if ($user->status !== 'approved') {
                return response()->json(['success' => false, 'message' => 'Only approved user can send reset password link!']);
            }
            //@send reset password link
            (new ForgotPasswordController())->sendResetLinkEmail($request);
            //@send reset password link
            return response()->json(['success' => true, 'message' => 'The user reset password link has been sent!']);
        }
        return response()->json(['success' => false, 'message' => 'The given user id does not exists!', $request->get('id')]);
    }


    /**
     * @todo delete user
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function responseActionDeleteUser(Request $request, $id): JsonResponse
    {
        $this->validate($request, [
            'id' => ['required']
        ]);
        $user = User::find($id);
        if (isset($user) && (int)$id === (int)$request->get('id') && $user->destroyInfo()) {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'The user account has been deleted!']);
        }
        return response()->json(['success' => false, 'message' => 'The given user id does not exists!', $request->get('id')]);
    }

    /**
     * * @todo add user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseActionAddUser(Request $request): JsonResponse
    {
        return response()->json((new RegisterController())->register($request));
    }

    /**
     * * @todo update user statuses
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function responseActionChangeUserStatus(Request $request, $id): JsonResponse
    {
        $this->validate($request, [
            'status' => ['required', 'string', 'max:25']
        ]);
        $user = User::find($id);
        $oldUserInfo = clone $user;
        $status = $request->get('status');
        if (isset($user) && $user->setStatus($request->get('status'))) {
            //check if user status change from disabled to approved
            $status = ($status === 'approved' && $oldUserInfo->status === 'disabled') ? 'enabled' : $status;
            $this->dispatch(new SendUserChangeStatus($user));
            return response()->json(['success' => true, 'message' => "The user account has been $status!"]);
        }
        return response()->json(['success' => false, 'message' => 'The given user id does not exists!']);
    }

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
        if ($type === 'users') {
            $fields = ['users.id', 'users.status', 'users.name', 'users.last_name', 'users.email', 'users.created_at'];
            $request->request->add(['fields' => $fields]);
            $data = User::select(array_merge(['users.image'], $fields))->join('user_types', 'user_types.user_id', 'users.id')
                ->whereIn('user_types.type_user_id', User::getNonAdminUserIds());
            $data->where(function ($query) use ($request, $text) {
                foreach ($request->fields as $k => $f) {
                    if ($f === 'users.created_at') {
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
            $data = $data->orderBy('users.created_at', 'desc')->paginate($paginateLimit);
            $data->map(function ($d) {
                $d->image = "/assets/images/user_profiles/{$d->image}";
                $d->statusColor = $d->status === 'approved' ? '#00bfa5' : ($d->status === 'disabled' ? '#d50000' : '');
                return $d;
            });
        } else if ($type === 'organizes') {
            $fields = ['id', 'name', 'government_organize', 'created_at', 'updated_at'];
            $request->request->add(['fields' => $fields]);
            $data = Organize::select($fields);
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
            $data->map(function ($d) {
                $d->government_organize = $d->government_organize === 'yes';
                return $d;
            });
        } else if ($type === 'departments') {
            $fields = ['id', 'name', 'created_at', 'updated_at'];
            $request->request->add(['fields' => $fields]);
            $data = Department::select($fields);
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
        } else if ($type === 'dictionaries') {
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
            $data = (new NewsResponse('get', ['text' => $text, 'limit' => $paginateLimit]))->get($request);
        } else if ($type === 'activity') {
            $data = (new ActivityResponse('get', ['text' => $text, 'limit' => $paginateLimit]))->get($request);
        } else if ($type === 'event') {
            $data = (new EventResponse('get', ['text' => $text, 'limit' => $paginateLimit]))->get($request);
        } else if ($type === 'scholarship') {
            $data = (new ScholarshipResponse('get', ['text' => $text, 'limit' => $paginateLimit]))->get($request);
        } else if ($type === 'organizeChartRanges') {
            $data = (new OrganizeChartRangeResponse('get', ['text' => $text, 'limit' => $paginateLimit]))->get($request);
        } else if ($type === 'banner') {
            $data = (new BannerResponse('get', ['text' => $text, 'limit' => $paginateLimit]))->get($request);
        } else if ($type === 'file') {
            $data = (new FileResponse('get', ['text' => $text, 'limit' => $paginateLimit]))->get($request);
        } else if ($type === 'sponsor') {
            $data = (new SponsorResponse('get', ['text' => $text, 'limit' => $paginateLimit]))->get($request);
        }
        if (count($data) > 0) {
            $data->appends(['limit' => $request->exists('limit'), 'q' => $request->get('q')]);
        }
        return response()->json(['data' => $data]);
    }

    /*** @postManagePostsStatus * */
    public function responseActionManagePostsStatus(Request $request)
    {
        $data = $this->validate($request, [
            'id' => 'required|max:191',
            'changeStatusTo' => 'required|max:191',
        ]);
        $info = Posts::find($data['id']);
        if (isset($info)) {
            if ($info->status === 'pending' && $data['changeStatusTo'] === 'approve') {
                $info->status = 'open';
            } else if ($info->status === 'open' && $data['changeStatusTo'] === 'close') {
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

    /**
     * @Helper helper functions
     */
}
