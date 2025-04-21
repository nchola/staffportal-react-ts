
import MainLayout from '@/components/layout/MainLayout';

const LeavePage = () => {
  return (
    <MainLayout>
      <div className="space-y-4">
        <h2 className="text-3xl font-bold">Leave Management</h2>
        <p className="text-muted-foreground">
          Manage employee leave requests and approvals.
        </p>
        
        <div className="rounded-lg bg-card p-8 text-center">
          <h3 className="text-xl font-medium mb-2">Leave Module</h3>
          <p className="text-muted-foreground">
            This module is being developed. Check back soon for updates.
          </p>
        </div>
      </div>
    </MainLayout>
  );
};

export default LeavePage;
