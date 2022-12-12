<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
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
            'user_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'd_o_b' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'image' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'please Iinput a valid user name',
            'first_name.string' => 'first name must be a name',
            'first_name.required' => 'please input a valid first name',
            'last_name.string' => 'first name must be a name',
            'last_name.required' => 'please input a valid last name',
            'd_o_b.min:1990-12-31' => 'date of birth must not be more than 1990',
            'd_o_b.required' => 'please input a valid date of birth',
            'phone.max:11' => 'phone must be more than eleven digit',
            'phone.required' => 'please input a valid phone number',
            'image.required' => 'please upload an image',
            'address.required' => 'please ad your home address',
        ];
    }
}
