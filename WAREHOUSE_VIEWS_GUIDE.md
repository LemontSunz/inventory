# Struktur Halaman SaaS Logistik - LogistikPro

## 📁 Struktur Project

```
resources/views/
├── layouts/
│   └── app.blade.php                    # Layout utama dengan sidebar & navbar
├── components/
│   ├── sidebar.blade.php                # Sidebar dengan menu warehouse
│   └── navbar.blade.php                 # Top navigation bar
└── pages/
    ├── dashboard/
    │   └── index.blade.php              # Dashboard utama
    └── warehouse/
        ├── items/
        │   └── index.blade.php          # Kelola Data Barang (Tabel)
        ├── inbound/
        │   └── index.blade.php          # Kelola Barang Masuk (Tabel)
        ├── outbound/
        │   └── index.blade.php          # Kelola Barang Keluar (Tabel)
        ├── stock/
        │   └── index.blade.php          # Kelola Stok Barang (Tabel)
        └── stock-management/
            └── index.blade.php          # Mengelola Stok Barang (Kanban)
```

## 🛣️ Routes yang Tersedia

| URL | Nama Route | Deskripsi |
|-----|-----------|-----------|
| `/` | `dashboard` | Dashboard utama |
| `/warehouse/items` | `warehouse.items.index` | Kelola Data Barang |
| `/warehouse/inbound` | `warehouse.inbound.index` | Kelola Barang Masuk |
| `/warehouse/outbound` | `warehouse.outbound.index` | Kelola Barang Keluar |
| `/warehouse/stock` | `warehouse.stock.index` | Kelola Stok Barang |
| `/warehouse/stock-management` | `warehouse.stock-management.index` | Mengelola Stok Barang |

## 🎨 Fitur Desain

### Sidebar
- **Design**: Gradient dark (slate-900 to slate-800)
- **Responsif**: 
  - Mobile: 80px width, icon only
  - Desktop: 256px width, dengan label
- **Menu Items**: 
  - Dashboard
  - Kelola Data Barang (hijau emerald)
  - Kelola Barang Masuk (biru)
  - Kelola Barang Keluar (oranye)
  - Kelola Stok Barang (ungu)
  - Mengelola Stok Barang (pink)
  - Laporan & Pengaturan

### Topbar
- Logo & nama perusahaan
- Search bar (desktop only)
- Notification bell dengan badge
- User profile dengan dropdown

### Halaman Dashboard
- 4 Stats cards (Total, Masuk, Keluar, Kritis)
- Recent activities feed
- Quick action buttons

### Halaman Kelola Data Barang
- Search & filter dengan dropdown kategori
- Tabel dengan columns: Kode, Nama, Kategori, Stok, Harga, Status, Aksi
- Status indicators (Aktif, Stok Rendah, Stok Kritis)
- Pagination

### Halaman Kelola Barang Masuk
- 4 Stats cards (Hari Ini, Menunggu, Sudah Diverifikasi, Total Supplier)
- Filter berdasarkan status
- Tabel dengan columns: No. PO, Supplier, Tanggal, Jumlah, Status, Penerima
- Status: Menunggu, Terverifikasi, Masalah

### Halaman Kelola Barang Keluar
- 4 Stats cards (Hari Ini, Dalam Proses, Sudah Terkirim, Total Penerima)
- Filter berdasarkan status pengiriman
- Tabel dengan columns: No. SO, Customer, Tanggal, Jumlah, Tujuan, Status
- Status: Dalam Proses, Terkirim, Tiba di Tujuan

### Halaman Kelola Stok Barang
- 4 Summary cards (Total SKU, Normal, Rendah, Kritis)
- Tabel dengan management stok
- Columns: Kode, Nama, Stok, Min, Max, Status, Action
- Status colors: Green (Normal), Yellow (Rendah), Red (Kritis)

### Halaman Mengelola Stok Barang (BERBEDA)
- **Kanban-style layout** dengan 4 kolom:
  1. **🔴 Stok Kritis** (Red column) - 8 items
  2. **🟡 Stok Rendah** (Yellow column) - 15 items
  3. **🟢 Stok Normal** (Green column) - 198 items
  4. **🔵 Stok Berlebih** (Blue column) - 26 items
- Item cards yang draggable (siap untuk JavaScript interaksi)
- Rekomendasi tindakan di bawah

## 🎯 Fitur Responsif

### Breakpoints Tailwind
- **Mobile**: < 640px (sm)
- **Tablet**: 768px - 1023px (md-lg)
- **Desktop**: >= 1024px (lg)

### Mobile Optimizations
- Sidebar collapse (icon only)
- Sidebar overlay dengan toggle button
- Single column untuk stats
- Search bar hidden on mobile
- Table scrollable horizontally

## 💅 Styling Details

### Color Scheme
- **Primary**: Blue (sky-500 to blue-600)
- **Success**: Green (emerald to green)
- **Warning**: Yellow & Amber
- **Danger**: Red (red-600)
- **Background**: Gray-50 untuk halaman, White untuk cards

### Shadows & Borders
- `shadow-sm` untuk cards
- `border border-gray-200` untuk pembatas
- `rounded-lg` untuk corners
- `rounded-xl` untuk larger elements

### Typography
- **H1 (Halaman Title)**: `text-3xl font-bold`
- **H2 (Section Title)**: `text-lg font-semibold`
- **Body**: `text-sm` untuk table & list
- **Muted text**: `text-gray-500 text-xs`

## 🚀 Cara Menggunakan

### Mengakses Halaman
```blade
<!-- Dashboard -->
<a href="{{ route('dashboard') }}">Dashboard</a>

<!-- Kelola Data Barang -->
<a href="{{ route('warehouse.items.index') }}">Kelola Data Barang</a>

<!-- Kelola Barang Masuk -->
<a href="{{ route('warehouse.inbound.index') }}">Kelola Barang Masuk</a>

<!-- Kelola Barang Keluar -->
<a href="{{ route('warehouse.outbound.index') }}">Kelola Barang Keluar</a>

<!-- Kelola Stok -->
<a href="{{ route('warehouse.stock.index') }}">Kelola Stok Barang</a>

<!-- Mengelola Stok -->
<a href="{{ route('warehouse.stock-management.index') }}">Mengelola Stok Barang</a>
```

## 🔧 Customization Tips

### Mengubah Sidebar Color
Edit `resources/views/components/sidebar.blade.php`
```blade
<!-- Ubah warna dari slate-900 to slate-800 menjadi color lain -->
<aside class="bg-gradient-to-b from-[COLOR]-900 to-[COLOR]-800">
```

### Menambah Menu Item
Tambahkan di section yang sesuai di sidebar:
```blade
<a href="{{ route('nama-route') }}" class="sidebar-item flex items-center gap-4...">
    <div class="flex h-5 w-5... bg-[COLOR]-500/20 text-[COLOR]-400...">
        <!-- SVG Icon -->
    </div>
    <span class="hidden md:inline">Menu Name</span>
</a>
```

### Mengubah Stats Cards
Edit jumlah dan style di halaman masing-masing.

## 📝 Notes

- Semua halaman sudah responsive
- Design menggunakan Tailwind CSS utility-first
- Layout sudah mobile-first approach
- Data di table adalah dummy data (siap untuk binding backend)
- Pagination buttons sudah tersedia UI-nya
- Search dan filter functionality siap untuk backend integration

---

**Created**: June 2024
**Framework**: Laravel 11 + Tailwind CSS 3
**Version**: 1.0
