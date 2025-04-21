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
  DialogDescription,
} from "@/components/ui/dialog";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import { Textarea } from "@/components/ui/textarea";
import { useEffect } from "react";

interface Props {
  pegawai: Pegawai | null;
  open: boolean;
  onClose: () => void;
  onSuccess: () => void;
}

export default function AddEditPegawaiForm({ pegawai, open, onClose, onSuccess }: Props) {
  const { toast } = useToast();
  const { register, handleSubmit, formState: { errors }, reset, setValue } = useForm<Pegawai>({
    defaultValues: pegawai || {
      status: 'Aktif'
    }
  });

  const mutation = useMutation({
    mutationFn: (data: Pegawai) => {
      if (pegawai) {
        return editPegawai(pegawai.id, data);
      }
      return addPegawai(data);
    },
    onSuccess: () => {
      toast({
        title: `Berhasil ${pegawai ? 'mengubah' : 'menambahkan'} data pegawai`,
        variant: 'default',
      });
      onSuccess();
      onClose();
      reset();
    },
    onError: (error) => {
      toast({
        title: `Gagal ${pegawai ? 'mengubah' : 'menambahkan'} data pegawai`,
        description: error instanceof Error ? error.message : 'Terjadi kesalahan',
        variant: 'destructive',
      });
    },
  });

  useEffect(() => {
    if (pegawai) {
      Object.entries(pegawai).forEach(([key, value]) => {
        setValue(key as keyof Pegawai, value);
      });
    }
  }, [pegawai, setValue]);

  return (
    <Dialog open={open} onOpenChange={onClose}>
      <DialogContent className="sm:max-w-[600px]">
        <DialogHeader>
          <DialogTitle>
            {pegawai ? "Edit Data Pegawai" : "Tambah Pegawai Baru"}
          </DialogTitle>
          <DialogDescription>
            {pegawai 
              ? "Ubah informasi pegawai pada form di bawah ini" 
              : "Isi informasi pegawai baru pada form di bawah ini"}
          </DialogDescription>
        </DialogHeader>
        <form onSubmit={handleSubmit((data) => mutation.mutate(data))}>
          <div className="grid gap-4 py-4">
            <div className="grid grid-cols-2 gap-4">
              {/* NIP */}
              <div className="grid gap-2">
                <label htmlFor="nip">NIP <span className="text-destructive">*</span></label>
                <Input
                  id="nip"
                  {...register("nip", { required: "NIP wajib diisi" })}
                  disabled={!!pegawai}
                />
                {errors.nip && (
                  <p className="text-sm text-destructive">{errors.nip.message}</p>
                )}
              </div>

              {/* Nama Lengkap */}
              <div className="grid gap-2">
                <label htmlFor="nama_lengkap">Nama Lengkap <span className="text-destructive">*</span></label>
                <Input
                  id="nama_lengkap"
                  {...register("nama_lengkap", { required: "Nama wajib diisi" })}
                />
                {errors.nama_lengkap && (
                  <p className="text-sm text-destructive">{errors.nama_lengkap.message}</p>
                )}
              </div>
            </div>

            {/* Email */}
            <div className="grid gap-2">
              <label htmlFor="email">Email</label>
              <Input
                id="email"
                type="email"
                {...register("email")}
              />
              {errors.email && (
                <p className="text-sm text-destructive">{errors.email.message}</p>
              )}
            </div>

            {/* No Telepon */}
            <div className="grid gap-2">
              <label htmlFor="no_telepon">No. Telepon</label>
              <Input
                id="no_telepon"
                type="tel"
                {...register("no_telepon")}
              />
              {errors.no_telepon && (
                <p className="text-sm text-destructive">{errors.no_telepon.message}</p>
              )}
            </div>

            {/* Alamat */}
            <div className="grid gap-2">
              <label htmlFor="alamat">Alamat</label>
              <Textarea
                id="alamat"
                {...register("alamat")}
              />
              {errors.alamat && (
                <p className="text-sm text-destructive">{errors.alamat.message}</p>
              )}
            </div>

            {/* Status */}
            <div className="grid gap-2">
              <label htmlFor="status">Status <span className="text-destructive">*</span></label>
              <Select
                onValueChange={(value) => setValue("status", value as 'Aktif' | 'Non-Aktif')}
                defaultValue={pegawai?.status || 'Aktif'}
              >
                <SelectTrigger>
                  <SelectValue placeholder="Pilih status" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="Aktif">Aktif</SelectItem>
                  <SelectItem value="Non-Aktif">Non-Aktif</SelectItem>
                </SelectContent>
              </Select>
              {errors.status && (
                <p className="text-sm text-destructive">{errors.status.message}</p>
              )}
            </div>

            {/* Tanggal Bergabung */}
            <div className="grid gap-2">
              <label htmlFor="tanggal_bergabung">Tanggal Bergabung <span className="text-destructive">*</span></label>
              <Input
                id="tanggal_bergabung"
                type="date"
                className="[color-scheme:dark]"
                {...register("tanggal_bergabung", { required: "Tanggal bergabung wajib diisi" })}
              />
              {errors.tanggal_bergabung && (
                <p className="text-sm text-destructive">{errors.tanggal_bergabung.message}</p>
              )}
            </div>

            <div className="flex justify-end gap-2">
              <Button
                type="button"
                variant="outline"
                onClick={onClose}
              >
                Batal
              </Button>
              <Button
                type="submit"
                disabled={mutation.isPending}
              >
                {mutation.isPending ? (
                  <span>Menyimpan...</span>
                ) : pegawai ? (
                  "Simpan Perubahan"
                ) : (
                  "Tambah Pegawai"
                )}
              </Button>
            </div>
          </div>
        </form>
      </DialogContent>
    </Dialog>
  );
}
