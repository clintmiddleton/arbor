<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\StudentService;
use Inertia\Inertia;
use Inertia\Response;

class StudentIndexController extends Controller
{
    public function __invoke(StudentService $studentService): Response
    {
        $this->authorize('viewAny', Student::class);

        $students = $studentService->index();

        return Inertia::render('Admin/Student/Index', [
            'students' => $students,
        ]);
    }
}
