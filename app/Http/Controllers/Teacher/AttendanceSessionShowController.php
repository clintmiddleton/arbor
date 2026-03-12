<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\AttendanceSession;
use App\Models\Classroom;
use Inertia\Inertia;
use Inertia\Response;

class AttendanceSessionShowController extends Controller
{
    public function __invoke(Classroom $classroom, AttendanceSession $session): Response
    {
        $this->authorize('view', $session);

        $session->load(['records.student', 'classroom.teacher']);

        return Inertia::render('Teacher/Attendance/Edit', [
            'classroom' => $session->classroom,
            'session' => $session,
        ]);
    }
}
