<?php
/**
 * Created by PhpStorm.
 * User: Tester-Ali
 * Date: 01-04-2016
 * Time: 9:51 AM
 */

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    /**
     * User Login
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Login(LoginRequest $request)
    {
        if (\Auth::attempt($request->all())) {
            return response()->json(\Auth::user());
        } else {
            return response()->json(['auth' => ['Invalid username/password']], 401);
        }
    }

    /**
     * check Authenticated
     * @return \Illuminate\Http\JsonResponse
     */
    public function Auth()
    {
        if (\Auth::check()) {
            return response()->json(\Auth::user());
        } else {
            return response()->json(['auth' => ['Access denied']], 403);
        }
    }

    /**
     * User logout
     * @return string
     */
    public Function Logout()
    {
        \Auth::logout();
        return 'logged out';
    }
}