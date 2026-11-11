<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PeminjamanCetakTest extends TestCase
{
    private function usePeminjamanDatabase(bool $includeReturnDate = true): void
    {
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');

        Schema::create('users', function ($table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('password')->nullable();
            $table->timestamps();
        });
        Schema::create('bukus', function ($table) {
            $table->id();
            $table->string('judul');
            $table->string('penulis');
            $table->string('penerbit');
            $table->unsignedBigInteger('kategori_id');
            $table->integer('tahun_terbit');
            $table->integer('stok');
            $table->string('gambar')->nullable();
            $table->string('status_validasi')->default('disetujui');
            $table->timestamps();
        });
        Schema::create('peminjamans', function ($table) use ($includeReturnDate) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('buku_id');
            $table->integer('jumlah')->default(1);
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            if ($includeReturnDate) {
                $table->date('tanggal_dikembalikan')->nullable();
            }
            $table->string('status');
            $table->timestamps();
        });
    }

    private function createLoan(string $status = 'diterima'): int
    {
        DB::table('users')->insert([
            'id' => 1,
            'nama' => 'Siswa Contoh',
            'email' => 'siswa@example.test',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('bukus')->insert([
            'id' => 1,
            'judul' => 'Buku Contoh',
            'penulis' => 'Penulis Contoh',
            'penerbit' => 'Penerbit Contoh',
            'kategori_id' => 1,
            'tahun_terbit' => 2025,
            'stok' => 0,
            'status_validasi' => 'disetujui',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return DB::table('peminjamans')->insertGetId([
            'user_id' => 1,
            'buku_id' => 1,
            'jumlah' => 1,
            'tanggal_pinjam' => '2026-11-01',
            'tanggal_kembali' => '2026-11-08',
            'status' => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_confirming_a_return_records_the_actual_return_date(): void
    {
        $this->usePeminjamanDatabase();
        $loanId = $this->createLoan();

        $this->withSession([
            'login' => true,
            'role' => 'petugas',
        ])->post(route('petugas.peminjaman.verifikasi', [$loanId, 'kembali']))
            ->assertRedirect();

        $this->assertDatabaseHas('peminjamans', [
            'id' => $loanId,
            'status' => 'dikembalikan',
        ]);
        $returnDate = DB::table('peminjamans')->where('id', $loanId)->value('tanggal_dikembalikan');
        $this->assertSame(now()->toDateString(), \Carbon\Carbon::parse($returnDate)->toDateString());
        $this->assertDatabaseHas('bukus', [
            'id' => 1,
            'stok' => 1,
        ]);
    }

    public function test_student_receives_a_return_receipt_for_their_returned_book(): void
    {
        $this->usePeminjamanDatabase();
        $loanId = $this->createLoan('dikembalikan');
        DB::table('peminjamans')->where('id', $loanId)->update([
            'tanggal_dikembalikan' => '2026-11-09',
        ]);

        $this->withSession([
            'login' => true,
            'role' => 'siswa',
            'user_id' => 1,
        ])->get(route('siswa.bukti', $loanId))
            ->assertOk()
            ->assertSee('Bukti Pengembalian Buku')
            ->assertSee('Diterima kembali pada')
            ->assertSee('09 Nov 2026')
            ->assertSee('Cetak / Simpan PDF');
    }

    public function test_student_cannot_print_another_students_transaction(): void
    {
        $this->usePeminjamanDatabase();
        $loanId = $this->createLoan();

        $this->withSession([
            'login' => true,
            'role' => 'siswa',
            'user_id' => 2,
        ])->get(route('siswa.bukti', $loanId))
            ->assertNotFound();
    }

    public function test_staff_can_print_separate_active_loan_and_return_reports(): void
    {
        $this->usePeminjamanDatabase();
        $returnedLoanId = $this->createLoan('dikembalikan');
        DB::table('peminjamans')->where('id', $returnedLoanId)->update([
            'tanggal_dikembalikan' => '2026-11-09',
        ]);
        DB::table('peminjamans')->insert([
            'user_id' => 1,
            'buku_id' => 1,
            'jumlah' => 1,
            'tanggal_pinjam' => '2026-11-09',
            'tanggal_kembali' => '2026-11-16',
            'status' => 'diterima',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->withSession([
            'login' => true,
            'role' => 'petugas',
        ])->get(route('petugas.peminjaman.laporan.cetak', ['jenis' => 'pengembalian']))
            ->assertOk()
            ->assertSee('Laporan Pengembalian Buku')
            ->assertSeeText('Total transaksi: 1')
            ->assertSee('09-11-2026')
            ->assertDontSee('Dipinjam');

        $this->get(route('petugas.peminjaman.laporan.cetak', ['jenis' => 'peminjaman']))
            ->assertOk()
            ->assertSee('Laporan Peminjaman Aktif')
            ->assertSeeText('Total transaksi: 1')
            ->assertSee('Dipinjam');
    }

    public function test_migration_backfills_return_dates_for_completed_transactions(): void
    {
        $this->usePeminjamanDatabase(false);
        $loanId = $this->createLoan('dikembalikan');

        $migration = require base_path('database/migrations/2026_11_09_000003_add_tanggal_dikembalikan_to_peminjamans_table.php');
        $migration->up();

        $returnDate = DB::table('peminjamans')->where('id', $loanId)->value('tanggal_dikembalikan');
        $this->assertSame(now()->toDateString(), \Carbon\Carbon::parse($returnDate)->toDateString());
    }
}
