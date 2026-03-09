<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class UserShowController extends Controller
{
    public function __invoke(User $user): Response
    {
        $this->authorize('view', $user);

        return Inertia::render('Admin/User/Show', [
            'user' => $user,
        ]);
    }
}
