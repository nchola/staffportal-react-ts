
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';

type Activity = {
  id: string;
  type: 'leave' | 'attendance' | 'recruitment' | 'promotion' | 'transfer';
  title: string;
  date: string;
  status?: 'pending' | 'approved' | 'rejected' | 'completed';
};

const activities: Activity[] = [
  {
    id: '1',
    type: 'leave',
    title: 'Annual Leave Request by John Smith',
    date: '2025-04-18',
    status: 'pending',
  },
  {
    id: '2',
    type: 'recruitment',
    title: 'New UI/UX Designer position opened',
    date: '2025-04-17',
    status: 'completed',
  },
  {
    id: '3',
    type: 'promotion',
    title: 'Sarah Johnson promoted to Senior Developer',
    date: '2025-04-16',
    status: 'approved',
  },
  {
    id: '4',
    type: 'attendance',
    title: 'Team meeting attendance recorded',
    date: '2025-04-15',
    status: 'completed',
  },
  {
    id: '5',
    type: 'transfer',
    title: 'Mike Chen transferred to Marketing',
    date: '2025-04-14',
    status: 'approved',
  },
];

const getStatusColor = (status?: string) => {
  switch (status) {
    case 'pending':
      return 'bg-yellow-500/20 text-yellow-500 hover:bg-yellow-500/20';
    case 'approved':
      return 'bg-green-500/20 text-green-500 hover:bg-green-500/20';
    case 'rejected':
      return 'bg-red-500/20 text-red-500 hover:bg-red-500/20';
    case 'completed':
      return 'bg-blue-500/20 text-blue-500 hover:bg-blue-500/20';
    default:
      return 'bg-gray-500/20 text-gray-500 hover:bg-gray-500/20';
  }
};

const RecentActivities = () => {
  return (
    <Card className="col-span-full lg:col-span-6">
      <CardHeader>
        <CardTitle>Recent Activities</CardTitle>
      </CardHeader>
      <CardContent>
        <div className="space-y-4">
          {activities.map((activity) => (
            <div
              key={activity.id}
              className="flex items-center justify-between border-b border-border/40 pb-2 last:border-0 last:pb-0"
            >
              <div>
                <p className="font-medium">{activity.title}</p>
                <p className="text-sm text-muted-foreground">
                  {new Date(activity.date).toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric',
                  })}
                </p>
              </div>
              {activity.status && (
                <Badge
                  variant="outline"
                  className={getStatusColor(activity.status)}
                >
                  {activity.status.charAt(0).toUpperCase() + activity.status.slice(1)}
                </Badge>
              )}
            </div>
          ))}
        </div>
      </CardContent>
    </Card>
  );
};

export default RecentActivities;
