# Cara Menggunakan Template Surat dengan Kop Surat Formal

## Konsep Dasar

Sistem ini dirancang untuk memudahkan pembuatan surat formal dengan kop surat. Admin hanya perlu:
1. **Upload file Word** yang sudah memiliki kop surat dan struktur surat lengkap
2. **Tentukan field-field** yang perlu diisi user (dengan form builder yang mudah)
3. Sistem akan **otomatis generate surat** dengan mengganti placeholder

## Langkah-Langkah Detail

### **A. Untuk Admin: Membuat Template**

#### 1. Siapkan File Word dengan Kop Surat

Buat file Word (.docx) dengan struktur lengkap termasuk:
- ✅ Kop surat dengan logo, nama instansi, alamat, kontak
- ✅ Nomor surat, sifat, lampiran, hal
- ✅ Penerima surat
- ✅ Isi surat
- ✅ Tanda tangan, QR code, dll

**Contoh struktur di Word:**

```
┌─────────────────────────────────────────────┐
│  [LOGO]                                     │
│  PEMERINTAH KABUPATEN BANTUL                │
│  KAPANEWON IMOGIRI                          │
│  KARANG TARUNA                              │
│                                             │
│  Alamat: Jl. Contoh No. 123                 │
│  Telp: (0274) 123456                        │
│  Email: karangtaruna@example.com            │
└─────────────────────────────────────────────┘

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

Demikian surat ini kami sampaikan, atas perhatiannya kami ucapkan terima kasih.

Hormat kami,
Ketua Karang Taruna

───────────────────────────────────────────────
Tanggal: {tanggal_surat_id}
```

#### 2. Gunakan Placeholder

Gunakan placeholder dengan format `{nama_field}` untuk bagian yang akan diisi user:

**Placeholder Standar (Otomatis):**
- `{nomor_surat}` → SKATA/2024/11/001
- `{perihal}` → Perihal surat
- `{tujuan}` → Tujuan surat
- `{isi}` → Isi surat
- `{tanggal_surat}` → 13 November 2024
- `{tanggal_surat_id}` → 13 November 2024 (format Indonesia)
- `{tanggal_surat_short}` → 13/11/2024
- `{pembuat}` → Nama pembuat
- `{email_pembuat}` → Email pembuat

**Placeholder Custom (Didefinisikan admin):**
- `{nama_penerima}` → Nama penerima
- `{alamat_penerima}` → Alamat penerima
- `{tanggal_acara}` → Tanggal acara
- dll (sesuai kebutuhan)

#### 3. Upload Template di Sistem

1. Login sebagai **Admin**
2. Masuk ke menu **"Kelola Template"**
3. Klik **"Tambah Template"**
4. Isi form:
   - **Nama Template**: Contoh "Surat Undangan Rapat"
   - **Deskripsi**: Penjelasan template
   - **File Template**: Upload file Word (.docx) yang sudah dibuat
5. **Tentukan Field yang Perlu Diisi User:**
   
   Klik **"+ Tambah Field"** untuk setiap field yang ada di template:
   
   **Contoh untuk field `nama_penerima`:**
   - Nama Field: `nama_penerima` (harus sama dengan placeholder di Word)
   - Label: `Nama Penerima` (yang muncul di form user)
   - Tipe: `Text`
   - Required: ✅ (centang jika wajib)
   
   **Contoh untuk field `alamat_penerima`:**
   - Nama Field: `alamat_penerima`
   - Label: `Alamat Penerima`
   - Tipe: `Textarea`
   - Required: ✅
   
   **Contoh untuk field `tanggal_acara`:**
   - Nama Field: `tanggal_acara`
   - Label: `Tanggal Acara`
   - Tipe: `Date`
   - Required: ✅
6. Aktifkan template
7. **Simpan**

### **B. Untuk User/Anggota: Membuat Surat**

1. Login sebagai **Anggota**
2. Masuk ke menu **"Template Surat"**
3. Pilih template yang ingin digunakan
4. Klik **"Gunakan"**
5. Isi form yang muncul:
   - **Perihal** (wajib)
   - **Tujuan**
   - **Tanggal Surat** (wajib)
   - **Isi Surat**
   - **Field-field custom** sesuai yang didefinisikan admin (contoh: Nama Penerima, Alamat Penerima, dll)
6. Klik **"Generate Surat"**
7. Sistem akan:
   - ✅ Generate nomor surat otomatis
   - ✅ Replace semua placeholder di template dengan data yang diisi
   - ✅ Generate file Word baru dengan kop surat tetap utuh
   - ✅ Simpan ke arsip
8. Download surat yang sudah jadi (Word/PDF)

## Keuntungan Sistem Ini

✅ **User-Friendly untuk Admin:**
- Hanya perlu upload file Word yang sudah ada
- Form builder yang mudah untuk define field
- Tidak perlu coding atau technical knowledge

✅ **User-Friendly untuk User:**
- Form yang jelas dan mudah diisi
- Tidak perlu tahu struktur surat
- Cukup isi data, sistem yang generate

✅ **Fleksibel:**
- Bisa untuk berbagai jenis surat (undangan, permohonan, dll)
- Kop surat tetap utuh di setiap surat
- Bisa tambah field sesuai kebutuhan

✅ **Konsisten:**
- Format surat selalu sama
- Kop surat tidak berubah
- Nomor surat otomatis teratur

## Contoh Lengkap

### Template Word (File: surat_undangan.docx)

```
PEMERINTAH KABUPATEN BANTUL
KAPANEWON IMOGIRI
KARANG TARUNA

Alamat: Jl. Contoh No. 123
Telp: (0274) 123456

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

Acara akan dilaksanakan pada:
Tanggal : {tanggal_acara}
Waktu   : {waktu_acara}
Tempat  : {tempat_acara}

Demikian surat undangan ini kami sampaikan.

Hormat kami,
Ketua Karang Taruna

───────────────────────────────────────────────────────
Tanggal: {tanggal_surat_id}
```

### Field yang Didefinisikan Admin:

1. `nama_penerima` - Text - Required
2. `alamat_penerima` - Textarea - Required
3. `tanggal_acara` - Date - Required
4. `waktu_acara` - Text - Required
5. `tempat_acara` - Text - Required

### Form yang Muncul untuk User:

- Perihal: [input text]
- Tujuan: [input text]
- Tanggal Surat: [date picker]
- Isi Surat: [textarea]
- **Data Tambahan:**
  - Nama Penerima: [input text] *
  - Alamat Penerima: [textarea] *
  - Tanggal Acara: [date picker] *
  - Waktu Acara: [input text] *
  - Tempat Acara: [input text] *

### Hasil Surat yang Di-generate:

```
PEMERINTAH KABUPATEN BANTUL
KAPANEWON IMOGIRI
KARANG TARUNA

Alamat: Jl. Contoh No. 123
Telp: (0274) 123456

═══════════════════════════════════════════════════════

Nomor    : SKATA/2024/11/001
Sifat    : Penting
Lampiran : -
Hal      : Undangan Rapat Koordinasi

Kepada Yth.
Budi Santoso
Jl. Merdeka No. 45, Imogiri
di-
IMOGIRI

Dengan hormat,

Kami mengundang Bapak/Ibu untuk hadir dalam rapat koordinasi...

Acara akan dilaksanakan pada:
Tanggal : 20 November 2024
Waktu   : 14:00 WIB
Tempat  : Aula Karang Taruna

Demikian surat undangan ini kami sampaikan.

Hormat kami,
Ketua Karang Taruna

───────────────────────────────────────────────────────
Tanggal: 13 November 2024
```

## Catatan Penting

1. **Format Placeholder**: Harus menggunakan `{nama_field}` (dengan kurung kurawal)
2. **Case Sensitive**: Nama field harus sama persis (huruf besar/kecil)
3. **File Template**: Harus format .docx (Word 2007+)
4. **Kop Surat**: Semua elemen kop surat akan tetap ada di setiap surat yang di-generate
5. **Logo**: Logo di kop surat akan tetap muncul jika sudah di-embed di template Word

## Troubleshooting

**Q: Kop surat tidak muncul di surat yang di-generate?**
A: Pastikan kop surat sudah di-embed dengan benar di file Word template, bukan hanya sebagai gambar yang di-link.

**Q: Placeholder tidak ter-replace?**
A: Pastikan nama placeholder di Word sama persis dengan nama field yang didefinisikan (tanpa spasi, gunakan underscore).

**Q: Format surat berubah?**
A: Pastikan file template menggunakan format .docx yang valid dan tidak corrupt.








