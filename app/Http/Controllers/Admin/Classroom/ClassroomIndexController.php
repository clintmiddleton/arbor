<?php

namespace App\Http\Controllers\Admin\Classroom;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Services\ClassroomService;
use Inertia\Inertia;
use Inertia\Response;

class ClassroomIndexController extends Controller
{
    public function __invoke(ClassroomService $classroomService): Response
    {
        $this->authorize('viewAny', Classroom::class);

        $classrooms = $classroomService->index();

        return Inertia::render('Admin/Classroom/Index', [
            'classrooms' => $classrooms,
        ]);
    }
}
