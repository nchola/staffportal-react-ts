<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resign extends Model
{
    use HasFactory;
    protected $fillable = [
        'pegawai_id',
        'tanggal_pengajuan',
        'tanggal_resign',
        'alasan',
        'status',
        'keterangan_verifikasi',
        'tanggal_verifikasi',
        'verifikasi_oleh',
        'surat_resign',
    ];
    public function pegawai() {
        return $this->belongsTo(Pegawai::class);
    }
    public function verifikator() {
        return $this->belongsTo(User::class, 'verifikasi_oleh');
    }
} 