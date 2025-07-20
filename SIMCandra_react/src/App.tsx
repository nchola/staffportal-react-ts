import { Toaster } from "@/components/ui/toaster";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { TooltipProvider } from "@/components/ui/tooltip";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Routes, Route, Navigate } from "react-router-dom";
import { AuthProvider } from "./context/AuthContext";
import { HelmetProvider } from "react-helmet-async";

// Pages
import LoginPage from "./pages/LoginPage";
import DashboardPage from "./pages/DashboardPage";
import LamaranPage from "./pages/LamaranPage";
import RekrutmenPage from "./pages/RekrutmenPage";
import PegawaiPage from "./pages/PegawaiPage";
import AbsensiPage from "./pages/AbsensiPage";
import CutiPage from "./pages/CutiPage";
import MutasiPage from "./pages/MutasiPage";
import PenggunaPage from "./pages/PenggunaPage";
import RewardPage from "./pages/RewardPage";
import PunishmentPage from "./pages/PunishmentPage";
import PromosiPage from "./pages/PromosiPage";
import PHKPage from "./pages/PHKPage";
import NotFound from "./pages/NotFound";

const queryClient = new QueryClient();

const App = () => (
  <HelmetProvider>
    <QueryClientProvider client={queryClient}>
      <AuthProvider>
        <TooltipProvider>
          <Toaster />
          <Sonner />
          <BrowserRouter>
            <Routes>
              <Route path="/login" element={<LoginPage />} />
              <Route path="/" element={<Navigate to="/dashboard" replace />} />
              <Route path="/dashboard" element={<DashboardPage />} />
              <Route path="/lamaran" element={<LamaranPage />} />
              <Route path="/rekrutmen" element={<RekrutmenPage />} />
              <Route path="/pegawai" element={<PegawaiPage />} />
              <Route path="/absensi" element={<AbsensiPage />} />
              <Route path="/cuti" element={<CutiPage />} />
              <Route path="/mutasi" element={<MutasiPage />} />
              <Route path="/pengguna" element={<PenggunaPage />} />
              <Route path="/reward" element={<RewardPage />} />
              <Route path="/punishment" element={<PunishmentPage />} />
              <Route path="/promosi" element={<PromosiPage />} />
              <Route path="/phk" element={<PHKPage />} />
              <Route path="*" element={<NotFound />} />
            </Routes>
          </BrowserRouter>
        </TooltipProvider>
      </AuthProvider>
    </QueryClientProvider>
  </HelmetProvider>
);

export default App;
