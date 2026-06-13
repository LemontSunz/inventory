{{-- Debug partial (temporary): pagination/search/status output --}}
<div style="display:none">
    <div>search={{ request('search') }}</div>
    <div>status={{ request('status') }}</div>
    <div>page={{ request('page') }}</div>
    <div>firstItem={{ $barangs->firstItem() ?? '-' }}</div>
</div>

