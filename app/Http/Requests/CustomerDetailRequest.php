<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerDetailRequest extends FormRequest
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
            'name' => 'required|string',
            'phone' => 'required',
            'email' => 'required|email',
            'date_of_birth' => 'required|date',
            'address' => 'required',
            'gender' => 'required|in:Male,Female,Others',
            'nationality' => 'required',
            'preferred_contact_mode' => 'required|in:Email,Phone,Both,None',
            'education_details.*.education_type' => 'required|in:School,HighSchool,Bachelors,Master,Phd',
            'education_details.*.institution_name' => 'required',
            'education_details.*.institution_address' => 'required',
            'education_details.*.current_status' => 'required|in:Ongoing,Completed',
            'education_details.*.grade' => 'required_if:current_status,Completed',
            'education_details.*.start_date' => 'required|date',
            'education_details.*.end_date' => 'nullable|date|required_if:current_status,Completed',
        ];

    }
}
