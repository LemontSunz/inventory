<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangKeluarDetail;
use App\Models\Cabang;
use App\Models\Driver;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        $query = BarangKeluar::with(['details.item', 'cabang', 'driver', 'kendaraan'])
            ->orderBy('tanggal_keluar', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('details.item', function ($qb) use ($search) {
                    $qb->where('nama_barang', 'like', "%{$search}%");
                })
                ->orWhereHas('cabang', function ($qc) use ($search) {
                    $qc->where('nama_cabang', 'like', "%{$search}%");
                })
                ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_keluar', $bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_keluar', $tahun);
        }

        // Sortable columns
        $sortable = ['tanggal_keluar', 'keterangan'];
        $sort = $request->get('sort', 'tanggal_keluar');
        $direction = $request->get('direction', 'desc');

        // Validate sort column and direction
        if (!in_array($sort, $sortable)) {
            $sort = 'tanggal_keluar';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        // Apply sorting
        $query->orderBy($sort, $direction);

        $barangKeluars = $query->paginate(10)->withQueryString();

        return view('pages.warehouse.outbound.index', compact('barangKeluars', 'sort', 'direction'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        $cabangs = Cabang::orderBy('nama_cabang')->get();
        $drivers = Driver::where('status', Driver::STATUS_AVAILABLE)->orderBy('name')->get();
        $kendaraans = Kendaraan::where('status', Kendaraan::STATUS_SIAP)->orderBy('nama_kendaraan')->get();

        return view('pages.warehouse.outbound.create', compact('barangs', 'cabangs', 'drivers', 'kendaraans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cabang_id' => 'required|exists:cabang,id',
            'driver_id' => ['nullable', Rule::exists('drivers', 'id')->where(function ($query) {
                $query->where('status', Driver::STATUS_AVAILABLE);
            })],
            'kendaraan_id' => ['nullable', Rule::exists('kendaraan', 'id')->where(function ($query) {
                $query->where('status', Kendaraan::STATUS_SIAP);
            })],
            'tanggal_keluar' => 'required|date',
            'keterangan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.jumlah_keluar' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($data) {
                // Aggregate quantities per barang to handle duplicates in a single transaction
                $totals = [];
                foreach ($data['items'] as $item) {
                    $bid = (int) $item['barang_id'];
                    $qty = (int) $item['jumlah_keluar'];
                    if (! isset($totals[$bid])) {
                        $totals[$bid] = 0;
                    }
                    $totals[$bid] += $qty;
                }

                // Lock all involved barang rows and validate stock BEFORE any modification
                $barangRows = Barang::whereIn('id', array_keys($totals))->lockForUpdate()->get()->keyBy('id');

                foreach ($totals as $bid => $requiredQty) {
                    $barang = $barangRows->get($bid);
                    if (! $barang) {
                        throw new \RuntimeException('Barang dengan ID ' . $bid . ' tidak ditemukan.');
                    }

                    $available = (int) ($barang->stok ?? 0);

                    if ($available === 0) {
                        throw new \RuntimeException('Stok barang ' . $barang->nama_barang . ' kosong dan tidak dapat dikeluarkan.');
                    }

                    if ($requiredQty > $available) {
                        throw new \RuntimeException('Stok ' . $barang->nama_barang . ' tidak mencukupi. Stok tersedia: ' . $available . ' unit.');
                    }
                }

                // All validations passed — create barang keluar and deduct stocks
                $firstItem = $data['items'][0];

                $barangKeluar = BarangKeluar::create([
                    'nomor_pengiriman' => null,
                    'barang_id' => $firstItem['barang_id'],
                    'cabang_id' => $data['cabang_id'],
                    'driver_id' => $data['driver_id'] ?? null,
                    'kendaraan_id' => $data['kendaraan_id'] ?? null,
                    'jumlah_keluar' => 0,
                    'tanggal_keluar' => $data['tanggal_keluar'],
                    'keterangan' => $data['keterangan'] ?? null,
                    'status' => BarangKeluar::STATUS_DALAM_PERJALANAN,
                ]);

                $totalQuantity = 0;

                foreach ($data['items'] as $item) {
                    $barang = $barangRows->get((int) $item['barang_id']);
                    $quantity = (int) $item['jumlah_keluar'];

                    BarangKeluarDetail::create([
                        'barang_keluar_id' => $barangKeluar->id,
                        'barang_id' => $barang->id,
                        'jumlah_keluar' => $quantity,
                    ]);

                    $barang->stok = $barang->stok - $quantity;
                    $barang->save();

                    $totalQuantity += $quantity;
                }

                if (! empty($data['driver_id'])) {
                    $driver = Driver::where('id', $data['driver_id'])->lockForUpdate()->firstOrFail();
                    if ($driver->status !== Driver::STATUS_AVAILABLE) {
                        throw new \RuntimeException('Driver yang dipilih tidak tersedia.');
                    }
                    $driver->update(['status' => Driver::STATUS_ON_ROUTE]);
                }

                if (! empty($data['kendaraan_id'])) {
                    $kendaraan = Kendaraan::where('id', $data['kendaraan_id'])->lockForUpdate()->firstOrFail();
                    if ($kendaraan->status !== Kendaraan::STATUS_SIAP) {
                        throw new \RuntimeException('Kendaraan yang dipilih tidak siap digunakan.');
                    }
                    $kendaraan->update(['status' => Kendaraan::STATUS_BERTUGAS]);
                }

                $barangKeluar->update([
                    'nomor_pengiriman' => 'BK-' . str_pad($barangKeluar->id, 6, '0', STR_PAD_LEFT),
                    'barang_id' => $firstItem['barang_id'],
                    'jumlah_keluar' => $totalQuantity,
                ]);
            });

            return redirect()->route('barang-keluar.index')->with('success', 'Barang Keluar berhasil disimpan');
        } catch (\Throwable $e) {
            Log::error('Error menyimpan Barang Keluar: ' . $e->getMessage());
            $msg = $e->getMessage() ?: 'Terjadi kesalahan saat menyimpan Barang Keluar';

            // If it's a stock/validation related error, show via withErrors so Blade's $errors displays it
            if (stripos($msg, 'stok') !== false || stripos($msg, 'Stok') !== false) {
                return back()->withInput()->withErrors(['stok' => $msg]);
            }

            return back()->withInput()->with('error', $msg);
        }
    }

    public function edit($id)
    {
        $barangKeluar = BarangKeluar::with(['details.item', 'cabang', 'driver', 'kendaraan'])->findOrFail($id);
        $barangs = Barang::orderBy('nama_barang')->get();
        $cabangs = Cabang::orderBy('nama_cabang')->get();
        $drivers = Driver::where('status', Driver::STATUS_AVAILABLE)->orWhere('id', $barangKeluar->driver_id)->orderBy('name')->get();
        $kendaraans = Kendaraan::where('status', Kendaraan::STATUS_SIAP)->orWhere('id', $barangKeluar->kendaraan_id)->orderBy('nama_kendaraan')->get();

        return view('pages.warehouse.outbound.edit', compact('barangKeluar', 'barangs', 'cabangs', 'drivers', 'kendaraans'));
    }

    public function update(Request $request, $id)
    {
        $barangKeluar = BarangKeluar::with(['details'])->findOrFail($id);

        $data = $request->validate([
            'cabang_id' => 'required|exists:cabang,id',
            'driver_id' => ['nullable', Rule::exists('drivers', 'id')->where(function ($query) use ($barangKeluar) {
                $query->where(function ($query) use ($barangKeluar) {
                    $query->where('status', Driver::STATUS_AVAILABLE)->orWhere('id', $barangKeluar->driver_id);
                });
            })],
            'kendaraan_id' => ['nullable', Rule::exists('kendaraan', 'id')->where(function ($query) use ($barangKeluar) {
                $query->where(function ($query) use ($barangKeluar) {
                    $query->where('status', Kendaraan::STATUS_SIAP)->orWhere('id', $barangKeluar->kendaraan_id);
                });
            })],
            'tanggal_keluar' => 'required|date',
            'keterangan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.jumlah_keluar' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($data, $barangKeluar) {
                foreach ($barangKeluar->details as $detail) {
                    $barang = Barang::where('id', $detail->barang_id)->lockForUpdate()->firstOrFail();
                    $barang->stok = (int) ($barang->stok ?? 0) + $detail->jumlah_keluar;
                    $barang->save();
                }

                if ($barangKeluar->driver_id && $barangKeluar->driver_id !== $data['driver_id']) {
                    $oldDriver = Driver::where('id', $barangKeluar->driver_id)->lockForUpdate()->first();
                    if ($oldDriver && $oldDriver->status === Driver::STATUS_ON_ROUTE) {
                        $oldDriver->update(['status' => Driver::STATUS_AVAILABLE]);
                    }
                }

                if ($barangKeluar->kendaraan_id && $barangKeluar->kendaraan_id !== $data['kendaraan_id']) {
                    $oldKendaraan = Kendaraan::where('id', $barangKeluar->kendaraan_id)->lockForUpdate()->first();
                    if ($oldKendaraan && $oldKendaraan->status === Kendaraan::STATUS_BERTUGAS) {
                        $oldKendaraan->update(['status' => Kendaraan::STATUS_SIAP]);
                    }
                }

                $barangKeluar->details()->delete();

                $totalQuantity = 0;
                $firstItem = $data['items'][0];

                foreach ($data['items'] as $item) {
                    $barang = $barangRows->get((int) $item['barang_id']);
                    $quantity = (int) $item['jumlah_keluar'];

                    BarangKeluarDetail::create([
                        'barang_keluar_id' => $barangKeluar->id,
                        'barang_id' => $barang->id,
                        'jumlah_keluar' => $quantity,
                    ]);

                    $barang->stok = $barang->stok - $quantity;
                    $barang->save();

                    $totalQuantity += $quantity;
                }

                if (! empty($data['driver_id'])) {
                    $driver = Driver::where('id', $data['driver_id'])->lockForUpdate()->firstOrFail();
                    if ($driver->status !== Driver::STATUS_AVAILABLE && $driver->id !== $barangKeluar->driver_id) {
                        throw new \RuntimeException('Driver yang dipilih tidak tersedia.');
                    }
                    $driver->update(['status' => Driver::STATUS_ON_ROUTE]);
                }

                if (! empty($data['kendaraan_id'])) {
                    $kendaraan = Kendaraan::where('id', $data['kendaraan_id'])->lockForUpdate()->firstOrFail();
                    if ($kendaraan->status !== Kendaraan::STATUS_SIAP && $kendaraan->id !== $barangKeluar->kendaraan_id) {
                        throw new \RuntimeException('Kendaraan yang dipilih tidak siap digunakan.');
                    }
                    $kendaraan->update(['status' => Kendaraan::STATUS_BERTUGAS]);
                }

                $barangKeluar->update([
                    'barang_id' => $firstItem['barang_id'],
                    'cabang_id' => $data['cabang_id'],
                    'driver_id' => $data['driver_id'] ?? null,
                    'kendaraan_id' => $data['kendaraan_id'] ?? null,
                    'jumlah_keluar' => $totalQuantity,
                    'tanggal_keluar' => $data['tanggal_keluar'],
                    'keterangan' => $data['keterangan'] ?? null,
                ]);
            });

            return redirect()->route('barang-keluar.index')->with('success', 'Barang Keluar berhasil diperbarui');
        } catch (\Throwable $e) {
            $msg = $e->getMessage() ?: 'Terjadi kesalahan saat memperbarui Barang Keluar';
            if (stripos($msg, 'stok') !== false || stripos($msg, 'Stok') !== false) {
                return back()->withInput()->withErrors(['stok' => $msg]);
            }
            return back()->withInput()->with('error', $msg);
        }
    }

    public function completeDelivery($id)
    {
        $barangKeluar = BarangKeluar::with(['driver', 'kendaraan'])->findOrFail($id);

        if ($barangKeluar->status === BarangKeluar::STATUS_TERKIRIM) {
            return back()->with('error', 'Pengiriman sudah selesai dan tidak dapat diproses ulang.');
        }

        try {
            DB::transaction(function () use ($barangKeluar) {
                $barangKeluar->markAsDelivered();
            });

            return redirect()->route('barang-keluar.index')->with('success', 'Pengiriman Barang Keluar berhasil diselesaikan.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage() ?: 'Terjadi kesalahan saat menyelesaikan pengiriman.');
        }
    }

    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::with(['details'])->findOrFail($id);

        try {
            DB::transaction(function () use ($barangKeluar) {
                foreach ($barangKeluar->details as $detail) {
                    $barang = Barang::where('id', $detail->barang_id)->lockForUpdate()->firstOrFail();
                    $barang->stok = (int) ($barang->stok ?? 0) + $detail->jumlah_keluar;
                    $barang->save();
                }

                if ($barangKeluar->driver_id) {
                    $driver = Driver::where('id', $barangKeluar->driver_id)->lockForUpdate()->first();
                    if ($driver && $driver->status === Driver::STATUS_ON_ROUTE) {
                        $driver->update(['status' => Driver::STATUS_AVAILABLE]);
                    }
                }

                if ($barangKeluar->kendaraan_id) {
                    $kendaraan = Kendaraan::where('id', $barangKeluar->kendaraan_id)->lockForUpdate()->first();
                    if ($kendaraan && $kendaraan->status === Kendaraan::STATUS_BERTUGAS) {
                        $kendaraan->update(['status' => Kendaraan::STATUS_SIAP]);
                    }
                }

                $barangKeluar->delete();
            });

            return redirect()->route('barang-keluar.index')->with('success', 'Barang Keluar berhasil dihapus');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage() ?: 'Terjadi kesalahan saat menghapus Barang Keluar');
        }
    }

    public function exportPdf(Request $request)
    {
        $search = $request->get('search');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        $query = BarangKeluar::with(['details.item', 'cabang', 'driver', 'kendaraan'])
            ->orderBy('tanggal_keluar', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('details.item', function ($qb) use ($search) {
                    $qb->where('nama_barang', 'like', "%{$search}%");
                })
                ->orWhereHas('cabang', function ($qc) use ($search) {
                    $qc->where('nama_cabang', 'like', "%{$search}%");
                })
                ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_keluar', $bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_keluar', $tahun);
        }

        $barangKeluars = $query->get();

        $pdf = Pdf::loadView('pdfs.barang-keluar', [
            'barangKeluars' => $barangKeluars,
            'search' => $search,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'printDate' => now(),
            'totalData' => count($barangKeluars),
        ]);

        return $pdf->download('Laporan-Barang-Keluar-' . now()->format('Y-m-d-His') . '.pdf');
    }

    public function cetak($id)
    {
        $barangKeluar = BarangKeluar::with(['details.item', 'cabang', 'driver', 'kendaraan'])->findOrFail($id);

        $data = [
            'barangKeluar' => $barangKeluar,
        ];

        $nomor = $barangKeluar->nomor_pengiriman ?? 'ID-' . $barangKeluar->id;

        $pdf = Pdf::loadView('barang-keluar.surat-jalan', $data)->setPaper('a4', 'portrait');

        return $pdf->download('Surat-Jalan-' . $nomor . '.pdf');
    }
}

