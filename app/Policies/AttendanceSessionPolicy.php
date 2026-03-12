<?php

namespace App\Policies;

use App\Models\AttendanceSession;
use App\Models\Classroom;
use App\Models\User;

class AttendanceSessionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Classroom $classroom): bool
    {
        return $classroom->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AttendanceSession $session): bool
    {
        return $session->classroom->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Classroom $classroom): bool
    {
        return $classroom->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AttendanceSession $session): bool
    {
        return $session->classroom->teacher_id === $user->id;
    }
}
