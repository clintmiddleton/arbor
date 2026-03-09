<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;

class UserDestroyController extends Controller
{
    public function __invoke(User $user, UserService $userService): RedirectResponse
    {
        $this->authorize('delete', $user);

        $userService->destroyUser($user);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User deleted successfully.');
    }
}
