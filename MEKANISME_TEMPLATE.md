# Mekanisme Template Surat E-SKATA

## ✅ Jawaban Singkat

**Ya, Anda bisa upload surat yang sudah jadi dengan kop surat sebagai template!**

Cara kerjanya:
1. **Admin upload file Word** yang sudah memiliki kop surat lengkap
2. **Admin tentukan field-field** yang perlu diisi user (dengan form builder yang mudah)
3. **User isi form** yang muncul secara dinamis
4. **Sistem otomatis generate surat** dengan mengganti placeholder, kop surat tetap utuh

## Konsep Dasar

Sistem template surat dirancang untuk memungkinkan admin mengupload file template (Word/DOCX) yang kemudian dapat digunakan oleh anggota untuk membuat surat dengan mengisi form dinamis. **Kop surat dan semua elemen visual akan tetap utuh** di setiap surat yang di-generate.

## Struktur Database

### Tabel `templates`
- `file_path`: Path ke file template (Word/DOCX/PDF)
- `form_fields`: JSON konfigurasi field yang perlu diisi user
  ```json
  [
    {
      "name": "nama_penerima",
      "label": "Nama Penerima",
      "type": "text",
      "required": true,
      "placeholder": "Masukkan nama penerima"
    },
    {
      "name": "alamat",
      "label": "Alamat",
      "type": "textarea",
      "required": true
    },
    {
      "name": "tanggal_acara",
      "label": "Tanggal Acara",
      "type": "date",
      "required": true
    }
  ]
  ```

### Tabel `surats`
- `form_data`: JSON data yang diisi user sesuai form_fields
  ```json
  {
    "nama_penerima": "Budi Santoso",
    "alamat": "Jl. Contoh No. 123",
    "tanggal_acara": "2024-12-25"
  }
  ```

## Pendekatan Implementasi

### **Pendekatan 1: Template dengan Placeholder (Recommended)**

**Cara Kerja:**
1. Admin upload file Word/DOCX yang berisi placeholder seperti:
   - `{nama_penerima}`
   - `{alamat}`
   - `{tanggal_acara}`
   - `{perihal}`
   - `{nomor_surat}` (otomatis diisi sistem)
   - `{tanggal_surat}` (otomatis diisi sistem)

2. Admin juga mengisi form_fields secara manual saat upload template:
   - Field apa saja yang perlu diisi
   - Label, type, required, dll

3. Saat anggota membuat surat:
   - Sistem menampilkan form dinamis berdasarkan form_fields
   - User mengisi form
   - Sistem membaca file template, replace placeholder dengan data user
   - Generate file Word/PDF baru

**Keuntungan:**
- Fleksibel untuk berbagai jenis surat
- Admin punya kontrol penuh
- Relatif mudah diimplementasikan

**Library yang dibutuhkan:**
- `phpoffice/phpword` untuk manipulasi file Word
- `barryvdh/laravel-dompdf` atau `barryvdh/laravel-snappy` untuk PDF

---

### **Pendekatan 2: Auto-detect Fields (Advanced)**

**Cara Kerja:**
1. Admin upload file Word/DOCX
2. Sistem membaca file dan otomatis detect placeholder/variable
3. Sistem generate form_fields secara otomatis
4. Admin bisa edit form_fields jika perlu

**Keuntungan:**
- Lebih otomatis
- Admin tidak perlu manual define fields

**Kekurangan:**
- Lebih kompleks
- Perlu pattern matching yang baik

---

### **Pendekatan 3: Template Builder (Most Flexible)**

**Cara Kerja:**
1. Admin menggunakan editor visual untuk membuat template
2. Drag & drop field ke template
3. Sistem generate form_fields dan file template otomatis

**Keuntungan:**
- Sangat fleksibel
- User-friendly untuk admin

**Kekurangan:**
- Paling kompleks
- Butuh development lebih banyak

---

## Rekomendasi Implementasi

Untuk tahap awal, **Pendekatan 1** adalah yang paling realistis:

1. **Upload Template:**
   - Admin upload file Word dengan placeholder
   - Admin isi form_fields manual (atau bisa dibuat form builder sederhana)

2. **Generate Surat:**
   - User isi form dinamis
   - Sistem replace placeholder di template
   - Generate file baru (Word/PDF)

3. **Library yang digunakan:**
   ```bash
   composer require phpoffice/phpword
   composer require barryvdh/laravel-dompdf
   ```

## Contoh Template Word

File template Word bisa berisi:

```
SURAT UNDANGAN

Nomor: {nomor_surat}
Perihal: {perihal}
Tanggal: {tanggal_surat}

Kepada Yth.
{nama_penerima}
{alamat}

Dengan hormat,
{isi_surat}

Hormat kami,
Ketua Karang Taruna
```

## Next Steps

1. Install library PHPWord dan DomPDF
2. Buat service untuk:
   - Parse template dan extract placeholder
   - Replace placeholder dengan data
   - Generate file Word/PDF baru
3. Update controller untuk generate file saat create surat

