
import { supabase } from "@/integrations/supabase/client";

/**
 * API Util untuk CRUD pegawai via Supabase Edge Function
 */
const EDGE_BASE = "https://dlcedsnzahniwvnobxon.functions.supabase.co/pegawai-crud";

export async function getPegawaiList({ page = 1, limit = 15, order = "nama_lengkap.asc" } = {}) {
  const offset = (page - 1) * limit;
  const url = `${EDGE_BASE}?limit=${limit}&offset=${offset}&order=${order}`;
  const res = await fetch(url, { headers: { apikey: supabase.supabaseKey! } });
  const json = await res.json();
  if (res.ok) return { data: json.data, total: json.total };
  throw new Error(json?.error ?? "Gagal mengambil data pegawai");
}

export async function addPegawai(payload: any) {
  const res = await fetch(EDGE_BASE, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      apikey: supabase.supabaseKey!,
    },
    body: JSON.stringify(payload),
  });
  const json = await res.json();
  if (res.ok) return json.data?.[0];
  throw new Error(json?.error ?? "Gagal menambah data pegawai");
}

export async function editPegawai(id: string, payload: any) {
  const res = await fetch(`${EDGE_BASE}?id=${id}`, {
    method: "PATCH",
    headers: {
      "Content-Type": "application/json",
      apikey: supabase.supabaseKey!,
    },
    body: JSON.stringify(payload),
  });
  const json = await res.json();
  if (res.ok) return json.data?.[0];
  throw new Error(json?.error ?? "Gagal mengedit data pegawai");
}

export async function printPegawai() {
  const url = `${EDGE_BASE}/print`;
  const res = await fetch(url, { headers: { apikey: supabase.supabaseKey! } });
  const json = await res.json();
  if (res.ok) return json.data;
  throw new Error(json?.error ?? "Gagal mencetak data pegawai");
}
