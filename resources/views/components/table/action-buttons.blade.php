@props(['editRoute' => null, 'editLabel' => 'Edit', 'editVariant' => 'blue', 'detailRoute' => null, 'detailLabel' => 'Detail', 'detailVariant' => 'slate', 'deleteRoute' => null, 'deleteConfirm' => 'Yakin ingin menghapus data ini?', 'deleteLabel' => 'Hapus', 'printRoute' => null, 'printLabel' => 'Cetak', 'printVariant' => 'slate', 'showDelete' => true, 'showEdit' => true, 'showDetail' => false, 'showPrint' => false, 'containerClass' => ''])

<div class="flex flex-wrap items-center justify-center gap-2 {{ $containerClass }}">
    @if($showPrint && $printRoute)
        <a href="{{ $printRoute }}" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-[11px] font-semibold text-slate-700 transition hover:bg-slate-50 cursor-pointer">{{ $printLabel }}</a>
    @endif

    @if($showDetail && $detailRoute)
        <a href="{{ $detailRoute }}" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-[11px] font-semibold text-slate-700 transition hover:bg-slate-50 cursor-pointer">{{ $detailLabel }}</a>
    @endif

    @if($showEdit && $editRoute)
        <a href="{{ $editRoute }}" class="rounded-2xl bg-blue-50 px-3 py-2 text-[11px] font-semibold text-blue-700 transition hover:bg-blue-100 cursor-pointer">{{ $editLabel }}</a>
    @endif

    @if($showDelete && $deleteRoute)
        <form action="{{ $deleteRoute }}" method="POST" class="inline" onsubmit="return confirm('{{ $deleteConfirm }}');">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-2xl bg-rose-50 px-3 py-2 text-[11px] font-semibold text-rose-700 transition hover:bg-rose-100 cursor-pointer">{{ $deleteLabel }}</button>
        </form>
    @endif
</div>
