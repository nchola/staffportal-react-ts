import { Helmet } from "react-helmet-async";
import MainLayout from "@/components/layout/MainLayout";

export default function MutasiPage() {
  return (
    <MainLayout>
      <Helmet>
        <title>Mutasi - Zenith Staff Portal</title>
      </Helmet>
      <div className="space-y-4">
        <div>
          <h1 className="text-3xl font-bold tracking-tight">Mutasi</h1>
          <p className="text-muted-foreground">
            Kelola mutasi dan perpindahan karyawan
          </p>
        </div>
        <div className="rounded-lg bg-card p-8 text-center">
          <h3 className="text-xl font-medium mb-2">Modul Mutasi</h3>
          <p className="text-muted-foreground">
            Modul ini sedang dalam pengembangan. Silakan periksa kembali nanti.
          </p>
        </div>
      </div>
    </MainLayout>
  );
} 