# TODO - Kelola Stok Barang Refactor

## Step 1: Audit & identifikasi sumber dummy / mismatch
- [x] Cek route `warehouse/stock-management` (mengarah ke `StokBarangController@index`)
- [ ] Identifikasi mismatch dropdown status mapping di Blade vs Controller
- [ ] Audit seluruh `resources/views/pages/warehouse/stock-management/*`
- [ ] Audit controller yang terlibat: `StokBarangController` (+ `StockManagementController` bila ada dummy walau tidak dipakai route)

## Step 2: Refactor query agar sesuai requirement
- [x] Ubah filter status supaya parameter GET: `status=normal|rendah|kritis`
- [x] Pastikan search `?search=` hanya pada `kode_barang` dan `nama_barang`
- [x] Pastikan search + filter bisa bersamaan (menggunakan query builder chaining)


## Step 3: Pagination
- [ ] Pastikan `paginate(10)` + `withQueryString()` aktif
- [ ] Pastikan link pagination mempertahankan `search/status`

## Step 4: Ringkasan kartu
- [ ] Hitung Total SKU, Stok Normal, Stok Rendah, Stok Kritis dari data barang aktual
- [ ] Pastikan ringkasan konsisten dengan filter/search aktif

## Step 5: Blade view adjustments
- [x] Ubah dropdown opsi status sesuai requirement (`normal/rendah/kritis`)
- [ ] Pastikan label kartu menggunakan kategori yang sesuai dengan perhitungan controller
- [ ] Pastikan tidak ada data dummy/hardcode tersisa di modul


## Step 6: Verifikasi manual
- [ ] Tambah barang baru di menu `barang` lalu cek muncul di `stock-management`
- [ ] Uji `?search=laptop` mengubah hasil
- [ ] Uji `?status=normal` mengubah hasil
- [ ] Uji `?search=laptop&status=normal` mengubah hasil
- [ ] Uji pagination (berpindah halaman)
- [ ] Pastikan tidak ada dummy tersisa

