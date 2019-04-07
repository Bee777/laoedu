<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 2/11/2019
 * Time: 2:38 PM
 */

namespace App\Responses;


use App\Http\Controllers\Helpers\Helpers;
use App\Site;
use Illuminate\Contracts\Support\Responsable;
use App\ContactInfo;

class ContactInfoResponse implements Responsable
{

    protected $actionType = "get";

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

            if ($this->actionType === 'get') {
                $data = ContactInfo::first();
            }

            if ($this->actionType === 'manage') {
                $info = ContactInfo::first();
                if (!isset($info)) {
                    $info = new ContactInfo();
                }
                $data = $info;
                $info->phone = $request->get('phone');
                $info->email = $request->get('email');
                $info->address = $request->get('address');
                $info->facebook = $request->get('facebook');
                $info->googleplus = $request->get('googleplus');
                $info->twitter = $request->get('twitter');
                $info->save();
                //save for site table
                $oldData = Site::where('key', 'email')->first();
                if (isset($oldData)) {
                    $oldData->value = $request->get('email');
                    $oldData->save();
                }
                //save for site table
            }
            return response()->json(['success' => true, "data" => $data]);
        }
    }

}
