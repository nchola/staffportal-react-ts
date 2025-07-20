<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuti extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pegawai_id',
        'jenis_cuti',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'keterangan',
        'status',
        'tanggal_verifikasi',
        'surat_keterangan'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_verifikasi' => 'date',
    ];

    /**
     * Get the pegawai that owns the Cuti.
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function requiresSuratKeterangan()
    {
        return in_array($this->jenis_cuti, ['Cuti Sakit', 'Cuti Melahirkan', 'Cuti Khusus']);
    }
}
