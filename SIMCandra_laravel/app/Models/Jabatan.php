<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $fillable = ['nama', 'deskripsi', 'level', 'departemen_id'];

    public function mutasiBaru()
    {
        return $this->hasMany(\App\Models\Mutasi::class, 'jabatan_baru_id');
    }

    public function mutasiLama()
    {
        return $this->hasMany(\App\Models\Mutasi::class, 'jabatan_lama_id');
    }

    public function departemen()
    {
        return $this->belongsTo(\App\Models\Departemen::class);
    }
} 