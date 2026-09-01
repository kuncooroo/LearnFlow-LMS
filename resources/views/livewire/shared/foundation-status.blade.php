<section class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
    <p class="text-sm font-medium text-sky-700">TASK-001 · Project Foundation</p>
    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">
        Laravel modular monolith is online.
    </h2>
    <p class="mt-4 max-w-2xl text-base leading-7 text-slate-600">
        Blade, Livewire, Alpine.js, and Tailwind CSS are wired for the LearnFlow LMS MVP.
        Business modules will be implemented in later tasks.
    </p>

    <dl class="mt-8 grid gap-4 sm:grid-cols-2">
        <div class="rounded-xl bg-slate-50 p-4">
            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Backend</dt>
            <dd class="mt-1 text-sm font-medium text-slate-900">Laravel {{ Illuminate\Foundation\Application::VERSION }}</dd>
        </div>
        <div class="rounded-xl bg-slate-50 p-4">
            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Livewire</dt>
            <dd class="mt-1 text-sm font-medium text-slate-900">{{ class_exists(\Livewire\Livewire::class) ? 'Enabled' : 'Pending' }}</dd>
        </div>
    </dl>

    <div
        class="mt-8 rounded-xl border border-dashed border-slate-300 p-5"
        x-data="{ open: false }"
    >
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-slate-900">Alpine.js interaction check</p>
                <p class="text-sm text-slate-600">Toggle this panel to confirm client-side UI behavior.</p>
            </div>
            <button
                type="button"
                class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800"
                x-on:click="open = ! open"
            >
                <span x-text="open ? 'Hide details' : 'Show details'"></span>
            </button>
        </div>

        <div class="mt-4 text-sm text-slate-600" x-show="open" x-cloak>
            Alpine is active. Livewire clicks below are handled server-side.
        </div>
    </div>

    <div class="mt-6 flex flex-wrap items-center gap-4">
        <button
            type="button"
            wire:click="increment"
            class="rounded-lg bg-sky-700 px-4 py-2 text-sm font-medium text-white hover:bg-sky-800"
        >
            Livewire click test
        </button>
        <p class="text-sm text-slate-600">
            Server-side count: <span class="font-semibold text-slate-900">{{ $clicks }}</span>
        </p>
    </div>
</section>
