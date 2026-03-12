<?php

namespace App\Jobs;

use App\Models\AttendanceRecord;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendParentNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public AttendanceRecord $record
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Placeholder for future parent notification logic (e.g. email/SMS when student is absent)
        Log::info('SendParentNotificationJob dispatched', [
            'record_id' => $this->record->id,
            'student_id' => $this->record->student_id,
        ]);
    }
}
