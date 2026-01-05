# Panduan Membuat Template Surat dengan Kop Surat

## Cara Membuat Template Surat Formal

### 1. Siapkan File Word dengan Kop Surat

Buat file Word (.docx) dengan struktur seperti contoh surat resmi:

```
┌─────────────────────────────────────────┐
│  [LOGO]  PEMERINTAH KABUPATEN BANTUL   │
│          KAPANEWON IMOGIRI              │
│          Alamat: ...                    │
│          Telp: ... Email: ...           │
└─────────────────────────────────────────┘

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
{isi_surat}

Hormat kami,
Ketua Karang Taruna

[QR Code/Tanda Tangan]
```

### 2. Gunakan Placeholder

Gunakan placeholder dengan format `{nama_field}` di dalam template Word:

**Placeholder Standar (Otomatis diisi sistem):**
- `{nomor_surat}` - Nomor surat otomatis (SKATA/YYYY/MM/XXX)
- `{perihal}` - Perihal surat
- `{tujuan}` - Tujuan surat
- `{isi}` - Isi surat
- `{tanggal_surat}` - Tanggal surat (format: 13 November 2024)
- `{tanggal_surat_id}` - Tanggal surat Indonesia (13 November 2024)
- `{tanggal_surat_short}` - Tanggal pendek (13/11/2024)
- `{pembuat}` - Nama pembuat surat
- `{email_pembuat}` - Email pembuat

**Placeholder Custom (Didefinisikan admin):**
- `{nama_penerima}` - Nama penerima
- `{alamat_penerima}` - Alamat penerima
- `{tanggal_acara}` - Tanggal acara
- `{waktu_acara}` - Waktu acara
- dll (sesuai kebutuhan)

### 3. Upload Template di Admin

1. Login sebagai Admin
2. Masuk ke menu "Kelola Template"
3. Klik "Tambah Template"
4. Isi:
   - **Nama Template**: Contoh "Surat Undangan Rapat"
   - **Deskripsi**: Penjelasan singkat template
   - **File Template**: Upload file Word (.docx) yang sudah dibuat
5. **Tentukan Field yang Perlu Diisi User:**
   - Klik "+ Tambah Field"
   - Isi:
     - **Nama Field**: `nama_penerima` (harus sama dengan placeholder di Word)
     - **Label**: `Nama Penerima` (yang muncul di form)
     - **Tipe**: Pilih tipe field (Text, Textarea, Date, Number, Email)
     - **Required**: Centang jika wajib diisi
   - Ulangi untuk semua field yang ada di template
6. Aktifkan template
7. Simpan

### 4. User Membuat Surat

1. User login sebagai Anggota
2. Pilih "Template Surat"
3. Pilih template yang ingin digunakan
4. Klik "Gunakan"
5. Isi form yang muncul:
   - Perihal (wajib)
   - Tujuan
   - Tanggal Surat (wajib)
   - Isi Surat
   - Field-field custom sesuai yang didefinisikan admin
6. Klik "Generate Surat"
7. Sistem akan:
   - Generate nomor surat otomatis
   - Replace semua placeholder di template dengan data yang diisi
   - Generate file Word baru
   - Simpan ke arsip

### 5. Download Surat

Setelah surat dibuat, user bisa:
- Lihat detail surat
- Download file Word (.docx)
- Download file PDF (jika tersedia)

## Contoh Template Word

### Template Surat Undangan

```
PEMERINTAH KABUPATEN BANTUL
KAPANEWON IMOGIRI
KARANG TARUNA

Alamat: Jl. Contoh No. 123
Telp: (0274) 123456
Email: karangtaruna@example.com

═══════════════════════════════════════════════════════

Nomor    : {nomor_surat}
Sifat    : Penting
Lampiran : -
Hal      : {perihal}

Kepada Yth.
{nama_penerima}
{alamat_penerima}
di-
{tujuan}

Dengan hormat,

{isi}

Demikian surat undangan ini kami sampaikan, atas perhatian dan kehadirannya kami ucapkan terima kasih.

Hormat kami,
Ketua Karang Taruna

[QR Code]

───────────────────────────────────────────────────────
Tanggal: {tanggal_surat_id}
```

### Field yang Perlu Didefinisikan:

1. **nama_penerima** (Text, Required)
2. **alamat_penerima** (Textarea, Required)
3. **isi** (Textarea, Required) - atau bisa pakai field standar "isi"

## Tips

1. **Kop Surat**: Buat kop surat di Word dengan logo, nama instansi, alamat, dll. Semua ini akan tetap ada di setiap surat yang di-generate.

2. **Placeholder**: Pastikan nama placeholder di Word sama persis dengan nama field yang didefinisikan (case-sensitive).

3. **Format Tanggal**: Gunakan `{tanggal_surat_id}` untuk format Indonesia (13 November 2024).

4. **Testing**: Setelah upload template, coba buat surat test untuk memastikan semua placeholder ter-replace dengan benar.

5. **Backup**: Simpan file template asli sebagai backup.

## Troubleshooting

**Q: Placeholder tidak ter-replace?**
A: Pastikan nama placeholder di Word sama persis dengan nama field (tanpa spasi, gunakan underscore).

**Q: Format tanggal tidak sesuai?**
A: Gunakan placeholder yang tepat:
- `{tanggal_surat}` - Format default
- `{tanggal_surat_id}` - Format Indonesia
- `{tanggal_surat_short}` - Format pendek

**Q: File tidak ter-generate?**
A: Pastikan file template valid (.docx), tidak corrupt, dan semua placeholder menggunakan format `{nama_field}`.








