<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    protected $fillable = [
        'alamat', 'catatan', 'email', 'nama_pelamar', 'no_telepon', 'pendidikan_terakhir', 'pengalaman_kerja', 'resume_url', 'status', 'rekrutmen_id', 'user_id'
    ];

    public function rekrutmen()
    {
        return $this->belongsTo(Rekrutmen::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
