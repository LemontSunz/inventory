@props(['href' => null])

@if($href)
    <a
        href="{{ $href }}"
        class="group inline-flex h-12 w-full items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 cursor-pointer"
    >
        {{ $slot }}
    </a>
@else
    <button
        type="reset"
        class="group inline-flex h-12 w-full items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 cursor-pointer"
    >
        {{ $slot }}
    </button>
@endif
