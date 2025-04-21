
import { ReactNode } from 'react';
import { Navigate } from 'react-router-dom';
import { useAuth } from '@/context/AuthContext';

interface AuthLayoutProps {
  children: ReactNode;
}

const AuthLayout = ({ children }: AuthLayoutProps) => {
  const { user, loading } = useAuth();

  // Loading
  if (loading) {
    return (
      <div className="flex min-h-screen items-center justify-center">
        <div className="h-8 w-8 rounded-full border-4 border-t-primary animate-spin-slow"></div>
      </div>
    );
  }

  // Redirect jika sudah login
  if (user) {
    return <Navigate to="/dashboard" replace />;
  }

  return (
    <div className="flex min-h-screen flex-col bg-muted/40 relative">
      {/* Background Gambar */}
      <div
        className="absolute inset-0 bg-cover bg-center"
        style={{ backgroundImage: "url('/landing-bg.jpg')" }}
      >
        <div className="absolute inset-0 bg-black/60" />
      </div>
      <div className="flex flex-1 items-center justify-center p-4 relative z-10">
        {children}
      </div>
      <footer className="py-6 text-center text-sm text-muted-foreground relative z-10">
        <p>© {new Date().getFullYear()} PT Sungai Budi Group. Hak Cipta Dilindungi.</p>
      </footer>
    </div>
  );
};

export default AuthLayout;
