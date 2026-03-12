<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\RedirectResponse;

class StudentDestroyController extends Controller
{
    public function __invoke(Student $student, StudentService $studentService): RedirectResponse
    {
        $this->authorize('delete', $student);

        $studentService->destroyStudent($student);

        return redirect()
            ->route('admin.students.index')
            ->with('status', 'Student deleted successfully.');
    }
}
