<?php

namespace App\Services;

use App\Models\Classroom;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Support\Collection;

class EnrollmentService
{
    /**
     * List enrollments for a classroom.
     *
     * @return Collection<int, Enrollment>
     */
    public function indexByClassroom(Classroom $classroom): Collection
    {
        return $classroom->enrollments()
            ->with('student')
            ->orderBy('id')
            ->get();
    }

    /**
     * Enroll a student in a classroom.
     */
    public function enroll(Classroom $classroom, Student $student): Enrollment
    {
        return Enrollment::firstOrCreate(
            [
                'classroom_id' => $classroom->id,
                'student_id' => $student->id,
            ]
        );
    }

    /**
     * Remove a student from a classroom.
     */
    public function unenroll(Enrollment $enrollment): void
    {
        $enrollment->delete();
    }
}
