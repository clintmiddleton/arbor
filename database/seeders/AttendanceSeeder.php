<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacher = User::factory()->create([
            'name' => 'Jane Teacher',
            'email' => 'teacher@example.com',
            'is_admin' => false,
            'is_teacher' => true,
        ]);

        $classroom = Classroom::create([
            'name' => 'Math Grade 5',
            'grade_level' => '5',
            'academic_year' => '2024-2025',
            'teacher_id' => $teacher->id,
        ]);

        $students = [
            Student::create([
                'student_number' => 'STU001',
                'first_name' => 'Alice',
                'last_name' => 'Anderson',
                'email' => 'alice@example.com',
            ]),
            Student::create([
                'student_number' => 'STU002',
                'first_name' => 'Bob',
                'last_name' => 'Brown',
                'email' => 'bob@example.com',
            ]),
            Student::create([
                'student_number' => 'STU003',
                'first_name' => 'Carol',
                'last_name' => 'Clark',
                'email' => 'carol@example.com',
            ]),
        ];

        foreach ($students as $student) {
            Enrollment::create([
                'classroom_id' => $classroom->id,
                'student_id' => $student->id,
            ]);
        }
    }
}
