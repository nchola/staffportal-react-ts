import { useForm } from "react-hook-form";
import { useMutation } from "@tanstack/react-query";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { addPegawai, editPegawai, type Pegawai } from "@/integrations/pegawaiApi";
import { useToast } from "@/hooks/use-toast";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog";

interface Props {
  pegawai?: Pegawai | null;
  onClose: () => void;
  onSuccess: () => void;
}

export default function AddEditEmployeeForm({ pegawai, onClose, onSuccess }: Props) {
  const { toast } = useToast();
  const {
    register,
    handleSubmit,
    formState: { errors, isSubmitting },
  } = useForm({
    defaultValues: {
      nip: pegawai?.nip || "",
      nama_lengkap: pegawai?.nama_lengkap || "",
      email: pegawai?.email || "",
      tanggal_bergabung: pegawai?.tanggal_bergabung || "",
    },
  });

  const mutation = useMutation({
    mutationFn: (data: any) =>
      pegawai ? editPegawai(pegawai.id, data) : addPegawai(data),
    onSuccess: () => {
      toast({
        title: "Berhasil",
        description: `Data pegawai berhasil ${pegawai ? "diperbarui" : "ditambahkan"}`,
      });
      onSuccess();
    },
    onError: (error) => {
      toast({
        title: "Gagal",
        description: `Terjadi kesalahan saat ${
          pegawai ? "memperbarui" : "menambahkan"
        } data`,
        variant: "destructive",
      });
    },
  });

  return (
    <Dialog open onOpenChange={onClose}>
      <DialogContent className="sm:max-w-[425px]">
        <DialogHeader>
          <DialogTitle>
            {pegawai ? "Edit Data Pegawai" : "Tambah Pegawai Baru"}
          </DialogTitle>
        </DialogHeader>
        <form onSubmit={handleSubmit((data) => mutation.mutate(data))}>
          <div className="grid gap-4 py-4">
            <div className="grid gap-2">
              <label htmlFor="nip">NIP</label>
              <Input
                id="nip"
                {...register("nip", { required: "NIP wajib diisi" })}
                disabled={!!pegawai}
              />
              {errors.nip && (
                <p className="text-sm text-destructive">{errors.nip.message}</p>
              )}
            </div>
            <div className="grid gap-2">
              <label htmlFor="nama_lengkap">Nama Lengkap</label>
              <Input
                id="nama_lengkap"
                {...register("nama_lengkap", { required: "Nama wajib diisi" })}
              />
              {errors.nama_lengkap && (
                <p className="text-sm text-destructive">
                  {errors.nama_lengkap.message}
                </p>
              )}
            </div>
            <div className="grid gap-2">
              <label htmlFor="email">Email</label>
              <Input
                id="email"
                type="email"
                {...register("email")}
              />
            </div>
            <div className="grid gap-2">
              <label htmlFor="tanggal_bergabung">Tanggal Bergabung</label>
              <Input
                id="tanggal_bergabung"
                type="date"
                {...register("tanggal_bergabung", {
                  required: "Tanggal bergabung wajib diisi",
                })}
              />
              {errors.tanggal_bergabung && (
                <p className="text-sm text-destructive">
                  {errors.tanggal_bergabung.message}
                </p>
              )}
            </div>
          </div>
          <div className="flex justify-end gap-2">
            <Button type="button" variant="outline" onClick={onClose}>
              Batal
            </Button>
            <Button type="submit" disabled={isSubmitting}>
              {isSubmitting ? (
                <>
                  <div className="h-4 w-4 border-2 border-current border-t-transparent rounded-full animate-spin mr-2" />
                  Menyimpan...
                </>
              ) : pegawai ? (
                "Simpan Perubahan"
              ) : (
                "Tambah Pegawai"
              )}
            </Button>
          </div>
        </form>
      </DialogContent>
    </Dialog>
  );
}
