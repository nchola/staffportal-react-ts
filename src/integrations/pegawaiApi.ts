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
  tanggal_bergabung: string;
  departemen_id?: string;
  jabatan_id?: string;
  created_at?: string;
  updated_at?: string;
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
    data,
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
  const { error } = await supabase
    .from('pegawai')
    .delete()
    .eq('id', id);

  if (error) throw error;
}

export async function printPegawai() {
  // For print functionality, we need all the data
  // Optimize by selecting only needed columns
  const { data, error } = await supabase
    .from('pegawai')
    .select(`
      nip,
      nama_lengkap,
      email,
      tanggal_bergabung
    `)
    .order('nama_lengkap');
  
  if (error) throw new Error(error.message ?? "Gagal mencetak data pegawai");
  return data;
}

/**
 * Get a single employee by ID
 * Added for better performance when fetching single record
 */
export async function getPegawaiById(id: string) {
  const { data, error } = await supabase
    .from('pegawai')
    .select(`
      id,
      nip,
      nama_lengkap,
      email,
      tanggal_bergabung,
      departemen_id,
      jabatan_id
    `)
    .eq('id', id)
    .single();
  
  if (error) throw new Error(error.message ?? "Gagal mengambil data pegawai");
  return data;
}
