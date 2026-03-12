<?php

namespace App\Http\Requests\AttendanceSession;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttendanceSessionStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $classroom = $this->route('classroom');

        return [
            'session_date' => [
                'required',
                'date',
                Rule::unique('attendance_sessions')
                    ->where('classroom_id', $classroom->id),
            ],
            'session_time' => ['required', 'date_format:H:i'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'session_date.unique' => 'An attendance session already exists for this classroom on this date.',
        ];
    }
}
