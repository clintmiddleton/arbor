<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class UserEditController extends Controller
{
    public function __invoke(User $user): Response
    {
        $this->authorize('update', $user);

        return Inertia::render('Admin/User/Edit', [
            'user' => $user,
        ]);
    }
}
