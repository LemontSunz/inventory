@props(['category' => null, 'title' => null, 'description' => null, 'actionButton' => null])

<div class="flex flex-col gap-5 border-b border-slate-200 pb-6 md:flex-row md:items-end md:justify-between">
    <div class="max-w-3xl">
        @if($category)
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">{{ $category }}</p>
        @endif

        @if($title)
            <h1 class="mt-2 text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">{{ $title }}</h1>
        @endif

        @if($description)
            <p class="mt-3 text-base leading-7 text-slate-600">{{ $description }}</p>
        @endif
    </div>

    @if($actionButton)
        <div class="flex flex-wrap items-center gap-3">
            {{ $actionButton }}
        </div>
    @endif
</div>
