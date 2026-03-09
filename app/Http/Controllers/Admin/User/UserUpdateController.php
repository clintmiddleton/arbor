<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;

class UserUpdateController extends Controller
{
    public function __invoke(UserUpdateRequest $request, User $user, UserService $userService): RedirectResponse
    {
        $this->authorize('update', $user);

        $userService->updateUser($user, $request->validated());

        return redirect()
            ->route('admin.users.show', $user)
            ->with('status', 'User updated successfully.');
    }
}
