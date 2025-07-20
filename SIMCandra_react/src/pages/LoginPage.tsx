import AuthLayout from '@/components/layout/AuthLayout';
import LoginForm from '@/components/auth/LoginForm';
import { motion } from 'framer-motion';

const LoginPage = () => {
  return (
    <AuthLayout>
      <div className="relative min-h-screen w-full flex flex-col items-center justify-center p-4">
        {/* Background decorative elements */}
        <div className="absolute inset-0 bg-grid-white/[0.02] pointer-events-none" />
        <div className="absolute inset-0 flex items-center justify-center">
          <div className="h-[500px] w-[500px] rounded-full bg-primary/5 blur-3xl pointer-events-none" />
        </div>
        
        {/* Animated circles */}
        <motion.div
          className="absolute top-1/4 left-1/4 h-64 w-64 rounded-full bg-primary/10 blur-3xl"
          animate={{
            scale: [1, 1.2, 1],
            opacity: [0.3, 0.2, 0.3],
          }}
          transition={{
            duration: 4,
            repeat: Infinity,
            ease: "easeInOut"
          }}
        />
        <motion.div
          className="absolute bottom-1/4 right-1/4 h-64 w-64 rounded-full bg-secondary/10 blur-3xl"
          animate={{
            scale: [1.2, 1, 1.2],
            opacity: [0.2, 0.3, 0.2],
          }}
          transition={{
            duration: 4,
            repeat: Infinity,
            ease: "easeInOut"
          }}
        />
        
        {/* Content */}
        <div className="relative w-full max-w-md space-y-8">
          {/* Logo */}
          <motion.div 
            className="flex flex-col items-center space-y-4"
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5 }}
          >
            <div className="w-32 h-32 relative">
              <img
                src="/logo.png"
                alt="Sungai Budi Group Logo"
                className="w-full h-full object-contain"
              />
            </div>
            <div className="text-center space-y-2">
              <h1 className="text-2xl font-bold tracking-tight text-foreground">
                PT Sungai Budi Group
              </h1>
              <p className="text-sm text-muted-foreground">
                Portal Staf - Sistem Manajemen SDM
              </p>
            </div>
          </motion.div>
          
          {/* Login Form with animation */}
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5, delay: 0.2 }}
          >
            <LoginForm />
          </motion.div>
          
          <motion.footer
            className="text-center text-xs text-muted-foreground"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 0.5, delay: 0.4 }}
          >
            &copy; {new Date().getFullYear()} PT Sungai Budi Group. All rights reserved.
          </motion.footer>
        </div>
      </div>
    </AuthLayout>
  );
};

export default LoginPage;
