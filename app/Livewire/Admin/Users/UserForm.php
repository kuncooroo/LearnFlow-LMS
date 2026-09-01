<?php

namespace App\Livewire\Admin\Users;

use App\Actions\Users\CreateUserAction;
use App\Actions\Users\UpdateUserAction;
use App\Enums\UserStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class UserForm extends Component
{
    use AuthorizesRequests;

    public ?User $user = null;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $status = 'active';

    public ?int $role_id = null;

    public bool $submitting = false;

    public function mount(?User $user = null): void
    {
        $this->user = $user;

        if ($user) {
            $this->authorize('update', $user);
            $this->name = $user->name;
            $this->email = $user->email;
            $this->status = $user->status instanceof UserStatus
                ? $user->status->value
                : (string) $user->status;
            $this->role_id = $user->roles()->first()?->id;
        } else {
            $this->authorize('create', User::class);
            $this->status = UserStatus::Active->value;
            $this->role_id = Role::query()->orderBy('display_name')->value('id');
        }
    }

    public function save(
        CreateUserAction $createUserAction,
        UpdateUserAction $updateUserAction,
    ): void {
        $this->submitting = true;

        $validated = $this->validate($this->rules());

        if ($this->user) {
            $updateUserAction->execute($this->user, $validated, auth()->user());
            session()->flash('status', __('User updated successfully.'));

            $this->redirectRoute('admin.users.show', $this->user);

            return;
        }

        $createUserAction->execute($validated, auth()->user());
        session()->flash('status', __('User created successfully.'));

        $this->redirectRoute('admin.users.index');
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user?->id),
            ],
            'role_id' => ['required', 'integer', Rule::exists(Role::class, 'id')],
        ];

        if ($this->user) {
            $rules['password'] = ['nullable', 'string', 'confirmed', Password::defaults()];
        } else {
            $rules['password'] = ['required', 'string', 'confirmed', Password::defaults()];
            $rules['status'] = ['required', Rule::enum(UserStatus::class)];
        }

        if ($this->user && auth()->id() === $this->user->id) {
            unset($rules['role_id']);
        }

        return $rules;
    }

    public function render(): View
    {
        return view('livewire.admin.users.user-form', [
            'roles' => Role::query()->orderBy('display_name')->get(),
            'isEditing' => $this->user !== null,
            'canEditRole' => ! $this->user || auth()->id() !== $this->user->id,
        ]);
    }
}
