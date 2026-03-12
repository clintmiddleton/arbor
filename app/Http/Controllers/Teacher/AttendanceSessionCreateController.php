<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Inertia\Inertia;
use Inertia\Response;

class AttendanceSessionCreateController extends Controller
{
    public function __invoke(Classroom $classroom): Response
    {
        $this->authorize('create', [\App\Models\AttendanceSession::class, $classroom]);

        $classroom->load('teacher');

        return Inertia::render('Teacher/Attendance/Create', [
            'classroom' => $classroom,
        ]);
    }
}
