<?php

namespace App\Http\Controllers\Admin\Classroom;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Services\ClassroomService;
use Illuminate\Http\RedirectResponse;

class ClassroomDestroyController extends Controller
{
    public function __invoke(Classroom $classroom, ClassroomService $classroomService): RedirectResponse
    {
        $this->authorize('delete', $classroom);

        $classroomService->destroyClassroom($classroom);

        return redirect()
            ->route('admin.classrooms.index')
            ->with('status', 'Classroom deleted successfully.');
    }
}
