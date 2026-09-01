<div>
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Users</h1>
            <p class="mt-1 text-sm text-slate-600">Search, manage, and import user accounts.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a
                href="{{ route('admin.users.import') }}"
                class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
            >
                Import CSV
            </a>
            <a
                href="{{ route('admin.users.create') }}"
                class="rounded-lg bg-sky-700 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-800"
            >
                Create user
            </a>
        </div>
    </div>

    <div class="mb-4 flex flex-wrap items-end gap-4 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="min-w-[16rem] flex-1">
            <label for="search" class="block text-sm font-medium text-slate-700">Search</label>
            <input
                id="search"
                type="search"
                wire:model.live.debounce.300ms="search"
                placeholder="Search users..."
                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"
            >
        </div>
        <div>
            <label for="statusFilter" class="block text-sm font-medium text-slate-700">Status</label>
            <select
                id="statusFilter"
                wire:model.live="statusFilter"
                class="mt-1 rounded-lg border border-slate-300 px-3 py-2 text-sm"
            >
                <option value="">All statuses</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}">{{ ucfirst($status->value) }}</option>
                @endforeach
            </select>
        </div>
        @if ($search !== '' || $statusFilter !== '')
            <button
                type="button"
                wire:click="clearFilters"
                class="rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 hover:bg-slate-50"
            >
                Clear filters
            </button>
        @endif
    </div>

    <div wire:loading class="mb-4 text-sm text-slate-500">Loading users…</div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        @if ($users->isEmpty())
            <div class="px-6 py-12 text-center">
                <p class="text-sm font-medium text-slate-900">No users found</p>
                <p class="mt-1 text-sm text-slate-500">Try adjusting your search or create a new user.</p>
            </div>
        @else
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-600">Name</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-600">Email</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-600">Role</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-600">Status</th>
                        <th class="px-4 py-3 text-right font-medium text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($users as $user)
                        <tr wire:key="user-{{ $user->id }}">
                            <td class="px-4 py-3 font-medium text-slate-900">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $user->roles->first()?->display_name ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <span @class([
                                    'rounded-full px-2.5 py-1 text-xs font-medium',
                                    'bg-emerald-100 text-emerald-800' => $user->isActive(),
                                    'bg-slate-200 text-slate-700' => ! $user->isActive(),
                                ])>
                                    {{ $user->status instanceof \App\Enums\UserStatus ? $user->status->value : $user->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.users.show', $user) }}" class="font-medium text-sky-700 hover:text-sky-900">View</a>
                                <span class="mx-2 text-slate-300">|</span>
                                <a href="{{ route('admin.users.edit', $user) }}" class="font-medium text-sky-700 hover:text-sky-900">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="border-t border-slate-200 px-4 py-3">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
