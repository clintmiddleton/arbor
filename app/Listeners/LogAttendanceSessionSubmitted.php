<?php

namespace App\Listeners;

use App\Events\AttendanceSessionSubmitted;
use Illuminate\Support\Facades\Log;

class LogAttendanceSessionSubmitted
{
    /**
     * Handle the event.
     */
    public function handle(AttendanceSessionSubmitted $event): void
    {
        Log::info('attendance.session.submitted', [
            'session_id' => $event->session->id,
            'classroom_id' => $event->session->classroom_id,
            'session_date' => $event->session->session_date?->toDateString(),
        ]);
    }
}
