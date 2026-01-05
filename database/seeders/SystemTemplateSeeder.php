<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Template;

class SystemTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus template lama jika ada (kecuali yang dibuat admin)
        Template::where('type', 'system')->delete();

        // Template Surat Permohonan
        Template::create([
            'name' => 'Surat Permohonan',
            'description' => 'Template surat permohonan formal dengan kop surat Karang Taruna Morosene Kabupaten Bantul',
            'type' => 'system',
            'file_path' => null,
            'form_fields' => [
                [
                    'name' => 'paragraf_pembuka',
                    'label' => 'Paragraf Pembuka',
                    'type' => 'textarea',
                    'required' => true,
                ],
                [
                    'name' => 'paragraf_isi',
                    'label' => 'Paragraf Isi (Inti Permohonan)',
                    'type' => 'textarea',
                    'required' => true,
                ],
                [
                    'name' => 'paragraf_penutup',
                    'label' => 'Paragraf Penutup',
                    'type' => 'textarea',
                    'required' => true,
                ],
            ],
            'is_active' => true,
        ]);

        // Template Surat Undangan
        Template::create([
            'name' => 'Surat Undangan',
            'description' => 'Template surat undangan formal dengan kop surat Karang Taruna Morosene Kabupaten Bantul',
            'type' => 'system',
            'file_path' => null,
            'form_fields' => [
                [
                    'name' => 'paragraf_pembuka',
                    'label' => 'Paragraf Pembuka',
                    'type' => 'textarea',
                    'required' => true,
                ],
                [
                    'name' => 'hari_acara',
                    'label' => 'Hari',
                    'type' => 'text',
                    'required' => true,
                ],
                [
                    'name' => 'tanggal_acara',
                    'label' => 'Tanggal Acara',
                    'type' => 'date',
                    'required' => true,
                ],
                [
                    'name' => 'waktu_acara',
                    'label' => 'Waktu',
                    'type' => 'text',
                    'required' => true,
                ],
                [
                    'name' => 'tempat_acara',
                    'label' => 'Tempat',
                    'type' => 'text',
                    'required' => true,
                ],
                [
                    'name' => 'acara',
                    'label' => 'Acara',
                    'type' => 'text',
                    'required' => true,
                ],
                [
                    'name' => 'paragraf_penutup',
                    'label' => 'Paragraf Penutup',
                    'type' => 'textarea',
                    'required' => true,
                ],
            ],
            'is_active' => true,
        ]);

        // Template Surat Proposal
        Template::create([
            'name' => 'Surat Proposal',
            'description' => 'Template surat proposal formal dengan kop surat MUDA-MUDI MOROSENE MAYUNGAN',
            'type' => 'system',
            'file_path' => null,
            'form_fields' => [], // Form fields handled in create_proposal.blade.php
            'is_active' => true,
        ]);
    }
}
