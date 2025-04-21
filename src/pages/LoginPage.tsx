
import AuthLayout from '@/components/layout/AuthLayout';
import LoginForm from '@/components/auth/LoginForm';

const LoginPage = () => {
  return (
    <AuthLayout>
      <div className="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
        <div className="flex flex-col space-y-2 text-center">
          <h1 className="text-3xl font-semibold tracking-tight">Zenith HR</h1>
          <p className="text-sm text-muted-foreground">
            Staff Portal Login
          </p>
        </div>
        <LoginForm />
      </div>
    </AuthLayout>
  );
};

export default LoginPage;
