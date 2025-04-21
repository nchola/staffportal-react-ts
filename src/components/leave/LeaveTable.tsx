import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
} from "@/components/ui/alert-dialog";
import { useToast } from "@/hooks/use-toast";
import { getLeaveList, deleteLeave, updateLeaveStatus, type Leave } from "@/integrations/leaveApi";
import { format } from "date-fns";
import { id } from "date-fns/locale";
import AddEditLeaveForm from "./AddEditLeaveForm";
import { Badge } from "@/components/ui/badge";
import { useAuth } from "@/context/AuthContext";

export default function LeaveTable() {
  const { toast } = useToast();
  const queryClient = useQueryClient();
  const [page, setPage] = useState(1);
  const [search, setSearch] = useState("");
  const [showForm, setShowForm] = useState(false);
  const [editLeaveData, setEditLeaveData] = useState<Leave | null>(null);
  const [deleteId, setDeleteId] = useState<string | null>(null);
  const { user } = useAuth();

  const { data: leaveList, isLoading } = useQuery({
    queryKey: ["leave-list", page, search],
    queryFn: () => getLeaveList(page, 10, search),
  });

  const updateStatusMutation = useMutation({
    mutationFn: async ({ id, status }: { id: string; status: Leave["status"] }) => {
      if (!user?.id) {
        throw new Error("Anda harus login untuk melakukan verifikasi");
      }
      if (user.role !== 'pimpinan') {
        throw new Error("Hanya pimpinan yang dapat memverifikasi pengajuan cuti");
      }
      return updateLeaveStatus(
        id, 
        status, 
        user.id, 
        status === 'Ditolak' ? 'Pengajuan cuti ditolak' : status === 'Disetujui' ? 'Pengajuan cuti disetujui' : undefined
      );
    },
    onSuccess: (data) => {
      toast({
        title: "Berhasil mengubah status cuti",
        description: `Status cuti telah diubah menjadi ${data.status.toLowerCase()}`,
        variant: "default",
      });
      queryClient.invalidateQueries({ queryKey: ["leave-list"] });
    },
    onError: (error) => {
      toast({
        title: "Gagal mengubah status cuti",
        description: error instanceof Error ? error.message : "Terjadi kesalahan saat memverifikasi cuti",
        variant: "destructive",
      });
    },
  });

  const deleteMutation = useMutation({
    mutationFn: deleteLeave,
    onSuccess: () => {
      toast({
        title: "Berhasil menghapus data cuti",
        variant: "default",
      });
      queryClient.invalidateQueries({ queryKey: ["leave-list"] });
      setDeleteId(null);
    },
    onError: (error) => {
      toast({
        title: "Gagal menghapus data cuti",
        description: error instanceof Error ? error.message : "Terjadi kesalahan",
        variant: "destructive",
      });
    },
  });

  const handleSearch = (value: string) => {
    setSearch(value);
    setPage(1);
  };

  const getStatusColor = (status: Leave["status"]) => {
    switch (status) {
      case "Diajukan":
        return "bg-yellow-500/10 text-yellow-500 hover:bg-yellow-500/20";
      case "Disetujui":
        return "bg-green-500/10 text-green-500 hover:bg-green-500/20";
      case "Ditolak":
        return "bg-red-500/10 text-red-500 hover:bg-red-500/20";
      default:
        return "";
    }
  };

  // Hanya tampilkan tombol tambah untuk admin, pimpinan, dan pegawai
  const canAddLeave = ['admin', 'pimpinan', 'pegawai'].includes(user?.role || '');
  
  // Hanya tampilkan tombol verifikasi untuk pimpinan
  const canVerifyLeave = user?.role === 'pimpinan';
  
  // Hanya tampilkan tombol hapus untuk admin dan pimpinan
  const canDeleteLeave = ['admin', 'pimpinan'].includes(user?.role || '');

  return (
    <div className="space-y-4">
      <div className="flex items-center justify-between">
        <Input
          placeholder="Cari berdasarkan nama atau NIP..."
          value={search}
          onChange={(e) => handleSearch(e.target.value)}
          className="max-w-xs"
        />
        {canAddLeave && (
          <Button onClick={() => setShowForm(true)}>Tambah Cuti</Button>
        )}
      </div>

      <div className="rounded-md border">
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>NIP</TableHead>
              <TableHead>Nama</TableHead>
              <TableHead>Jenis Cuti</TableHead>
              <TableHead>Tanggal Mulai</TableHead>
              <TableHead>Tanggal Selesai</TableHead>
              <TableHead>Status</TableHead>
              <TableHead>Aksi</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            {isLoading ? (
              <TableRow>
                <TableCell colSpan={7} className="text-center">
                  Memuat data...
                </TableCell>
              </TableRow>
            ) : leaveList?.data.length ? (
              leaveList.data.map((leave) => (
                <TableRow key={leave.id}>
                  <TableCell>{leave.pegawai?.nip}</TableCell>
                  <TableCell>{leave.pegawai?.nama_lengkap}</TableCell>
                  <TableCell>{leave.jenis_cuti}</TableCell>
                  <TableCell>
                    {format(new Date(leave.tanggal_mulai), "dd MMMM yyyy", {
                      locale: id,
                    })}
                  </TableCell>
                  <TableCell>
                    {format(new Date(leave.tanggal_selesai), "dd MMMM yyyy", {
                      locale: id,
                    })}
                  </TableCell>
                  <TableCell>
                    <Badge className={getStatusColor(leave.status)}>
                      {leave.status}
                    </Badge>
                  </TableCell>
                  <TableCell>
                    <div className="flex items-center gap-2">
                      {canVerifyLeave && leave.status === "Diajukan" && (
                        <>
                          <Button
                            size="sm"
                            variant="outline"
                            className="bg-green-500/10 text-green-500 hover:bg-green-500/20"
                            onClick={() =>
                              updateStatusMutation.mutate({
                                id: leave.id,
                                status: "Disetujui",
                              })
                            }
                          >
                            Setujui
                          </Button>
                          <Button
                            size="sm"
                            variant="outline"
                            className="bg-red-500/10 text-red-500 hover:bg-red-500/20"
                            onClick={() =>
                              updateStatusMutation.mutate({
                                id: leave.id,
                                status: "Ditolak",
                              })
                            }
                          >
                            Tolak
                          </Button>
                        </>
                      )}
                      {canDeleteLeave && (
                        <Button
                          size="sm"
                          variant="outline"
                          className="border-destructive/50 text-destructive hover:bg-destructive/10"
                          onClick={() => setDeleteId(leave.id)}
                        >
                          Hapus
                        </Button>
                      )}
                    </div>
                  </TableCell>
                </TableRow>
              ))
            ) : (
              <TableRow>
                <TableCell colSpan={7} className="text-center text-muted-foreground">
                  Tidak ada data cuti.
                </TableCell>
              </TableRow>
            )}
          </TableBody>
        </Table>
      </div>

      <div className="flex items-center justify-between px-2">
        <span className="text-sm text-muted-foreground">
          Halaman {page} / {leaveList?.meta.lastPage || 1}
        </span>
        <div className="flex gap-2">
          <Button
            size="sm"
            variant="outline"
            className="border-border/10 hover:bg-muted/50"
            disabled={page === 1}
            onClick={() => setPage((p) => p - 1)}
          >
            Sebelumnya
          </Button>
          <Button
            size="sm"
            variant="outline"
            className="border-border/10 hover:bg-muted/50"
            disabled={page === leaveList?.meta.lastPage || !leaveList?.meta.lastPage}
            onClick={() => setPage((p) => p + 1)}
          >
            Selanjutnya
          </Button>
        </div>
      </div>

      <AddEditLeaveForm
        leave={editLeaveData}
        open={showForm}
        onClose={() => {
          setShowForm(false);
          setEditLeaveData(null);
        }}
        onSuccess={() => {
          queryClient.invalidateQueries({ queryKey: ["leave-list"] });
        }}
      />

      <AlertDialog open={!!deleteId} onOpenChange={() => setDeleteId(null)}>
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle>Hapus Data Cuti</AlertDialogTitle>
            <AlertDialogDescription>
              Apakah Anda yakin ingin menghapus data cuti ini? Tindakan ini tidak
              dapat dibatalkan.
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <AlertDialogCancel>Batal</AlertDialogCancel>
            <AlertDialogAction
              className="bg-destructive hover:bg-destructive/90"
              onClick={() => deleteId && deleteMutation.mutate(deleteId)}
            >
              Hapus
            </AlertDialogAction>
          </AlertDialogFooter>
        </AlertDialogContent>
      </AlertDialog>
    </div>
  );
} 