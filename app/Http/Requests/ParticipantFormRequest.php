<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParticipantFormRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'min:3', 'max:255'],
            'course' => ['required', 'string', 'min:2', 'max:255'],
            'year_level' => ['required', 'string', 'min:1', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'contact_number' => ['required', 'regex:/^[0-9\+\-\s\(\)]+$/', 'min:10', 'max:20'],
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Participant full name is required.',
            'full_name.min' => 'Full name must be at least 3 characters.',
            'full_name.max' => 'Full name must not exceed 255 characters.',
            'course.required' => 'Course is required.',
            'course.min' => 'Course must be at least 2 characters.',
            'year_level.required' => 'Year level is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'contact_number.required' => 'Contact number is required.',
            'contact_number.regex' => 'Contact number must be a valid phone number.',
            'contact_number.min' => 'Contact number must be at least 10 digits.',
            'contact_number.max' => 'Contact number must not exceed 20 characters.',
        ];
    }
}
