<?php

namespace App\Http\Controllers;

use App\Dictionary;
use App\Jobs\SendContactInfo;
use App\Responses\Home\Pages\Dictionary\DictionaryCommentResponse;
use App\Responses\Home\PostsResponse;
use App\Responses\Home\SinglePostsResponse;
use App\Responses\OrganizeChartMemberResponse;
use App\Responses\OrganizeInfoResponse;
use App\Traits\DefaultData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\ContactInfo;
use App\AboutJaol;
use App\Http\Controllers\Helpers\Helpers;
use App\Banner;
use App\Posts;
use App\Sponsor;

class HomeController extends Controller
{
    use DefaultData;
    public $rootView = 'main.general';

    /**
     * @Responses and Actions api|web
     */

    /***@SinglePostsResponse *
     * @param Request $request
     * @param $type
     * @param $id
     * @return SinglePostsResponse
     */

    public function responsePostsSingle(Request $request, $type, $id): SinglePostsResponse
    {
        return new SinglePostsResponse(['rootView' => $this->rootView], $type, $id);
    }
    /***@SinglePostsResponse * */


    /***@PostsResponse *
     * @param Request $request
     * @param $type
     * @return PostsResponse
     */
    public function responsePosts(Request $request, $type): PostsResponse
    {
        return new PostsResponse(['rootView' => $this->rootView], $type);
    }
    /***@PostsResponse * */

    /**
     * @Responses and Actions api|web
     */
    /**
     * @TODO home guest or all users  can view
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (Helpers::isAjax($request)) {
            return response()->json(['data' => $this->getHomeData($request)]);
        }
        return view((string)$this->rootView, $this->getDefaultData($request));
    }

    /**
     * @DictionarySection
     */
    public function dictionary(Request $request)
    {
        return view("{$this->rootView}.dictionaries", $this->getDefaultData($request));
    }

    public function singeDictionary(Request $request, $id)
    {
        $fields = ['id', 'lao', 'japanese', 'description', 'updated_at'];
        $data = Dictionary::select($fields)->where('id', $id)->first();
        if (!isset($data)) {
            return redirect('/');
        }
        return view("{$this->rootView}.single.single-dictionary", array_merge($this->getDefaultData($request), ['post' => $data]));
    }


    public function getDictionaryComments(Request $request)
    {
        return new DictionaryCommentResponse('get');
    }

    public function manageDictionaryComments(Request $request)
    {
        $rules = [
            'text' => 'required',
        ];
        if (!$request->user('api')) {
            $rules = array_merge($rules, ['name' => 'required|max:191', 'surname' => 'required|max:191']);
        }
        $this->validate($request, $rules);
        return new DictionaryCommentResponse('manage');
    }

    public function deleteDictionaryComments(Request $request)
    {
        return new DictionaryCommentResponse('delete');
    }
    /**
     * @EndDictionarySection
     */

    /***@Get Home Data
     * @param $request
     * @return array
     */
    public function getHomeData($request): array
    {
        $data = [];
        $data['banners'] = Banner::getBanners(8);
        $data['AboutJaol'] = AboutJaol::getAbout();
        $data['ContactInfo'] = ContactInfo::getContactInfo();
        $data['latest_news'] = Posts::getPosts('news', 3);
        $data['latest_scholarship'] = Posts::getPosts('scholarship', 4);
        $data['latest_event'] = Posts::getPosts('event', 4);
        $data['latest_activity'] = Posts::getPosts('activity', 4);
        $data['mostViewScholarship'] = Posts::where('type', 'scholarship')->where('status', 'open')->orderBy('view', 'desc')->first();
        if ($data['mostViewScholarship']) {//set image
            $data['mostViewScholarship']->image = Posts::$uploadPath . $data['mostViewScholarship']->image;
            $data['mostViewScholarship']->formatted_deadline = date('H:i A, M d Y', strtotime($data['mostViewScholarship']->deadline));
        }
        $data['sponsors'] = Sponsor::getSponsor(20);
        return $data;
    }
    /***@Get Home Data */

    /***@POST_CONTACTINFO
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function responsePostContactInfo(Request $request): JsonResponse
    {
        $data = $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191'],
            'message' => ['required', 'string'],
        ]);
        $this->dispatch(new SendContactInfo($data));
        return response()->json(['success' => true, 'msg' => 'The contact information was sent!.']);
    }

    /***@POST_CONTACTINFO */
    /***@GET_ChartRangeMembers
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function getChartRangeMembers(Request $request, $id): JsonResponse
    {
        $text = $request->get('q');
        $data = (new OrganizeChartMemberResponse('get', ['text' => $text, 'id' => $id]))->get($request);
        return response()->json(['data' => $data]);
    }
    /***@GET_ChartRangeMembers */
}
