
import { useState } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { cn } from '@/lib/utils';
import { Button } from '@/components/ui/button';
import { useAuth } from '@/context/AuthContext';
import { 
  ArrowLeft, 
  ArrowRight, 
  LayoutDashboard, 
  Users, 
  Calendar, 
  FileCheck, 
  Award, 
  UserCheck, 
  FolderSymlink, 
  UserCog, 
  BriefcaseIcon
} from 'lucide-react';

type NavItem = {
  title: string;
  href: string;
  icon: React.ElementType;
  roles?: Array<'admin' | 'manager' | 'employee'>;
};

const navItems: NavItem[] = [
  {
    title: 'Dashboard',
    href: '/dashboard',
    icon: LayoutDashboard,
    roles: ['admin', 'manager', 'employee'],
  },
  {
    title: 'Recruitment',
    href: '/recruitment',
    icon: BriefcaseIcon,
    roles: ['admin', 'manager'],
  },
  {
    title: 'Employee Data',
    href: '/employees',
    icon: Users,
    roles: ['admin', 'manager', 'employee'],
  },
  {
    title: 'Attendance',
    href: '/attendance',
    icon: Calendar,
    roles: ['admin', 'manager', 'employee'],
  },
  {
    title: 'Leave Management',
    href: '/leave',
    icon: FileCheck,
    roles: ['admin', 'manager', 'employee'],
  },
  {
    title: 'Performance',
    href: '/performance',
    icon: Award,
    roles: ['admin', 'manager', 'employee'],
  },
  {
    title: 'Promotions',
    href: '/promotions',
    icon: UserCheck,
    roles: ['admin', 'manager'],
  },
  {
    title: 'Transfers',
    href: '/transfers',
    icon: FolderSymlink,
    roles: ['admin', 'manager'],
  },
  {
    title: 'User Management',
    href: '/users',
    icon: UserCog,
    roles: ['admin'],
  },
];

const Sidebar = () => {
  const [expanded, setExpanded] = useState(true);
  const { user } = useAuth();
  const location = useLocation();

  // Filter nav items based on user role
  const filteredNavItems = navItems.filter(
    (item) => !item.roles || (user && item.roles.includes(user.role))
  );

  return (
    <div
      className={cn(
        'flex flex-col border-r border-border/40 bg-card transition-all duration-300',
        expanded ? 'w-64' : 'w-20'
      )}
    >
      <div className={cn('flex h-16 items-center border-b border-border/40 px-4')}>
        {expanded ? (
          <div className="flex items-center space-x-2">
            <div className="h-8 w-8 rounded-full bg-primary flex items-center justify-center">
              <span className="font-bold text-white">Z</span>
            </div>
            <span className="text-xl font-semibold">Zenith HR</span>
          </div>
        ) : (
          <div className="mx-auto h-8 w-8 rounded-full bg-primary flex items-center justify-center">
            <span className="font-bold text-white">Z</span>
          </div>
        )}
      </div>
      
      <div className="flex-1 overflow-auto scrollbar-hide">
        <nav className="space-y-1 px-2 py-4">
          {filteredNavItems.map((item) => (
            <Link
              key={item.href}
              to={item.href}
              className={cn(
                'group flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors',
                location.pathname === item.href
                  ? 'bg-primary text-primary-foreground'
                  : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground'
              )}
            >
              <item.icon className={cn('h-5 w-5', expanded ? 'mr-2' : 'mx-auto')} />
              {expanded && <span>{item.title}</span>}
            </Link>
          ))}
        </nav>
      </div>

      <div className="border-t border-border/40 p-2">
        <Button
          variant="ghost"
          size="icon"
          className="w-full h-10 justify-center"
          onClick={() => setExpanded(!expanded)}
        >
          {expanded ? (
            <ArrowLeft className="h-5 w-5" />
          ) : (
            <ArrowRight className="h-5 w-5" />
          )}
        </Button>
      </div>
    </div>
  );
};

export default Sidebar;
