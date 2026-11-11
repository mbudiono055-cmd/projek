<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class AsistenAiController extends Controller
{
    public function index()
    {
        abort_unless(session('role') === 'siswa', 403);

        return view('siswa.asisten-ai');
    }

    public function tanya(Request $request)
    {
        abort_unless(session('role') === 'siswa', 403);

        $validated = $request->validate([
            'messages' => ['required', 'array', 'min:1', 'max:12'],
            'messages.*.role' => ['required', 'in:user,assistant'],
            'messages.*.text' => ['required', 'string', 'max:1000'],
        ]);

        $messages = $validated['messages'];
        if ($messages[0]['role'] !== 'user' || end($messages)['role'] !== 'user') {
            return response()->json([
                'message' => 'Percakapan harus dimulai dan diakhiri dengan pesan dari kamu.',
            ], 422);
        }

        foreach ($messages as $index => $message) {
            $expectedRole = $index % 2 === 0 ? 'user' : 'assistant';
            if ($message['role'] !== $expectedRole) {
                return response()->json([
                    'message' => 'Urutan pesan percakapan tidak valid.',
                ], 422);
            }
        }

        $question = mb_strtolower(end($messages)['text'], 'UTF-8');

        if (preg_match('/\b(pinjam|meminjam|peminjaman|peminjam)\b/u', $question)) {
            return response()->json([
                'reply' => 'Untuk meminjam, buka menu Katalog Buku, pilih buku, lalu ajukan peminjaman. Pengajuan akan menunggu persetujuan petugas. Pastikan stok buku tersedia.',
            ]);
        }

        $ignoredTerms = [
            'ada', 'apa', 'bagaimana', 'buku', 'cari', 'carikan', 'dan', 'dengan',
            'di', 'dong', 'judul', 'katalog', 'ke', 'kak', 'koleksi', 'mana', 'mencari', 'penulis',
            'rekomendasi', 'rekomendasikan', 'saja', 'saya', 'tentang', 'tolong',
            'stok', 'tersedia', 'untuk', 'yang',
        ];
        $terms = preg_split('/[^\p{L}\p{N}]+/u', $question, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $terms = array_values(array_filter($terms, function (string $term) use ($ignoredTerms) {
            return mb_strlen($term, 'UTF-8') >= 3 && !in_array($term, $ignoredTerms, true);
        }));
        $wantsCatalog = preg_match('/\b(rekomendasi|rekomendasikan|carikan|cari|buku|katalog|stok|tersedia)\b/u', $question);

        $booksQuery = Buku::disetujui()
            ->with('kategori:id,nama_kategori')
            ->orderByDesc('id');

        if ($terms) {
            $booksQuery->where(function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $query->orWhere('judul', 'like', '%' . $term . '%')
                        ->orWhere('penulis', 'like', '%' . $term . '%')
                        ->orWhereHas('kategori', function ($categoryQuery) use ($term) {
                            $categoryQuery->where('nama_kategori', 'like', '%' . $term . '%');
                        });
                }
            });
        } elseif ($wantsCatalog) {
            $booksQuery->where('stok', '>', 0);
        } else {
            return response()->json([
                'reply' => 'Saya asisten offline perpustakaan. Saya bisa membantu mencari buku berdasarkan judul, penulis, atau kategori, serta menjelaskan cara mengajukan peminjaman. Coba tanyakan topik atau judul buku yang kamu cari.',
            ]);
        }

        $books = $booksQuery
            ->limit(5)
            ->get(['id', 'judul', 'penulis', 'kategori_id', 'tahun_terbit', 'stok']);

        if ($books->isEmpty()) {
            return response()->json([
                'reply' => $terms
                    ? 'Saya belum menemukan buku yang cocok di katalog yang disetujui. Coba kata kunci judul, penulis, atau kategori lain.'
                    : 'Belum ada buku dengan stok tersedia di katalog saat ini.',
            ]);
        }

        $bookDetails = $books->map(function (Buku $buku) {
            $availability = $buku->stok > 0
                ? 'stok tersedia: ' . $buku->stok
                : 'stok habis';

            return '- ' . $buku->judul . ' — ' . $buku->penulis
                . ' (kategori ' . ($buku->kategori->nama_kategori ?? 'Umum')
                . ', ' . $availability . ')';
        })->implode("\n");

        return response()->json([
            'reply' => 'Berikut buku yang saya temukan di katalog:' . "\n" . $bookDetails,
        ]);
    }
}
