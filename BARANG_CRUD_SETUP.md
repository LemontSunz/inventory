# 📋 Panduan Setup CRUD Kelola Data Barang

## 📦 File yang Telah Dibuat

### 1. **Migration**
```
database/migrations/2024_06_04_000000_create_barang_table.php
```

### 2. **Model**
```
app/Models/Barang.php
```

### 3. **Requests (Validation)**
```
app/Http/Requests/StoreBarangRequest.php
app/Http/Requests/UpdateBarangRequest.php
```

### 4. **Controller**
```
app/Http/Controllers/Warehouse/BarangController.php
```

### 5. **Views**
```
resources/views/barang/index.blade.php
resources/views/barang/create.blade.php
resources/views/barang/edit.blade.php
```

### 6. **Routes**
```
routes/web.php (Updated with Route::resource)
```

---

## 🚀 Langkah Instalasi

### 1. **Run Migration**
```bash
php artisan migrate
```

Output:
```
Migrating: 2024_06_04_000000_create_barang_table
Migrated:  2024_06_04_000000_create_barang_table (xxx ms)
```

### 2. **Clear Cache (Optional but Recommended)**
```bash
php artisan cache:clear
php artisan route:cache
```

### 3. **Jalankan Development Server**
```bash
php artisan serve
```

### 4. **Akses di Browser**
```
http://localhost:8000/barang
```

---

## ✅ Fitur CRUD yang Tersedia

### **Create (Tambah Barang)**
- Route: `GET /barang/create`
- View: `barang/create.blade.php`
- Form validation dengan error display
- Support kategori: Elektronik, Aksesoris, Peralatan, Bahan Baku, Lainnya
- Support satuan: Unit, Box, Pcs, Kg, Meter, Liter
- Flash message: "Data barang berhasil disimpan"

### **Read (Daftar Barang)**
- Route: `GET /barang`
- View: `barang/index.blade.php`
- Fitur:
  - ✅ Tampilkan tabel dengan 8 kolom
  - ✅ Search (kode, nama, kategori)
  - ✅ Filter kategori
  - ✅ Pagination (10 item per halaman)
  - ✅ Status stok (hijau, kuning, merah)
  - ✅ Tombol Edit & Delete dengan konfirmasi

### **Update (Edit Barang)**
- Route: `GET /barang/{id}/edit` & `PUT /barang/{id}`
- View: `barang/edit.blade.php`
- Form validation dengan error display
- Pre-fill data dari database
- Flash message: "Data barang berhasil diperbarui"

### **Delete (Hapus Barang)**
- Route: `DELETE /barang/{id}`
- Konfirmasi hapus dengan JavaScript
- Flash message: "Data barang berhasil dihapus"
- Soft Delete (menggunakan SoftDeletes)

---

## 📊 Database Schema

### Tabel: `barang`

| Field | Type | Validasi |
|-------|------|----------|
| `id` | BigInt | Primary Key, Auto Increment |
| `kode_barang` | String | Unique, Required |
| `nama_barang` | String | Required, Max 255 |
| `kategori` | String | Required |
| `satuan` | String | Required |
| `stok` | Integer | Required, Min 0 |
| `lokasi_rak` | String | Required |
| `deskripsi` | Text | Nullable |
| `deleted_at` | Timestamp | Soft Delete |
| `created_at` | Timestamp | Auto |
| `updated_at` | Timestamp | Auto |

---

## 🎯 Validasi Form

### **Store Request (Create)**
```php
'kode_barang' => 'required|string|unique:barang,kode_barang|max:50'
'nama_barang' => 'required|string|max:255'
'kategori' => 'required|string|max:100'
'satuan' => 'required|string|max:50'
'stok' => 'required|integer|min:0'
'lokasi_rak' => 'required|string|max:100'
'deskripsi' => 'nullable|string|max:1000'
```

### **Update Request (Edit)**
```php
'kode_barang' => 'required|string|unique:barang,kode_barang,{id}|max:50'
'nama_barang' => 'required|string|max:255'
'kategori' => 'required|string|max:100'
'satuan' => 'required|string|max:50'
'stok' => 'required|integer|min:0'
'lokasi_rak' => 'required|string|max:100'
'deskripsi' => 'nullable|string|max:1000'
```

---

## 🎨 UI Features

### **Responsive Design**
- ✅ Mobile-first approach
- ✅ Tailwind CSS utilities
- ✅ Rounded corners (rounded-lg, rounded-xl)
- ✅ Shadow effects (shadow-sm, shadow-md)
- ✅ Professional color scheme

### **Flash Messages**
- ✅ Success (hijau) - Create, Update, Delete
- ✅ Error (merah) - Validasi gagal
- ✅ Dismissible alerts dengan close button
- ✅ Auto-fade animation

### **Form Features**
- ✅ Inline error validation
- ✅ Field highlighting on error (red border)
- ✅ Helpful placeholder text
- ✅ Field requirement indicators (*)
- ✅ Cancel buttons dengan konfirmasi

### **Table Features**
- ✅ Numbered rows
- ✅ Search functionality
- ✅ Category filter dropdown
- ✅ Reset filter button
- ✅ Pagination with page numbers
- ✅ Stock status indicators (colors)
- ✅ Description truncation
- ✅ Edit & Delete action buttons
- ✅ Empty state message

---

## 🔗 Integrasi dengan Sidebar

Sidebar sudah dikonfigurasi dengan link ke menu "Kelola Data Barang":

```blade
<a href="{{ route('barang.index') }}" 
   class="sidebar-item flex items-center gap-4 ...">
    <!-- Emerald icon -->
    <span class="hidden md:inline">Kelola Data Barang</span>
</a>
```

**Link:** `/barang`

---

## 📝 Contoh Data untuk Testing

### **Data Sample 1**
```
Kode: BR-001
Nama: Laptop Dell XPS 15
Kategori: Elektronik
Satuan: Unit
Stok: 45
Lokasi Rak: A-01-01
Deskripsi: Laptop premium dengan spesifikasi tinggi
```

### **Data Sample 2**
```
Kode: BR-002
Nama: Mouse Wireless Logitech
Kategori: Aksesoris
Satuan: Pcs
Stok: 12
Lokasi Rak: B-02-05
Deskripsi: Mouse nirkabel dengan baterai tahan lama
```

### **Data Sample 3**
```
Kode: BR-003
Nama: Keyboard Mekanik RGB
Kategori: Aksesoris
Satuan: Unit
Stok: 2
Lokasi Rak: C-01-02
Deskripsi: Keyboard gaming dengan backlit RGB
```

---

## 🐛 Troubleshooting

### ❌ "Class Not Found"
```bash
php artisan cache:clear
composer dump-autoload
```

### ❌ "Migration Not Found"
Pastikan file migration ada di: `database/migrations/`
```bash
php artisan migrate:refresh  # Reset semua
php artisan migrate         # Re-run
```

### ❌ "Route Not Found"
```bash
php artisan route:clear
php artisan route:cache
php artisan serve
```

### ❌ "CSRF Token Mismatch"
Pastikan form memiliki `@csrf`

### ❌ "Validation Error Not Showing"
Pastikan menggunakan `StoreBarangRequest` atau `UpdateBarangRequest` di controller

---

## 📈 Routes Summary

```bash
GET     /barang              → index()      List semua barang
GET     /barang/create       → create()     Form tambah barang
POST    /barang              → store()      Simpan barang baru
GET     /barang/{id}/edit    → edit()       Form edit barang
PUT     /barang/{id}         → update()     Update barang
DELETE  /barang/{id}         → destroy()    Hapus barang
```

---

## 🎓 Laravel 12 Best Practices Digunakan

✅ Resource Controller (RESTful)
✅ Form Request Validation
✅ Eloquent ORM dengan Model
✅ SoftDeletes untuk archiving
✅ CSRF Protection
✅ Method Spoofing (@method)
✅ Blade Templating
✅ Flash Session Messages
✅ Custom Error Messages
✅ Query String Persistence

---

## 📦 Dependencies

Tidak ada dependency tambahan diperlukan. Menggunakan:
- Laravel 12
- Blade Template Engine
- Tailwind CSS 3
- MySQL/SQLite

---

## 🎯 Next Steps (Optional Enhancements)

1. **Import Excel** - Tambahkan fitur upload barang dari Excel
2. **Export PDF** - Generate laporan barang PDF
3. **Barcode** - Generate barcode untuk setiap barang
4. **History Log** - Track perubahan data barang
5. **API Endpoint** - Create REST API untuk mobile app
6. **Multi-Warehouse** - Support multiple gudang
7. **Stock Adjustment** - Fitur adjustment stok fisik

---

**Version:** 1.0
**Last Updated:** June 2024
**Created with:** Laravel 12 + Tailwind CSS 3
