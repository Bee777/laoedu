<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 3/3/2019
 * Time: 11:33 AM
 */

namespace App\Responses\Home;


use App\Banner;
use App\Dictionary;
use App\Http\Controllers\Helpers\Helpers;
use App\Posts;
use App\Traits\DefaultData;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;

class SinglePostsResponse implements Responsable
{
    use DefaultData;

    protected $options = [];
    protected $type = '';
    protected $id;

    public function __construct($options, $type, $id)
    {
        $this->options = $options;
        $this->type = $type;
        $this->id = $id;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response | mixed
     */
    public function toResponse($request)
    {
        $type = $this->getPostsType($this->type);

        $post = Posts::where('type', $type)->whereIn('status', ['open', 'close'])->where('id', $this->id)->first();
        $post_type_name = ucfirst($this->type);
        if (Helpers::isAjax($request)) {
            //@for dictionaries only
            if ($type === 'dictionary') {
                $fields = ['id', 'lao', 'japanese', 'description', 'updated_at'];
                $data = Dictionary::select($fields)->where('id', $this->id)->first();
                if (!isset($data)) {
                    return response()->json(['success' => false, 'msg' => 'The post does not exits!.']);
                }
                return ['data' => $data, 'others' => []];
            }
            //@for dictionaries only
            if (!isset($post)) {
                return response()->json(['success' => false, 'msg' => 'The post does not exits!.']);
            }
            Posts::IncreaseViews($post->id);
            return $this->postsPaginator($request);
        }
        if (empty($type)) {
            return redirect('/');
        }
        if (!isset($post)) {
            return redirect('/');
        }
        Posts::IncreaseViews($post->id);
        return view("{$this->options['rootView']}.single.single-posts",
            array_merge(['post_type_name' => $post_type_name, 'type' => $this->type, 'post' => $post], $this->getDefaultData($request)));
    }

    public function postsPaginator($request): array
    {
        $type = $this->getPostsType($this->type);

        $fields = ['id', 'title', 'type', 'image', 'description', 'status', 'place', 'start_date', 'deadline', 'updated_at', 'user_id',];
        $data = Posts::select($fields)->where('type', $type)->whereIn('status', ['open', 'close'])->where('id', $this->id)->first();

        $this->mapPost($data);
        $others = Posts::select($fields)->where('type', $type)->whereIn('status', ['open', 'close'])
            ->limit(3)->where('id', '!=', $this->id)->inRandomOrder()->get();
        $this->mapPosts($others);
        return ['data' => $data, 'others' => $others];
    }

    public function getPostsType($title)
    {
        $types = [
            'activities' => 'activity', 'news' => 'news',
             'scholarships' => 'scholarship',
            'dictionaries' => 'dictionary',
        ];
        return $types[$title] ?? '';
    }

    public function mapPosts($data): void
    {
        $data->map(function ($d) {
            $d->author = $d->user->name;
            $d->author_image = $d->user->userInfo['imagePath'] . $d->user->userInfo['preThumb'] . $d->user->image;
            $d->image = Posts::$uploadPath . $d->image;
            $d->post_updated = Helpers::toFormatDateString($d->updated_at, 'H:i A, j M Y');
            $d->isClosed = $d->status==='close';

            if ($d->type === 'activity') {
                $d->formatted_start_date = Helpers::toFormatDateString($d->start_date, 'j M Y');
            }
            // if ($d->type === 'event') {

            //     $d->formatted_start_date = Helpers::toFormatDateString($d->start_date, 'M d Y');
            //     $d->formatted_deadline = Helpers::toFormatDateString($d->deadline, 'M d Y');

            //     $d->during_time = Helpers::toFormatDateString($d->start_date, 'H:i A') . ' - ';
            //     $d->during_time .= Helpers::toFormatDateString($d->deadline, 'H:i A');
            // }

            if ($d->type === 'scholarship') {
                $d->formatted_deadline = date('H:i A, M d Y', strtotime($d->deadline));
            }
            //remove relationship
            unset($d->user, $d->type);
            $d->setRelations([]);
            unset($d->user_id);
            //remove relationship
            return $d;
        });
    }

    public function mapPost($data): void
    {

        $data->author = $data->user->name . ' ' . $data->user->last_name;
        $data->author_image = $data->user->userInfo['imagePath'] . $data->user->userInfo['preThumb'] . $data->user->image;
        $data->image = Posts::$uploadPath . $data->image;
        $data->post_updated_ago = $data->updated_at->diffForHumans();
        $data->post_updated = Helpers::toFormatDateString($data->updated_at, 'H:i A, j M Y');
        $data->isClosed = $data->status==='close';
        if ($data->type === 'activity') {
            $data->formatted_start_date = Helpers::toFormatDateString($data->start_date, 'j M Y');
            $data->formatted_start_date_ago = $data->start_date->diffForHumans();
        }
        // if ($data->type === 'event') {
        //     $data->formatted_start_date = Helpers::toFormatDateString($data->start_date, 'M d Y');
        //     $data->formatted_deadline = Helpers::toFormatDateString($data->deadline, 'M d Y');
        //     $data->during_time = Helpers::toFormatDateString($data->start_date, 'H:i A') . ' - ';
        //     $data->during_time .= Helpers::toFormatDateString($data->deadline, 'H:i A');
        // }
        if ($data->type === 'scholarship') {
            $data->formatted_deadline = date('H:i A, M d Y', strtotime($data->deadline));
        }
        //remove relationship
        unset($data->user, $data->type);
        $data->setRelations([]);
        unset($data->user_id);
        //remove relationship
    }
}
