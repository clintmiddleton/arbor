<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Inertia\Inertia;
use Inertia\Response;

class UserIndexController extends Controller
{
    public function __invoke(UserService $userService): Response
    {
        $this->authorize('viewAny', User::class);

        $users = $userService->index();

        return Inertia::render('Admin/User/Index', [
            'users' => $users,
        ]);
    }
}
