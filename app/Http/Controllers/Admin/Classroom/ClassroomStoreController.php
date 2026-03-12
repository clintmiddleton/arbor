<?php

namespace App\Http\Controllers\Admin\Classroom;

use App\Http\Controllers\Controller;
use App\Http\Requests\Classroom\ClassroomStoreRequest;
use App\Models\Classroom;
use App\Services\ClassroomService;
use Illuminate\Http\RedirectResponse;

class ClassroomStoreController extends Controller
{
    public function __invoke(ClassroomStoreRequest $request, ClassroomService $classroomService): RedirectResponse
    {
        $this->authorize('create', Classroom::class);

        $classroom = $classroomService->storeClassroom($request->validated());

        return redirect()
            ->route('admin.classrooms.index')
            ->with('status', 'Classroom created successfully.');
    }
}
