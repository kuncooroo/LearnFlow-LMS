@extends('layouts.admin', ['title' => 'Import Users'])

@section('content')
    <div class="mx-auto max-w-3xl space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Import users</h1>
                <p class="mt-1 text-sm text-slate-600">Upload a CSV file using the official template format.</p>
            </div>
            <a
                href="{{ route('admin.users.import.template') }}"
                class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
            >
                Download template
            </a>
        </div>

        @if (session('import_result'))
            @php($result = session('import_result'))
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Import summary</h2>
                <dl class="mt-4 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-lg bg-emerald-50 px-4 py-3">
                        <dt class="text-sm text-emerald-700">Created</dt>
                        <dd class="text-2xl font-semibold text-emerald-900">{{ $result['created'] }}</dd>
                    </div>
                    <div class="rounded-lg bg-amber-50 px-4 py-3">
                        <dt class="text-sm text-amber-700">Skipped</dt>
                        <dd class="text-2xl font-semibold text-amber-900">{{ $result['skipped'] }}</dd>
                    </div>
                    <div class="rounded-lg bg-red-50 px-4 py-3">
                        <dt class="text-sm text-red-700">Failed</dt>
                        <dd class="text-2xl font-semibold text-red-900">{{ $result['failed'] }}</dd>
                    </div>
                </dl>

                @if (! empty($result['details']['failed']))
                    <div class="mt-6">
                        <h3 class="text-sm font-semibold text-slate-900">Failed rows</h3>
                        <ul class="mt-2 space-y-2 text-sm text-slate-600">
                            @foreach ($result['details']['failed'] as $row)
                                <li>Line {{ $row['line'] }} ({{ $row['email'] }}): {{ $row['reason'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (! empty($result['details']['skipped']))
                    <div class="mt-6">
                        <h3 class="text-sm font-semibold text-slate-900">Skipped rows</h3>
                        <ul class="mt-2 space-y-2 text-sm text-slate-600">
                            @foreach ($result['details']['skipped'] as $row)
                                <li>Line {{ $row['line'] }} ({{ $row['email'] }}): {{ $row['reason'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('admin.users.import.store') }}"
            enctype="multipart/form-data"
            class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm"
            x-data="{ submitting: false }"
            x-on:submit="submitting = true"
        >
            @csrf

            <label for="file" class="block text-sm font-medium text-slate-700">CSV file</label>
            <input
                id="file"
                name="file"
                type="file"
                accept=".csv,text/csv"
                required
                class="mt-2 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"
            >
            <p class="mt-2 text-xs text-slate-500">
                Expected headers: name, email, password, status, role
            </p>

            @error('file')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div class="mt-6 flex items-center gap-3">
                <button
                    type="submit"
                    class="rounded-lg bg-sky-700 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-800 disabled:opacity-60"
                    x-bind:disabled="submitting"
                >
                    Import users
                </button>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-slate-600 hover:text-slate-900">Cancel</a>
            </div>
        </form>
    </div>
@endsection
