<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterUserRequest extends FormRequest
{
    use RegistersUsers;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => 'required|max:55|unique:users',
            'user_type'             => 'required',
            'full_name'             => 'required',
            'email'                 => array(
                'required',
                'email',
                'max:55',
                'unique:users',
            ),
            'phone_number'          => 'required|numeric|min:8|unique:users',
            'password'              => 'required|min:6|max:30|confirmed',
            'password_confirmation' => 'required|same:password',
        ];
    }
}
