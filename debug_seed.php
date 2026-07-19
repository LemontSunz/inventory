<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$seedMarker = 'Seed June 2026 demo data';

echo "=== Debug Seed Transactions ===\n";
echo "incoming_table: " . (new App\Models\IncomingGoods)->getTable() . "\n";
echo "barang_masuk_table: " . (new App\Models\BarangMasuk)->getTable() . "\n";

echo "-- total incoming goods june 2026 --\n";
$incomingCount = App\Models\IncomingGoods::whereYear('receiving_date', 2026)
    ->whereMonth('receiving_date', 6)
    ->count();
echo "incoming_june_count: {$incomingCount}\n";

echo "-- seeded incoming goods june 2026 --\n";
$seeds = App\Models\IncomingGoods::with('details')
    ->where('description', $seedMarker)
    ->whereYear('receiving_date', 2026)
    ->whereMonth('receiving_date', 6)
    ->get();
echo "seeded_count: " . count($seeds) . "\n";
foreach ($seeds as $s) {
    echo "record: id={$s->id}|receiving_code={$s->receiving_code}|receiving_date={$s->receiving_date}|supplier={$s->supplier}|description={$s->description}|created_by={$s->created_by}\n";
    foreach ($s->details as $d) {
        echo "  detail: id={$d->id}|incoming_goods_id={$d->incoming_goods_id}|item_id={$d->item_id}|quantity_received={$d->quantity_received}|rack_location_id={$d->rack_location_id}\n";
    }
}

echo "-- legacy barang_masuk seed count --\n";
$legacy = App\Models\BarangMasuk::where('keterangan', $seedMarker)
    ->whereYear('tanggal_masuk', 2026)
    ->whereMonth('tanggal_masuk', 6)
    ->count();
echo "legacy_seed_count: {$legacy}\n";

echo "-- manual TRM-00004 record --\n";
$manual = App\Models\IncomingGoods::with('details')->where('receiving_code', 'TRM-00004')->first();
$seeded = App\Models\IncomingGoods::with('details')->where('receiving_code', 'TRM-00005')->first();

echo "-- manual TRM-00004 raw --\n";
if ($manual) {
    print_r($manual->toArray());
} else {
    echo "manual: not found\n";
}

echo "-- seeded TRM-00005 raw --\n";
if ($seeded) {
    print_r($seeded->toArray());
} else {
    echo "seeded TRM-00005: not found\n";
}

echo "-- total incoming goods overall --\n";
$totalIncoming = App\Models\IncomingGoods::count();
echo "total_incoming_count: {$totalIncoming}\n";

echo "-- first 20 incoming goods by receiving_date desc --\n";
$latest = App\Models\IncomingGoods::with(['details.item'])->orderBy('receiving_date', 'desc')->orderBy('id', 'desc')->take(20)->get();
foreach ($latest as $item) {
    echo "latest: id={$item->id}|code={$item->receiving_code}|date={$item->receiving_date}|description={$item->description}|supplier={$item->supplier}|details=" . $item->details->count() . "\n";
}

echo "-- controller index ids --\n";
$query = App\Models\IncomingGoods::with(['details.item'])->orderBy('receiving_date', 'desc');
$ids = $query->pluck('id')->toArray();
echo "index_ids: " . implode(',', $ids) . "\n";
echo "-- controller index SQL --\n";
echo $query->toSql() . "\n";
echo "-- controller index bindings --\n";
echo json_encode($query->getBindings()) . "\n";

echo "=== End Debug ===\n";
