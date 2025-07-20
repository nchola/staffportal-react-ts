<?php

namespace App\Policies;

use App\Models\Cuti;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Auth\Access\Response;

class CutiPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // HRD, Kepala Unit, and Karyawan can view the list (filtering for Karyawan happens in the controller)
        return in_array($user->role, ['HRD', 'Kepala Unit', 'Karyawan']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Cuti $cuti): bool
    {
        if ($user->role === 'HRD' || $user->role === 'Kepala Unit') {
            return true;
        }
        if ($user->role === 'Karyawan') {
            $pegawai = $user->pegawai;
            return $pegawai && $pegawai->id === $cuti->pegawai_id;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // HRD and Karyawan can create cuti requests.
        return in_array($user->role, ['HRD', 'Karyawan']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Cuti $cuti): bool
    {
        if ($user->role === 'HRD') {
            return true;
        }
        if ($user->role === 'Karyawan') {
            $pegawai = $user->pegawai;
            return $pegawai && $pegawai->id === $cuti->pegawai_id && ($cuti->status === null || $cuti->status === 'Pending');
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Cuti $cuti): bool
    {
        // Only HRD can delete cuti requests.
        return $user->role === 'HRD';
    }

    /**
     * Determine whether the user can verify the model.
     */
    public function verify(User $user, Cuti $cuti): bool
    {
        // HRD dan Kepala Unit bisa verifikasi cuti yang pending
        return in_array($user->role, ['HRD', 'Kepala Unit']) && ($cuti->status === null || $cuti->status === 'Pending');
    }

    /**
     * Determine whether the user can print the model.
     */
    public function print(User $user, Cuti $cuti): bool
    {
        if (($user->role === 'HRD' || $user->role === 'Kepala Unit') && $cuti->status === 'Disetujui') {
            return true;
        }
        if ($user->role === 'Karyawan') {
            $pegawai = $user->pegawai;
            return $pegawai && $pegawai->id === $cuti->pegawai_id && $cuti->status === 'Disetujui';
        }
        return false;
    }
}
