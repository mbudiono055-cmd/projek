# Plan: Add "Terlambat" Status to Peminjaman

## Task: Add "terlambat" status if masa peminjaman passes the specified return date

## Steps Completed:

### 1. Database Migration ✅
- [x] Added 'terlambat' to the enum in `database/migrations/2026_02_27_000000_add_terlambat_to_peminjamans_table.php`

### 2. Model Updates (app/Models/Peminjaman.php) ✅
- [x] Added constant `const STATUS_TERLAMBAT = 'terlambat'`
- [x] Added helper method `isTerlambat()`
- [x] Added method `isOverdue()` to check if peminjaman is past due date
- [x] Added method `cekStatusTerlambat()` to auto-update status to 'terlambat'
- [x] Updated `isAktif()` to include 'terlambat' status

### 3. Controller Updates ✅
- [x] Updated `Admin/PeminjamanController.php` - added auto-check overdue in index()
- [x] Updated `Petugas/PeminjamanController.php` - added auto-check overdue in index()
- [x] Updated `Siswa/DashboardController.php` - added auto-check overdue in bukuSaya() and riwayat()

### 4. View Updates ✅
- [x] Updated `admin/peminjaman/index.blade.php` - added terlambat badge
- [x] Updated `petugas/peminjaman/index.blade.php` - added terlambat badge and return button
- [x] Updated `siswa/buku_saya.blade.php` - fixed status logic
- [x] Updated `siswa/riwayat.blade.php` - added terlambat badge

### 5. Migration Executed ✅
- [x] Ran `php artisan migrate` to update the database

## Status Flow:
- When viewing peminjaman data, system automatically checks if:
  - Status is 'diterima' (accepted) AND
  - Current date > tanggal_kembali (return date)
- If true, automatically update status to 'terlambat'

## How It Works:
1. When admin/petugas/siswa views peminjaman data, the `cekStatusTerlambat()` method is called
2. It checks if the peminjaman status is 'diterima' and the current date is past the return date
3. If true, it automatically updates the status to 'terlambat'
4. The views display a red "Terlambat" badge for overdue items
