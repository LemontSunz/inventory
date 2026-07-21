@props(['title' => 'Tidak ada data', 'description' => 'Belum ada data yang tersedia.', 'actionRoute' => null, 'actionLabel' => null])

<div class="px-6 py-16 text-center">
    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100">
        <svg class="h-6 w-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
        </svg>
    </div>
    <p class="font-medium text-slate-500">{{ $title }}</p>
    <p class="mt-1 text-sm text-slate-400">{{ $description }}</p>
    @if($actionRoute && $actionLabel)
        <a href="{{ $actionRoute }}" class="group mt-4 inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
            {{ $actionLabel }}
        </a>
    @endif
</div>
