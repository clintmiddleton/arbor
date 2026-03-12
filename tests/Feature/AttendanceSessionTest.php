<?php

namespace Tests\Feature;

use App\Models\Classroom;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceSessionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_teacher_can_create_attendance_session(): void
    {
        $teacher = User::where('email', 'teacher@example.com')->first();
        $this->assertNotNull($teacher);

        $classroom = Classroom::where('teacher_id', $teacher->id)->first();
        $this->assertNotNull($classroom);

        $response = $this->actingAs($teacher)->post(
            route('teacher.classrooms.attendance.store', $classroom),
            [
                'session_date' => now()->format('Y-m-d'),
                'session_time' => '09:00',
            ]
        );

        $response->assertRedirect();
        $this->assertDatabaseHas('attendance_sessions', [
            'classroom_id' => $classroom->id,
            'status' => 'draft',
        ]);

        $session = $classroom->attendanceSessions()->first();
        $this->assertNotNull($session);
        $this->assertCount(
            $classroom->enrollments()->count(),
            $session->records
        );
    }

    public function test_cannot_create_duplicate_session_for_same_class_and_date(): void
    {
        $teacher = User::where('email', 'teacher@example.com')->first();
        $classroom = Classroom::where('teacher_id', $teacher->id)->first();
        $date = now()->format('Y-m-d');

        $this->actingAs($teacher)->post(
            route('teacher.classrooms.attendance.store', $classroom),
            ['session_date' => $date, 'session_time' => '09:00']
        );

        $response = $this->actingAs($teacher)->post(
            route('teacher.classrooms.attendance.store', $classroom),
            ['session_date' => $date, 'session_time' => '10:00']
        );

        $response->assertSessionHasErrors('session_date');
        $this->assertEquals(1, $classroom->attendanceSessions()->count());
    }

    public function test_teacher_cannot_access_other_teachers_classroom(): void
    {
        $teacher = User::where('email', 'teacher@example.com')->first();
        $otherTeacher = User::factory()->create([
            'is_teacher' => true,
        ]);
        $classroom = Classroom::where('teacher_id', $teacher->id)->first();

        $response = $this->actingAs($otherTeacher)->get(
            route('teacher.classrooms.attendance.index', $classroom)
        );

        $response->assertForbidden();
    }
}
