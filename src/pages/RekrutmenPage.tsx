import { Helmet } from "react-helmet-async";
import MainLayout from "@/components/layout/MainLayout";

export default function RekrutmenPage() {
  return (
    <MainLayout>
      <Helmet>
        <title>Rekrutmen - Zenith Staff Portal</title>
      </Helmet>
      <div className="space-y-4">
        <div>
          <h1 className="text-3xl font-bold tracking-tight">Rekrutmen</h1>
          <p className="text-muted-foreground">
            Kelola proses rekrutmen karyawan baru
          </p>
        </div>
        {/* RekrutmenTable component will be added here */}
      </div>
    </MainLayout>
  );
} 