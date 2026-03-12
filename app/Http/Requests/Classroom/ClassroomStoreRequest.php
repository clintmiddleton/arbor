<?php

namespace App\Http\Requests\Classroom;

use Illuminate\Foundation\Http\FormRequest;

class ClassroomStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'grade_level' => ['required', 'string', 'max:10'],
            'academic_year' => ['required', 'string', 'max:10'],
            'teacher_id' => ['required', 'exists:users,id'],
        ];
    }
}
