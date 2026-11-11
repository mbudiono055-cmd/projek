<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SiswaAsistenAiTest extends TestCase
{
    public function test_only_students_can_open_the_ai_assistant(): void
    {
        $this->withSession([
            'login' => true,
            'role' => 'petugas',
        ])->get(route('siswa.asisten-ai'))
            ->assertForbidden();
    }

    public function test_offline_assistant_answers_how_to_borrow_without_api_configuration(): void
    {
        $this->withSession([
            'login' => true,
            'role' => 'siswa',
        ])->postJson(route('siswa.asisten-ai.tanya'), [
            'messages' => [
                ['role' => 'user', 'text' => 'Bagaimana cara meminjam buku?'],
            ],
        ])->assertOk()
            ->assertJsonPath('reply', 'Untuk meminjam, buka menu Katalog Buku, pilih buku, lalu ajukan peminjaman. Pengajuan akan menunggu persetujuan petugas. Pastikan stok buku tersedia.');
    }

    public function test_offline_assistant_searches_only_approved_books(): void
    {
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');

        Schema::create('kategoris', function ($table) {
            $table->id();
            $table->string('nama_kategori');
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
            $table->string('status_validasi');
            $table->timestamps();
        });

        $category = Kategori::create(['nama_kategori' => 'Teknologi']);
        Buku::create([
            'judul' => 'Belajar Teknologi',
            'penulis' => 'Dina',
            'penerbit' => 'Pustaka',
            'kategori_id' => $category->id,
            'tahun_terbit' => 2024,
            'stok' => 2,
            'status_validasi' => Buku::STATUS_DISETUJUI,
        ]);
        Buku::create([
            'judul' => 'Teknologi Belum Disetujui',
            'penulis' => 'Rudi',
            'penerbit' => 'Pustaka',
            'kategori_id' => $category->id,
            'tahun_terbit' => 2024,
            'stok' => 4,
            'status_validasi' => Buku::STATUS_MENUNGGU,
        ]);

        $this->withSession([
            'login' => true,
            'role' => 'siswa',
        ])->postJson(route('siswa.asisten-ai.tanya'), [
            'messages' => [
                ['role' => 'user', 'text' => 'Ada buku tentang teknologi?'],
            ],
        ])->assertOk()
            ->assertJsonPath('reply', "Berikut buku yang saya temukan di katalog:\n- Belajar Teknologi — Dina (kategori Teknologi, stok tersedia: 2)")
            ->assertDontSee('Teknologi Belum Disetujui');
    }
}
