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
use App\AboutJaol;

class AboutInfoResponse implements Responsable
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

            if($this->actionType==='get'){
               $data = AboutJaol::first();
            }

            if($this->actionType==='manage'){
                $info = AboutJaol::first();
                if(!isset($info)){
                    $info = new AboutJaol();
                }
                $data = $info;
                $info->description =$request->get('description');
                $info->save();


            }
            return response()->json(['success' => true, "data" => $data]);
        }
    }

}