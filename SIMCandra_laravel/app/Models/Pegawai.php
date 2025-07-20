<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\User;

class Pegawai extends Model
{
    // Define fillable attributes to allow mass assignment
    protected $fillable = [
        'agama',
        'alamat',
        'departemen_id',
        'email',
        'jenis_kelamin',
        'nama_lengkap',
        'nip',
        'no_telepon',
        'pendidikan_terakhir',
        'status',
        'status_pernikahan',
        'tanggal_bergabung',
        'tanggal_lahir',
        'tempat_lahir',
        'user_id',
        'nama_panggilan',
        'no_ktp',
        'no_absensi',
        'atasan_langsung',
        'jabatan_id',
    ];

    /**
     * Get the user that the pegawai belongs to.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'pegawai_id');
    }

    public function mutasis()
    {
        return $this->hasMany(\App\Models\Mutasi::class);
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
}
