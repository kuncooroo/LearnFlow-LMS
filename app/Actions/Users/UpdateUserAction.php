<?php

namespace App\Actions\Users;

use App\Enums\PermissionName;
use App\Events\Users\UserUpdated;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UpdateUserAction
{
    /**
     * @param  array{name: string, email: string, password?: string|null, role_id: int}  $data
     */
    public function execute(User $user, array $data, User $actor): User
    {
        if (! $actor->hasPermission(PermissionName::UsersManage)) {
            throw ValidationException::withMessages([
                'authorization' => __('You are not authorized to manage users.'),
            ]);
        }

        if ($actor->is($user)) {
            unset($data['role_id']);
        }

        $role = isset($data['role_id'])
            ? Role::query()->findOrFail($data['role_id'])
            : null;

        if ($role && $actor->is($user) && $role->name !== $user->roles()->first()?->name) {
            throw ValidationException::withMessages([
                'role_id' => __('You cannot change your own role.'),
            ]);
        }

        return DB::transaction(function () use ($user, $data, $actor, $role): User {
            $attributes = [
                'name' => $data['name'],
                'email' => $data['email'],
            ];

            if (! empty($data['password'])) {
                $attributes['password'] = $data['password'];
            }

            $user->update($attributes);

            if ($role) {
                $user->roles()->syncWithPivotValues(
                    [$role->id],
                    ['assigned_by' => $actor->id],
                );
            }

            event(new UserUpdated($user->fresh('roles'), $actor));

            return $user->fresh('roles');
        });
    }
}
