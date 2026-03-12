<?php

namespace App\Http\Requests\AttendanceSession;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceSessionUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'records' => ['required', 'array'],
            'records.*.student_id' => ['required', 'exists:students,id'],
            'records.*.status' => [
                'required',
                'in:present,absent,tardy,excused',
            ],
            'records.*.notes' => ['nullable', 'string', 'max:255'],
            'submit' => ['boolean'],
        ];
    }
}
