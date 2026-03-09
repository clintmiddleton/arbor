<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class UserCreateController extends Controller
{
    public function __invoke(): Response
    {
        $this->authorize('create', User::class);

        return Inertia::render('Admin/User/Create');
    }
}
