<div class="mx-auto max-w-2xl">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">
            {{ $isEditing ? 'Edit user' : 'Create user' }}
        </h1>
        <p class="mt-1 text-sm text-slate-600">
            {{ $isEditing ? 'Update profile details and role assignment.' : 'Add a new user account with an initial role.' }}
        </p>
    </div>

    <form wire:submit="save" class="space-y-5 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700">Name</label>
            <input id="name" type="text" wire:model="name" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
            <input id="email" type="email" wire:model="email" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        @if (! $isEditing)
            <div>
                <label for="status" class="block text-sm font-medium text-slate-700">Status</label>
                <select id="status" wire:model="status" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    @foreach (\App\Enums\UserStatus::cases() as $statusOption)
                        <option value="{{ $statusOption->value }}">{{ ucfirst($statusOption->value) }}</option>
                    @endforeach
                </select>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        @endif

        @if ($canEditRole)
            <div>
                <label for="role_id" class="block text-sm font-medium text-slate-700">Role</label>
                <select id="role_id" wire:model="role_id" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                    @endforeach
                </select>
                @error('role_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        @else
            <p class="rounded-lg bg-slate-50 px-4 py-3 text-sm text-slate-600">
                You cannot change your own role.
            </p>
        @endif

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700">
                {{ $isEditing ? 'New password (optional)' : 'Password' }}
            </label>
            <input id="password" type="password" wire:model="password" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirm password</label>
            <input id="password_confirmation" type="password" wire:model="password_confirmation" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button
                type="submit"
                class="rounded-lg bg-sky-700 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-800 disabled:opacity-60"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>{{ $isEditing ? 'Save changes' : 'Create user' }}</span>
                <span wire:loading>Saving…</span>
            </button>
            <a href="{{ $isEditing ? route('admin.users.show', $user) : route('admin.users.index') }}" class="text-sm text-slate-600 hover:text-slate-900">
                Cancel
            </a>
        </div>
    </form>
</div>
