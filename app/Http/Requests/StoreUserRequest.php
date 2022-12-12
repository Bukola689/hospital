<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        return [
            'username' => ['string','required'],
            'email' => 'required',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'username.string' => 'username must be a string',
            'username.required' => 'please input your username correctly',
            'email.required' => 'please input your email',
            'password.required' => 'input your password'
        ];
    }
}
