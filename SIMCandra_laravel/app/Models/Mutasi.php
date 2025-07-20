<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    protected $fillable = [
        'alasan',
        'keterangan',
        'status_verifikasi',
        'status_ketetapan',
        'tanggal_efektif',
        'tanggal_verifikasi',
        'departemen_baru_id',
        'departemen_lama_id',
        'jabatan_baru_id',
        'jabatan_lama_id',
        'pegawai_id',
        'verifikasi_oleh',
        'dokumen',
        'jenis',
    ];

    public function pegawai() {
        return $this->belongsTo(Pegawai::class);
    }
    public function departemenBaru() {
        return $this->belongsTo(\App\Models\Departemen::class, 'departemen_baru_id');
    }
    public function departemenLama() {
        return $this->belongsTo(\App\Models\Departemen::class, 'departemen_lama_id');
    }
    public function jabatanBaru() {
        return $this->belongsTo(\App\Models\Jabatan::class, 'jabatan_baru_id');
    }
    public function jabatanLama() {
        return $this->belongsTo(\App\Models\Jabatan::class, 'jabatan_lama_id');
    }
    public function verifikator() {
        return $this->belongsTo(\App\Models\User::class, 'verifikasi_oleh');
    }
}
