
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
    placeholderData: (oldData) => oldData, // Replace keepPreviousData with placeholderData
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
    <div>
      <div className="flex items-center justify-between mb-3 gap-2">
        <div className="flex gap-2">
          <Button size="sm" onClick={() => { setShowForm(true); setEditPegawaiData(null); }}>
            <Plus className="w-4 h-4 mr-1" /> Tambah Pegawai
          </Button>
          <Button size="sm" variant="secondary" onClick={() => refetch()}>
            <RefreshCcw className="w-4 h-4 mr-1" /> Refresh
          </Button>
          <Button size="sm" variant="outline" onClick={handleCetak}>
            <Printer className="w-4 h-4 mr-1" /> Cetak Data
          </Button>
        </div>
        <div className="flex items-center gap-1">
          <span>Sort:</span>
          <Button
            size="icon"
            variant={order==="nama_lengkap.asc" ? "default":"outline"}
            onClick={() => setOrder("nama_lengkap.asc")}
          >
            <ArrowDown className="w-4 h-4" />
          </Button>
          <Button
            size="icon"
            variant={order==="nama_lengkap.desc" ? "default":"outline"}
            onClick={() => setOrder("nama_lengkap.desc")}
          >
            <ArrowUp className="w-4 h-4" />
          </Button>
        </div>
      </div>
      {showForm &&
        <AddEditEmployeeForm
          pegawai={editPegawaiData}
          onClose={() => { setShowForm(false); setEditPegawaiData(null); }}
          onSuccess={() => { setShowForm(false); setEditPegawaiData(null); queryClient.invalidateQueries({ queryKey: ["pegawai"] }); }}
        />
      }
      <div className="rounded-lg border bg-white">
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>NIP</TableHead>
              <TableHead>Nama</TableHead>
              <TableHead>Email</TableHead>
              <TableHead>Tanggal Bergabung</TableHead>
              <TableHead>Aksi</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            {isLoading ? (
              <TableRow>
                <TableCell colSpan={5}>Memuat data...</TableCell>
              </TableRow>
            ) : (data?.data?.length ?
              data.data.map((peg: Pegawai) => (
                <TableRow key={peg.id}>
                  <TableCell>{peg.nip}</TableCell>
                  <TableCell>{peg.nama_lengkap}</TableCell>
                  <TableCell>{peg.email ?? "-"}</TableCell>
                  <TableCell>{peg.tanggal_bergabung}</TableCell>
                  <TableCell>
                    <Button
                      variant="outline"
                      size="sm"
                      onClick={() => { setEditPegawaiData(peg); setShowForm(true); }}
                    >
                      <Edit2 className="w-4 h-4" /> Edit
                    </Button>
                  </TableCell>
                </TableRow>
              ))
              : (
                <TableRow>
                  <TableCell colSpan={5}>Tidak ada data pegawai.</TableCell>
                </TableRow>
              )
            )}
          </TableBody>
        </Table>
        <div className="flex justify-between items-center p-2 border-t">
          <span>Halaman {page} / {lastPage || 1}</span>
          <div className="flex gap-2">
            <Button size="sm" disabled={page === 1} onClick={() => setPage(p=>p-1)}>
              Sebelumnya
            </Button>
            <Button size="sm" disabled={page === lastPage || lastPage === 0} onClick={() => setPage(p=>p+1)}>
              Selanjutnya
            </Button>
          </div>
        </div>
      </div>
      {error && <div className="text-red-500 mt-2">{(error as any).message}</div>}
    </div>
  );
}
