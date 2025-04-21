import { useForm } from "react-hook-form";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { addPegawai, editPegawai } from "@/integrations/pegawaiApi";
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { toast } from "@/hooks/use-toast";

type Pegawai = {
  id?: string;
  nip: string;
  nama_lengkap: string;
  email?: string;
  tanggal_bergabung: string;
};

type Props = {
  pegawai?: Pegawai|null;
  onClose: () => void;
  onSuccess: () => void;
};

export default function AddEditEmployeeForm({ pegawai, onClose, onSuccess }: Props) {
  const queryClient = useQueryClient();
  const { register, handleSubmit, formState: { errors, isSubmitting } } = useForm<Pegawai>({
    defaultValues: pegawai || {
      nip: "",
      nama_lengkap: "",
      email: "",
      tanggal_bergabung: "",
    }
  });

  // Using useMutation with better error handling
  const mutation = useMutation({
    mutationFn: async (data: Pegawai) => {
      if (pegawai?.id) {
        return await editPegawai(pegawai.id, data);
      } else {
        return await addPegawai(data);
      }
    },
    onSuccess: () => {
      // Immediately invalidate to refresh the data
      queryClient.invalidateQueries({ queryKey: ["pegawai"] });
      toast({ title: "Sukses", description: `Data pegawai berhasil disimpan.` });
      onSuccess();
    },
    onError: (err: any) => {
      toast({ title: "Gagal", description: err?.message || "Terjadi kesalahan", variant: "destructive" });
    }
  });

  return (
    <div className="fixed inset-0 bg-black/30 flex items-center justify-center z-50">
      <div className="bg-white rounded-lg shadow-md p-6 w-full max-w-md">
        <h3 className="text-lg font-semibold mb-3">{pegawai ? "Edit Pegawai" : "Tambah Pegawai"}</h3>
        <form onSubmit={handleSubmit(data => mutation.mutate(data))} className="space-y-3">
          <div>
            <label className="block mb-1">NIP <span className="text-red-500">*</span></label>
            <Input {...register("nip", { required: "NIP wajib diisi" })} disabled={!!pegawai?.id} />
            {errors.nip && <span className="text-sm text-red-500">{errors.nip.message}</span>}
          </div>
          <div>
            <label className="block mb-1">Nama Lengkap <span className="text-red-500">*</span></label>
            <Input {...register("nama_lengkap", { required: "Nama wajib diisi" })} />
            {errors.nama_lengkap && <span className="text-sm text-red-500">{errors.nama_lengkap.message}</span>}
          </div>
          <div>
            <label className="block mb-1">Email</label>
            <Input {...register("email")} />
          </div>
          <div>
            <label className="block mb-1">Tanggal Bergabung <span className="text-red-500">*</span></label>
            <Input type="date" {...register("tanggal_bergabung", { required: "Tanggal bergabung wajib diisi" })} />
            {errors.tanggal_bergabung && <span className="text-sm text-red-500">{errors.tanggal_bergabung.message}</span>}
          </div>
          <div className="flex gap-2 mt-4">
            <Button type="submit" disabled={isSubmitting}>
              {pegawai ? "Simpan Perubahan" : "Tambah"}
            </Button>
            <Button type="button" variant="outline" onClick={onClose} disabled={isSubmitting}>
              Batal
            </Button>
          </div>
        </form>
      </div>
    </div>
  );
}
