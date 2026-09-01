<?php

namespace App\Livewire\Admin\Users;

use App\Actions\Users\ChangeUserStatusAction;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ShowUser extends Component
{
    use AuthorizesRequests;

    public User $user;

    public bool $confirmingStatusChange = false;

    public function mount(User $user): void
    {
        $this->authorize('view', $user);
        $this->user = $user->load('roles');
    }

    public function confirmStatusChange(): void
    {
        $this->confirmingStatusChange = true;
    }

    public function cancelStatusChange(): void
    {
        $this->confirmingStatusChange = false;
    }

    public function toggleStatus(ChangeUserStatusAction $changeUserStatus): void
    {
        $this->authorize('changeStatus', $this->user);

        $newStatus = $this->user->isActive()
            ? UserStatus::Inactive
            : UserStatus::Active;

        try {
            $this->user = $changeUserStatus->execute(
                $this->user,
                $newStatus,
                auth()->user(),
            );
        } catch (ValidationException $exception) {
            $this->addError('status', collect($exception->errors())->flatten()->first());
        }

        $this->confirmingStatusChange = false;
    }

    public function render(): View
    {
        return view('livewire.admin.users.show-user');
    }
}
