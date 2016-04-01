<?php

namespace App\Http\Controllers;

use App\Common;
use App\Http\Requests\Request;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * GET /api/search
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSearch(UserRequest $request){
        $q = User::query();
        if($request->has('username')){
            $q->where('username', '=', $request->get('username'));
        }
        if($request->has('email')){
            $q->where('email', 'LIKE', "%{$request->get('email')}%");
        }
        if($request->has('type')){
            $q->where('type', '=', $request->get('type'));
        }
        if($request->has('office')){
            $q->where('office', '=', $request->get('office'));
        }
        if($request->has('role')){
            $q->where('role', '=', $request->get('role'));
        }
        $result = $q->orderBy('id')->paginate(10);
        return response()->json($result);
    }

    /**
     * Responds to requests to GET /api/User/[:id]
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser($id = 0)
    {
        if ($id > 0 && $user = User::find($id)) {
            return response()->json($user->toArray());
        }
        return response()->json(User::all());
    }


    /**
     * Responds to requests to POST /api/User
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUser(UserRequest $request)
    {
        $data = $request->all();
        $data['created_by'] = \Auth::user()->username;
        if ($request->password) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        $user = User::create($data);
        if (\Auth::user()->role == 'ADMIN') {
            return response()->json($user->toArray());
        }
        return response()->json(false);
    }


    /**
     * Responds to requests to PUT /api/User/:id
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function putUser(UserRequest $request)
    {
        $user = User::findOrFail($request->id);
        if (\Auth::user()->role == 'ADMIN' || \Auth::user()->username == $user->username) {
            $data = $request->all();
            if ($request->password) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }
            $user->update($data);
            return response()->json($user->toArray());
        }else{
        }
        return response()->json(false);
    }

    /**
     * Responds to requests to GET /api/common
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
