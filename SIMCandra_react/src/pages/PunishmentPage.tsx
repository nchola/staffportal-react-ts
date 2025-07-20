import { Helmet } from "react-helmet-async";
import MainLayout from "@/components/layout/MainLayout";

export default function PunishmentPage() {
  return (
    <MainLayout>
      <Helmet>
        <title>Punishment - Zenith Staff Portal</title>
      </Helmet>
      <div className="space-y-4">
        <div>
          <h1 className="text-3xl font-bold tracking-tight">Punishment</h1>
          <p className="text-muted-foreground">
            Kelola sanksi dan hukuman karyawan
          </p>
        </div>
        <div className="rounded-lg bg-card p-8 text-center">
          <h3 className="text-xl font-medium mb-2">Modul Punishment</h3>
          <p className="text-muted-foreground">
            Modul ini sedang dalam pengembangan. Silakan periksa kembali nanti.
          </p>
        </div>
      </div>
    </MainLayout>
  );
} 