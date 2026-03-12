<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * List users with pagination.
     *
     * @return LengthAwarePaginator<User>
     */
    public function index(int $perPage = 15): LengthAwarePaginator
    {
        return User::query()
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * Create a new user.
     */
    public function storeUser(array $data): User
    {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->is_admin = $data['is_admin'] ?? false;
        $user->is_teacher = $data['is_teacher'] ?? false;
        $user->save();

        return $user;
    }

    /**
     * Get a single user.
     */
    public function show(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Update an existing user.
     */
    public function updateUser(User $user, array $data): User
    {
        $user->name = $data['name'];
        $user->email = $data['email'];

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->is_admin = $data['is_admin'] ?? false;
        $user->is_teacher = $data['is_teacher'] ?? false;
        $user->save();

        return $user;
    }

    /**
     * Delete a user.
     */
    public function destroyUser(User $user): void
    {
        $user->delete();
    }
}
