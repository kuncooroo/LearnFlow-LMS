<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen bg-white text-slate-900 antialiased">
        <div class="mx-auto flex min-h-screen max-w-6xl flex-col px-6 py-8">
            <header class="mb-8 flex items-center justify-between border-b border-slate-200 pb-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-700">LearnFlow</p>
                    <p class="text-lg font-semibold">{{ config('app.name') }}</p>
                </div>
                <nav class="text-sm text-slate-600">
                    <a href="{{ url('/') }}" class="hover:text-slate-900">Home</a>
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
