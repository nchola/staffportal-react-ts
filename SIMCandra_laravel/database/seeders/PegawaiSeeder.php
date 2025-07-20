<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Departemen;
use App\Models\Jabatan;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user berdasarkan username
        $hrdUser = User::where('username', 'HRD')->first();
        $kepalaUnitUser = User::where('username', 'Kepala Unit')->first();
        $karyawanUser = User::where('username', 'Karyawan')->first();

        // 1. Insert departemen jika belum ada
        $departemenIT = Departemen::firstOrCreate(['nama' => 'IT'], ['deskripsi' => 'Teknologi Informasi']);
        $departemenHRD = Departemen::firstOrCreate(['nama' => 'HRD'], ['deskripsi' => 'Human Resource']);
        $departemenManagerial = Departemen::firstOrCreate(['nama' => 'Managerial'], ['deskripsi' => 'Manajemen']);
        $departemenOperasional = Departemen::firstOrCreate(['nama' => 'Operasional'], ['deskripsi' => 'Operasional']);

        // 2. Insert jabatan jika belum ada
        $jabatanDeveloper = Jabatan::firstOrCreate(['nama' => 'Developer', 'departemen_id' => $departemenIT->id], ['level' => 1]);
        $jabatanNetworkEngineer = Jabatan::firstOrCreate(['nama' => 'Network Engineer', 'departemen_id' => $departemenIT->id], ['level' => 1]);
        $jabatanManagerIT = Jabatan::firstOrCreate(['nama' => 'Manager IT', 'departemen_id' => $departemenManagerial->id], ['level' => 2]);
        $jabatanStaffRekrutmen = Jabatan::firstOrCreate(['nama' => 'Staff Rekrutmen', 'departemen_id' => $departemenHRD->id], ['level' => 1]);
        $jabatanStaffOperasional = Jabatan::firstOrCreate(['nama' => 'Staff Operasional', 'departemen_id' => $departemenOperasional->id], ['level' => 1]);

        // 3. Isi pegawai
        $pegawais = [
            [
                'nip' => '123456789',
                'nama_lengkap' => 'Budi Santoso',
                'username' => 'budi.santoso',
                'password' => 'passwordbudi',
                'role' => 'Karyawan',
                'nama_panggilan' => 'Budi',
                'no_ktp' => '320111222333444',
                'no_absensi' => 'ABS-001',
                'atasan_langsung' => 'Siti Aminah',
                'departemen_id' => $departemenIT->id,
                'jabatan_id' => $jabatanDeveloper->id,
                'email' => 'budi.s@example.com',
                'no_telepon' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 1, Jakarta',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-05-15',
                'pendidikan_terakhir' => 'S1 Teknik Informatika',
                'status_pernikahan' => 'Belum Menikah',
                'status' => 'Pegawai Tetap',
                'tanggal_bergabung' => '2020-01-10',
                'user_id' => $karyawanUser ? $karyawanUser->id : null,
            ],
            [
                'nip' => '987654321',
                'nama_lengkap' => 'Siti Aminah',
                'username' => 'kepalaunit',
                'password' => 'kepalaunit123',
                'role' => 'Kepala Unit',
                'nama_panggilan' => 'Siti',
                'no_ktp' => '320199888777666',
                'no_absensi' => 'ABS-002',
                'atasan_langsung' => null,
                'departemen_id' => $departemenManagerial->id,
                'jabatan_id' => $jabatanManagerIT->id,
                'email' => 'siti.a@example.com',
                'no_telepon' => '081298765432',
                'alamat' => 'Jl. Sudirman No. 5, Jakarta',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1985-11-20',
                'pendidikan_terakhir' => 'S2 Manajemen',
                'status_pernikahan' => 'Menikah',
                'status' => 'Pegawai Tetap',
                'tanggal_bergabung' => '2015-03-01',
                'user_id' => $kepalaUnitUser ? $kepalaUnitUser->id : null,
            ],
            [
                'nip' => '112233445',
                'nama_lengkap' => 'Agus Susanto',
                'username' => 'agus.susanto',
                'password' => 'passwordagus',
                'role' => 'Karyawan',
                'nama_panggilan' => 'Agus',
                'no_ktp' => '320111222333555',
                'no_absensi' => 'ABS-003',
                'atasan_langsung' => 'Siti Aminah',
                'departemen_id' => $departemenIT->id,
                'jabatan_id' => $jabatanNetworkEngineer->id,
                'email' => 'agus.s@example.com',
                'no_telepon' => '085612345678',
                'alamat' => 'Jl. Asia Afrika No. 10, Bandung',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Kristen',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1992-07-07',
                'pendidikan_terakhir' => 'D3 Teknik Komputer',
                'status_pernikahan' => 'Menikah',
                'status' => 'Pegawai Kontrak',
                'tanggal_bergabung' => '2022-08-15',
                'user_id' => null,
            ],
            [
                'nip' => '556677889',
                'nama_lengkap' => 'Dewi Lestari',
                'username' => 'dewi.lestari',
                'password' => 'passworddewi',
                'role' => 'Karyawan',
                'nama_panggilan' => 'Dewi',
                'no_ktp' => '320144555666777',
                'no_absensi' => 'ABS-004',
                'atasan_langsung' => 'Siti Aminah',
                'departemen_id' => $departemenHRD->id,
                'jabatan_id' => $jabatanStaffRekrutmen->id,
                'email' => 'dewi.l@example.com',
                'no_telepon' => '087898765432',
                'alamat' => 'Perumahan Indah Blok C No. 3, Bogor',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Buddha',
                'tempat_lahir' => 'Bogor',
                'tanggal_lahir' => '1995-02-28',
                'pendidikan_terakhir' => 'S1 Psikologi',
                'status_pernikahan' => 'Belum Menikah',
                'status' => 'Pegawai Tetap',
                'tanggal_bergabung' => '2021-06-01',
                'user_id' => null,
            ],
            [
                'nip' => '998877665',
                'nama_lengkap' => 'Joko Prabowo',
                'username' => 'karyawan',
                'password' => 'karyawan123',
                'role' => 'Karyawan',
                'nama_panggilan' => 'Joko',
                'no_ktp' => '320177888999000',
                'no_absensi' => 'ABS-005',
                'atasan_langsung' => 'Siti Aminah',
                'departemen_id' => $departemenOperasional->id,
                'jabatan_id' => $jabatanStaffOperasional->id,
                'email' => 'joko.p@example.com',
                'no_telepon' => '081312345678',
                'alamat' => 'Gang Mawar No. 8, Depok',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Hindu',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '1993-09-10',
                'pendidikan_terakhir' => 'D3 Manajemen Bisnis',
                'status_pernikahan' => 'Menikah',
                'status' => 'Pegawai Kontrak',
                'tanggal_bergabung' => '2023-01-20',
                'user_id' => null,
            ],
            [
                'nip' => '111222333',
                'nama_lengkap' => 'Dian HRD',
                'username' => 'hrd',
                'password' => 'hrd123',
                'role' => 'HRD',
                'nama_panggilan' => 'Dian',
                'no_ktp' => '320100200300400',
                'no_absensi' => 'ABS-010',
                'atasan_langsung' => null,
                'departemen_id' => $departemenHRD->id,
                'jabatan_id' => $jabatanStaffRekrutmen->id,
                'email' => 'dian.hrd@example.com',
                'no_telepon' => '081200300400',
                'alamat' => 'Jl. HRD No. 10, Jakarta',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1988-12-12',
                'pendidikan_terakhir' => 'S2 Psikologi',
                'status_pernikahan' => 'Menikah',
                'status' => 'Pegawai Tetap',
                'tanggal_bergabung' => '2018-04-01',
                'user_id' => null,
            ],
        ];

        foreach ($pegawais as $data) {
            $pegawai = Pegawai::create([
                'nip' => $data['nip'],
                'nama_lengkap' => $data['nama_lengkap'],
                'nama_panggilan' => $data['nama_panggilan'],
                'no_ktp' => $data['no_ktp'],
                'no_absensi' => $data['no_absensi'],
                'atasan_langsung' => $data['atasan_langsung'],
                'departemen_id' => $data['departemen_id'],
                'jabatan_id' => $data['jabatan_id'],
                'email' => $data['email'],
                'no_telepon' => $data['no_telepon'],
                'alamat' => $data['alamat'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'agama' => $data['agama'],
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'pendidikan_terakhir' => $data['pendidikan_terakhir'],
                'status_pernikahan' => $data['status_pernikahan'],
                'status' => $data['status'],
                'tanggal_bergabung' => $data['tanggal_bergabung'],
                'user_id' => $data['user_id'],
            ]);

            User::create([
                'name' => $data['nama_lengkap'],
                'username' => $data['username'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'pegawai_id' => $pegawai->id,
            ]);
        }
    }
}
