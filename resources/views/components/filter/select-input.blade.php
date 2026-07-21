@props(['name', 'label' => null, 'id' => null, 'containerClass' => ''])

<div class="w-full {{ $containerClass }}">
    @if($label)
        <label for="{{ $id ?? $name }}" class="mb-2 block text-sm font-semibold text-slate-700">{{ $label }}</label>
    @endif

    <div class="relative">
        <select
            name="{{ $name }}"
            id="{{ $id ?? $name }}"
            class="w-full appearance-none rounded-2xl border border-slate-300 bg-white py-3 pl-4 pr-10 text-sm text-slate-900 shadow-sm focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100"
        >
            {{ $slot }}
        </select>
        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </span>
    </div>
</div>
