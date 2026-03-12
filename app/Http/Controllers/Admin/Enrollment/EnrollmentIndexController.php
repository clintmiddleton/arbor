<?php

namespace App\Http\Controllers\Admin\Enrollment;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Student;
use App\Services\EnrollmentService;
use Inertia\Inertia;
use Inertia\Response;

class EnrollmentIndexController extends Controller
{
    public function __invoke(Classroom $classroom, EnrollmentService $enrollmentService): Response
    {
        $this->authorize('viewAny', \App\Models\Enrollment::class);

        $classroom->load('teacher');
        $enrollments = $enrollmentService->indexByClassroom($classroom);

        $enrolledStudentIds = $enrollments->pluck('student_id')->toArray();
        $availableStudents = Student::query()
            ->whereNotIn('id', $enrolledStudentIds)
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get(['id', 'student_number', 'first_name', 'last_name', 'email']);

        return Inertia::render('Admin/Enrollment/Index', [
            'classroom' => $classroom,
            'enrollments' => $enrollments,
            'availableStudents' => $availableStudents,
        ]);
    }
}
