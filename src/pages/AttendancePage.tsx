import MainLayout from '@/components/layout/MainLayout';

const AttendancePage = () => {
  return (
    <MainLayout>
      <div className="space-y-4">
        <h2 className="text-3xl font-bold">Manajemen Absensi</h2>
        <p className="text-muted-foreground">
          Pantau dan kelola catatan kehadiran pegawai.
        </p>
        
        <div className="rounded-lg bg-card p-8 text-center">
          <h3 className="text-xl font-medium mb-2">Modul Absensi</h3>
          <p className="text-muted-foreground">
            Modul ini sedang dalam pengembangan. Silakan periksa kembali nanti.
          </p>
        </div>
      </div>
    </MainLayout>
  );
};

export default AttendancePage;
