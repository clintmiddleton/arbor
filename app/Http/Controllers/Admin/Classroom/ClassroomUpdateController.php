<?php

namespace App\Http\Controllers\Admin\Classroom;

use App\Http\Controllers\Controller;
use App\Http\Requests\Classroom\ClassroomUpdateRequest;
use App\Models\Classroom;
use App\Services\ClassroomService;
use Illuminate\Http\RedirectResponse;

class ClassroomUpdateController extends Controller
{
    public function __invoke(ClassroomUpdateRequest $request, Classroom $classroom, ClassroomService $classroomService): RedirectResponse
    {
        $this->authorize('update', $classroom);

        $classroomService->updateClassroom($classroom, $request->validated());

        return redirect()
            ->route('admin.classrooms.show', $classroom)
            ->with('status', 'Classroom updated successfully.');
    }
}
