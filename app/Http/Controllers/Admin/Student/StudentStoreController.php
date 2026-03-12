<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentStoreRequest;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\RedirectResponse;

class StudentStoreController extends Controller
{
    public function __invoke(StudentStoreRequest $request, StudentService $studentService): RedirectResponse
    {
        $this->authorize('create', Student::class);

        $student = $studentService->storeStudent($request->validated());

        return redirect()
            ->route('admin.students.index')
            ->with('status', 'Student created successfully.');
    }
}
