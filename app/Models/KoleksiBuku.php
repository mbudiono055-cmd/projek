<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KoleksiBuku extends Model
{
    protected $fillable = [
        'user_id',
        'buku_id'
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
