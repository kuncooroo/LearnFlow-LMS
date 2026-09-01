<?php

namespace App\Actions\Users;

use App\Enums\PermissionName;
use App\Enums\RoleName;
use App\Enums\UserStatus;
use App\Events\Users\UserStatusChanged;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ChangeUserStatusAction
{
    public function execute(User $user, UserStatus $status, User $actor): User
    {
        if (! $actor->hasPermission(PermissionName::UsersManage)) {
            throw ValidationException::withMessages([
                'authorization' => __('You are not authorized to manage users.'),
            ]);
        }

        if ($actor->is($user) && $status === UserStatus::Inactive) {
            throw ValidationException::withMessages([
                'status' => __('You cannot deactivate your own account.'),
            ]);
        }

        if ($status === UserStatus::Inactive && $this->isLastActiveAdministrator($user)) {
            throw ValidationException::withMessages([
                'status' => __('Cannot deactivate the last active administrator.'),
            ]);
        }

        if ($user->status === $status) {
            return $user;
        }

        $previousStatus = $user->status instanceof UserStatus
            ? $user->status
            : UserStatus::from((string) $user->status);

        return DB::transaction(function () use ($user, $status, $actor, $previousStatus): User {
            $user->update(['status' => $status]);

            event(new UserStatusChanged($user->fresh(), $actor, $previousStatus, $status));

            return $user->fresh('roles');
        });
    }

    private function isLastActiveAdministrator(User $user): bool
    {
        if (! $user->hasRole(RoleName::Administrator) || ! $user->isActive()) {
            return false;
        }

        return User::query()
            ->where('status', UserStatus::Active)
            ->whereKeyNot($user->id)
            ->whereHas('roles', fn ($query) => $query->where('name', RoleName::Administrator->value))
            ->doesntExist();
    }
}
