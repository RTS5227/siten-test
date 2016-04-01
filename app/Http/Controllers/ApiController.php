<?php

namespace App\Http\Controllers;

use App\Common;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class ApiController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * GET /api/search
     *
     * @param SearchRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSearch(SearchRequest $request)
    {
        $q = User::query();
        if ($request->has('username')) {
            $q->where('username', '=', $request->get('username'));
        }
        if ($request->has('email')) {
            $q->where('email', 'LIKE', "%{$request->get('email')}%");
        }
        if ($request->has('type')) {
            $q->where('type', '=', $request->get('type'));
        }
        if ($request->has('office')) {
            $q->where('office', '=', $request->get('office'));
        }
        if ($request->has('role')) {
            $q->where('role', '=', $request->get('role'));
        }
        $result = $q->paginate(10);
        $lastId = DB::table('users')->select(DB::raw('max(id) as max'))->get();
        $lastId = +$lastId[0]->max;
        return response()->json(['result' => $result, 'last_id'=> $lastId]);
    }

    /**
     * Responds to requests to GET /api/User/[:id]
     *
     * @param SearchRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(SearchRequest $request)
    {
        if ($request->has('id') && $user = User::find(+$request->get('id'))) {
            return response()->json($user->toArray());
        }
        return $this->getSearch($request);
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
        if (\Auth::user()->role === 'ADMIN') {
            $user = User::create($data);
            return response()->json($user->toArray());
        }
        return response()->json(['role' => ['Access Denied']], 403);
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
        } else {
        }
        return response()->json(['role' => ['Access Denied']], 403);
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
