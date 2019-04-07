<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 3/5/2019
 * Time: 3:09 PM
 */

namespace App\Responses\User;


use App\Http\Controllers\Helpers\Helpers;
use App\Jobs\SendNewPostsCreated;
use App\Posts;
use Illuminate\Contracts\Support\Responsable;
use Image;

class UserNewsResponse implements Responsable
{

    protected $actionType = 'get';
    protected $options = [];
    protected $uploadPath = '/assets/images/posts/';

    public function __construct($actionType, $options = [])
    {
        $this->options = $options;
        $this->actionType = $actionType;
    }

    /**
     * Create an HTTP response that represents the object.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function get($request)
    {
        $fields = ['id', 'title', 'image', 'status', 'description', 'user_id', 'created_at', 'updated_at'];
        $request->request->add(['fields' => $fields]);
        $text = $this->options['text'];
        $paginateLimit = $this->options['limit'];
        $data = Posts::select($fields)->where('type', 'news')->where('user_id', auth()->user()->id);
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
            $d->statusColor = $d->status === 'open' ? '#00bfa5' : ($d->status === 'close' ? '#d50000' : '');
            $d->filename = $d->image;
            $d->image = "{$this->uploadPath}{$d->image}";
            return $d;
        });
        return $data;
    }

    public function toResponse($request)
    {
        $data = [];
        if (Helpers::isAjax($request)) {
            if ($this->actionType === 'insert') {
                $file = $request->file('image');
                $fileExt = strtolower($file->getClientOriginalExtension());
                $imgOriginalName = Helpers::subFileName($file->getClientOriginalName()) . md5('^');
                $img_filename = $imgOriginalName . md5(date('Y-m-d H:i:s') . microtime()) . time() . '_posts.' . $fileExt;
                if ($fileExt === 'gif' || $fileExt === 'svg') {
                    $location = public_path($this->uploadPath);
                    $file->move($location, $img_filename);
                } else {
                    $img = Image::make($file);
                    $location = public_path($this->uploadPath . $img_filename);
                    $img->save($location)->destroy();
                }
                $info = new Posts();
                $info->title = $request->get('title');
                $info->image = $img_filename;
                $info->type = 'news';
                $info->description = $request->get('description');
                $info->user_id = auth()->user()->id;
                $info->status = 'pending';//for normal user
                $info->save();
                $data = $info;
                //@send an email to admin email or site email
                dispatch(new SendNewPostsCreated($data));
            } else if ($this->actionType === 'update') {
                $info = Posts::where('id', $request->id)->where('user_id', auth()->user()->id)->first();
                $img_filename = null;
                if (isset($info)) {
                    if ($request->hasFile('image')) {
                        $file = $request->file('image');
                        $fileExt = strtolower($file->getClientOriginalExtension());
                        $imgOriginalName = Helpers::subFileName($file->getClientOriginalName()) . md5('^');
                        $img_filename = $imgOriginalName . md5(date('Y-m-d H:i:s') . microtime()) . time() . '_posts.' . $fileExt;
                        if ($fileExt === 'gif' || $fileExt === 'svg') {
                            $location = public_path($this->uploadPath);
                            $file->move($location, $img_filename);
                        } else {
                            $img = Image::make($file);
                            $location = public_path($this->uploadPath . $img_filename);
                            $img->save($location)->destroy();
                        }
                        Helpers::removeFile($this->uploadPath . $info->image);
                    }
                    $info->title = $request->get('title');
                    $info->description = $request->get('description');
                    $info->image = $img_filename ?? $info->image;
                    $info->save();
                    $data = $info;
                }
            } else if ($this->actionType === 'delete') {
                $info = Posts::where('id', $request->id)->where('user_id', auth()->user()->id)->first();
                if (isset($info)) {
                    Helpers::removeFile($this->uploadPath . $info->image);
                    $info->delete();
                    $data = $info;
                }
            }
            return response()->json(['success' => true, 'data' => $data]);
        }
    }
}
