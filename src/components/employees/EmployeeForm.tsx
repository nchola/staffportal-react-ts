import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import * as z from "zod";

const employeeSchema = z.object({
  name: z.string().min(3, "Nama minimal 3 karakter"),
  nip: z.string().min(6, "NIP minimal 6 karakter"),
  email: z.string().email("Email tidak valid"),
  department: z.string().min(1, "Departemen wajib diisi"),
  position: z.string().min(1, "Jabatan wajib diisi"),
  joinDate: z.string().min(1, "Tanggal bergabung wajib diisi"),
  // Add more fields as needed
});

export function EmployeeForm({ 
  employee,
  onSubmit,
  onCancel 
}: EmployeeFormProps) {
  const form = useForm<z.infer<typeof employeeSchema>>({
    resolver: zodResolver(employeeSchema),
    defaultValues: employee || {
      name: "",
      nip: "",
      email: "",
      department: "",
      position: "",
      joinDate: new Date().toISOString().split("T")[0],
    },
  });

  return (
    <Form {...form}>
      <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-6">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          <FormField
            control={form.control}
            name="name"
            render={({ field }) => (
              <FormItem>
                <FormLabel>Nama Lengkap</FormLabel>
                <FormControl>
                  <Input {...field} />
                </FormControl>
                <FormMessage />
              </FormItem>
            )}
          />
          {/* Add more form fields */}
        </div>

        <div className="flex justify-end gap-3">
          <Button variant="outline" onClick={onCancel}>
            Batal
          </Button>
          <Button type="submit">
            {employee ? "Simpan Perubahan" : "Tambah Pegawai"}
          </Button>
        </div>
      </form>
    </Form>
  );
} 