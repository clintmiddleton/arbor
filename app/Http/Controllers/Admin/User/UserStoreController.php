<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;

class UserStoreController extends Controller
{
    public function __invoke(UserStoreRequest $request, UserService $userService): RedirectResponse
    {
        $this->authorize('create', User::class);

        $userService->storeUser($request->validated());

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User created successfully.');
    }
}
