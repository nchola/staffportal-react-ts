import { useState } from 'react';
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import MainLayout from '@/components/layout/MainLayout';
import { PageHeader } from '@/components/ui/page-header';
import { ModuleCard } from '@/components/ui/module-card';
import { DataTable } from '@/components/ui/data-table';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Calendar, Search, Filter, Plus, Download, Edit2, Trash2 } from 'lucide-react';
import { getAbsensiList, deleteAbsensi, printAbsensi, type Absensi } from '@/integrations/absensiApi';
import { useToast } from '@/hooks/use-toast';
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
import { ColumnDef } from '@tanstack/react-table';
import AddEditAbsensiForm from '@/components/absensi/AddEditAbsensiForm';
import { useAuth } from '@/context/AuthContext';
import { format } from 'date-fns';
import { id } from 'date-fns/locale';

const AttendancePage = () => {
  const { user } = useAuth();
  const { toast } = useToast();
  const queryClient = useQueryClient();
  const [searchQuery, setSearchQuery] = useState('');
  const [page, setPage] = useState(1);
  const [selectedDate, setSelectedDate] = useState<string>(
    new Date().toISOString().split('T')[0]
  );
  const [showAddEditForm, setShowAddEditForm] = useState(false);
  const [selectedAbsensi, setSelectedAbsensi] = useState<Absensi | null>(null);
  const [showDeleteAlert, setShowDeleteAlert] = useState(false);

  // Fetch attendance data
  const { data, isLoading } = useQuery({
    queryKey: ['absensi', page, searchQuery, selectedDate],
    queryFn: () => getAbsensiList(page, 10, searchQuery, selectedDate),
  });

  // Delete mutation
  const deleteMutation = useMutation({
    mutationFn: deleteAbsensi,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['absensi'] });
      toast({
        title: "Berhasil",
        description: "Data absensi telah dihapus",
      });
      setShowDeleteAlert(false);
    },
    onError: (error) => {
      toast({
        title: "Gagal",
        description: "Terjadi kesalahan saat menghapus data",
        variant: "destructive",
      });
    }
  });

  // Add print mutation
  const printMutation = useMutation({
    mutationFn: () => printAbsensi(selectedDate),
    onSuccess: (data) => {
      // Create printable format
      const printContent = data.map(absensi => `
        ${absensi.pegawai?.nama_lengkap} (${absensi.pegawai?.nip})
        Tanggal: ${new Date(absensi.tanggal).toLocaleDateString('id-ID')}
        Status: ${absensi.status}
        Waktu Masuk: ${absensi.waktu_masuk ? new Date(absensi.waktu_masuk).toLocaleTimeString('id-ID') : '-'}
        Waktu Keluar: ${absensi.waktu_keluar ? new Date(absensi.waktu_keluar).toLocaleTimeString('id-ID') : '-'}
        Keterangan: ${absensi.keterangan || '-'}
        ----------------------------------------
      `).join('\n');

      // Create a new window for printing
      const printWindow = window.open('', '_blank');
      if (printWindow) {
        printWindow.document.write(`
          <html>
            <head>
              <title>Laporan Absensi</title>
              <style>
                body { font-family: Arial, sans-serif; }
                .header { text-align: center; margin-bottom: 20px; }
                .content { white-space: pre-line; }
              </style>
            </head>
            <body>
              <div class="header">
                <h1>Laporan Absensi</h1>
                <p>Tanggal: ${new Date(selectedDate).toLocaleDateString('id-ID')}</p>
              </div>
              <div class="content">${printContent}</div>
            </body>
          </html>
        `);
        printWindow.document.close();
        printWindow.print();
      }
    },
    onError: () => {
      toast({
        title: "Gagal",
        description: "Gagal mengunduh data absensi",
        variant: "destructive",
      });
    }
  });

  const columns: ColumnDef<Absensi>[] = [
    {
      accessorKey: "pegawai.nama_lengkap",
      header: "Nama Pegawai",
    },
    {
      accessorKey: "pegawai.nip",
      header: "NIP",
    },
    {
      accessorKey: "tanggal",
      header: "Tanggal",
      cell: ({ row }) => {
        const date = new Date(row.getValue("tanggal"));
        return format(date, 'EEEE, d MMMM yyyy', { locale: id });
      },
    },
    {
      accessorKey: "waktu_masuk",
      header: "Waktu Masuk",
      cell: ({ row }) => {
        const time = row.getValue("waktu_masuk") as string;
        return time ? format(new Date(time), 'HH:mm') : "-";
      },
    },
    {
      accessorKey: "waktu_keluar",
      header: "Waktu Keluar",
      cell: ({ row }) => {
        const time = row.getValue("waktu_keluar") as string;
        return time ? format(new Date(time), 'HH:mm') : "-";
      },
    },
    {
      accessorKey: "status",
      header: "Status",
      cell: ({ row }) => {
        const status = row.getValue("status") as string;
        return (
          <span className={`px-2 py-1 rounded-full text-xs font-medium ${
            status === "Hadir" ? "bg-green-100 text-green-700" :
            status === "Terlambat" ? "bg-yellow-100 text-yellow-700" :
            status === "Izin" ? "bg-blue-100 text-blue-700" :
            status === "Sakit" ? "bg-orange-100 text-orange-700" :
            status === "Cuti" ? "bg-purple-100 text-purple-700" :
            "bg-red-100 text-red-700"
          }`}>
            {status || "Tanpa Keterangan"}
          </span>
        );
      },
    },
    {
      accessorKey: "keterangan",
      header: "Keterangan",
      cell: ({ row }) => row.getValue("keterangan") || "-",
    },
    {
      id: "actions",
      cell: ({ row }) => {
        const absensi = row.original;
        return (
          <div className="flex items-center gap-4">
            <Button
              variant="ghost"
              size="icon"
              onClick={() => {
                setSelectedAbsensi(absensi);
                setShowAddEditForm(true);
              }}
            >
              <Edit2 className="h-4 w-4" />
            </Button>
            <Button
              variant="ghost"
              size="icon"
              onClick={() => {
                setSelectedAbsensi(absensi);
                setShowDeleteAlert(true);
              }}
            >
              <Trash2 className="h-4 w-4" />
            </Button>
          </div>
        );
      },
    },
  ];

  // Only admin and pimpinan can add/edit/delete
  const canManage = user?.role === 'admin' || user?.role === 'pimpinan';

  return (
    <MainLayout>
      <div className="flex flex-col gap-8">
        <PageHeader
          title="Manajemen Absensi"
          description="Pantau dan kelola catatan kehadiran pegawai"
        >
          <div className="flex items-center">
            <Calendar className="h-6 w-6" />
          </div>
        </PageHeader>

        <ModuleCard
          title="Daftar Absensi"
        >
          <div className="flex items-center justify-between mb-4">
            <div className="flex items-center gap-2">
              <Input
                placeholder="Cari pegawai..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="w-[300px]"
              />
              <Button variant="outline" size="icon">
                <Search className="h-4 w-4" />
              </Button>
              <Input
                type="date"
                value={selectedDate}
                onChange={(e) => setSelectedDate(e.target.value)}
                className="w-[200px] [color-scheme:dark]"
              />
            </div>
            {canManage && (
              <div className="flex items-center gap-2">
                <Button 
                  variant="outline" 
                  size="icon"
                  onClick={() => printMutation.mutate()}
                  disabled={printMutation.isPending}
                >
                  <Download className="h-4 w-4" />
                </Button>
                <Button onClick={() => setShowAddEditForm(true)}>
                  <Plus className="h-4 w-4 mr-2" />
                  Tambah Absensi
                </Button>
              </div>
            )}
          </div>

          <DataTable
            columns={columns}
            data={data?.data || []}
            isLoading={isLoading}
          />
        </ModuleCard>
      </div>

      {/* Add/Edit Form Dialog */}
      <AddEditAbsensiForm
        absensi={selectedAbsensi}
        open={showAddEditForm}
        onClose={() => {
          setShowAddEditForm(false);
          setSelectedAbsensi(null);
        }}
        onSuccess={() => {
          setShowAddEditForm(false);
          setSelectedAbsensi(null);
          queryClient.invalidateQueries({ queryKey: ['absensi'] });
        }}
      />

      {/* Delete Confirmation Dialog */}
      <AlertDialog open={showDeleteAlert} onOpenChange={setShowDeleteAlert}>
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle>Hapus Data Absensi</AlertDialogTitle>
            <AlertDialogDescription>
              Apakah Anda yakin ingin menghapus data absensi ini? Tindakan ini tidak dapat dibatalkan.
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <AlertDialogCancel>Batal</AlertDialogCancel>
            <AlertDialogAction
              onClick={() => {
                if (selectedAbsensi) {
                  deleteMutation.mutate(selectedAbsensi.id);
                }
              }}
            >
              Hapus
            </AlertDialogAction>
          </AlertDialogFooter>
        </AlertDialogContent>
      </AlertDialog>
    </MainLayout>
  );
};

export default AttendancePage;
