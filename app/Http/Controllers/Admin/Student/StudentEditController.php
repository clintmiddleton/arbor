<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Inertia\Inertia;
use Inertia\Response;

class StudentEditController extends Controller
{
    public function __invoke(Student $student): Response
    {
        $this->authorize('update', $student);

        return Inertia::render('Admin/Student/Edit', [
            'student' => $student,
        ]);
    }
}
