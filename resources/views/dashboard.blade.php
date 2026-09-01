@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-8">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-700">Dashboard</p>
        <h1 class="mt-2 text-2xl font-semibold text-slate-900">Welcome, {{ $user->name }}</h1>
        <p class="mt-2 text-slate-600">
            You are signed in as <span class="font-medium">{{ $user->email }}</span>.
        </p>

        @can('viewAny', App\Models\User::class)
            <div class="mt-6">
                <a
                    href="{{ route('admin.users.index') }}"
                    class="inline-flex rounded-lg bg-sky-700 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-800"
                >
                    Manage users
                </a>
            </div>
        @endcan

        <form method="POST" action="{{ route('logout') }}" class="mt-8">
            @csrf
            <button
                type="submit"
                class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
            >
                Sign out
            </button>
        </form>
    </div>
@endsection
