<?php
/**
 * Created by PhpStorm.
 * User: Tester-Ali
 * Date: 01-04-2016
 * Time: 9:17 AM
 */

namespace App\Http\Requests;


class UserRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uid' => 'required|unique:users',
            'password' => 'required|min:6',
            'email' => 'required|email|unique:users'
        ];
    }
}