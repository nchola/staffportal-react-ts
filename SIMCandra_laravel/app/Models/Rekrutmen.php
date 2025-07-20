<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekrutmen extends Model
{
    protected $fillable = [
        'judul', 'deskripsi', 'kualifikasi', 'status', 'tanggal_buka', 'tanggal_tutup'
    ];

    public function lamarans()
    {
        return $this->hasMany(Lamaran::class);
    }
}
