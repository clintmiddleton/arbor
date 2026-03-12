<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Inertia\Inertia;
use Inertia\Response;

class StudentCreateController extends Controller
{
    public function __invoke(): Response
    {
        $this->authorize('create', Student::class);

        return Inertia::render('Admin/Student/Create');
    }
}
