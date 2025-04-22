# PT Sungai Budi Group - Staff Portal

Sistem Manajemen SDM (Human Resource Management System) untuk PT Sungai Budi Group yang dibangun dengan teknologi modern dan best practices.

![image](https://github.com/user-attachments/assets/0d82ca23-81b8-4b0c-82b9-a5b2bf8383e0)
![image](https://github.com/user-attachments/assets/2101ab7a-9b17-42a6-a96f-72a6b98d9fed)
![image](https://github.com/user-attachments/assets/f3ec76fd-65ba-4845-b118-2b8132405d2d)

## 🚀 Teknologi yang Digunakan
### Frontend
- **React 18** - Library JavaScript untuk membangun user interface
- **Vite** - Build tool dan development server yang cepat
- **TypeScript** - Superset JavaScript dengan static typing
- **Tailwind CSS** - Utility-first CSS framework
- **shadcn/ui** - Komponen UI yang reusable dan accessible
- **React Router v6** - Client-side routing
- **React Query** - State management dan data fetching
- **React Hook Form** - Form handling dengan validasi
- **Zod** - Schema validation
- **Framer Motion** - Animasi dan transisi

### Backend & Database
- **Supabase** - Backend-as-a-Service dengan PostgreSQL database
- **PostgreSQL** - Relational database management system

### Deployment
- **Vercel** - Platform untuk deployment dan hosting
- **Docker** - Containerization untuk development dan deployment

## 📁 Struktur Proyek
```
src/
├── components/     # Komponen UI yang reusable
├── context/       # React context untuk state management
├── db/            # Database schema dan types
├── hooks/         # Custom React hooks
├── integrations/  # Integrasi dengan external services
├── lib/           # Utility functions dan helpers
├── pages/         # Halaman aplikasi
├── types/         # TypeScript type definitions
├── App.tsx        # Root component
└── main.tsx       # Entry point aplikasi
```

## 🛠️ Setup Development
1. Clone repository:
```bash
git clone [repository-url]
cd [project-name]
```

2. Install dependencies:
```bash
npm install
```

3. Setup environment variables:
```bash
cp .env.example .env.local
```

4. Update environment variables di `.env.local`:
```env
VITE_SUPABASE_URL=your_supabase_url
VITE_SUPABASE_ANON_KEY=your_supabase_anon_key
```

5. Start development server:
```bash
npm run dev
```

## 🏗️ Arsitektur & Best Practices
### State Management
- Menggunakan React Query untuk server state management
- Context API untuk global state yang sederhana
- Local state dengan useState dan useReducer

### Data Fetching
- Menggunakan React Query untuk data fetching dan caching
- Optimistic updates untuk UX yang lebih baik
- Error handling dengan toast notifications

### Form Handling
- React Hook Form untuk form management
- Zod untuk schema validation
- Custom form components dengan shadcn/ui

### Styling
- Tailwind CSS untuk utility-first styling
- CSS Modules untuk component-specific styles
- Responsive design dengan mobile-first approach

### Type Safety
- TypeScript untuk type checking
- Strict mode enabled
- Custom type definitions untuk database models

## 🚀 Deployment
### Vercel Deployment
1. Tambahkan environment variables di Vercel:
   - `VITE_SUPABASE_URL`
   - `VITE_SUPABASE_ANON_KEY`

2. Deploy dengan Vercel CLI:
```bash
vercel
```

### Docker Deployment
1. Build Docker image:
```bash
docker build -t staff-portal .
```

2. Run container:
```bash
docker run -p 3000:3000 staff-portal
```

## 📋 Fitur Utama
- **Manajemen Data Pegawai**
  - CRUD operasi untuk data pegawai
  - Upload dan manajemen dokumen
  - Riwayat pekerjaan

- **Sistem Absensi**
  - Clock in/out
  - Laporan absensi
  - Pengajuan izin

- **Manajemen Cuti**
  - Pengajuan cuti
  - Approval workflow
  - Kalender cuti

- **Rekrutmen**
  - Manajemen lowongan
  - Tracking kandidat
  - Interview scheduling

- **Mutasi & Promosi**
  - Pengajuan mutasi
  - Tracking riwayat posisi
  - Approval workflow

- **Pengguna & Hak Akses**
  - Role-based access control
  - Permission management
  - Audit log

- **Reward & Punishment**
  - Tracking prestasi
  - Sistem poin
  - Laporan evaluasi

## 🔒 Keamanan
- Authentication dengan Supabase Auth
- Role-based access control
- HTTPS enforcement
- Input sanitization
- CSRF protection
- Rate limiting

## 📚 Dokumentasi Tambahan
- [Supabase Documentation](https://supabase.com/docs)
- [React Documentation](https://react.dev)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [shadcn/ui Documentation](https://ui.shadcn.com)
