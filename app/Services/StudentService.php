<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StudentService
{
    /**
     * List students with pagination.
     *
     * @return LengthAwarePaginator<Student>
     */
    public function index(int $perPage = 15): LengthAwarePaginator
    {
        return Student::query()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->paginate($perPage);
    }

    /**
     * Create a new student.
     */
    public function storeStudent(array $data): Student
    {
        return Student::create($data);
    }

    /**
     * Get a single student.
     */
    public function show(Student $student): Student
    {
        $student->load('enrollments.classroom');

        return $student;
    }

    /**
     * Update an existing student.
     */
    public function updateStudent(Student $student, array $data): Student
    {
        $student->update($data);

        return $student->fresh();
    }

    /**
     * Delete a student.
     */
    public function destroyStudent(Student $student): void
    {
        $student->delete();
    }
}
