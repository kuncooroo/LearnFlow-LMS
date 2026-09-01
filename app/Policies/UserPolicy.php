<?php

namespace App\Policies;

use App\Enums\PermissionName;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission(PermissionName::UsersManage);
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasPermission(PermissionName::UsersManage);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(PermissionName::UsersManage);
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasPermission(PermissionName::UsersManage);
    }

    public function changeStatus(User $user, User $model): bool
    {
        return $user->hasPermission(PermissionName::UsersManage);
    }

    public function import(User $user): bool
    {
        return $user->hasPermission(PermissionName::UsersManage);
    }
}
