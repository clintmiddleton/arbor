<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Services\AttendanceService;
use Inertia\Inertia;
use Inertia\Response;

class AttendanceSessionIndexController extends Controller
{
    public function __invoke(Classroom $classroom, AttendanceService $attendanceService): Response
    {
        $this->authorize('viewAny', [\App\Models\AttendanceSession::class, $classroom]);

        $classroom->load('teacher');
        $sessions = $attendanceService->sessionsForClassroom($classroom);

        return Inertia::render('Teacher/Attendance/Index', [
            'classroom' => $classroom,
            'sessions' => $sessions,
        ]);
    }
}
