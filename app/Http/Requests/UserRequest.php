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
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (request()->isMethod('put')) {
            $emailUnique = (request()->get('email') == \Auth::user()->email)
                ? '' : '|unique:users';
            $usernameUnique = (request()->get('username') == \Auth::user()->username)
                ? '' : '|unique:users';
            return [
                'id' => 'required',
                'username' => 'required' . $usernameUnique,
                'email' => 'required|email' . $emailUnique
            ];
        }
        return [
            'username' => 'required|unique:users',
            'password' => ['required', 'min:6', 'regex:/^(?:[0-9]+[a-z]|[a-z]+[0-9])[a-z0-9]*$/i'],
            'email' => 'required|email|unique:users'
        ];
    }
}