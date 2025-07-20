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
  BriefcaseIcon,
  FileText,
  UserPlus,
  UserMinus,
  Star,
  AlertTriangle
} from 'lucide-react';

type NavItem = {
  title: string;
  href: string;
  icon: React.ElementType;
  roles?: Array<'admin' | 'pimpinan' | 'pegawai'>;
};

const navItems: NavItem[] = [
  {
    title: 'Dasbor',
    href: '/dashboard',
    icon: LayoutDashboard,
    roles: ['admin', 'pimpinan', 'pegawai'],
  },
  {
    title: 'Lamaran',
    href: '/lamaran',
    icon: FileText,
    roles: ['admin', 'pimpinan', 'pegawai'],
  },
  {
    title: 'Rekrutmen',
    href: '/rekrutmen',
    icon: UserPlus,
    roles: ['admin', 'pimpinan'],
  },
  {
    title: 'Data Pegawai',
    href: '/pegawai',
    icon: Users,
    roles: ['admin', 'pimpinan'],
  },
  {
    title: 'Absensi',
    href: '/absensi',
    icon: Calendar,
    roles: ['admin', 'pimpinan', 'pegawai'],
  },
  {
    title: 'Cuti/Izin',
    href: '/cuti',
    icon: FileCheck,
    roles: ['admin', 'pimpinan', 'pegawai'],
  },
  {
    title: 'Mutasi',
    href: '/mutasi',
    icon: FolderSymlink,
    roles: ['admin', 'pimpinan', 'pegawai'],
  },
  {
    title: 'Pengguna',
    href: '/pengguna',
    icon: UserCog,
    roles: ['admin', 'pimpinan'],
  },
  {
    title: 'Reward',
    href: '/reward',
    icon: Star,
    roles: ['admin', 'pimpinan', 'pegawai'],
  },
  {
    title: 'Punishment',
    href: '/punishment',
    icon: AlertTriangle,
    roles: ['admin', 'pimpinan', 'pegawai'],
  },
  {
    title: 'Promosi',
    href: '/promosi',
    icon: UserCheck,
    roles: ['admin', 'pimpinan', 'pegawai'],
  },
  {
    title: 'PHK',
    href: '/phk',
    icon: UserMinus,
    roles: ['admin', 'pimpinan'],
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
            <img 
              src="/logo.png" 
              alt="PT Sungai Budi Group Logo" 
              className="h-8 w-auto"
            />
            <span className="text-lg font-bold">SUNGAI BUDI</span>
          </div>
        ) : (
          <div className="mx-auto">
            <img 
              src="/logo.png" 
              alt="PT Sungai Budi Group Logo" 
              className="h-8 w-auto"
            />
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
