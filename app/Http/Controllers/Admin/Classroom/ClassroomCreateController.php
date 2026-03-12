<?php

namespace App\Http\Controllers\Admin\Classroom;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class ClassroomCreateController extends Controller
{
    public function __invoke(): Response
    {
        $this->authorize('create', Classroom::class);

        $teachers = User::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Admin/Classroom/Create', [
            'teachers' => $teachers,
        ]);
    }
}
