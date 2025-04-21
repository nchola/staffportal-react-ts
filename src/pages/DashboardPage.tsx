
import { useEffect } from 'react';
import MainLayout from '@/components/layout/MainLayout';
import { useAuth } from '@/context/AuthContext';
import StatCard from '@/components/dashboard/StatCard';
import RecentActivities from '@/components/dashboard/RecentActivities';
import UpcomingEvents from '@/components/dashboard/UpcomingEvents';
import { Users, Calendar, FileCheck, Award, BriefcaseIcon } from 'lucide-react';

const DashboardPage = () => {
  const { user } = useAuth();

  useEffect(() => {
    document.title = 'Dashboard | Zenith HR';
  }, []);

  const greeting = () => {
    const hour = new Date().getHours();
    if (hour < 12) return 'Good morning';
    if (hour < 18) return 'Good afternoon';
    return 'Good evening';
  };

  return (
    <MainLayout>
      <div className="space-y-6">
        <div>
          <h2 className="text-3xl font-bold">
            {greeting()}, {user?.name.split(' ')[0]}
          </h2>
          <p className="text-muted-foreground">
            Here's an overview of what's happening today.
          </p>
        </div>
        
        <div className="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
          <StatCard
            title="Total Employees"
            value="284"
            icon={<Users className="h-4 w-4" />}
            description="+12 from last month"
          />
          <StatCard
            title="Open Positions"
            value="8"
            icon={<BriefcaseIcon className="h-4 w-4" />}
            description="4 in interview phase"
          />
          <StatCard
            title="Attendance Today"
            value="97%"
            icon={<Calendar className="h-4 w-4" />}
            description="8 employees on leave"
          />
          <StatCard
            title="Pending Requests"
            value="12"
            icon={<FileCheck className="h-4 w-4" />}
            description="5 new since yesterday"
          />
        </div>

        <div className="grid grid-cols-12 gap-4">
          <RecentActivities />
          <UpcomingEvents />
        </div>
      </div>
    </MainLayout>
  );
};

export default DashboardPage;
