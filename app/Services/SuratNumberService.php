<?php

namespace App\Services;

use App\Models\Surat;
use Carbon\Carbon;

class SuratNumberService
{
    /**
     * Generate nomor surat unik dan otomatis
     * Format: SKATA/YYYY/MM/NNN
     * Contoh: SKATA/2025/11/001
     */
    public function generateNomorSurat()
    {
        // Gunakan prefix sesuai sistem (bisa diubah sesuai kebutuhan)
        $prefix = 'SKATA';
        $year = now()->format('Y');
        $month = now()->format('m');

        // Buat pola pencarian berdasarkan tahun dan bulan
        $pattern = $prefix . '/' . $year . '/' . $month . '/%';

        // Cari surat terakhir dengan bulan & tahun yang sama
        $lastSurat = Surat::where('nomor_surat', 'like', $pattern)
            ->orderByDesc('id')
            ->first();

        // Ambil angka terakhir dari nomor surat
        if ($lastSurat && preg_match('/(\d{3})$/', $lastSurat->nomor_surat, $matches)) {
            $lastNumber = intval($matches[1]);
        } else {
            $lastNumber = 0;
        }

        // Naikkan nomor +1
        $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        // Gabungkan jadi satu string
        $nomorSurat = "{$prefix}/{$year}/{$month}/{$nextNumber}";

        // Pastikan unik (jaga-jaga kalau sistem paralel)
        if (Surat::where('nomor_surat', $nomorSurat)->exists()) {
            // Jika sudah ada, panggil ulang fungsi ini untuk regenerasi
            return $this->generateNomorSurat();
        }

        return $nomorSurat;
    }
}






