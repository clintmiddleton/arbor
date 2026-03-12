<?php

namespace App\Http\Controllers\Admin\Classroom;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Services\ClassroomService;
use Inertia\Inertia;
use Inertia\Response;

class ClassroomShowController extends Controller
{
    public function __invoke(Classroom $classroom, ClassroomService $classroomService): Response
    {
        $this->authorize('view', $classroom);

        $classroom = $classroomService->show($classroom);

        return Inertia::render('Admin/Classroom/Show', [
            'classroom' => $classroom,
        ]);
    }
}
