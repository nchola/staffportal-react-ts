import MainLayout from '@/components/layout/MainLayout';

const LeavePage = () => {
  return (
    <MainLayout>
      <div className="space-y-4">
        <h2 className="text-3xl font-bold">Manajemen Cuti</h2>
        <p className="text-muted-foreground">
          Kelola permintaan dan persetujuan cuti pegawai.
        </p>
        
        <div className="rounded-lg bg-card p-8 text-center">
          <h3 className="text-xl font-medium mb-2">Modul Cuti</h3>
          <p className="text-muted-foreground">
            Modul ini sedang dalam pengembangan. Silakan periksa kembali nanti.
          </p>
        </div>
      </div>
    </MainLayout>
  );
};

export default LeavePage;
