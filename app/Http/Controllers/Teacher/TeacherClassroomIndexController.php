<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Inertia\Inertia;
use Inertia\Response;

class TeacherClassroomIndexController extends Controller
{
    public function __invoke(): Response
    {
        $classrooms = Classroom::query()
            ->where('teacher_id', auth()->id())
            ->withCount('enrollments')
            ->orderBy('name')
            ->get();

        return Inertia::render('Teacher/Classroom/Index', [
            'classrooms' => $classrooms,
        ]);
    }
}
