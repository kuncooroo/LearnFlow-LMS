<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
        <div class="mx-auto flex min-h-screen max-w-md flex-col justify-center px-6 py-12">
            <header class="mb-8 text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-700">LearnFlow</p>
                <h1 class="mt-1 text-2xl font-semibold text-slate-900">{{ $title ?? config('app.name') }}</h1>
            </header>

            <main class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
                @yield('content')
            </main>

            <footer class="mt-8 text-center text-sm text-slate-500">
                &copy; {{ date('Y') }} {{ config('app.name') }}
            </footer>
        </div>
    </body>
</html>
