<?php

namespace App\Http\Controllers\Admin\Classroom;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class ClassroomEditController extends Controller
{
    public function __invoke(Classroom $classroom): Response
    {
        $this->authorize('update', $classroom);

        $teachers = User::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Admin/Classroom/Edit', [
            'classroom' => $classroom,
            'teachers' => $teachers,
        ]);
    }
}
