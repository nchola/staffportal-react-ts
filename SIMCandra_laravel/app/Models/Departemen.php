<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    protected $fillable = ['nama', 'deskripsi'];

    public function mutasiBaru()
    {
        return $this->hasMany(\App\Models\Mutasi::class, 'departemen_baru_id');
    }

    public function mutasiLama()
    {
        return $this->hasMany(\App\Models\Mutasi::class, 'departemen_lama_id');
    }

    public function jabatans()
    {
        return $this->hasMany(\App\Models\Jabatan::class);
    }
} 