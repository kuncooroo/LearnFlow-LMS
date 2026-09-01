<div class="mx-auto max-w-3xl space-y-6">
    @if (session('status'))
        <div class="rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-700">User detail</p>
            <h1 class="mt-1 text-2xl font-semibold text-slate-900">{{ $user->name }}</h1>
            <p class="mt-1 text-slate-600">{{ $user->email }}</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a
                href="{{ route('admin.users.edit', $user) }}"
                class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
            >
                Edit
            </a>
            @can('changeStatus', $user)
                <button
                    type="button"
                    wire:click="confirmStatusChange"
                    @class([
                        'rounded-lg px-4 py-2 text-sm font-medium',
                        'border border-red-200 bg-red-50 text-red-700 hover:bg-red-100' => $user->isActive(),
                        'border border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' => ! $user->isActive(),
                    ])
                >
                    {{ $user->isActive() ? 'Deactivate' : 'Reactivate' }}
                </button>
            @endcan
        </div>
    </div>

    @error('status')
        <div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">{{ $message }}</div>
    @enderror

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <dl class="grid gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-sm text-slate-500">Status</dt>
                <dd class="mt-1 font-medium text-slate-900">
                    {{ $user->status instanceof \App\Enums\UserStatus ? ucfirst($user->status->value) : $user->status }}
                </dd>
            </div>
            <div>
                <dt class="text-sm text-slate-500">Role</dt>
                <dd class="mt-1 font-medium text-slate-900">
                    {{ $user->roles->first()?->display_name ?? '—' }}
                </dd>
            </div>
            <div>
                <dt class="text-sm text-slate-500">Last login</dt>
                <dd class="mt-1 font-medium text-slate-900">
                    {{ $user->last_login_at?->format('M j, Y g:i A') ?? 'Never' }}
                </dd>
            </div>
            <div>
                <dt class="text-sm text-slate-500">Created</dt>
                <dd class="mt-1 font-medium text-slate-900">
                    {{ $user->created_at?->format('M j, Y') }}
                </dd>
            </div>
        </dl>
    </div>

    <p class="text-sm text-slate-500">
        Deactivating a user preserves enrollments, submissions, grades, and audit history.
    </p>

    @if ($confirmingStatusChange)
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-6">
            <h2 class="text-lg font-semibold text-amber-900">
                {{ $user->isActive() ? 'Deactivate user?' : 'Reactivate user?' }}
            </h2>
            <p class="mt-2 text-sm text-amber-800">
                @if ($user->isActive())
                    This user will no longer be able to sign in. Academic history will be preserved.
                @else
                    This user will be able to sign in again once reactivated.
                @endif
            </p>
            <div class="mt-4 flex gap-3">
                <button
                    type="button"
                    wire:click="toggleStatus"
                    class="rounded-lg bg-amber-700 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-800"
                >
                    Confirm
                </button>
                <button
                    type="button"
                    wire:click="cancelStatusChange"
                    class="rounded-lg border border-amber-300 px-4 py-2 text-sm text-amber-900 hover:bg-amber-100"
                >
                    Cancel
                </button>
            </div>
        </div>
    @endif
</div>
