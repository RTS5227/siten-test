<?php

namespace App\Http\Controllers;

use App\Common;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Routing\Controller as BaseController;

class HomeController extends BaseController
{
    /**
     * Responds to requests to GET /home/allUser
     */
    public function getAllUser()
    {
        return response()->json(User::all());
    }

    /**
     * Responds to requests to GET /home/User/:id
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser($id){
        $user = User::findOrFail($id);
        return response()->json($user->toArray());
    }


    /**
     * Responds to requests to POST /home/User
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUser(UserRequest $request){
        $user = User::create($request->all());
        return response()->json($user->toArray());
    }


    /**
     * Responds to requests to PUT /home/User/:id
     *
     * @param UserRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putUser(UserRequest $request, $id){
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user->toArray());
    }

    /**
     * Responds to requests to GET /home/common
     */
    public function getCommon(){
        $commons = [];
        $t= Common::all();
        /** @var Common $common */
        foreach($t as $common){
            $commons[$common->name] = json_decode($common->value);
        }
        return response()->json($commons);
    }
}
