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
    public function Login(LoginRequest $request){
        if(\Auth::attempt($request->all())){
            return \Auth::user();
        }else{
            return 'Invalid username/password';
        }
    }

    public Function Logout(){
        \Auth::logout();
        return 'logged out';
    }
}