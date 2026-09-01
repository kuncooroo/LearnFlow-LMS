@extends('layouts.auth', ['title' => 'Forgot password'])

@section('content')
    <p class="mb-6 text-sm text-slate-600">
        Enter your email address and we will send you a password reset link if an account exists.
    </p>

    @if (session('status'))
        <div class="mb-4 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            {{ session('status') }}
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('password.email') }}"
        class="space-y-5"
        x-data="{ submitting: false }"
        x-on:submit="submitting = true"
    >
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500"
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="w-full rounded-lg bg-sky-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-sky-800 disabled:cursor-not-allowed disabled:opacity-60"
            x-bind:disabled="submitting"
        >
            <span x-show="!submitting">Send reset link</span>
            <span x-show="submitting" x-cloak>Sending…</span>
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-600">
        <a href="{{ route('login') }}" class="font-medium text-sky-700 hover:text-sky-900">Back to sign in</a>
    </p>
@endsection
