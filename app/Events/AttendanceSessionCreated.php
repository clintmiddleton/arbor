<?php

namespace App\Events;

use App\Models\AttendanceSession;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AttendanceSessionCreated
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public AttendanceSession $session
    ) {}
}
