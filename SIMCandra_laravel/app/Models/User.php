<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Pegawai;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Define user roles as constants
    const ROLE_HRD = 'HRD';
    const ROLE_KEPALA_UNIT = 'Kepala Unit';
    const ROLE_KARYAWAN = 'Karyawan';
    const ROLE_CALON_KARYAWAN = 'Calon Karyawan';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if the user is an HRD.
     *
     * @return bool
     */
    public function isHrd()
    {
        return $this->role === self::ROLE_HRD;
    }

    /**
     * Check if the user is a Kepala Unit.
     *
     * @return bool
     */
    public function isKepalaUnit()
    {
        return $this->role === self::ROLE_KEPALA_UNIT;
    }

    /**
     * Check if the user is a Karyawan.
     *
     * @return bool
     */
    public function isKaryawan()
    {
        return $this->role === self::ROLE_KARYAWAN;
    }

    /**
     * Check if the user is a Calon Karyawan.
     *
     * @return bool
     */
    public function isCalonKaryawan()
    {
        return $this->role === self::ROLE_CALON_KARYAWAN;
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function mutasiVerifikasi()
    {
        return $this->hasMany(\App\Models\Mutasi::class, 'verifikasi_oleh');
    }
}
