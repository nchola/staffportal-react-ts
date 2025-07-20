import { useState } from 'react';
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import MainLayout from '@/components/layout/MainLayout';
import { PageHeader } from '@/components/ui/page-header';
import { ModuleCard } from '@/components/ui/module-card';
import { DataTable } from '@/components/ui/data-table';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Users, Search, Filter, Plus, Download, Edit2, Trash2 } from 'lucide-react';
import { getPegawaiList, deletePegawai, printPegawai, type Pegawai } from '@/integrations/pegawaiApi';
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
import AddEditPegawaiForm from '@/components/pegawai/AddEditPegawaiForm';
import { cn } from '@/lib/utils';

const PegawaiPage = () => {
  const { toast } = useToast();
  const queryClient = useQueryClient();
  const [searchQuery, setSearchQuery] = useState('');
  const [page, setPage] = useState(1);
  const [showAddEditForm, setShowAddEditForm] = useState(false);
  const [selectedPegawai, setSelectedPegawai] = useState<Pegawai | null>(null);
  const [showDeleteAlert, setShowDeleteAlert] = useState(false);

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
      setShowDeleteAlert(false);
    },
    onError: (error: Error) => {
      toast({
        title: "Gagal",
        description: error.message || "Terjadi kesalahan saat menghapus data",
        variant: "destructive",
      });
      setShowDeleteAlert(false);
    }
  });

  // Add print mutation
  const printMutation = useMutation({
    mutationFn: printPegawai,
    onSuccess: (data) => {
      // Split data into two columns
      const midPoint = Math.ceil(data.length / 2);
      const leftColumn = data.slice(0, midPoint);
      const rightColumn = data.slice(midPoint);

      // Create printable format with numbering
      const formatColumn = (items: typeof data, startNum: number) => items.map((pegawai, idx) => `
        ${startNum + idx}. Pegawai
        Nama: ${pegawai.nama_lengkap}
        NIP: ${pegawai.nip}
        Email: ${pegawai.email || '-'}
        No. Telepon: ${pegawai.no_telepon || '-'}
        Alamat: ${pegawai.alamat || '-'}
        Status: ${pegawai.status || 'Aktif'}
        Tgl Bergabung: ${new Date(pegawai.tanggal_bergabung).toLocaleDateString('id-ID')}
        ----------------------------------------
      `).join('\n');

      const leftContent = formatColumn(leftColumn, 1);
      const rightContent = formatColumn(rightColumn, midPoint + 1);

      // Create a new window for printing
      const printWindow = window.open('', '_blank');
      if (printWindow) {
        printWindow.document.write(`
          <html>
            <head>
              <title>Daftar Pegawai</title>
              <style>
                body { 
                  font-family: Arial, sans-serif;
                  padding: 16px;
                  max-width: 1200px;
                  margin: 0 auto;
                }
                .header { 
                  text-align: center; 
                  margin-bottom: 20px;
                  border-bottom: 2px solid #000;
                  padding-bottom: 10px;
                }
                .content { 
                  display: flex;
                  justify-content: space-between;
                  gap: 20px;
                }
                .column {
                  flex: 1;
                  white-space: pre-line;
                  line-height: 1.5;
                }
                @media print {
                  body {
                    padding: 0;
                  }
                  .content {
                    gap: 40px;
                  }
                }
              </style>
            </head>
            <body>
              <div class="header">
                <h1>Daftar Pegawai</h1>
                <p>Tanggal Cetak: ${new Date().toLocaleDateString('id-ID')}</p>
                <p>Total Pegawai: ${data.length}</p>
              </div>
              <div class="content">
                <div class="column">${leftContent}</div>
                <div class="column">${rightContent}</div>
              </div>
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
        description: "Gagal mengunduh data pegawai",
        variant: "destructive",
      });
    }
  });

  const columns: ColumnDef<Pegawai>[] = [
    {
      accessorKey: "nama_lengkap",
      header: "Nama Lengkap",
    },
    {
      accessorKey: "nip",
      header: "NIP",
    },
    {
      accessorKey: "email",
      header: "Email",
      cell: ({ row }) => row.getValue("email") || "-"
    },
    {
      accessorKey: "no_telepon",
      header: "No. Telepon",
      cell: ({ row }) => row.getValue("no_telepon") || "-"
    },
    {
      accessorKey: "alamat",
      header: "Alamat",
      cell: ({ row }) => row.getValue("alamat") || "-"
    },
    {
      accessorKey: "status",
      header: "Status",
      cell: ({ row }) => {
        const status = row.getValue("status") as string;
        return (
          <span className={cn(
            "px-2 py-1 rounded-full text-xs font-medium",
            status === "Aktif" && "bg-green-100 text-green-700",
            status === "Cuti" && "bg-yellow-100 text-yellow-700",
            status === "Tidak Aktif" && "bg-red-100 text-red-700"
          )}>
            {status || "Aktif"}
          </span>
        );
      }
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
          <div className="flex items-center gap-4">
            <Button
              variant="ghost"
              size="icon"
              onClick={() => {
                setSelectedPegawai(pegawai);
                setShowAddEditForm(true);
              }}
            >
              <Edit2 className="h-4 w-4" />
            </Button>
            <Button
              variant="ghost"
              size="icon"
              onClick={() => {
                setSelectedPegawai(pegawai);
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

  return (
    <MainLayout>
      <div className="flex flex-col gap-8">
        <PageHeader
          title="Data Pegawai"
          description="Kelola data pegawai perusahaan"
        >
          <div className="flex items-center">
            <Users className="h-6 w-6" />
          </div>
        </PageHeader>

        <ModuleCard
          title="Daftar Pegawai"
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
              <Button variant="outline" size="icon">
                <Filter className="h-4 w-4" />
              </Button>
            </div>
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
                Tambah Pegawai
              </Button>
            </div>
          </div>

          <DataTable
            columns={columns}
            data={data?.data || []}
            isLoading={isLoading}
          />
        </ModuleCard>
      </div>

      {/* Add/Edit Form Dialog */}
      <AddEditPegawaiForm
        pegawai={selectedPegawai}
        open={showAddEditForm}
        onClose={() => {
          setShowAddEditForm(false);
          setSelectedPegawai(null);
        }}
        onSuccess={() => {
          setShowAddEditForm(false);
          setSelectedPegawai(null);
          queryClient.invalidateQueries({ queryKey: ['pegawai'] });
        }}
      />

      {/* Delete Confirmation Dialog */}
      <AlertDialog open={showDeleteAlert} onOpenChange={setShowDeleteAlert}>
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle>Hapus Data Pegawai</AlertDialogTitle>
            <AlertDialogDescription>
              Apakah Anda yakin ingin menghapus data pegawai ini? Tindakan ini tidak dapat dibatalkan.
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <AlertDialogCancel>Batal</AlertDialogCancel>
            <AlertDialogAction
              onClick={() => {
                if (selectedPegawai) {
                  deleteMutation.mutate(selectedPegawai.id);
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

export default PegawaiPage;
