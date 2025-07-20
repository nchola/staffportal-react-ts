import { Helmet } from "react-helmet-async";
import LeaveTable from "@/components/leave/LeaveTable";
import MainLayout from "@/components/layout/MainLayout";

export default function LeavePage() {
  return (
    <MainLayout>
      <Helmet>
        <title>Manajemen Cuti | Zenith Staff Portal</title>
      </Helmet>

      <div className="flex flex-col gap-6">
        <div>
          <h1 className="text-3xl font-bold tracking-tight">Manajemen Cuti</h1>
          <p className="text-muted-foreground">
            Kelola pengajuan cuti pegawai
          </p>
        </div>

        <LeaveTable />
      </div>
    </MainLayout>
  );
}
