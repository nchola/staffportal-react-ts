import { useState } from 'react';
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import MainLayout from '@/components/layout/MainLayout';
import { PageHeader } from '@/components/ui/page-header';
import { ModuleCard } from '@/components/ui/module-card';
import { DataTable } from '@/components/ui/data-table';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Users, Search, Filter, Plus, Download, Edit2, Trash2 } from 'lucide-react';
import { getPegawaiList, deletePegawai, type Pegawai } from '@/integrations/pegawaiApi';
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
import AddEditEmployeeForm from '@/components/pegawai/AddEditEmployeeForm';

const EmployeesPage = () => {
  const { toast } = useToast();
  const queryClient = useQueryClient();
  const [searchQuery, setSearchQuery] = useState('');
  const [page, setPage] = useState(1);
  const [showForm, setShowForm] = useState(false);
  const [editPegawaiData, setEditPegawaiData] = useState<Pegawai | null>(null);
  const [deleteId, setDeleteId] = useState<string | null>(null);

  // Fetch employees
  const { data, isLoading } = useQuery({
    queryKey: ['pegawai', page, searchQuery],
    queryFn: () => getPegawaiList(page, 10, searchQuery),
  });

  // Delete mutation
  const deleteMutation = useMutation({
    mutationFn: deletePegawai,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['pegawai'] });
      toast({
        title: "Berhasil",
        description: "Data pegawai telah dihapus",
      });
    },
    onError: (error) => {
      toast({
        title: "Gagal",
        description: "Terjadi kesalahan saat menghapus data",
        variant: "destructive",
      });
    },
  });

  const columns: ColumnDef<Pegawai>[] = [
    {
      accessorKey: "nip",
      header: "NIP",
    },
    {
      accessorKey: "nama_lengkap",
      header: "Nama Lengkap",
    },
    {
      accessorKey: "email",
      header: "Email",
    },
    {
      accessorKey: "tanggal_bergabung",
      header: "Tanggal Bergabung",
      cell: ({ row }) => {
        const date = new Date(row.getValue("tanggal_bergabung"));
        return date.toLocaleDateString("id-ID", {
          day: "numeric",
          month: "long",
          year: "numeric",
        });
      },
    },
    {
      id: "actions",
      cell: ({ row }) => {
        const pegawai = row.original;
        return (
          <div className="flex items-center gap-2">
            <Button
              variant="outline"
              size="icon"
              onClick={() => {
                setEditPegawaiData(pegawai);
                setShowForm(true);
              }}
            >
              <Edit2 className="h-4 w-4" />
            </Button>
            <Button
              variant="outline"
              size="icon"
              className="text-destructive hover:text-destructive"
              onClick={() => setDeleteId(pegawai.id)}
            >
              <Trash2 className="h-4 w-4" />
            </Button>
          </div>
        );
      },
    },
  ];

  return (
    <MainLayout>
      <div className="space-y-6">
        <PageHeader
          title="Data Pegawai"
          description="Kelola data pegawai dengan fitur tambah, edit, pencarian, dan cetak untuk keperluan manajemen SDM."
        >
          <div className="flex items-center gap-2">
            <Button variant="outline" size="icon">
              <Filter className="h-4 w-4" />
            </Button>
            <Button variant="outline" size="icon">
              <Download className="h-4 w-4" />
            </Button>
            <Button onClick={() => { setShowForm(true); setEditPegawaiData(null); }}>
              <Plus className="h-4 w-4 mr-2" />
              Tambah Pegawai
            </Button>
          </div>
        </PageHeader>

        <div className="flex items-center gap-4">
          <div className="relative flex-1">
            <Search className="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
            <Input
              placeholder="Cari pegawai..."
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              className="pl-9 bg-muted/50"
            />
          </div>
        </div>

        <ModuleCard
          title="Daftar Pegawai"
          icon={<Users className="h-5 w-5" />}
          className="border-none shadow-none"
        >
          <DataTable
            columns={columns}
            data={data?.data || []}
            isLoading={isLoading}
          />
        </ModuleCard>
      </div>

      {/* Add/Edit Form Dialog */}
      {showForm && (
        <AddEditEmployeeForm
          pegawai={editPegawaiData}
          onClose={() => { setShowForm(false); setEditPegawaiData(null); }}
          onSuccess={() => {
            setShowForm(false);
            setEditPegawaiData(null);
            queryClient.invalidateQueries({ queryKey: ['pegawai'] });
          }}
        />
      )}

      {/* Delete Confirmation Dialog */}
      <AlertDialog open={!!deleteId} onOpenChange={() => setDeleteId(null)}>
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle>Hapus Data Pegawai</AlertDialogTitle>
            <AlertDialogDescription>
              Apakah Anda yakin ingin menghapus data pegawai ini? 
              Tindakan ini tidak dapat dibatalkan.
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <AlertDialogCancel>Batal</AlertDialogCancel>
            <AlertDialogAction
              className="bg-destructive hover:bg-destructive/90"
              onClick={() => {
                if (deleteId) {
                  deleteMutation.mutate(deleteId);
                  setDeleteId(null);
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

export default EmployeesPage;
