<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceSession\AttendanceSessionStoreRequest;
use App\Models\Classroom;
use App\Services\AttendanceService;
use Illuminate\Http\RedirectResponse;

class AttendanceSessionStoreController extends Controller
{
    public function __invoke(AttendanceSessionStoreRequest $request, Classroom $classroom, AttendanceService $attendanceService): RedirectResponse
    {
        $this->authorize('create', [\App\Models\AttendanceSession::class, $classroom]);

        $session = $attendanceService->createSession($classroom, $request->validated());

        return redirect()
            ->route('teacher.classrooms.attendance.edit', [$classroom, $session])
            ->with('status', 'Attendance session created. Record attendance below.');
    }
}
