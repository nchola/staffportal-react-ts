
import { supabase } from "@/integrations/supabase/client";

/**
 * API Util untuk CRUD pegawai via Supabase direct queries
 * Implementasi untuk performance:
 * - Direct queries (tanpa Edge Function)
 * - Menggunakan filter di database level
 * - Query optimization dengan select kolom yang dibutuhkan saja
 */

export async function getPegawaiList({ page = 1, limit = 15, order = "nama_lengkap.asc" } = {}) {
  const offset = (page - 1) * limit;
  
  // Split the order string into column and direction
  const [column, direction] = order.split('.');
  
  // Execute count query first to get total
  const { count, error: countError } = await supabase
    .from('pegawai')
    .select('*', { count: 'exact', head: true });
  
  if (countError) throw new Error(countError.message ?? "Gagal menghitung total pegawai");
  
  // Then execute the actual data query
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
    .order(column, { ascending: direction === 'asc' })
    .range(offset, offset + limit - 1);
  
  if (error) throw new Error(error.message ?? "Gagal mengambil data pegawai");
  return { data, total: count };
}

export async function addPegawai(payload: any) {
  const { data, error } = await supabase
    .from('pegawai')
    .insert([payload])
    .select();
  
  if (error) throw new Error(error.message ?? "Gagal menambah data pegawai");
  return data?.[0];
}

export async function editPegawai(id: string, payload: any) {
  const { data, error } = await supabase
    .from('pegawai')
    .update(payload)
    .eq('id', id)
    .select();
  
  if (error) throw new Error(error.message ?? "Gagal mengedit data pegawai");
  return data?.[0];
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
