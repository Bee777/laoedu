<?php
namespace App\Http\Controllers;

use App\Responses\Admin\DashboardResponse;
use App\Responses\IndexInstituteResponse;
use App\Http\Controllers\Helpers\Helpers;
use Illuminate\Http\JsonResponse;
use App\Models\InstituteProfile;
use App\Models\UserProfile;
use Illuminate\Http\Request;

use App\Models\Site;
use Illuminate\Support\Facades\DB;

class InstituteProfileController extends Controller
{

    protected $rootView = 'main.institute';

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
        $this->middleware('api-mode-user-management:super_admin,admin,institute', $this->excepts);
    }

    /**
     * @Responses and Actions api|web
     */
    /**
     * @param Request $request
     * @return IndexUserResponse
     */
    public function index(Request $request): IndexInstituteResponse
    {
        return new IndexInstituteResponse($this->options($request));
    }

    public function responseProfileManage(Request $request): InstituteProfileManage
    {
        $this->validate($request, [
            'institute_name' => 'required|string|max:191',
            'short_institute_name' => 'required|string|max:191',
            'profile_image' => 'max:3000|mimes:jpeg,png,jpg,gif,svg',
            'phone_number' => 'max:191',
        ]);
        return new InstituteProfileManage($request);
    }



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
}
