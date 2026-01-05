<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('surats', function (Blueprint $table) {
            $table->string('lampiran')->nullable()->after('nomor_surat');
            $table->string('hal')->nullable()->after('lampiran');
            $table->json('penerima')->nullable()->after('hal'); // Array of recipients
            $table->text('isi_surat')->nullable()->after('penerima'); // Rename from 'isi'
            $table->string('kota_penetapan')->nullable()->after('isi_surat');
            $table->date('tanggal_penetapan')->nullable()->after('kota_penetapan');
            $table->string('jabatan_penanda_tangan')->nullable()->after('tanggal_penetapan');
            $table->string('nama_penanda_tangan')->nullable()->after('jabatan_penanda_tangan');
            $table->string('nip_penanda_tangan')->nullable()->after('nama_penanda_tangan');
            $table->json('tembusan')->nullable()->after('nip_penanda_tangan'); // Array of CC recipients
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surats', function (Blueprint $table) {
            $table->dropColumn([
                'lampiran',
                'hal',
                'penerima',
                'isi_surat',
                'kota_penetapan',
                'tanggal_penetapan',
                'jabatan_penanda_tangan',
                'nama_penanda_tangan',
                'nip_penanda_tangan',
                'tembusan',
            ]);
        });
    }
};
