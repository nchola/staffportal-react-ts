<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phk extends Model
{
    protected $fillable = [
        'pegawai_id',
        'keterangan',
        'status',
        'tanggal_verifikasi',
        'verifikasi_oleh',
        'surat_phk',
    ];
    protected $casts = [
        'tanggal_verifikasi' => 'date',
    ];
    public function pegawai() {
        return $this->belongsTo(\App\Models\Pegawai::class);
    }
    public function verifikator() {
        return $this->belongsTo(\App\Models\User::class, 'verifikasi_oleh');
    }
}
