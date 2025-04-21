import { supabase } from "@/integrations/supabase/client";

/**
 * API Util untuk CRUD pegawai via Supabase direct queries
 * Implementasi untuk performance:
 * - Direct queries (tanpa Edge Function)
 * - Menggunakan filter di database level
 * - Query optimization dengan select kolom yang dibutuhkan saja
 */

export interface Pegawai {
  id: string;
  nip: string;
  nama_lengkap: string;
  email?: string;
  tempat_lahir?: string;
  tanggal_lahir?: string;
  jenis_kelamin?: 'Laki-laki' | 'Perempuan';
  alamat?: string;
  agama?: string;
  status_pernikahan?: string;
  no_telepon?: string;
  pendidikan_terakhir?: string;
  tanggal_bergabung: string;
  jabatan_id?: string;
  departemen_id?: string;
  status: 'Aktif' | 'Non-Aktif';
  created_at?: string;
  updated_at?: string;
  user_id?: string;
}

export async function getPegawaiList(
  page = 1,
  limit = 10,
  search = '',
  order = 'nama_lengkap.asc'
) {
  const [field, direction] = order.split('.');
  const offset = (page - 1) * limit;

  let query = supabase
    .from('pegawai')
    .select('*', { count: 'exact' });

  if (search) {
    query = query.or(`nama_lengkap.ilike.%${search}%,nip.ilike.%${search}%,email.ilike.%${search}%`);
  }

  const { data, error, count } = await query
    .order(field, { ascending: direction === 'asc' })
    .range(offset, offset + limit - 1);

  if (error) throw error;

  return {
    data: data as Pegawai[],
    meta: {
      total: count || 0,
      page,
      limit,
      lastPage: Math.ceil((count || 0) / limit)
    }
  };
}

export async function addPegawai(pegawai: Omit<Pegawai, 'id' | 'created_at' | 'updated_at'>) {
  const { data, error } = await supabase
    .from('pegawai')
    .insert([pegawai])
    .select()
    .single();

  if (error) throw error;
  return data;
}

export async function editPegawai(id: string, pegawai: Partial<Pegawai>) {
  const { data, error } = await supabase
    .from('pegawai')
    .update(pegawai)
    .eq('id', id)
    .select()
    .single();

  if (error) throw error;
  return data;
}

export async function deletePegawai(id: string) {
  try {
    // Check if employee has related records
    const { data: relatedData, error: checkError } = await supabase
      .from('absensi')
      .select('id')
      .eq('pegawai_id', id)
      .limit(1);

    if (checkError) throw checkError;

    if (relatedData && relatedData.length > 0) {
      throw new Error('Pegawai ini memiliki data absensi. Hapus data absensi terlebih dahulu.');
    }

    // Check other related tables
    const { data: cutiData, error: cutiError } = await supabase
      .from('cuti')
      .select('id')
      .eq('pegawai_id', id)
      .limit(1);

    if (cutiError) throw cutiError;

    if (cutiData && cutiData.length > 0) {
      throw new Error('Pegawai ini memiliki data cuti. Hapus data cuti terlebih dahulu.');
    }

    // If no related records found, proceed with deletion
    const { error: deleteError } = await supabase
      .from('pegawai')
      .delete()
      .eq('id', id);

    if (deleteError) throw deleteError;
  } catch (error) {
    if (error instanceof Error) {
      throw new Error(error.message);
    }
    throw new Error('Gagal menghapus data pegawai');
  }
}

export async function printPegawai() {
  const { data, error } = await supabase
    .from('pegawai')
    .select(`
      nip,
      nama_lengkap,
      email,
      no_telepon,
      alamat,
      status,
      tanggal_bergabung
    `)
    .order('nama_lengkap');
  
  if (error) throw new Error(error.message ?? "Gagal mencetak data pegawai");
  return data as Pegawai[];
}

/**
 * Get a single employee by ID
 * Added for better performance when fetching single record
 */
export async function getPegawaiById(id: string) {
  const { data, error } = await supabase
    .from('pegawai')
    .select('*')
    .eq('id', id)
    .single();
  
  if (error) throw new Error(error.message ?? "Gagal mengambil data pegawai");
  return data as Pegawai;
}
