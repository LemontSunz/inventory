@props(['name', 'label' => null, 'value' => null, 'placeholder' => null, 'id' => null, 'containerClass' => ''])

<div class="w-full {{ $containerClass }}">
    @if($label)
        <label for="{{ $id ?? $name }}" class="mb-2 block text-sm font-semibold text-slate-700">{{ $label }}</label>
    @endif

    <div class="relative">
        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </span>
        <input
            type="search"
            name="{{ $name }}"
            id="{{ $id ?? $name }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            class="w-full rounded-2xl border border-slate-300 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-900 placeholder:text-slate-400 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100"
        />
    </div>
</div>
