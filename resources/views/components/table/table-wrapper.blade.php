@props(['title' => null, 'description' => null, 'count' => null, 'overflowClass' => null, 'containerClass' => ''])

@php
    $resolvedOverflowClass = $overflowClass;
    if ($resolvedOverflowClass === null) {
        $slotHtml = trim((string) $slot);
        $columnCount = substr_count($slotHtml, '<th');
        $resolvedOverflowClass = $columnCount > 7 ? 'overflow-x-auto' : '';
    }
@endphp

<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm {{ $containerClass }}">
    @if($title || $description || $count !== null)
        <div class="mb-4 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                @if($title)
                    <h2 class="text-xl font-semibold text-slate-900">{{ $title }}</h2>
                @endif
                @if($description)
                    <p class="mt-1 text-sm text-slate-500">{{ $description }}</p>
                @endif
            </div>
            @if($count !== null)
                <div class="rounded-3xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">Total: {{ $count }}</div>
            @endif
        </div>
    @endif

    <div class="{{ $resolvedOverflowClass }} rounded-xl">
        {{ $slot }}
    </div>
</div>
