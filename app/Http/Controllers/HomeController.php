<?php

namespace App\Http\Controllers;

use App\Common;
use App\Http\Requests\Request;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Routing\Controller as BaseController;

class HomeController extends BaseController
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Responds to requests to GET /home/User/[:id]
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser($id = 0)
    {
        if($id > 0 && $user = User::find($id)){
            return response()->json($user->toArray());
        }
        return response()->json(User::all());
    }


    /**
     * Responds to requests to POST /home/User
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUser(UserRequest $request)
    {
        $user = User::create($request->all());
        if (\Auth::user()->role == 'ADMIN') {
            return response()->json($user->toArray());
        }
        return response()->json(false);
    }


    /**
     * Responds to requests to PUT /home/User/:id
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function putUser(UserRequest $request)
    {
        $user = User::findOrFail($request->id);
        if (true) {
            $user->update($request->all());
            return response()->json($user->toArray());
        }
        return response()->json(false);
    }

    /**
     * Responds to requests to GET /home/common
     */
    public function getCommon()
    {
        $commons = [];
        $t = Common::all();
        /** @var Common $common */
        foreach ($t as $common) {
            $commons[$common->name] = json_decode($common->value);
        }
        return response()->json($commons);
    }
}
