
import MainLayout from '@/components/layout/MainLayout';

const AttendancePage = () => {
  return (
    <MainLayout>
      <div className="space-y-4">
        <h2 className="text-3xl font-bold">Attendance Management</h2>
        <p className="text-muted-foreground">
          Track and manage employee attendance records.
        </p>
        
        <div className="rounded-lg bg-card p-8 text-center">
          <h3 className="text-xl font-medium mb-2">Attendance Module</h3>
          <p className="text-muted-foreground">
            This module is being developed. Check back soon for updates.
          </p>
        </div>
      </div>
    </MainLayout>
  );
};

export default AttendancePage;
