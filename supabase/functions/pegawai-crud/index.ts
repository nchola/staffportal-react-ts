
import { serve } from "https://deno.land/std@0.168.0/http/server.ts";

const corsHeaders = {
  "Access-Control-Allow-Origin": "*",
  "Access-Control-Allow-Headers": "authorization, x-client-info, apikey, content-type",
  "Content-Type": "application/json",
};

const SUPABASE_SERVICE_KEY = Deno.env.get("SUPABASE_SERVICE_KEY");
const SUPABASE_URL = Deno.env.get("SUPABASE_URL");

if (!SUPABASE_SERVICE_KEY || !SUPABASE_URL) {
  throw new Error("Missing SUPABASE_SERVICE_KEY or SUPABASE_URL");
}

async function callSupabase(path: string, opts: any = {}) {
  const url = `${SUPABASE_URL}/rest/v1/${path}`;
  return await fetch(url, {
    headers: {
      apikey: SUPABASE_SERVICE_KEY,
      Authorization: `Bearer ${SUPABASE_SERVICE_KEY}`,
      ...(opts.headers || {})
    },
    ...opts,
  });
}

serve(async (req) => {
  if (req.method === "OPTIONS") {
    return new Response("ok", { headers: corsHeaders });
  }

  try {
    const { pathname } = new URL(req.url);

    // PRINT /pegawai-crud/print
    if (pathname.endsWith("/print")) {
      // Cetak data pegawai (all, pagination tetap agar tidak overload)
      const resp = await callSupabase(
        "pegawai?order=nama_lengkap.asc&select=*"
      );
      const data = await resp.json();
      return new Response(JSON.stringify({ data }), { headers: corsHeaders });
    }

    // GET: Ambil data pegawai
    if (req.method === "GET") {
      const { searchParams } = new URL(req.url);
      const limit = Number(searchParams.get("limit")) || 15;
      const offset = Number(searchParams.get("offset")) || 0;
      const order = searchParams.get("order") || "nama_lengkap.asc";
      const response = await callSupabase(
        `pegawai?order=${order}&limit=${limit}&offset=${offset}&select=*`
      );
      const data = await response.json();
      // Untuk performa, info jumlah total baris (optional)
      const countResp = await callSupabase(
        "pegawai?select=id",
      );
      const totalData = (await countResp.json())?.length ?? 0;
      return new Response(JSON.stringify({ data, total: totalData }), { headers: corsHeaders });
    }

    // POST: Tambah data pegawai
    if (req.method === "POST") {
      const body = await req.json();
      // Validasi basic field wajib
      if (!body.nip || !body.nama_lengkap || !body.tanggal_bergabung) {
        return new Response(
          JSON.stringify({ error: "Field wajib: nip, nama_lengkap, tanggal_bergabung" }),
          { status: 400, headers: corsHeaders }
        );
      }
      // Untuk keamanan, whitelist kolom yang diizinkan
      const allowed = [
        "nip", "nama_lengkap", "email", "tempat_lahir", "tanggal_lahir",
        "jenis_kelamin", "agama", "status_pernikahan", "no_telepon",
        "alamat", "pendidikan_terakhir", "tanggal_bergabung",
        "departemen_id", "jabatan_id", "status"
      ];
      const payload: any = {};
      for (const key of allowed) {
        if (body.hasOwnProperty(key)) payload[key] = body[key];
      }
      const supaResp = await callSupabase("pegawai", {
        method: "POST",
        body: JSON.stringify([payload]), // Supabase REST API batch style
        headers: { "Content-Type": "application/json" },
      });
      if (!supaResp.ok) {
        const error = await supaResp.json();
        return new Response(JSON.stringify({ error }), { status: 400, headers: corsHeaders });
      }
      const inserted = await supaResp.json();
      return new Response(JSON.stringify({ data: inserted }), { headers: corsHeaders });
    }

    // PATCH: Edit data pegawai
    if (req.method === "PATCH") {
      const { searchParams } = new URL(req.url);
      const id = searchParams.get("id");
      if (!id) {
        return new Response(JSON.stringify({ error: "Param id wajib" }), { status: 400, headers: corsHeaders });
      }
      const body = await req.json();
      // Kolom yang diizinkan untuk update
      const allowed = [
        "nip", "nama_lengkap", "email", "tempat_lahir", "tanggal_lahir",
        "jenis_kelamin", "agama", "status_pernikahan", "no_telepon",
        "alamat", "pendidikan_terakhir", "tanggal_bergabung",
        "departemen_id", "jabatan_id", "status"
      ];
      const payload: any = {};
      for (const key of allowed) {
        if (body.hasOwnProperty(key)) payload[key] = body[key];
      }
      if (Object.keys(payload).length === 0) {
        return new Response(JSON.stringify({ error: "Tidak ada field untuk update" }), { status: 400, headers: corsHeaders });
      }
      const supaResp = await callSupabase(`pegawai?id=eq.${id}`, {
        method: "PATCH",
        body: JSON.stringify(payload),
        headers: { "Content-Type": "application/json" },
      });
      if (!supaResp.ok) {
        const error = await supaResp.json();
        return new Response(JSON.stringify({ error }), { status: 400, headers: corsHeaders });
      }
      const updated = await supaResp.json();
      return new Response(JSON.stringify({ data: updated }), { headers: corsHeaders });
    }
    // Method tidak didukung
    return new Response(JSON.stringify({ error: "Not found" }), { status: 404, headers: corsHeaders });
  } catch (err) {
    console.error("pegawai-crud error:", err);
    return new Response(JSON.stringify({ error: err?.message || "Internal error" }), {
      status: 500,
      headers: corsHeaders,
    });
  }
});
