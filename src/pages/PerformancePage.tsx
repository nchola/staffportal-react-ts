import MainLayout from '@/components/layout/MainLayout';

const PerformancePage = () => {
  return (
    <MainLayout>
      <div className="space-y-4">
        <h2 className="text-3xl font-bold">Manajemen Kinerja</h2>
        <p className="text-muted-foreground">
          Pantau kinerja pegawai, penghargaan, dan tindakan kedisiplinan.
        </p>
        
        <div className="rounded-lg bg-card p-8 text-center">
          <h3 className="text-xl font-medium mb-2">Modul Kinerja</h3>
          <p className="text-muted-foreground">
            Modul ini sedang dalam pengembangan. Silakan periksa kembali nanti.
          </p>
        </div>
      </div>
    </MainLayout>
  );
};

export default PerformancePage;
