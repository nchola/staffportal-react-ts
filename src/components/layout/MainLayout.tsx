import { ReactNode, useEffect } from 'react';
import { Navigate } from 'react-router-dom';
import { useAuth } from '@/context/AuthContext';
import Sidebar from './Sidebar';
import TopBar from './TopBar';
import { AnimatePresence } from 'framer-motion';
import { PageTransition } from '@/components/ui/page-transition';

interface MainLayoutProps {
  children: ReactNode;
}

const MainLayout = ({ children }: MainLayoutProps) => {
  const { user, loading } = useAuth();

  useEffect(() => {
    document.title = 'PT. Sungai Budi Group';
  }, []);

  // Show loading state
  if (loading) {
    return (
      <div className="flex min-h-screen items-center justify-center">
        <PageTransition>
          <div className="flex flex-col items-center space-y-2">
            <div className="h-8 w-8 rounded-full border-4 border-t-primary border-r-transparent border-b-primary border-l-transparent animate-spin-slow"></div>
            <p className="text-sm text-muted-foreground">Memuat...</p>
          </div>
        </PageTransition>
      </div>
    );
  }

  // Redirect to login if not authenticated
  if (!user) {
    return <Navigate to="/login" replace />;
  }

  return (
    <div className="flex h-screen overflow-hidden bg-background">
      <Sidebar />
      <div className="flex flex-1 flex-col overflow-hidden">
        <TopBar />
        <AnimatePresence mode="wait">
          <main className="flex-1 overflow-auto p-4 lg:p-6">
            <PageTransition>
              {children}
            </PageTransition>
          </main>
        </AnimatePresence>
      </div>
    </div>
  );
};

export default MainLayout;
