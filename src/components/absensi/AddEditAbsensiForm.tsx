import { useForm } from "react-hook-form";
import { useMutation, useQuery } from "@tanstack/react-query";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { addAbsensi, editAbsensi, type Absensi } from "@/integrations/absensiApi";
import { getPegawaiList } from "@/integrations/pegawaiApi";
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
import { Textarea } from "@/components/ui/textarea";

interface Props {
  absensi?: Absensi | null;
  open: boolean;
  onClose: () => void;
  onSuccess: () => void;
}

type FormValues = {
  pegawai_id: string;
  tanggal: string;
  waktu_masuk?: string;
  waktu_keluar?: string;
  status: 'Hadir' | 'Terlambat' | 'Izin' | 'Sakit' | 'Cuti' | 'Tanpa Keterangan';
  keterangan?: string;
};

export default function AddEditAbsensiForm({ absensi, open, onClose, onSuccess }: Props) {
  const { toast } = useToast();
  const {
    register,
    handleSubmit,
    formState: { errors, isSubmitting },
    setValue,
  } = useForm<FormValues>({
    defaultValues: {
      pegawai_id: absensi?.pegawai_id || "",
      tanggal: absensi?.tanggal || new Date().toISOString().split('T')[0],
      waktu_masuk: absensi?.waktu_masuk?.split('T')[1].split('.')[0] || "",
      waktu_keluar: absensi?.waktu_keluar?.split('T')[1].split('.')[0] || "",
      status: absensi?.status || "Hadir",
      keterangan: absensi?.keterangan || "",
    },
  });

  // Fetch pegawai list for dropdown
  const { data: pegawaiList } = useQuery({
    queryKey: ['pegawai-list-dropdown'],
    queryFn: () => getPegawaiList(1, 100),
  });

  const mutation = useMutation({
    mutationFn: (data: FormValues) => {
      // Combine date and time for waktu_masuk and waktu_keluar
      const formattedData = {
        ...data,
        waktu_masuk: data.waktu_masuk ? `${data.tanggal}T${data.waktu_masuk}Z` : null,
        waktu_keluar: data.waktu_keluar ? `${data.tanggal}T${data.waktu_keluar}Z` : null,
      };
      
      return absensi 
        ? editAbsensi(absensi.id, formattedData)
        : addAbsensi(formattedData);
    },
    onSuccess: () => {
      toast({
        title: "Berhasil",
        description: `Data absensi berhasil ${absensi ? "diperbarui" : "ditambahkan"}`,
      });
      onSuccess();
    },
    onError: (error) => {
      toast({
        title: "Gagal",
        description: `Terjadi kesalahan saat ${
          absensi ? "memperbarui" : "menambahkan"
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
            {absensi ? "Edit Data Absensi" : "Tambah Absensi Baru"}
          </DialogTitle>
        </DialogHeader>
        <form onSubmit={handleSubmit((data) => mutation.mutate(data))}>
          <div className="grid gap-4 py-4">
            {/* Pegawai */}
            <div className="grid gap-2">
              <label htmlFor="pegawai_id">Pegawai <span className="text-destructive">*</span></label>
              <Select
                onValueChange={(value) => setValue("pegawai_id", value)}
                defaultValue={absensi?.pegawai_id || undefined}
              >
                <SelectTrigger>
                  <SelectValue placeholder="Pilih pegawai" />
                </SelectTrigger>
                <SelectContent>
                  {pegawaiList?.data.map((pegawai) => (
                    <SelectItem key={pegawai.id} value={pegawai.id}>
                      {pegawai.nama_lengkap} ({pegawai.nip})
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
              {errors.pegawai_id && (
                <p className="text-sm text-destructive">{errors.pegawai_id.message}</p>
              )}
            </div>

            <div className="grid grid-cols-2 gap-4">
              {/* Tanggal */}
              <div className="grid gap-2">
                <label htmlFor="tanggal">Tanggal <span className="text-destructive">*</span></label>
                <Input
                  id="tanggal"
                  type="date"
                  className="[color-scheme:dark]"
                  {...register("tanggal", { required: "Tanggal wajib diisi" })}
                />
                {errors.tanggal && (
                  <p className="text-sm text-destructive">{errors.tanggal.message}</p>
                )}
              </div>

              {/* Status */}
              <div className="grid gap-2">
                <label htmlFor="status">Status <span className="text-destructive">*</span></label>
                <Select
                  onValueChange={(value: FormValues['status']) => setValue("status", value)}
                  defaultValue={absensi?.status || "Hadir"}
                >
                  <SelectTrigger>
                    <SelectValue placeholder="Pilih status" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="Hadir">Hadir</SelectItem>
                    <SelectItem value="Terlambat">Terlambat</SelectItem>
                    <SelectItem value="Izin">Izin</SelectItem>
                    <SelectItem value="Sakit">Sakit</SelectItem>
                    <SelectItem value="Cuti">Cuti</SelectItem>
                    <SelectItem value="Tanpa Keterangan">Tanpa Keterangan</SelectItem>
                  </SelectContent>
                </Select>
              </div>
            </div>

            <div className="grid grid-cols-2 gap-4">
              {/* Waktu Masuk */}
              <div className="grid gap-2">
                <label htmlFor="waktu_masuk">Waktu Masuk</label>
                <Input
                  id="waktu_masuk"
                  type="time"
                  className="[color-scheme:dark]"
                  {...register("waktu_masuk")}
                />
              </div>

              {/* Waktu Keluar */}
              <div className="grid gap-2">
                <label htmlFor="waktu_keluar">Waktu Keluar</label>
                <Input
                  id="waktu_keluar"
                  type="time"
                  className="[color-scheme:dark]"
                  {...register("waktu_keluar")}
                />
              </div>
            </div>

            {/* Keterangan */}
            <div className="grid gap-2">
              <label htmlFor="keterangan">Keterangan</label>
              <Textarea
                id="keterangan"
                {...register("keterangan")}
                placeholder="Tambahkan keterangan jika diperlukan"
              />
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
              ) : absensi ? (
                "Simpan Perubahan"
              ) : (
                "Tambah Absensi"
              )}
            </Button>
          </div>
        </form>
      </DialogContent>
    </Dialog>
  );
} 