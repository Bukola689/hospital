<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
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
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'service_id' => 'required',
            'phone' => 'required',
            'message' => 'required',
            'appointment_date' => 'nullable|date'
        ];
    }

    public function messages()
    {
        return [
            'patient_id.require' => 'please select a patient name',
            'doctor_id.required' => 'please choose a doctor',
            'service_id.required' => 'please select your service',
            'phone.required' => 'input your phone number',
            'message.required' => 'type your message '
        ];
    }
}
