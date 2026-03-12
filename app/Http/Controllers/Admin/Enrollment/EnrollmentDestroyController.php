<?php

namespace App\Http\Controllers\Admin\Enrollment;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Services\EnrollmentService;
use Illuminate\Http\RedirectResponse;

class EnrollmentDestroyController extends Controller
{
    public function __invoke(Enrollment $enrollment, EnrollmentService $enrollmentService): RedirectResponse
    {
        $this->authorize('delete', $enrollment);

        $classroom = $enrollment->classroom;
        $enrollmentService->unenroll($enrollment);

        return redirect()
            ->route('admin.classrooms.enrollments.index', $classroom)
            ->with('status', 'Student removed from classroom.');
    }
}
