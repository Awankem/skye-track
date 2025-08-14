<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInternRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|max:255|min:5',
            'email'=>'required|email|unique:interns,email',
            'department'=>'required',
            'mac_address'=>'required|regex:/^([0-9a-fA-F]{2}:){5}[0-9a-fA-F]{2}$/|unique:interns,mac_address'
        ];
    }



    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required',
            'name.max'=> 'The name cannot exceed 255 characters',
            'name.min'=> 'The name must be above 5 characters',
            'email.required' => 'The email field is required',
            'email.email'=> 'The field must be an email',
            'email.unique'=>'The email must not exist in the database',
            'department.required' => 'The department field is required',
            'mac_address.required' => 'The MAC address field is required',
            'mac_address.regex' => 'The MAC address must be in the format XX:XX:XX:XX:XX:XX',
            ];
    }
}
