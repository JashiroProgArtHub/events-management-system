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
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10', 'max:1000'],
            'venue' => ['required', 'string', 'max:255'],
            // datetime-local input sends format: Y-m-d\TH:i (with T separator, not space)
            'event_date' => ['required', 'date_format:Y-m-d\TH:i'],
        ];

        // Only require future dates for CREATE (POST), not for UPDATE (PUT/PATCH)
        if ($this->isMethod('post')) {
            $rules['event_date'][] = 'after:now';
        }

        return $rules;
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
            'description.max' => 'Event description must not exceed 1000 characters.',
            'venue.required' => 'Event venue is required.',
            'venue.max' => 'Venue name must not exceed 255 characters.',
            'event_date.required' => 'Event date and time are required.',
            'event_date.date_format' => 'Event date and time format is invalid. Please use the date/time picker.',
            'event_date.after' => 'Event date must be in the future.',
        ];
    }
}
