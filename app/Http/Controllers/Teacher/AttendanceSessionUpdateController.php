<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceSession\AttendanceSessionUpdateRequest;
use App\Models\AttendanceSession;
use App\Models\Classroom;
use App\Services\AttendanceService;
use Illuminate\Http\RedirectResponse;

class AttendanceSessionUpdateController extends Controller
{
    public function __invoke(AttendanceSessionUpdateRequest $request, Classroom $classroom, AttendanceSession $session, AttendanceService $attendanceService): RedirectResponse
    {
        $this->authorize('update', $session);

        $data = $request->validated();
        $records = $data['records'];

        $attendanceService->updateRecords($session, $records);

        if (! empty($data['submit'])) {
            $attendanceService->submitSession($session);

            return redirect()
                ->route('teacher.classrooms.attendance.index', $classroom)
                ->with('status', 'Attendance submitted successfully.');
        }

        return redirect()
            ->route('teacher.classrooms.attendance.edit', [$classroom, $session])
            ->with('status', 'Attendance saved as draft.');
    }
}
