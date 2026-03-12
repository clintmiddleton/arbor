<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\RedirectResponse;

class StudentUpdateController extends Controller
{
    public function __invoke(StudentUpdateRequest $request, Student $student, StudentService $studentService): RedirectResponse
    {
        $this->authorize('update', $student);

        $studentService->updateStudent($student, $request->validated());

        return redirect()
            ->route('admin.students.show', $student)
            ->with('status', 'Student updated successfully.');
    }
}
