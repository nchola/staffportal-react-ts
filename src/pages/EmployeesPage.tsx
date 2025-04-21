
import MainLayout from '@/components/layout/MainLayout';
import EmployeesTable from '@/components/pegawai/EmployeesTable';

const EmployeesPage = () => {
  return (
    <MainLayout>
      <div className="space-y-4">
        <h2 className="text-3xl font-bold">Data Pegawai PT SUNGAI BUDI GROUP</h2>
        <p className="text-muted-foreground">
          Kelola data pegawai dengan fitur tambah, edit, pencarian, dan cetak untuk keperluan manajemen SDM PT Sungai Budi Group.
        </p>
        <EmployeesTable />
      </div>
    </MainLayout>
  );
};

export default EmployeesPage;
