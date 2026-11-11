<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'kategori_id',
        'tahun_terbit',
        'stok',
        'gambar',
        'status_validasi',
    ];

    public const STATUS_MENUNGGU = 'menunggu';
    public const STATUS_DISETUJUI = 'disetujui';
    public const STATUS_DITOLAK = 'ditolak';

    public function scopeDisetujui($query)
    {
        return $query->where('status_validasi', self::STATUS_DISETUJUI);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function ulasans()
    {
        return $this->hasMany(Ulasan::class);
    }
}
