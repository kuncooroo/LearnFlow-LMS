<?php

namespace App\Actions\Users;

use App\Enums\PermissionName;
use App\Enums\UserStatus;
use App\Events\Users\UserCreated;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreateUserAction
{
    /**
     * @param  array{name: string, email: string, password: string, status?: UserStatus|string, role_id: int}  $data
     */
    public function execute(array $data, User $actor): User
    {
        if (! $actor->hasPermission(PermissionName::UsersManage)) {
            throw ValidationException::withMessages([
                'authorization' => __('You are not authorized to manage users.'),
            ]);
        }

        $role = Role::query()->findOrFail($data['role_id']);
        $status = $data['status'] ?? UserStatus::Active;

        if ($status instanceof UserStatus === false) {
            $status = UserStatus::from((string) $status);
        }

        return DB::transaction(function () use ($data, $actor, $role, $status): User {
            $user = User::query()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'status' => $status,
            ]);

            $user->roles()->syncWithPivotValues(
                [$role->id],
                ['assigned_by' => $actor->id],
            );

            event(new UserCreated($user, $actor));

            return $user->load('roles');
        });
    }
}
