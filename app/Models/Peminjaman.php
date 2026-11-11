<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Buku;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'buku_id',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status'
    ];

    protected $casts = [
        'tanggal_pinjam'   => 'date',
        'tanggal_kembali'  => 'date',
        'tanggal_dikembalikan' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | KONSTANTA STATUS (ANTI TYPO)
    |--------------------------------------------------------------------------
    */

    const STATUS_MENUNGGU      = 'menunggu';
    const STATUS_DITERIMA      = 'diterima';
    const STATUS_DITOLAK       = 'ditolak';
    const STATUS_DIKEMBALIKAN  = 'dikembalikan';
    const STATUS_TERLAMBAT     = 'terlambat';

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS HELPER
    |--------------------------------------------------------------------------
    */

    public function isMenunggu()
    {
        return $this->status === self::STATUS_MENUNGGU;
    }

    public function isDiterima()
    {
        return $this->status === self::STATUS_DITERIMA;
    }

    public function isDitolak()
    {
        return $this->status === self::STATUS_DITOLAK;
    }

    public function isDikembalikan()
    {
        return $this->status === self::STATUS_DIKEMBALIKAN;
    }

    public function isTerlambat()
    {
        return $this->status === self::STATUS_TERLAMBAT;
    }

    public function isOverdue()
    {
        // Check if the peminjaman is past the return date and still active
        if ($this->status === self::STATUS_DITERIMA) {
            return now()->greaterThan($this->tanggal_kembali);
        }
        return false;
    }

    public function cekStatusTerlambat()
    {
        // Auto-update status to 'terlambat' if past due date
        if ($this->isOverdue()) {
            $this->status = self::STATUS_TERLAMBAT;
            $this->save();
        }
        return $this;
    }

    public function isAktif()
    {
        return in_array($this->status, [
            self::STATUS_MENUNGGU,
            self::STATUS_DITERIMA,
            self::STATUS_TERLAMBAT
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | QUERY SCOPE (BIAR CONTROLLER LEBIH BERSIH)
    |--------------------------------------------------------------------------
    */

    public function scopeAktif($query)
    {
        return $query->whereIn('status', [
            self::STATUS_MENUNGGU,
            self::STATUS_DITERIMA,
            self::STATUS_TERLAMBAT
        ]);
    }

    public function scopeSelesai($query)
    {
        return $query->whereIn('status', [
            self::STATUS_DITOLAK,
            self::STATUS_DIKEMBALIKAN
        ]);
    }
}
