
import MainLayout from '@/components/layout/MainLayout';

const PromotionsPage = () => {
  return (
    <MainLayout>
      <div className="space-y-4">
        <h2 className="text-3xl font-bold">Promotions Management</h2>
        <p className="text-muted-foreground">
          Manage employee promotions and career development.
        </p>
        
        <div className="rounded-lg bg-card p-8 text-center">
          <h3 className="text-xl font-medium mb-2">Promotions Module</h3>
          <p className="text-muted-foreground">
            This module is being developed. Check back soon for updates.
          </p>
        </div>
      </div>
    </MainLayout>
  );
};

export default PromotionsPage;
