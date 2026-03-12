<?php

namespace App\Services;

use App\Models\Classroom;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ClassroomService
{
    /**
     * List classrooms with pagination.
     *
     * @return LengthAwarePaginator<Classroom>
     */
    public function index(int $perPage = 15): LengthAwarePaginator
    {
        return Classroom::query()
            ->with('teacher')
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * Create a new classroom.
     */
    public function storeClassroom(array $data): Classroom
    {
        return Classroom::create($data);
    }

    /**
     * Get a single classroom.
     */
    public function show(Classroom $classroom): Classroom
    {
        $classroom->load(['teacher', 'enrollments.student']);

        return $classroom;
    }

    /**
     * Update an existing classroom.
     */
    public function updateClassroom(Classroom $classroom, array $data): Classroom
    {
        $classroom->update($data);

        return $classroom->fresh();
    }

    /**
     * Delete a classroom.
     */
    public function destroyClassroom(Classroom $classroom): void
    {
        $classroom->delete();
    }
}
