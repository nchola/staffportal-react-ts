import { supabase } from "@/integrations/supabase/client";

export interface Leave {
  id: string;
  pegawai_id: string;
  jenis_cuti: 'Tahunan' | 'Sakit' | 'Melahirkan' | 'Penting';
  tanggal_mulai: string;
  tanggal_selesai: string;
  alasan: string;
  status: 'Diajukan' | 'Disetujui' | 'Ditolak';
  verifikasi_oleh: string | null;
  tanggal_verifikasi: string | null;
  keterangan: string | null;
  created_at: string;
  updated_at: string;
  pegawai?: {
    nama_lengkap: string;
    nip: string;
  };
}

export async function getLeaveList(
  page = 1,
  limit = 10,
  search = '',
  order = 'created_at.desc'
) {
  const [field, direction] = order.split('.');
  const offset = (page - 1) * limit;

  let query = supabase
    .from('cuti')
    .select('*, pegawai!inner(nama_lengkap, nip)', { count: 'exact' });

  if (search) {
    query = query.or(`or(pegawai.nama_lengkap.ilike.%${search}%,pegawai.nip.ilike.%${search}%)`);
  }

  const { data, error, count } = await query
    .order(field, { ascending: direction === 'asc' })
    .range(offset, offset + limit - 1);

  if (error) throw error;

  return {
    data: data as Leave[],
    meta: {
      total: count || 0,
      page,
      limit,
      lastPage: Math.ceil((count || 0) / limit)
    }
  };
}

export async function getLeaveById(id: string) {
  const { data, error } = await supabase
    .from('cuti')
    .select('*, pegawai!inner(nama_lengkap, nip)')
    .eq('id', id)
    .single();

  if (error) throw error;
  return data as Leave;
}

export async function addLeave(leave: Omit<Leave, 'id' | 'created_at' | 'updated_at' | 'pegawai' | 'verifikasi_oleh' | 'tanggal_verifikasi'>) {
  const { data, error } = await supabase
    .from('cuti')
    .insert([{ ...leave, status: 'Diajukan' }])
    .select()
    .single();

  if (error) throw error;
  return data;
}

export async function updateLeaveStatus(
  id: string, 
  status: Leave['status'],
  verifikasi_oleh: string,
  keterangan?: string
) {
  // Untuk aplikasi skripsi dengan mock auth, kita tidak perlu menyimpan verifikasi_oleh
  const { data, error } = await supabase
    .from('cuti')
    .update({ 
      status,
      tanggal_verifikasi: new Date().toISOString(),
      keterangan: keterangan || null
    })
    .eq('id', id)
    .select()
    .single();

  if (error) throw error;
  return data;
}

export async function deleteLeave(id: string) {
  const { error } = await supabase
    .from('cuti')
    .delete()
    .eq('id', id);

  if (error) throw error;
} 