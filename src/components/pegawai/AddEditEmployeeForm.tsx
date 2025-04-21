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
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import { useEffect } from "react";

interface Props {
  pegawai?: Pegawai | null;
  open: boolean;
  onClose: () => void;
  onSuccess: () => void;
}

type FormValues = {
  nip: string;
  nama_lengkap: string;
  email?: string;
  tanggal_bergabung: string;
  tanggal_lahir?: string;
  tempat_lahir?: string;
  jenis_kelamin?: 'Laki-laki' | 'Perempuan';
  alamat?: string;
  no_telepon?: string;
  status?: 'Aktif' | 'Cuti' | 'Tidak Aktif';
  agama: string;
  status_pernikahan: string;
  pendidikan_terakhir: string;
};

export default function AddEditEmployeeForm({ pegawai, open, onClose, onSuccess }: Props) {
  const { toast } = useToast();
  const {
    register,
    handleSubmit,
    formState: { errors, isSubmitting },
    setValue,
    reset,
  } = useForm<FormValues>({
    defaultValues: {
      nip: pegawai?.nip || "",
      nama_lengkap: pegawai?.nama_lengkap || "",
      email: pegawai?.email || "",
      tanggal_bergabung: pegawai?.tanggal_bergabung || "",
      tanggal_lahir: pegawai?.tanggal_lahir || "",
      tempat_lahir: pegawai?.tempat_lahir || "",
      jenis_kelamin: pegawai?.jenis_kelamin || undefined,
      alamat: pegawai?.alamat || "",
      no_telepon: pegawai?.no_telepon || "",
      status: pegawai?.status || "Aktif",
      agama: pegawai?.agama || "",
      status_pernikahan: pegawai?.status_pernikahan || "",
      pendidikan_terakhir: pegawai?.pendidikan_terakhir || "",
    }
  });

  // Reset form when pegawai changes
  useEffect(() => {
    if (pegawai) {
      reset({
        nip: pegawai.nip,
        nama_lengkap: pegawai.nama_lengkap,
        email: pegawai.email || "",
        tanggal_bergabung: pegawai.tanggal_bergabung,
        tanggal_lahir: pegawai.tanggal_lahir || "",
        tempat_lahir: pegawai.tempat_lahir || "",
        jenis_kelamin: pegawai.jenis_kelamin,
        alamat: pegawai.alamat || "",
        no_telepon: pegawai.no_telepon || "",
        status: pegawai.status || "Aktif",
        agama: pegawai.agama || "",
        status_pernikahan: pegawai.status_pernikahan || "",
        pendidikan_terakhir: pegawai.pendidikan_terakhir || "",
      });
    } else {
      reset({
        nip: "",
        nama_lengkap: "",
        email: "",
        tanggal_bergabung: "",
        tanggal_lahir: "",
        tempat_lahir: "",
        jenis_kelamin: undefined,
        alamat: "",
        no_telepon: "",
        status: "Aktif",
        agama: "",
        status_pernikahan: "",
        pendidikan_terakhir: "",
      });
    }
  }, [pegawai, reset]);

  const mutation = useMutation({
    mutationFn: (data: FormValues) =>
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
    <Dialog open={open} onOpenChange={onClose}>
      <DialogContent className="sm:max-w-[600px]">
        <DialogHeader>
          <DialogTitle>
            {pegawai ? "Edit Data Pegawai" : "Tambah Pegawai Baru"}
          </DialogTitle>
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

            <div className="grid grid-cols-2 gap-4">
              {/* Tempat Lahir */}
              <div className="grid gap-2">
                <label htmlFor="tempat_lahir">Tempat Lahir</label>
                <Input
                  id="tempat_lahir"
                  {...register("tempat_lahir")}
                />
              </div>

              {/* Tanggal Lahir */}
              <div className="grid gap-2">
                <label htmlFor="tanggal_lahir">Tanggal Lahir</label>
                <Input
                  id="tanggal_lahir"
                  type="date"
                  className="[color-scheme:dark]"
                  {...register("tanggal_lahir")}
                />
              </div>
            </div>

            <div className="grid grid-cols-2 gap-4">
              {/* Jenis Kelamin */}
              <div className="grid gap-2">
                <label htmlFor="jenis_kelamin">Jenis Kelamin</label>
                <Select
                  onValueChange={(value) => {
                    const event = {
                      target: { value, name: "jenis_kelamin" }
                    };
                    register("jenis_kelamin").onChange(event);
                  }}
                  defaultValue={pegawai?.jenis_kelamin}
                >
                  <SelectTrigger>
                    <SelectValue placeholder="Pilih jenis kelamin" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="Laki-laki">Laki-laki</SelectItem>
                    <SelectItem value="Perempuan">Perempuan</SelectItem>
                  </SelectContent>
                </Select>
              </div>

              {/* Status */}
              <div className="grid gap-2">
                <label htmlFor="status">Status</label>
                <Select
                  onValueChange={(value) => {
                    const event = {
                      target: { value, name: "status" }
                    };
                    register("status").onChange(event);
                  }}
                  defaultValue={pegawai?.status}
                >
                  <SelectTrigger>
                    <SelectValue placeholder="Pilih status" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="Aktif">Aktif</SelectItem>
                    <SelectItem value="Cuti">Cuti</SelectItem>
                    <SelectItem value="Tidak Aktif">Tidak Aktif</SelectItem>
                  </SelectContent>
                </Select>
              </div>
            </div>

            <div className="grid grid-cols-2 gap-4">
              {/* No Telepon */}
              <div className="grid gap-2">
                <label htmlFor="no_telepon">No. Telepon</label>
                <Input
                  id="no_telepon"
                  type="tel"
                  {...register("no_telepon")}
                />
              </div>

              {/* Email */}
              <div className="grid gap-2">
                <label htmlFor="email">Email</label>
                <Input
                  id="email"
                  type="email"
                  {...register("email")}
                />
              </div>
            </div>

            {/* Alamat */}
            <div className="grid gap-2">
              <label htmlFor="alamat">Alamat</label>
              <Input
                id="alamat"
                {...register("alamat")}
              />
            </div>

            {/* Tanggal Bergabung */}
            <div className="grid gap-2">
              <label htmlFor="tanggal_bergabung">Tanggal Bergabung <span className="text-destructive">*</span></label>
              <Input
                id="tanggal_bergabung"
                type="date"
                className="[color-scheme:dark]"
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
