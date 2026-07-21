@props(['type' => 'submit'])

<button
    type="{{ $type }}"
    class="group inline-flex h-12 w-full items-center justify-center rounded-2xl bg-slate-900 px-5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer"
>
    {{ $slot }}
</button>
