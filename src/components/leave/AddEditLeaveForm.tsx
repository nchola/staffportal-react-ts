import { useForm } from "react-hook-form";
import { useMutation, useQuery } from "@tanstack/react-query";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { addLeave, type Leave } from "@/integrations/leaveApi";
import { getPegawaiList } from "@/integrations/pegawaiApi";
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

interface Props {
  leave?: Leave | null;
  open: boolean;
  onClose: () => void;
  onSuccess: () => void;
}

export default function AddEditLeaveForm({ leave, open, onClose, onSuccess }: Props) {
  const { toast } = useToast();
  const { register, handleSubmit, formState: { errors }, reset, setValue } = useForm<Leave>({
    defaultValues: leave || {
      status: 'Diajukan'
    }
  });

  const { data: pegawaiList } = useQuery({
    queryKey: ["pegawai-list-all"],
    queryFn: () => getPegawaiList(1, 100),
  });

  const mutation = useMutation({
    mutationFn: (data: Omit<Leave, 'id' | 'created_at' | 'updated_at'>) => {
      return addLeave(data);
    },
    onSuccess: () => {
      toast({
        title: "Berhasil mengajukan cuti",
        variant: "default",
      });
      onSuccess();
      onClose();
      reset();
    },
    onError: (error) => {
      toast({
        title: "Gagal mengajukan cuti",
        description: error instanceof Error ? error.message : "Terjadi kesalahan",
        variant: "destructive",
      });
    },
  });

  return (
    <Dialog open={open} onOpenChange={onClose}>
      <DialogContent className="sm:max-w-[600px]">
        <DialogHeader>
          <DialogTitle>
            Ajukan Cuti
          </DialogTitle>
          <DialogDescription>
            Isi form pengajuan cuti di bawah ini
          </DialogDescription>
        </DialogHeader>
        <form onSubmit={handleSubmit((data) => mutation.mutate(data))}>
          <div className="grid gap-4 py-4">
            {/* Pegawai */}
            <div className="grid gap-2">
              <label htmlFor="pegawai_id">Pegawai <span className="text-destructive">*</span></label>
              <Select
                onValueChange={(value) => setValue("pegawai_id", value)}
                defaultValue={leave?.pegawai_id}
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

            {/* Jenis Cuti */}
            <div className="grid gap-2">
              <label htmlFor="jenis_cuti">Jenis Cuti <span className="text-destructive">*</span></label>
              <Select
                onValueChange={(value) => setValue("jenis_cuti", value as Leave['jenis_cuti'])}
                defaultValue={leave?.jenis_cuti}
              >
                <SelectTrigger>
                  <SelectValue placeholder="Pilih jenis cuti" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="Tahunan">Cuti Tahunan</SelectItem>
                  <SelectItem value="Sakit">Cuti Sakit</SelectItem>
                  <SelectItem value="Melahirkan">Cuti Melahirkan</SelectItem>
                  <SelectItem value="Penting">Cuti Penting</SelectItem>
                </SelectContent>
              </Select>
              {errors.jenis_cuti && (
                <p className="text-sm text-destructive">{errors.jenis_cuti.message}</p>
              )}
            </div>

            <div className="grid grid-cols-2 gap-4">
              {/* Tanggal Mulai */}
              <div className="grid gap-2">
                <label htmlFor="tanggal_mulai">Tanggal Mulai <span className="text-destructive">*</span></label>
                <Input
                  id="tanggal_mulai"
                  type="date"
                  {...register("tanggal_mulai", { required: "Tanggal mulai wajib diisi" })}
                />
                {errors.tanggal_mulai && (
                  <p className="text-sm text-destructive">{errors.tanggal_mulai.message}</p>
                )}
              </div>

              {/* Tanggal Selesai */}
              <div className="grid gap-2">
                <label htmlFor="tanggal_selesai">Tanggal Selesai <span className="text-destructive">*</span></label>
                <Input
                  id="tanggal_selesai"
                  type="date"
                  {...register("tanggal_selesai", { required: "Tanggal selesai wajib diisi" })}
                />
                {errors.tanggal_selesai && (
                  <p className="text-sm text-destructive">{errors.tanggal_selesai.message}</p>
                )}
              </div>
            </div>

            {/* Alasan */}
            <div className="grid gap-2">
              <label htmlFor="alasan">Alasan <span className="text-destructive">*</span></label>
              <Textarea
                id="alasan"
                {...register("alasan", { required: "Alasan wajib diisi" })}
                placeholder="Tuliskan alasan pengajuan cuti"
              />
              {errors.alasan && (
                <p className="text-sm text-destructive">{errors.alasan.message}</p>
              )}
            </div>

            <div className="flex justify-end gap-2 mt-6">
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
                ) : (
                  "Ajukan Cuti"
                )}
              </Button>
            </div>
          </div>
        </form>
      </DialogContent>
    </Dialog>
  );
} 