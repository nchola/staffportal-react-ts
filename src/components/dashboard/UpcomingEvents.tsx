
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { CalendarCheck, Users, ArrowRight } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';

type Event = {
  id: string;
  title: string;
  date: string;
  type: 'meeting' | 'holiday' | 'deadline' | 'birthday';
};

const events: Event[] = [
  {
    id: '1',
    title: 'Department Meeting',
    date: '2025-04-23T10:00:00',
    type: 'meeting',
  },
  {
    id: '2',
    title: 'Employee Benefit Enrollment Deadline',
    date: '2025-04-25T23:59:59',
    type: 'deadline',
  },
  {
    id: '3',
    title: 'Public Holiday - Memorial Day',
    date: '2025-05-26T00:00:00',
    type: 'holiday',
  },
  {
    id: '4',
    title: 'Performance Review Meeting',
    date: '2025-04-29T14:00:00',
    type: 'meeting',
  },
  {
    id: '5',
    title: 'David\'s Birthday',
    date: '2025-04-30T00:00:00',
    type: 'birthday',
  },
];

const getEventIcon = (type: Event['type']) => {
  switch (type) {
    case 'meeting':
      return <Users className="h-4 w-4" />;
    default:
      return <CalendarCheck className="h-4 w-4" />;
  }
};

const UpcomingEvents = () => {
  return (
    <Card className="col-span-full lg:col-span-6">
      <CardHeader className="flex flex-row items-center justify-between">
        <CardTitle>Upcoming Events</CardTitle>
        <Button variant="ghost" size="sm" className="text-xs flex items-center gap-1">
          View Calendar <ArrowRight className="h-3 w-3" />
        </Button>
      </CardHeader>
      <CardContent>
        <div className="space-y-1">
          {events.map((event) => {
            const eventDate = new Date(event.date);
            return (
              <div key={event.id}>
                <div className="flex items-start justify-between py-2">
                  <div className="flex items-start gap-2">
                    <div className="mt-0.5 rounded bg-primary/10 p-1.5 text-primary">
                      {getEventIcon(event.type)}
                    </div>
                    <div>
                      <p className="font-medium">{event.title}</p>
                      <p className="text-xs text-muted-foreground">
                        {eventDate.toLocaleDateString('en-US', {
                          month: 'short',
                          day: 'numeric',
                          year: 'numeric',
                        })}{' '}
                        •{' '}
                        {eventDate.toLocaleTimeString('en-US', {
                          hour: 'numeric',
                          minute: '2-digit',
                          hour12: true,
                        })}
                      </p>
                    </div>
                  </div>
                </div>
                <Separator className="mt-1.5" />
              </div>
            );
          })}
        </div>
      </CardContent>
    </Card>
  );
};

export default UpcomingEvents;
