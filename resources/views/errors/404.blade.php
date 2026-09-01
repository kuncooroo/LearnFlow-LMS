<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Not Found</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
        <div class="mx-auto flex min-h-screen max-w-xl items-center px-6">
            <section class="w-full rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-sm">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-amber-700">404</p>
                <h1 class="mt-3 text-2xl font-semibold">Page not found</h1>
                <p class="mt-3 text-sm text-slate-600">The page you requested could not be found.</p>
                <a href="{{ url('/') }}" class="mt-6 inline-block text-sm font-medium text-sky-700 hover:text-sky-800">Return home</a>
            </section>
        </div>
    </body>
</html>
