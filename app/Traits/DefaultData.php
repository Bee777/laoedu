<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 3/7/2019
 * Time: 4:29 PM
 */

namespace App\Traits;


use App\AboutJaol;
use App\Banner;
use App\ContactInfo;
use App\Posts;
use App\Responses\Home\PostsResponse;
use App\Site;
use Illuminate\Http\Request;

trait DefaultData
{
    public function getDefaultData(Request $request): array
    {
        $request->request->set('limit', 2);
        return [

            's' => $this->getSettings(),

            'banners' => json_encode(Banner::getBanners(8)),
            'latest_news' => json_encode(Posts::getPosts('news', 3)),

            'news' => json_encode((new PostsResponse([], 'news'))->postsPaginator($request)),
            'activities' => json_encode((new PostsResponse([], 'activities'))->postsPaginator($request)),
            'events' => json_encode((new PostsResponse([], 'events'))->postsPaginator($request)),
            'scholarships' => json_encode((new PostsResponse([], 'scholarships'))->postsPaginator($request)),
            'dictionaries' => json_encode((new PostsResponse([], 'dictionaries'))->postsPaginator($request)),

            'contactInfo' => json_encode(ContactInfo::getContactInfo()),
            'aboutInfo' => json_encode(AboutJaol::getAbout()),
        ];
    }

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
}
