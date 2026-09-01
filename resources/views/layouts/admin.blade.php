<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
        <div class="mx-auto flex min-h-screen max-w-6xl flex-col px-6 py-8">
            <header class="mb-8 flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 pb-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-700">LearnFlow Admin</p>
                    <p class="text-lg font-semibold">{{ $title ?? config('app.name') }}</p>
                </div>
                <nav class="flex flex-wrap items-center gap-4 text-sm text-slate-600">
                    <a href="{{ route('dashboard') }}" class="hover:text-slate-900">Dashboard</a>
                    @can('viewAny', App\Models\User::class)
                        <a href="{{ route('admin.users.index') }}" class="font-medium text-sky-700 hover:text-sky-900">Users</a>
                    @endcan
                </nav>
            </header>

            <main class="flex-1">
                @hasSection('content')
                    @yield('content')
                @else
                    {{ $slot }}
                @endif
            </main>
        </div>

        @livewireScripts
    </body>
</html>
