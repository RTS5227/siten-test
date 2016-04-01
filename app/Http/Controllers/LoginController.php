<?php
/**
 * Created by PhpStorm.
 * User: Tester-Ali
 * Date: 01-04-2016
 * Time: 9:51 AM
 */

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Log;

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
            Log::create(['actor'=>\Auth::user()->username, 'action' => 'login successful']);
            return response()->json(\Auth::user());
        } else {
            Log::create(['actor'=>'', 'action' => 'login failed']);
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
        Log::create(['actor'=>\Auth::user()->username, 'action' => 'logout successful']);
        \Auth::logout();
        return 'logged out';
    }
}