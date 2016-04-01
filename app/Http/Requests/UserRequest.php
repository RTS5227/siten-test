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
        $user_id = request()->get('id');
        //edit
        if (request()->isMethod('put')) {
            return [
                'id' => 'required',
                'username' => 'required|unique:users,username,' . $user_id,
                'email' => 'required|email|unique:users,email,' . $user_id
            ];
        }
        //create new
        return [
            'username' => 'required|unique:users',
            'password' => ['required', 'min:6', 'regex:/^(?:[0-9]+[a-z]|[a-z]+[0-9])[a-z0-9]*$/i'],
            'email' => 'required|email|unique:users'
        ];
    }
}