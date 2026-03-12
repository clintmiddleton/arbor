<?php

namespace App\Http\Controllers\Admin\Enrollment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enrollment\EnrollmentStoreRequest;
use App\Models\Classroom;
use App\Models\Enrollment;
use App\Models\Student;
use App\Services\EnrollmentService;
use Illuminate\Http\RedirectResponse;

class EnrollmentStoreController extends Controller
{
    public function __invoke(EnrollmentStoreRequest $request, Classroom $classroom, EnrollmentService $enrollmentService): RedirectResponse
    {
        $this->authorize('create', Enrollment::class);

        $student = Student::findOrFail($request->validated('student_id'));
        $enrollmentService->enroll($classroom, $student);

        return redirect()
            ->route('admin.classrooms.enrollments.index', $classroom)
            ->with('status', 'Student enrolled successfully.');
    }
}
