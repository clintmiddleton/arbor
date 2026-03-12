<?php

namespace App\Listeners;

use App\Events\AttendanceSessionCreated;
use Illuminate\Support\Facades\Log;

class LogAttendanceSessionCreated
{
    /**
     * Handle the event.
     */
    public function handle(AttendanceSessionCreated $event): void
    {
        Log::info('attendance.session.created', [
            'session_id' => $event->session->id,
            'classroom_id' => $event->session->classroom_id,
            'session_date' => $event->session->session_date?->toDateString(),
        ]);
    }
}
