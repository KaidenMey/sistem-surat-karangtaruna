<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'template_id',
        'nomor_surat',
        'lampiran',
        'hal',
        'penerima',
        'perihal',
        'tujuan',
        'isi',
        'isi_surat',
        'kota_penetapan',
        'tanggal_penetapan',
        'jabatan_penanda_tangan',
        'nama_penanda_tangan',
        'nip_penanda_tangan',
        'tanda_tangan',
        'tembusan',
        'form_data',
        'file_pdf',
        'file_word',
        'file_html',
        'tanggal_surat',
    ];

    protected $casts = [
        'form_data' => 'array',
        'penerima' => 'array',
        'tembusan' => 'array',
        'tanda_tangan' => 'array',
        'tanggal_surat' => 'date',
        'tanggal_penetapan' => 'date',
    ];

    /**
     * Get the user that created this surat
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the template used for this surat
     */
    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
