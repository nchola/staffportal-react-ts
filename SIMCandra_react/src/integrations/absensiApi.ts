import { supabase } from "@/integrations/supabase/client";

export interface Absensi {
  id: string;
  pegawai_id: string | null;
  tanggal: string;
  waktu_masuk: string | null;
  waktu_keluar: string | null;
  status: 'Hadir' | 'Terlambat' | 'Izin' | 'Sakit' | 'Cuti' | 'Tanpa Keterangan' | null;
  keterangan?: string | null;
  created_at: string;
  updated_at: string;
  pegawai?: {
    nama_lengkap: string;
    nip: string;
  };
}

export async function getAbsensiList(
  page = 1,
  limit = 10,
  search = '',
  tanggal?: string
) {
  const offset = (page - 1) * limit;

  let query = supabase
    .from('absensi')
    .select(`
      *,
      pegawai (
        nama_lengkap,
        nip
      )
    `, { count: 'exact' });

  if (search) {
    query = query.or(`pegawai.nama_lengkap.ilike.%${search}%,pegawai.nip.ilike.%${search}%`);
  }

  if (tanggal) {
    query = query.eq('tanggal', tanggal);
  }

  const { data, error, count } = await query
    .order('tanggal', { ascending: false })
    .range(offset, offset + limit - 1);

  if (error) throw error;

  return {
    data: data as Absensi[],
    meta: {
      total: count || 0,
      page,
      limit,
      lastPage: Math.ceil((count || 0) / limit)
    }
  };
}

export async function addAbsensi(absensi: Omit<Absensi, 'id' | 'created_at' | 'updated_at' | 'pegawai'>) {
  const { data, error } = await supabase
    .from('absensi')
    .insert([absensi])
    .select(`
      *,
      pegawai (
        nama_lengkap,
        nip
      )
    `)
    .single();

  if (error) throw error;
  return data as Absensi;
}

export async function editAbsensi(id: string, absensi: Partial<Omit<Absensi, 'id' | 'created_at' | 'updated_at' | 'pegawai'>>) {
  const { data, error } = await supabase
    .from('absensi')
    .update(absensi)
    .eq('id', id)
    .select(`
      *,
      pegawai (
        nama_lengkap,
        nip
      )
    `)
    .single();

  if (error) throw error;
  return data as Absensi;
}

export async function deleteAbsensi(id: string) {
  const { error } = await supabase
    .from('absensi')
    .delete()
    .eq('id', id);

  if (error) throw error;
}

export async function getAbsensiById(id: string) {
  const { data, error } = await supabase
    .from('absensi')
    .select(`
      *,
      pegawai (
        nama_lengkap,
        nip
      )
    `)
    .eq('id', id)
    .single();

  if (error) throw error;
  return data as Absensi;
}

export async function printAbsensi(tanggal?: string) {
  let query = supabase
    .from('absensi')
    .select(`
      *,
      pegawai (
        nama_lengkap,
        nip
      )
    `);

  if (tanggal) {
    query = query.eq('tanggal', tanggal);
  }

  const { data, error } = await query
    .order('tanggal', { ascending: false });

  if (error) throw new Error(error.message ?? "Gagal mencetak data absensi");
  return data as Absensi[];
} 