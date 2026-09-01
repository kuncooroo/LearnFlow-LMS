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
        <div class="mx-auto flex min-h-screen max-w-5xl flex-col px-6 py-10">
            <header class="mb-10 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-700">LearnFlow</p>
                    <h1 class="text-2xl font-semibold text-slate-900">{{ config('app.name') }}</h1>
                </div>
                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-800">
                    Foundation Ready
                </span>
            </header>

            <main class="flex-1">
                {{ $slot }}
            </main>

            <footer class="mt-10 border-t border-slate-200 pt-6 text-sm text-slate-500">
                Modular monolith foundation for LearnFlow LMS.
            </footer>
        </div>

        @livewireScripts
    </body>
</html>
