import AuthLayout from '@/components/layout/AuthLayout';
import LoginForm from '@/components/auth/LoginForm';

const LoginPage = () => {
  return (
    <AuthLayout>
      <div className="relative min-h-screen w-full flex flex-col items-center justify-center p-4">
        {/* Background decorative elements */}
        <div className="absolute inset-0 bg-grid-white/[0.02] pointer-events-none" />
        <div className="absolute inset-0 flex items-center justify-center">
          <div className="h-[500px] w-[500px] rounded-full bg-primary/5 blur-3xl pointer-events-none" />
        </div>
        
        {/* Content */}
        <div className="relative w-full max-w-md space-y-6">
          <div className="flex flex-col space-y-2 text-center">
            <h1 className="text-3xl font-bold tracking-tight text-foreground">
              PT Sungai Budi Group
            </h1>
            <p className="text-sm text-muted-foreground">
              Portal Staf - Sistem Manajemen SDM
            </p>
          </div>
          
          <LoginForm />
          
          <footer className="text-center text-xs text-muted-foreground">
            &copy; {new Date().getFullYear()} PT Sungai Budi Group. All rights reserved.
          </footer>
        </div>
      </div>
    </AuthLayout>
  );
};

export default LoginPage;
