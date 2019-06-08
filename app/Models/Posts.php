<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Helpers\Helpers;

class Posts extends Model
{
    protected $dates = ['start_date', 'deadline'];
    public static $uploadPath = '/assets/images/posts/';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getPosts($type, $limit)
    {
        $mLimit = Helpers::isNumber($limit) ? $limit : 3;
        $posts = self::where('type', $type)->limit($mLimit)->orderBy('id', 'desc')->where('status', 'open')->get();
        $posts->map(function ($post) {
            $post->author = $post->user->name;
            $post->formatted_updated_at = Helpers::toFormatDateString($post->updated_at, 'M d, Y');
            $post->formatted_start_date = Helpers::toFormatDateString($post->start_date, 'M d Y');
            $post->formatted_end_date = Helpers::toFormatDateString($post->deadline, 'M d Y');
            $post->formatted_deadline = Helpers::toFormatDateString($post->deadline, 'H:i A, M d Y');
            $post->formatted_start_time = Helpers::toFormatDateString($post->start_date, 'H:i A');
            $post->formatted_end_time = Helpers::toFormatDateString($post->deadline, 'H:i A');

            $post->image = url('/assets/images/posts') . '/' . $post->image;
            unset($post->user);
            $post->setRelations([]);
            return $post;
        });
        return $posts;
    }

    public static function IncreaseViews($id): void
    {
        $c = self::find($id);
        if (isset($c)) {
            $c->timestamps = false;
            ++$c->view;
            $c->save();
        }
    }
}
