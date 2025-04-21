
import MainLayout from '@/components/layout/MainLayout';

const RecruitmentPage = () => {
  return (
    <MainLayout>
      <div className="space-y-4">
        <h2 className="text-3xl font-bold">Recruitment Management</h2>
        <p className="text-muted-foreground">
          Manage job openings, applications, and hiring processes.
        </p>
        
        <div className="rounded-lg bg-card p-8 text-center">
          <h3 className="text-xl font-medium mb-2">Recruitment Module</h3>
          <p className="text-muted-foreground">
            This module is being developed. Check back soon for updates.
          </p>
        </div>
      </div>
    </MainLayout>
  );
};

export default RecruitmentPage;
