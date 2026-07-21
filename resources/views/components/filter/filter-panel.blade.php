@props(['action' => '', 'method' => 'GET', 'gridClass' => 'grid gap-4 lg:grid-cols-[1.5fr_1fr_0.9fr]', 'formClass' => ''])

<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <form action="{{ $action }}" method="{{ $method }}" class="{{ $gridClass }} {{ $formClass }}">
        {{ $slot }}
    </form>
</div>
