# PT Sungai Budi Group - Staff Portal

Sistem Manajemen SDM untuk PT Sungai Budi Group.

## Teknologi yang Digunakan

- React + Vite
- TypeScript
- Tailwind CSS
- shadcn/ui
- Supabase
- Vercel

## Environment Setup

1. Copy `.env.example` ke `.env.local`:
```bash
cp .env.example .env.local
```

2. Update environment variables di `.env.local` dengan credentials Supabase:
```env
VITE_SUPABASE_URL=your_supabase_url
VITE_SUPABASE_ANON_KEY=your_supabase_anon_key
```

3. Jangan commit `.env.local` atau `src/integrations/supabase/client.ts` ke version control

## Development

```bash
# Install dependencies
npm install

# Start development server
npm run dev
```

## Deployment di Vercel

1. Tambahkan environment variables berikut di pengaturan proyek Vercel:
- `VITE_SUPABASE_URL`
- `VITE_SUPABASE_ANON_KEY`

2. Deploy proyek:
```bash
vercel
```

## Fitur

- Manajemen Data Pegawai
- Sistem Absensi
- Manajemen Cuti
- Rekrutmen
- Mutasi
- Pengguna & Hak Akses
- Reward & Punishment
- Promosi
- PHK
