import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import {
  getPegawaiList,
  addPegawai,
  editPegawai,
  printPegawai,
} from "@/integrations/pegawaiApi";
import { Button } from "@/components/ui/button";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { ArrowDown, ArrowUp, Plus, Printer, RefreshCcw, Edit2 } from "lucide-react";
import { useState } from "react";
import AddEditEmployeeForm from "./AddEditEmployeeForm";
import { toast } from "@/hooks/use-toast";

type Pegawai = {
  id: string;
  nip: string;
  nama_lengkap: string;
  email?: string;
  tanggal_bergabung: string;
  departemen_id?: string;
  jabatan_id?: string;
};

export default function EmployeesTable() {
  const [page, setPage] = useState(1);
  const [order, setOrder] = useState<"nama_lengkap.asc"|"nama_lengkap.desc">("nama_lengkap.asc");
  const [showForm, setShowForm] = useState(false);
  const [editPegawaiData, setEditPegawaiData] = useState<Pegawai|null>(null);
  const queryClient = useQueryClient();

  const { data, isLoading, refetch, error } = useQuery({
    queryKey: ["pegawai", page, order],
    queryFn: () => getPegawaiList({ page, limit: 15, order }),
    placeholderData: (oldData) => oldData, // Keep placeholderData for smooth transitions
  });

  const total = data?.total ?? 0;
  const lastPage = Math.ceil(total/15);

  const handleCetak = async () => {
    try {
      const dataCetak = await printPegawai();
      // Export ke CSV sederhana (improvisasi performa)
      const header = ["NIP","Nama Lengkap","Email","Tanggal Bergabung"];
      const csvRows = [header.join(","), ...dataCetak.map(
        (p: Pegawai) => [p.nip, p.nama_lengkap, p.email||"", p.tanggal_bergabung].map(f=>`"${f??""}"`).join(",")
      )].join("\n");
      const blob = new Blob([csvRows], { type: "text/csv" });
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = "data-pegawai.csv";
      a.click();
      toast({ title: "Berhasil mencetak", description: "Data pegawai siap diunduh (CSV)" });
    } catch (e) {
      toast({ title: "Gagal mencetak", description: (e as any).message, variant: "destructive" });
    }
  };

  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between mb-3 gap-2">
        <div className="flex gap-2">
          <Button 
            size="sm" 
            className="bg-primary hover:bg-primary/90"
            onClick={() => { setShowForm(true); setEditPegawaiData(null); }}
          >
            <Plus className="w-4 h-4 mr-1" /> Tambah Pegawai
          </Button>
          <Button 
            size="sm" 
            variant="secondary" 
            className="bg-secondary hover:bg-secondary/90"
            onClick={() => refetch()}
          >
            <RefreshCcw className="w-4 h-4 mr-1" /> Refresh
          </Button>
          <Button 
            size="sm" 
            variant="outline" 
            className="border-border/10 hover:bg-muted/50"
            onClick={handleCetak}
          >
            <Printer className="w-4 h-4 mr-1" /> Cetak Data
          </Button>
        </div>
        <div className="flex items-center gap-2">
          <span className="text-sm text-muted-foreground">Sort:</span>
          <Button
            size="icon"
            variant={order==="nama_lengkap.asc" ? "default":"outline"}
            className={order==="nama_lengkap.asc" ? "bg-primary" : "border-border/10 hover:bg-muted/50"}
          >
            <ArrowDown className="w-4 h-4" />
          </Button>
          <Button
            size="icon"
            variant={order==="nama_lengkap.desc" ? "default":"outline"}
            className={order==="nama_lengkap.desc" ? "bg-primary" : "border-border/10 hover:bg-muted/50"}
          >
            <ArrowUp className="w-4 h-4" />
          </Button>
        </div>
      </div>

      <div className="rounded-lg border border-border/10 bg-card/30 backdrop-blur-sm overflow-hidden">
        <Table>
          <TableHeader>
            <TableRow className="hover:bg-muted/30">
              <TableHead className="font-semibold text-foreground">NIP</TableHead>
              <TableHead className="font-semibold text-foreground">Nama</TableHead>
              <TableHead className="font-semibold text-foreground">Email</TableHead>
              <TableHead className="font-semibold text-foreground">Tanggal Bergabung</TableHead>
              <TableHead className="font-semibold text-foreground">Aksi</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            {isLoading ? (
              <TableRow>
                <TableCell colSpan={5} className="text-center text-muted-foreground">
                  Memuat data...
                </TableCell>
              </TableRow>
            ) : (data?.data?.length ?
              data.data.map((peg: Pegawai) => (
                <TableRow 
                  key={peg.id}
                  className="hover:bg-muted/20 transition-colors"
                >
                  <TableCell className="text-foreground/90">{peg.nip}</TableCell>
                  <TableCell className="text-foreground/90">{peg.nama_lengkap}</TableCell>
                  <TableCell className="text-foreground/90">{peg.email ?? "-"}</TableCell>
                  <TableCell className="text-foreground/90">{peg.tanggal_bergabung}</TableCell>
                  <TableCell>
                    <Button
                      variant="outline"
                      size="sm"
                      className="border-border/10 hover:bg-muted/50"
                      onClick={() => { setEditPegawaiData(peg); setShowForm(true); }}
                    >
                      <Edit2 className="w-4 h-4 mr-1" /> Edit
                    </Button>
                  </TableCell>
                </TableRow>
              ))
              : (
                <TableRow>
                  <TableCell colSpan={5} className="text-center text-muted-foreground">
                    Tidak ada data pegawai.
                  </TableCell>
                </TableRow>
              )
            )}
          </TableBody>
        </Table>
      </div>

      <div className="flex items-center justify-between px-2">
        <span className="text-sm text-muted-foreground">
          Halaman {page} / {lastPage || 1}
        </span>
        <div className="flex gap-2">
          <Button 
            size="sm" 
            variant="outline"
            className="border-border/10 hover:bg-muted/50"
            disabled={page === 1} 
            onClick={() => setPage(p=>p-1)}
          >
            Sebelumnya
          </Button>
          <Button 
            size="sm"
            variant="outline" 
            className="border-border/10 hover:bg-muted/50"
            disabled={page === lastPage || lastPage === 0} 
            onClick={() => setPage(p=>p+1)}
          >
            Selanjutnya
          </Button>
        </div>
      </div>

      {showForm && (
        <div className="fixed inset-0 bg-background/80 backdrop-blur-sm z-50 flex items-center justify-center">
          <div className="bg-card rounded-lg border border-border/10 shadow-lg w-full max-w-md p-6">
            <h3 className="text-xl font-semibold mb-4 text-foreground">
              {editPegawaiData ? 'Edit Pegawai' : 'Tambah Pegawai'}
            </h3>
            <form className="space-y-4">
              <div className="space-y-2">
                <label className="text-sm font-medium text-foreground">
                  NIP <span className="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  className="w-full rounded-md border border-border/10 bg-muted/50 px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50"
                  placeholder="Masukkan NIP"
                  required
                />
              </div>
              <div className="space-y-2">
                <label className="text-sm font-medium text-foreground">
                  Nama Lengkap <span className="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  className="w-full rounded-md border border-border/10 bg-muted/50 px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50"
                  placeholder="Masukkan nama lengkap"
                  required
                />
              </div>
              <div className="space-y-2">
                <label className="text-sm font-medium text-foreground">
                  Email
                </label>
                <input
                  type="email"
                  className="w-full rounded-md border border-border/10 bg-muted/50 px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50"
                  placeholder="Masukkan email"
                />
              </div>
              <div className="space-y-2">
                <label className="text-sm font-medium text-foreground">
                  Tanggal Bergabung <span className="text-red-500">*</span>
                </label>
                <input
                  type="date"
                  className="w-full rounded-md border border-border/10 bg-muted/50 px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50"
                  required
                />
              </div>
              <div className="flex justify-end gap-2 mt-6">
                <Button
                  type="button"
                  variant="outline"
                  className="border-border/10 hover:bg-muted/50"
                  onClick={() => { setShowForm(false); setEditPegawaiData(null); }}
                >
                  Batal
                </Button>
                <Button
                  type="submit"
                  className="bg-primary hover:bg-primary/90"
                >
                  {editPegawaiData ? 'Simpan Perubahan' : 'Tambah'}
                </Button>
              </div>
            </form>
          </div>
        </div>
      )}

      {error && (
        <div className="text-destructive mt-2">
          {(error as any).message}
        </div>
      )}
    </div>
  );
}
