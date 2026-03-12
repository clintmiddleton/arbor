<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttendanceSession extends Model
{
    protected $fillable = [
        'classroom_id',
        'session_date',
        'session_time',
        'status',
        'created_by',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'session_date' => 'date',
            'submitted_at' => 'datetime',
        ];
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function records(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class, 'attendance_session_id');
    }

    public function isEditable(): bool
    {
        return $this->status === 'draft';
    }
}
