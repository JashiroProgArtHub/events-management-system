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
            'full_name' => ['required', 'string', 'max:255'],
            'course' => ['required', 'string', 'max:255'],
            'year_level' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'contact_number' => ['required', 'string', 'max:20'],
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Participant full name is required.',
            'full_name.max' => 'Full name must not exceed 255 characters.',
            'course.required' => 'Course is required.',
            'year_level.required' => 'Year level is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'contact_number.required' => 'Contact number is required.',
        ];
    }
}
