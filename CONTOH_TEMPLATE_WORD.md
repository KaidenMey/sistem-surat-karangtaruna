# Contoh Template Word untuk Surat Formal

## Struktur Template dengan Kop Surat

Berikut adalah contoh lengkap template Word yang bisa Anda gunakan:

```
┌─────────────────────────────────────────────────────────────┐
│                                                             │
│  [LOGO KARANG TARUNA]                                      │
│                                                             │
│  PEMERINTAH KABUPATEN BANTUL                               │
│  KAPANEWON IMOGIRI                                         │
│  KARANG TARUNA                                             │
│                                                             │
│  Alamat: Jl. Contoh No. 123, Imogiri, Bantul              │
│  Telepon: (0274) 123456                                    │
│  Email: karangtaruna@example.com                           │
│  Website: www.karangtaruna.example.com                     │
│                                                             │
└─────────────────────────────────────────────────────────────┘

═══════════════════════════════════════════════════════════════

Nomor    : {nomor_surat}
Sifat    : Biasa
Lampiran : -
Hal      : {perihal}

Kepada Yth.
{nama_penerima}
{alamat_penerima}
di-
{tujuan}

Dengan hormat,

{isi}

Demikian surat ini kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.

Hormat kami,
Ketua Karang Taruna

[QR Code / Tanda Tangan]

───────────────────────────────────────────────────────────────
Tanggal: {tanggal_surat_id}
```

## Field yang Perlu Didefinisikan di Sistem

Saat upload template ini, admin perlu define field-field berikut:

1. **nama_penerima** (Text, Required)
   - Label: "Nama Penerima"
   - Placeholder di Word: `{nama_penerima}`

2. **alamat_penerima** (Textarea, Required)
   - Label: "Alamat Penerima"
   - Placeholder di Word: `{alamat_penerima}`

## Placeholder Standar (Otomatis)

Field-field ini otomatis diisi sistem, tidak perlu didefinisikan:
- `{nomor_surat}` → SKATA/2024/11/001
- `{perihal}` → Perihal surat
- `{tujuan}` → Tujuan surat
- `{isi}` → Isi surat
- `{tanggal_surat}` → 13 November 2024
- `{tanggal_surat_id}` → 13 November 2024 (format Indonesia)
- `{tanggal_surat_short}` → 13/11/2024
- `{pembuat}` → Nama pembuat
- `{email_pembuat}` → Email pembuat

## Tips Membuat Template

1. **Kop Surat**: Buat kop surat dengan lengkap di Word, termasuk logo, nama instansi, alamat, kontak. Semua ini akan tetap ada di setiap surat.

2. **Formatting**: Gunakan formatting Word yang baik (bold, italic, alignment) untuk kop surat agar terlihat profesional.

3. **Placeholder**: Gunakan format `{nama_field}` dengan kurung kurawal. Pastikan tidak ada spasi di dalam placeholder.

4. **Testing**: Setelah upload, coba buat surat test untuk memastikan semua placeholder ter-replace dengan benar.

5. **Backup**: Simpan file template asli sebagai backup sebelum upload.








