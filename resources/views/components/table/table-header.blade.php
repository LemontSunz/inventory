@props(['label' => '', 'sortable' => false, 'sortRoute' => null, 'column' => null, 'direction' => null, 'currentSort' => null, 'align' => 'left', 'class' => ''])

<th class="border-b border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 {{ $align === 'center' ? 'text-center' : 'text-left' }} {{ $class }}">
    @if($sortable && $sortRoute && $column !== null)
        @php
            $isSorted = $currentSort === $column;
            $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
            $params = array_merge(request()->query(), ['sort' => $column, 'direction' => $nextDirection]);
        @endphp
        <a href="{{ route($sortRoute, $params) }}" class="group inline-flex items-center gap-2 {{ $align === 'center' ? 'justify-center w-full' : '' }} hover:text-slate-900 transition">
            <span>{{ $label }}</span>
            <span class="inline-flex items-center">
                @if($isSorted)
                    @if($direction === 'asc')
                        <svg class="h-4 w-4 text-slate-900" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 15.21a.75.75 0 001.06.02L12 10.56l5.71 4.67a.75.75 0 001.06-1.06l-6.24-5.11a.75.75 0 00-1.06 0L5.23 14.15a.75.75 0 00.02 1.06z" clip-rule="evenodd"/></svg>
                    @else
                        <svg class="h-4 w-4 text-slate-900" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                    @endif
                @else
                    <svg class="h-4 w-4 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                @endif
            </span>
        </a>
    @else
        <span>{{ $label }}</span>
    @endif
</th>
