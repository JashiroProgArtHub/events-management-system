<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventFormRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'venue' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date_format:Y-m-d H:i', 'after:now'],
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Event title is required.',
            'title.max' => 'Event title must not exceed 255 characters.',
            'description.required' => 'Event description is required.',
            'description.min' => 'Event description must be at least 10 characters.',
            'venue.required' => 'Event venue is required.',
            'event_date.required' => 'Event date and time are required.',
            'event_date.date_format' => 'Event date must be in format: YYYY-MM-DD HH:MM.',
            'event_date.after' => 'Event date must be in the future.',
        ];
    }
}
