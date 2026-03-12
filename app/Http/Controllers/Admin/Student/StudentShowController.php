<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\StudentService;
use Inertia\Inertia;
use Inertia\Response;

class StudentShowController extends Controller
{
    public function __invoke(Student $student, StudentService $studentService): Response
    {
        $this->authorize('view', $student);

        $student = $studentService->show($student);

        return Inertia::render('Admin/Student/Show', [
            'student' => $student,
        ]);
    }
}
