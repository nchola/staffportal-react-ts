export type Json =
  | string
  | number
  | boolean
  | null
  | { [key: string]: Json | undefined }
  | Json[]

export type Database = {
  public: {
    Tables: {
      absensi: {
        Row: {
          created_at: string
          id: string
          keterangan: string | null
          pegawai_id: string | null
          status: string | null
          tanggal: string
          updated_at: string
          waktu_keluar: string | null
          waktu_masuk: string | null
        }
        Insert: {
          created_at?: string
          id?: string
          keterangan?: string | null
          pegawai_id?: string | null
          status?: string | null
          tanggal: string
          updated_at?: string
          waktu_keluar?: string | null
          waktu_masuk?: string | null
        }
        Update: {
          created_at?: string
          id?: string
          keterangan?: string | null
          pegawai_id?: string | null
          status?: string | null
          tanggal?: string
          updated_at?: string
          waktu_keluar?: string | null
          waktu_masuk?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "absensi_pegawai_id_fkey"
            columns: ["pegawai_id"]
            isOneToOne: false
            referencedRelation: "pegawai"
            referencedColumns: ["id"]
          },
        ]
      }
      cuti: {
        Row: {
          alasan: string
          created_at: string
          id: string
          jenis_cuti: string
          keterangan: string | null
          pegawai_id: string | null
          status: string | null
          tanggal_mulai: string
          tanggal_selesai: string
          tanggal_verifikasi: string | null
          updated_at: string
          verifikasi_oleh: string | null
        }
        Insert: {
          alasan: string
          created_at?: string
          id?: string
          jenis_cuti: string
          keterangan?: string | null
          pegawai_id?: string | null
          status?: string | null
          tanggal_mulai: string
          tanggal_selesai: string
          tanggal_verifikasi?: string | null
          updated_at?: string
          verifikasi_oleh?: string | null
        }
        Update: {
          alasan?: string
          created_at?: string
          id?: string
          jenis_cuti?: string
          keterangan?: string | null
          pegawai_id?: string | null
          status?: string | null
          tanggal_mulai?: string
          tanggal_selesai?: string
          tanggal_verifikasi?: string | null
          updated_at?: string
          verifikasi_oleh?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "cuti_pegawai_id_fkey"
            columns: ["pegawai_id"]
            isOneToOne: false
            referencedRelation: "pegawai"
            referencedColumns: ["id"]
          },
        ]
      }
      departemen: {
        Row: {
          created_at: string
          deskripsi: string | null
          id: string
          nama: string
          updated_at: string
        }
        Insert: {
          created_at?: string
          deskripsi?: string | null
          id?: string
          nama: string
          updated_at?: string
        }
        Update: {
          created_at?: string
          deskripsi?: string | null
          id?: string
          nama?: string
          updated_at?: string
        }
        Relationships: []
      }
      hukuman: {
        Row: {
          created_at: string
          deskripsi: string
          id: string
          jenis_hukuman: string
          keterangan: string | null
          pegawai_id: string | null
          sanksi: string | null
          status: string | null
          tanggal: string
          tanggal_verifikasi: string | null
          updated_at: string
          verifikasi_oleh: string | null
        }
        Insert: {
          created_at?: string
          deskripsi: string
          id?: string
          jenis_hukuman: string
          keterangan?: string | null
          pegawai_id?: string | null
          sanksi?: string | null
          status?: string | null
          tanggal: string
          tanggal_verifikasi?: string | null
          updated_at?: string
          verifikasi_oleh?: string | null
        }
        Update: {
          created_at?: string
          deskripsi?: string
          id?: string
          jenis_hukuman?: string
          keterangan?: string | null
          pegawai_id?: string | null
          sanksi?: string | null
          status?: string | null
          tanggal?: string
          tanggal_verifikasi?: string | null
          updated_at?: string
          verifikasi_oleh?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "hukuman_pegawai_id_fkey"
            columns: ["pegawai_id"]
            isOneToOne: false
            referencedRelation: "pegawai"
            referencedColumns: ["id"]
          },
        ]
      }
      jabatan: {
        Row: {
          created_at: string
          departemen_id: string | null
          deskripsi: string | null
          id: string
          level: number
          nama: string
          updated_at: string
        }
        Insert: {
          created_at?: string
          departemen_id?: string | null
          deskripsi?: string | null
          id?: string
          level: number
          nama: string
          updated_at?: string
        }
        Update: {
          created_at?: string
          departemen_id?: string | null
          deskripsi?: string | null
          id?: string
          level?: number
          nama?: string
          updated_at?: string
        }
        Relationships: [
          {
            foreignKeyName: "jabatan_departemen_id_fkey"
            columns: ["departemen_id"]
            isOneToOne: false
            referencedRelation: "departemen"
            referencedColumns: ["id"]
          },
        ]
      }
      lamaran: {
        Row: {
          alamat: string | null
          catatan: string | null
          created_at: string
          email: string
          id: string
          nama_pelamar: string
          no_telepon: string | null
          pendidikan_terakhir: string | null
          pengalaman_kerja: string | null
          rekrutmen_id: string | null
          resume_url: string | null
          status: string | null
          updated_at: string
        }
        Insert: {
          alamat?: string | null
          catatan?: string | null
          created_at?: string
          email: string
          id?: string
          nama_pelamar: string
          no_telepon?: string | null
          pendidikan_terakhir?: string | null
          pengalaman_kerja?: string | null
          rekrutmen_id?: string | null
          resume_url?: string | null
          status?: string | null
          updated_at?: string
        }
        Update: {
          alamat?: string | null
          catatan?: string | null
          created_at?: string
          email?: string
          id?: string
          nama_pelamar?: string
          no_telepon?: string | null
          pendidikan_terakhir?: string | null
          pengalaman_kerja?: string | null
          rekrutmen_id?: string | null
          resume_url?: string | null
          status?: string | null
          updated_at?: string
        }
        Relationships: [
          {
            foreignKeyName: "lamaran_rekrutmen_id_fkey"
            columns: ["rekrutmen_id"]
            isOneToOne: false
            referencedRelation: "rekrutmen"
            referencedColumns: ["id"]
          },
        ]
      }
      mutasi: {
        Row: {
          alasan: string
          created_at: string
          departemen_baru_id: string | null
          departemen_lama_id: string | null
          id: string
          jabatan_baru_id: string | null
          jabatan_lama_id: string | null
          keterangan: string | null
          pegawai_id: string | null
          status: string | null
          tanggal_efektif: string
          tanggal_verifikasi: string | null
          updated_at: string
          verifikasi_oleh: string | null
        }
        Insert: {
          alasan: string
          created_at?: string
          departemen_baru_id?: string | null
          departemen_lama_id?: string | null
          id?: string
          jabatan_baru_id?: string | null
          jabatan_lama_id?: string | null
          keterangan?: string | null
          pegawai_id?: string | null
          status?: string | null
          tanggal_efektif: string
          tanggal_verifikasi?: string | null
          updated_at?: string
          verifikasi_oleh?: string | null
        }
        Update: {
          alasan?: string
          created_at?: string
          departemen_baru_id?: string | null
          departemen_lama_id?: string | null
          id?: string
          jabatan_baru_id?: string | null
          jabatan_lama_id?: string | null
          keterangan?: string | null
          pegawai_id?: string | null
          status?: string | null
          tanggal_efektif?: string
          tanggal_verifikasi?: string | null
          updated_at?: string
          verifikasi_oleh?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "mutasi_departemen_baru_id_fkey"
            columns: ["departemen_baru_id"]
            isOneToOne: false
            referencedRelation: "departemen"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "mutasi_departemen_lama_id_fkey"
            columns: ["departemen_lama_id"]
            isOneToOne: false
            referencedRelation: "departemen"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "mutasi_jabatan_baru_id_fkey"
            columns: ["jabatan_baru_id"]
            isOneToOne: false
            referencedRelation: "jabatan"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "mutasi_jabatan_lama_id_fkey"
            columns: ["jabatan_lama_id"]
            isOneToOne: false
            referencedRelation: "jabatan"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "mutasi_pegawai_id_fkey"
            columns: ["pegawai_id"]
            isOneToOne: false
            referencedRelation: "pegawai"
            referencedColumns: ["id"]
          },
        ]
      }
      pegawai: {
        Row: {
          agama: string | null
          alamat: string | null
          created_at: string
          departemen_id: string | null
          email: string | null
          id: string
          jabatan_id: string | null
          jenis_kelamin: string | null
          nama_lengkap: string
          nip: string
          no_telepon: string | null
          pendidikan_terakhir: string | null
          status: string | null
          status_pernikahan: string | null
          tanggal_bergabung: string
          tanggal_lahir: string | null
          tempat_lahir: string | null
          updated_at: string
          user_id: string | null
        }
        Insert: {
          agama?: string | null
          alamat?: string | null
          created_at?: string
          departemen_id?: string | null
          email?: string | null
          id?: string
          jabatan_id?: string | null
          jenis_kelamin?: string | null
          nama_lengkap: string
          nip: string
          no_telepon?: string | null
          pendidikan_terakhir?: string | null
          status?: string | null
          status_pernikahan?: string | null
          tanggal_bergabung: string
          tanggal_lahir?: string | null
          tempat_lahir?: string | null
          updated_at?: string
          user_id?: string | null
        }
        Update: {
          agama?: string | null
          alamat?: string | null
          created_at?: string
          departemen_id?: string | null
          email?: string | null
          id?: string
          jabatan_id?: string | null
          jenis_kelamin?: string | null
          nama_lengkap?: string
          nip?: string
          no_telepon?: string | null
          pendidikan_terakhir?: string | null
          status?: string | null
          status_pernikahan?: string | null
          tanggal_bergabung?: string
          tanggal_lahir?: string | null
          tempat_lahir?: string | null
          updated_at?: string
          user_id?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "pegawai_departemen_id_fkey"
            columns: ["departemen_id"]
            isOneToOne: false
            referencedRelation: "departemen"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "pegawai_jabatan_id_fkey"
            columns: ["jabatan_id"]
            isOneToOne: false
            referencedRelation: "jabatan"
            referencedColumns: ["id"]
          },
        ]
      }
      penghargaan: {
        Row: {
          created_at: string
          deskripsi: string
          id: string
          jenis_penghargaan: string
          keterangan: string | null
          nilai_penghargaan: number | null
          pegawai_id: string | null
          status: string | null
          tanggal: string
          tanggal_verifikasi: string | null
          updated_at: string
          verifikasi_oleh: string | null
        }
        Insert: {
          created_at?: string
          deskripsi: string
          id?: string
          jenis_penghargaan: string
          keterangan?: string | null
          nilai_penghargaan?: number | null
          pegawai_id?: string | null
          status?: string | null
          tanggal: string
          tanggal_verifikasi?: string | null
          updated_at?: string
          verifikasi_oleh?: string | null
        }
        Update: {
          created_at?: string
          deskripsi?: string
          id?: string
          jenis_penghargaan?: string
          keterangan?: string | null
          nilai_penghargaan?: number | null
          pegawai_id?: string | null
          status?: string | null
          tanggal?: string
          tanggal_verifikasi?: string | null
          updated_at?: string
          verifikasi_oleh?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "penghargaan_pegawai_id_fkey"
            columns: ["pegawai_id"]
            isOneToOne: false
            referencedRelation: "pegawai"
            referencedColumns: ["id"]
          },
        ]
      }
      phk: {
        Row: {
          alasan: string
          created_at: string
          id: string
          keterangan: string | null
          kompensasi: number | null
          pegawai_id: string | null
          status: string | null
          tanggal_efektif: string
          tanggal_verifikasi: string | null
          updated_at: string
          verifikasi_oleh: string | null
        }
        Insert: {
          alasan: string
          created_at?: string
          id?: string
          keterangan?: string | null
          kompensasi?: number | null
          pegawai_id?: string | null
          status?: string | null
          tanggal_efektif: string
          tanggal_verifikasi?: string | null
          updated_at?: string
          verifikasi_oleh?: string | null
        }
        Update: {
          alasan?: string
          created_at?: string
          id?: string
          keterangan?: string | null
          kompensasi?: number | null
          pegawai_id?: string | null
          status?: string | null
          tanggal_efektif?: string
          tanggal_verifikasi?: string | null
          updated_at?: string
          verifikasi_oleh?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "phk_pegawai_id_fkey"
            columns: ["pegawai_id"]
            isOneToOne: false
            referencedRelation: "pegawai"
            referencedColumns: ["id"]
          },
        ]
      }
      profiles: {
        Row: {
          created_at: string
          email: string | null
          foto_url: string | null
          id: string
          nama: string | null
          no_telepon: string | null
          role: string | null
          updated_at: string
        }
        Insert: {
          created_at?: string
          email?: string | null
          foto_url?: string | null
          id: string
          nama?: string | null
          no_telepon?: string | null
          role?: string | null
          updated_at?: string
        }
        Update: {
          created_at?: string
          email?: string | null
          foto_url?: string | null
          id?: string
          nama?: string | null
          no_telepon?: string | null
          role?: string | null
          updated_at?: string
        }
        Relationships: []
      }
      promosi: {
        Row: {
          alasan: string
          created_at: string
          id: string
          jabatan_baru_id: string | null
          jabatan_lama_id: string | null
          keterangan: string | null
          pegawai_id: string | null
          status: string | null
          tanggal_efektif: string
          tanggal_verifikasi: string | null
          updated_at: string
          verifikasi_oleh: string | null
        }
        Insert: {
          alasan: string
          created_at?: string
          id?: string
          jabatan_baru_id?: string | null
          jabatan_lama_id?: string | null
          keterangan?: string | null
          pegawai_id?: string | null
          status?: string | null
          tanggal_efektif: string
          tanggal_verifikasi?: string | null
          updated_at?: string
          verifikasi_oleh?: string | null
        }
        Update: {
          alasan?: string
          created_at?: string
          id?: string
          jabatan_baru_id?: string | null
          jabatan_lama_id?: string | null
          keterangan?: string | null
          pegawai_id?: string | null
          status?: string | null
          tanggal_efektif?: string
          tanggal_verifikasi?: string | null
          updated_at?: string
          verifikasi_oleh?: string | null
        }
        Relationships: [
          {
            foreignKeyName: "promosi_jabatan_baru_id_fkey"
            columns: ["jabatan_baru_id"]
            isOneToOne: false
            referencedRelation: "jabatan"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "promosi_jabatan_lama_id_fkey"
            columns: ["jabatan_lama_id"]
            isOneToOne: false
            referencedRelation: "jabatan"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "promosi_pegawai_id_fkey"
            columns: ["pegawai_id"]
            isOneToOne: false
            referencedRelation: "pegawai"
            referencedColumns: ["id"]
          },
        ]
      }
      rekrutmen: {
        Row: {
          created_at: string
          departemen_id: string | null
          deskripsi: string
          id: string
          jabatan_id: string | null
          judul: string
          kualifikasi: string
          pembuat_id: string | null
          status: string | null
          tanggal_buka: string
          tanggal_tutup: string
          updated_at: string
        }
        Insert: {
          created_at?: string
          departemen_id?: string | null
          deskripsi: string
          id?: string
          jabatan_id?: string | null
          judul: string
          kualifikasi: string
          pembuat_id?: string | null
          status?: string | null
          tanggal_buka: string
          tanggal_tutup: string
          updated_at?: string
        }
        Update: {
          created_at?: string
          departemen_id?: string | null
          deskripsi?: string
          id?: string
          jabatan_id?: string | null
          judul?: string
          kualifikasi?: string
          pembuat_id?: string | null
          status?: string | null
          tanggal_buka?: string
          tanggal_tutup?: string
          updated_at?: string
        }
        Relationships: [
          {
            foreignKeyName: "rekrutmen_departemen_id_fkey"
            columns: ["departemen_id"]
            isOneToOne: false
            referencedRelation: "departemen"
            referencedColumns: ["id"]
          },
          {
            foreignKeyName: "rekrutmen_jabatan_id_fkey"
            columns: ["jabatan_id"]
            isOneToOne: false
            referencedRelation: "jabatan"
            referencedColumns: ["id"]
          },
        ]
      }
    }
    Views: {
      [_ in never]: never
    }
    Functions: {
      [_ in never]: never
    }
    Enums: {
      [_ in never]: never
    }
    CompositeTypes: {
      [_ in never]: never
    }
  }
}

type DefaultSchema = Database[Extract<keyof Database, "public">]

export type Tables<
  DefaultSchemaTableNameOrOptions extends
    | keyof (DefaultSchema["Tables"] & DefaultSchema["Views"])
    | { schema: keyof Database },
  TableName extends DefaultSchemaTableNameOrOptions extends {
    schema: keyof Database
  }
    ? keyof (Database[DefaultSchemaTableNameOrOptions["schema"]]["Tables"] &
        Database[DefaultSchemaTableNameOrOptions["schema"]]["Views"])
    : never = never,
> = DefaultSchemaTableNameOrOptions extends { schema: keyof Database }
  ? (Database[DefaultSchemaTableNameOrOptions["schema"]]["Tables"] &
      Database[DefaultSchemaTableNameOrOptions["schema"]]["Views"])[TableName] extends {
      Row: infer R
    }
    ? R
    : never
  : DefaultSchemaTableNameOrOptions extends keyof (DefaultSchema["Tables"] &
        DefaultSchema["Views"])
    ? (DefaultSchema["Tables"] &
        DefaultSchema["Views"])[DefaultSchemaTableNameOrOptions] extends {
        Row: infer R
      }
      ? R
      : never
    : never

export type TablesInsert<
  DefaultSchemaTableNameOrOptions extends
    | keyof DefaultSchema["Tables"]
    | { schema: keyof Database },
  TableName extends DefaultSchemaTableNameOrOptions extends {
    schema: keyof Database
  }
    ? keyof Database[DefaultSchemaTableNameOrOptions["schema"]]["Tables"]
    : never = never,
> = DefaultSchemaTableNameOrOptions extends { schema: keyof Database }
  ? Database[DefaultSchemaTableNameOrOptions["schema"]]["Tables"][TableName] extends {
      Insert: infer I
    }
    ? I
    : never
  : DefaultSchemaTableNameOrOptions extends keyof DefaultSchema["Tables"]
    ? DefaultSchema["Tables"][DefaultSchemaTableNameOrOptions] extends {
        Insert: infer I
      }
      ? I
      : never
    : never

export type TablesUpdate<
  DefaultSchemaTableNameOrOptions extends
    | keyof DefaultSchema["Tables"]
    | { schema: keyof Database },
  TableName extends DefaultSchemaTableNameOrOptions extends {
    schema: keyof Database
  }
    ? keyof Database[DefaultSchemaTableNameOrOptions["schema"]]["Tables"]
    : never = never,
> = DefaultSchemaTableNameOrOptions extends { schema: keyof Database }
  ? Database[DefaultSchemaTableNameOrOptions["schema"]]["Tables"][TableName] extends {
      Update: infer U
    }
    ? U
    : never
  : DefaultSchemaTableNameOrOptions extends keyof DefaultSchema["Tables"]
    ? DefaultSchema["Tables"][DefaultSchemaTableNameOrOptions] extends {
        Update: infer U
      }
      ? U
      : never
    : never

export type Enums<
  DefaultSchemaEnumNameOrOptions extends
    | keyof DefaultSchema["Enums"]
    | { schema: keyof Database },
  EnumName extends DefaultSchemaEnumNameOrOptions extends {
    schema: keyof Database
  }
    ? keyof Database[DefaultSchemaEnumNameOrOptions["schema"]]["Enums"]
    : never = never,
> = DefaultSchemaEnumNameOrOptions extends { schema: keyof Database }
  ? Database[DefaultSchemaEnumNameOrOptions["schema"]]["Enums"][EnumName]
  : DefaultSchemaEnumNameOrOptions extends keyof DefaultSchema["Enums"]
    ? DefaultSchema["Enums"][DefaultSchemaEnumNameOrOptions]
    : never

export type CompositeTypes<
  PublicCompositeTypeNameOrOptions extends
    | keyof DefaultSchema["CompositeTypes"]
    | { schema: keyof Database },
  CompositeTypeName extends PublicCompositeTypeNameOrOptions extends {
    schema: keyof Database
  }
    ? keyof Database[PublicCompositeTypeNameOrOptions["schema"]]["CompositeTypes"]
    : never = never,
> = PublicCompositeTypeNameOrOptions extends { schema: keyof Database }
  ? Database[PublicCompositeTypeNameOrOptions["schema"]]["CompositeTypes"][CompositeTypeName]
  : PublicCompositeTypeNameOrOptions extends keyof DefaultSchema["CompositeTypes"]
    ? DefaultSchema["CompositeTypes"][PublicCompositeTypeNameOrOptions]
    : never

export const Constants = {
  public: {
    Enums: {},
  },
} as const
