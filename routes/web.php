<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/* ================= ADMIN ================= */
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\UlasanController as AdminUlasanController;

/* ================= PETUGAS ================= */
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\BukuController as PetugasBukuController;
use App\Http\Controllers\Petugas\KategoriController as PetugasKategoriController;
use App\Http\Controllers\Petugas\PeminjamanController as PetugasPeminjamanController;
use App\Http\Controllers\Petugas\UlasanController as PetugasUlasanController;
use App\Http\Controllers\Petugas\ProfileController;

/* ================= SISWA ================= */
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\KatalogController;
use App\Http\Controllers\Siswa\PeminjamanController as SiswaPeminjamanController;
use App\Http\Controllers\Siswa\ProfileController as SiswaProfileController;
use App\Http\Controllers\Siswa\KoleksiController;
use App\Http\Controllers\Siswa\AsistenAiController;


/* ================= HALAMAN AWAL ================= */
Route::get('/', function () {

    if (session()->has('login')) {

        if (session('role') == 'admin') {
            return redirect('/admin/dashboard');
        }

        if (session('role') == 'petugas') {
            return redirect('/petugas/dashboard');
        }

        if (session('role') == 'user') {
            return redirect('/siswa/dashboard');
        }
    }

    return redirect('/login');
});


/* ================= AUTH ================= */
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess']);

Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'registerProcess']);

Route::post('/logout', [AuthController::class, 'logout']);


/* ================= ADMIN ================= */
Route::middleware(['ceklogin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('buku/laporan', [BukuController::class, 'cetak'])
        ->name('buku.laporan.cetak');
    Route::resource('buku', BukuController::class);
    Route::post('buku/{id}/validasi', [BukuController::class, 'validasi'])
        ->name('buku.validasi');
    Route::get('petugas/laporan', [PetugasController::class, 'cetak'])
        ->name('petugas.laporan.cetak');
    Route::resource('petugas', PetugasController::class);
    Route::resource('kategori', KategoriController::class);
    Route::get('peminjaman/laporan', [PeminjamanController::class, 'cetak'])
        ->name('peminjaman.laporan.cetak');
    Route::resource('peminjaman', PeminjamanController::class);

    Route::post('peminjaman/{id}/{aksi}',
        [PeminjamanController::class, 'verifikasi'])
        ->name('peminjaman.verifikasi');

    Route::get('siswa', [SiswaController::class, 'index'])
        ->name('siswa.index');

    Route::get('siswa/laporan', [SiswaController::class, 'cetak'])
        ->name('siswa.laporan.cetak');
    Route::get('siswa/export', [SiswaController::class, 'export'])
        ->name('siswa.export');

    Route::delete('siswa/{id}', [SiswaController::class, 'destroy'])
        ->name('siswa.destroy');

    Route::get('/ulasan', [AdminUlasanController::class, 'index'])
        ->name('admin.ulasan.index');

    Route::delete('/ulasan/{id}', [AdminUlasanController::class, 'destroy'])
        ->name('admin.ulasan.destroy');

    Route::get('/profil', [DashboardController::class, 'profil'])
        ->name('profil');

    Route::get('/profil/edit', [DashboardController::class, 'editProfil'])
        ->name('profil.edit');

    Route::post('/profil/update', [DashboardController::class, 'updateProfil'])
        ->name('profil.update');
});


/* ================= PETUGAS ================= */
Route::middleware(['ceklogin'])
    ->prefix('petugas')
    ->as('petugas.')
    ->group(function () {

        Route::get('/dashboard', [PetugasDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('buku/laporan', [PetugasBukuController::class, 'cetak'])
            ->name('buku.laporan.cetak');
        Route::resource('buku', PetugasBukuController::class);
        Route::resource('kategori', PetugasKategoriController::class);
        Route::get('peminjaman/laporan', [PetugasPeminjamanController::class, 'cetak'])
            ->name('peminjaman.laporan.cetak');
        Route::resource('peminjaman', PetugasPeminjamanController::class);

        Route::post('peminjaman/{id}/{aksi}',
            [PetugasPeminjamanController::class, 'verifikasi'])
            ->name('peminjaman.verifikasi');

        Route::get('/ulasan', [PetugasUlasanController::class, 'index'])
            ->name('ulasan.index');

        Route::get('/profile', [ProfileController::class, 'index'])
            ->name('profile');

        Route::post('/profile/update', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::post('/profile/password', [ProfileController::class, 'updatePassword'])
            ->name('profile.password');
});


/* ================= SISWA ================= */
Route::middleware(['ceklogin'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

        Route::get('/dashboard', [SiswaDashboardController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/asisten-ai', [AsistenAiController::class, 'index'])
            ->name('asisten-ai');
        Route::post('/asisten-ai/tanya', [AsistenAiController::class, 'tanya'])
            ->middleware('throttle:10,1')
            ->name('asisten-ai.tanya');

        Route::get('/katalog', [KatalogController::class, 'index'])
            ->name('katalog');

        Route::get('/katalog/{id}', [KatalogController::class, 'show'])
            ->name('detail');

        Route::post('/pinjam/{id}', [SiswaPeminjamanController::class, 'pinjam'])
            ->name('pinjam');

        Route::get('/buku-saya', [SiswaPeminjamanController::class, 'bukuSaya'])
            ->name('buku.saya');

        Route::get('/riwayat', [SiswaPeminjamanController::class, 'riwayat'])
            ->name('riwayat');

        Route::get('/bukti/{id}', [SiswaPeminjamanController::class, 'bukti'])
            ->name('bukti');

        Route::post('/batal/{id}', [SiswaPeminjamanController::class, 'batal'])
            ->name('batal');

        Route::post('/ulasan', [SiswaPeminjamanController::class, 'simpanUlasan'])
            ->name('ulasan.simpan');

        /* ===== KOLEKSI BUKU ===== */
        Route::get('/koleksi', [KoleksiController::class, 'index'])
            ->name('koleksi');

        Route::post('/koleksi/{id}', [KoleksiController::class, 'tambah'])
            ->name('koleksi.tambah');

        Route::delete('/koleksi/{id}', [KoleksiController::class, 'hapus'])
            ->name('koleksi.hapus');

        /* ===== PROFIL ===== */
        Route::get('/profile', [SiswaProfileController::class, 'index'])
            ->name('profile');

        Route::get('/profile/edit', [SiswaProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::post('/profile/update', [SiswaProfileController::class, 'update'])
            ->name('profile.update');
});
