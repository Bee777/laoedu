<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 2/11/2019
 * Time: 2:38 PM
 */

namespace App\Responses;

use App\Http\Controllers\Helpers\Helpers;
use Illuminate\Contracts\Support\Responsable;
use App\Posts;

class OrganizeInfoResponse implements Responsable
{

    protected $actionType = 'get';

    public function __construct($actionType)
    {
        $this->actionType = $actionType;
    }

    /**
     * Create an HTTP response that represents the object.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        if (Helpers::isAjax($request)) {
            $data = null;
            if ($this->actionType === 'get') {
                $data = $this->getOrganizeInfo();
            } else if ($this->actionType === 'manage') {
                $info = Posts::first();
                if (!isset($info)) {
                    $info = new Posts();
                }
                $data = $info;
                $info->type = 'organize_info';
                $info->title = 'orginize_title';
                $info->image = 'orginize_image';
                $info->description = $request->get('description');
                $info->save();
            }
            return response()->json(['success' => true, 'data' => $data]);
        }
    }

    public function getOrganizeInfo()
    {
        return Posts::where('status', 'open')->where('type', 'organize_info')->first();
    }

}
