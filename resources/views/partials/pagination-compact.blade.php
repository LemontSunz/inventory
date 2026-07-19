@php
    $current = $paginator->currentPage();
    $last = $paginator->lastPage();

    $pages = [];

    if ($last <= 5) {
        $pages = range(1, $last);
    } else {
        $pages[] = 1;

        if ($current <= 2) {
            $pages = array_merge($pages, [2, 3]);
        } elseif ($current >= $last - 1) {
            $pages = array_merge($pages, [$last - 2, $last - 1]);
        } else {
            $pages = array_merge($pages, [$current - 1, $current, $current + 1]);
        }

        $pages[] = $last;
    }

    $pages = array_unique(array_filter($pages, fn ($page) => $page >= 1 && $page <= $last));
    sort($pages);
@endphp

@if($last > 1)
    <div class="flex flex-wrap gap-2">
        @if($paginator->onFirstPage())
            <button disabled class="rounded-2xl border border-slate-300 bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-500 cursor-not-allowed">← Sebelumnya</button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer">← Sebelumnya</a>
        @endif

        @php $previous = 0; @endphp
        @foreach($pages as $page)
            @if($previous && $page > $previous + 1)
                <span class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-500">...</span>
            @endif

            @if($page == $current)
                <button disabled class="rounded-2xl border border-slate-300 bg-blue-50 px-3 py-2 text-sm font-semibold text-blue-700 cursor-not-allowed">{{ $page }}</button>
            @else
                <a href="{{ $paginator->url($page) }}" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer">{{ $page }}</a>
            @endif

            @php $previous = $page; @endphp
        @endforeach

        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer">Selanjutnya →</a>
        @else
            <button disabled class="rounded-2xl border border-slate-300 bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-500 cursor-not-allowed">Selanjutnya →</button>
        @endif
    </div>
@endif
