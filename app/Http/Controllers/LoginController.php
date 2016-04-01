<?php
/**
 * Created by PhpStorm.
 * User: Tester-Ali
 * Date: 01-04-2016
 * Time: 9:51 AM
 */

namespace App\Http\Controllers;

class LoginController
{
    public function Login(){
        if(Auth::attempt(Input::only('username','password'))){
            return Auth::user();
        }else{
            return 'invalid username/password';
        }
    }

    public Function Logout(){
        Auth::logout();
        return 'logged out';
    }
}