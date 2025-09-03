<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInternRequest extends FormRequest
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
            'name'=>'max:255|min:5',
            'email'=>'email',
            'departmentEdit'=>'exists:interns,department',
            'mac_address'=>'regex:/^([0-9a-fA-F]{2}:){5}[0-9a-fA-F]{2}$/|unique:interns,mac_address'
        ];
    }



    public function messages(): array
    {
        return [
            'name.max'=> 'The name cannot exceed 255 characters',
            'name.min'=> 'The name must be above 5 characters',
            'email.email'=> 'The field must be an email',
            'departmentEdit.exists'=>'The department does not exist',
            'mac_address.regex' => 'The MAC address must be in the format XX:XX:XX:XX:XX:XX',
            ];
    }
}
