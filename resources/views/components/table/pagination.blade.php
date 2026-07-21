@props(['paginator' => null, 'info' => null])

@if($paginator)
    <div class="mt-4 flex flex-col gap-3 border-t border-slate-200 pt-4 text-sm text-slate-600 lg:flex-row lg:items-center lg:justify-between">
        <div>
            @if($info)
                {{ $info }}
            @else
                Menampilkan <strong>{{ $paginator->firstItem() }}</strong> hingga <strong>{{ $paginator->lastItem() }}</strong> dari <strong>{{ $paginator->total() }}</strong>
            @endif
        </div>
        <div>
            @include('partials.pagination-compact', ['paginator' => $paginator])
        </div>
    </div>
@endif
