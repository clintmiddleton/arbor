<?php

namespace App\Services;

use App\Events\AttendanceSessionCreated;
use App\Events\AttendanceSessionSubmitted;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\Classroom;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    /**
     * List attendance sessions for a classroom with pagination.
     *
     * @return LengthAwarePaginator<AttendanceSession>
     */
    public function sessionsForClassroom(Classroom $classroom, int $perPage = 15): LengthAwarePaginator
    {
        return $classroom->attendanceSessions()
            ->with('records.student')
            ->orderByDesc('session_date')
            ->orderByDesc('session_time')
            ->paginate($perPage);
    }

    /**
     * Create a new attendance session with records for each enrolled student.
     */
    public function createSession(Classroom $classroom, array $data): AttendanceSession
    {
        return DB::transaction(function () use ($classroom, $data) {
            $session = AttendanceSession::create([
                'classroom_id' => $classroom->id,
                'session_date' => $data['session_date'],
                'session_time' => $data['session_time'],
                'status' => 'draft',
                'created_by' => auth()->id(),
            ]);

            $enrollments = $classroom->enrollments()->with('student')->get();

            foreach ($enrollments as $enrollment) {
                AttendanceRecord::create([
                    'attendance_session_id' => $session->id,
                    'student_id' => $enrollment->student_id,
                    'status' => 'present',
                    'recorded_at' => now(),
                ]);
            }

            AttendanceSessionCreated::dispatch($session);

            return $session->load('records.student');
        });
    }

    /**
     * Update attendance records for a session.
     */
    public function updateRecords(AttendanceSession $session, array $records): AttendanceSession
    {
        if (! $session->isEditable()) {
            throw new \InvalidArgumentException('Session cannot be edited.');
        }

        return DB::transaction(function () use ($session, $records) {
            foreach ($records as $recordData) {
                $record = AttendanceRecord::where('attendance_session_id', $session->id)
                    ->where('student_id', $recordData['student_id'])
                    ->first();

                if ($record) {
                    $record->update([
                        'status' => $recordData['status'],
                        'notes' => $recordData['notes'] ?? null,
                        'recorded_at' => now(),
                    ]);
                }
            }

            return $session->fresh(['records.student']);
        });
    }

    /**
     * Submit an attendance session (finalize it).
     */
    public function submitSession(AttendanceSession $session): AttendanceSession
    {
        if (! $session->isEditable()) {
            throw new \InvalidArgumentException('Session cannot be submitted.');
        }

        $session->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        AttendanceSessionSubmitted::dispatch($session);

        return $session->fresh();
    }
}
