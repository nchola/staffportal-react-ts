import { useState } from 'react';
import { useAuth } from '@/context/AuthContext';
import { Button } from '@/components/ui/button';
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Eye, EyeOff, LogIn } from 'lucide-react';
import { cn } from '@/lib/utils';

const LoginForm = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  const [showPassword, setShowPassword] = useState(false);
  const { login } = useAuth();

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsLoading(true);
    try {
      await login(email, password);
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <Card className="w-full max-w-md border-border/10 bg-card/95 backdrop-blur-lg shadow-2xl relative overflow-hidden">
      {/* Decorative elements for tech feel */}
      <div className="absolute inset-0 bg-gradient-to-br from-primary/5 to-secondary/5 pointer-events-none" />
      <div className="absolute inset-0 bg-grid-white/[0.02] pointer-events-none" 
           style={{ backgroundSize: '32px 32px' }} />
      
      <div className="relative">
        <CardHeader className="space-y-1 pb-6">
          <CardTitle className="text-2xl font-bold text-foreground">
            Masuk ke Portal
          </CardTitle>
          <CardDescription className="text-muted-foreground">
            Silakan masukkan kredensial Anda untuk mengakses sistem
          </CardDescription>
        </CardHeader>

        <form onSubmit={handleSubmit}>
          <CardContent className="space-y-4">
            {/* Email Field */}
            <div className="space-y-2">
              <Label 
                htmlFor="email" 
                className="text-sm font-medium text-foreground/90"
              >
                Email
              </Label>
              <div className="relative">
                <Input
                  id="email"
                  type="email"
                  placeholder="nama@perusahaan.com"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  required
                  className={cn(
                    "h-10 bg-muted/50 border-border/10",
                    "focus:border-primary/50 focus:ring-1 focus:ring-primary/50",
                    "placeholder:text-muted-foreground/50",
                    "transition-all duration-200"
                  )}
                />
                <div className="absolute inset-0 rounded-md border border-primary/10 pointer-events-none" />
              </div>
            </div>

            {/* Password Field */}
            <div className="space-y-2">
              <Label 
                htmlFor="password"
                className="text-sm font-medium text-foreground/90"
              >
                Kata Sandi
              </Label>
              <div className="relative">
                <Input
                  id="password"
                  type={showPassword ? 'text' : 'password'}
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  required
                  className={cn(
                    "h-10 bg-muted/50 border-border/10",
                    "focus:border-primary/50 focus:ring-1 focus:ring-primary/50",
                    "placeholder:text-muted-foreground/50",
                    "transition-all duration-200"
                  )}
                />
                <Button
                  type="button"
                  variant="ghost"
                  size="sm"
                  className={cn(
                    "absolute right-0 top-0 h-full px-3 py-2",
                    "hover:bg-transparent text-muted-foreground",
                    "hover:text-foreground transition-colors"
                  )}
                  onClick={() => setShowPassword(!showPassword)}
                >
                  {showPassword ? (
                    <EyeOff className="h-4 w-4" />
                  ) : (
                    <Eye className="h-4 w-4" />
                  )}
                </Button>
                <div className="absolute inset-0 rounded-md border border-primary/10 pointer-events-none" />
              </div>
            </div>
          </CardContent>

          <CardFooter className="flex flex-col gap-4 pt-2">
            <Button 
              type="submit" 
              className={cn(
                "w-full h-11 bg-primary",
                "hover:bg-primary/90 transition-colors",
                "font-medium tracking-wide",
                "flex items-center justify-center gap-2"
              )}
              disabled={isLoading}
            >
              {isLoading ? (
                <>
                  <div className="h-4 w-4 border-2 border-white/30 border-t-white rounded-full animate-spin" />
                  <span>Memproses...</span>
                </>
              ) : (
                <>
                  <LogIn className="h-4 w-4" />
                  <span>Masuk</span>
                </>
              )}
            </Button>

            {/* Demo Account Section */}
            <div className="w-full rounded-lg bg-muted/30 p-4 border border-border/10">
              <div className="space-y-3">
                <div className="flex items-center justify-between">
                  <span className="text-sm font-medium text-foreground">
                    Akun Demo
                  </span>
                  <span className="text-xs text-muted-foreground">
                    Untuk keperluan testing
                  </span>
                </div>
                <div className="space-y-2 text-sm">
                  <DemoAccount
                    role="Admin"
                    email="admin@zenith.com"
                    password="admin123"
                  />
                  <DemoAccount
                    role="Pimpinan"
                    email="pimpinan@zenith.com"
                    password="pimpinan123"
                  />
                  <DemoAccount
                    role="Pegawai"
                    email="pegawai@zenith.com"
                    password="pegawai123"
                  />
                </div>
              </div>
            </div>
          </CardFooter>
        </form>
      </div>
    </Card>
  );
};

// Separate component for demo accounts
const DemoAccount = ({ role, email, password }: { 
  role: string;
  email: string;
  password: string;
}) => (
  <div className="flex items-center justify-between p-2 rounded bg-background/50 border border-border/5">
    <div className="flex items-center gap-2">
      <div className="h-2 w-2 rounded-full bg-primary/50" />
      <span className="font-medium">{role}</span>
    </div>
    <div className="text-xs text-muted-foreground">
      {email} / {password}
    </div>
  </div>
);

export default LoginForm;
