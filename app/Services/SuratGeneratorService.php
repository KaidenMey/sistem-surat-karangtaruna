<?php

namespace App\Services;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Template;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html as PhpWordHtml;

class SuratGeneratorService
{
    public function generateSurat($surat)
    {
        try {
            // Reload surat with relationships
            if (method_exists($surat, 'load')) {
                $surat->load(['template', 'user']);
            }
            
            $data = method_exists($surat, 'toArray') ? $surat->toArray() : $surat;
            $formatted = $this->formatData($data);
            
            // Determine which template view to use
            $templateSlug = $formatted['template']['slug'] ?? 'surat';
            $viewName = 'templates.generator';
            if ($templateSlug === 'surat_permohonan') {
                $viewName = 'templates.generator_permohonan';
            }

            $html = View::make($viewName, ['surat' => $formatted])->render();

            $nomorSurat = preg_replace('/[^\w\-]/', '_', $formatted['nomor_surat']);
            $fileName = $nomorSurat . '.html';
            $filePath = 'surat/' . $fileName;

            // Ensure directory exists
            $directory = storage_path('app/public/surat');
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            Storage::disk('public')->put($filePath, $html);

            // HTML sudah berhasil dibuat, sekarang generate PDF & Word
            // Jika PDF/Word gagal, HTML tetap tersedia
            $pdfPath = null;
            $wordPath = null;
            
            try {
                $pdf = $this->generatePdf($surat, false);
                $pdfPath = $pdf['path'] ?? null;
            } catch (\Exception $e) {
                $errorMsg = 'Error generating PDF: ' . $e->getMessage();
                \Log::error($errorMsg);
                \Log::error('PDF Stack trace: ' . $e->getTraceAsString());
                // Continue even if PDF generation fails - HTML is already created
            }
            
            try {
                $word = $this->generateWord($surat, false);
                $wordPath = $word['path'] ?? null;
            } catch (\Exception $e) {
                $errorMsg = 'Error generating Word: ' . $e->getMessage();
                \Log::error($errorMsg);
                \Log::error('Word Stack trace: ' . $e->getTraceAsString());
                // Continue even if Word generation fails - HTML is already created
            }

            // update surat di database - HTML selalu ada, PDF/Word mungkin null
            if (method_exists($surat, 'update')) {
                $surat->update([
                    'file_html' => $filePath,
                    'file_pdf' => $pdfPath,
                    'file_word' => $wordPath,
                ]);
            }

            return [
                'path' => $filePath,
                'url' => asset('storage/' . $filePath),
                'pdf_path' => $pdfPath,
                'word_path' => $wordPath,
            ];
        } catch (\Exception $e) {
            \Log::error('Error in generateSurat: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Jika error terjadi sebelum HTML dibuat, throw exception
            // Tapi jika HTML sudah dibuat, jangan throw - biarkan user bisa lihat preview
            if (!isset($filePath) || !Storage::disk('public')->exists($filePath)) {
                throw $e;
            }
            
            // HTML sudah dibuat, return dengan path HTML meskipun ada error
            return [
                'path' => $filePath,
                'url' => asset('storage/' . $filePath),
                'pdf_path' => null,
                'word_path' => null,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function generatePdf($surat, $update = true)
    {
        try {
            // Reload surat with relationships
            if (method_exists($surat, 'load')) {
                $surat->load(['template', 'user']);
            }
            
            $data = method_exists($surat, 'toArray') ? $surat->toArray() : $surat;
            $formatted = $this->formatData($data);
            
            // Determine which template view to use
            $templateSlug = $formatted['template']['slug'] ?? 'surat';
            $viewName = 'templates.generator';
            if ($templateSlug === 'surat_permohonan') {
                $viewName = 'templates.generator_permohonan';
            }

            $html = View::make($viewName, ['surat' => $formatted])->render();

            $nomorSurat = preg_replace('/[^\w\-]/', '_', $formatted['nomor_surat']);
            $fileName = $nomorSurat . '.pdf';
            $filePath = 'surat/' . $fileName;

            // Ensure directory exists
            $directory = storage_path('app/public/surat');
            if (!is_dir($directory)) {
                if (!mkdir($directory, 0755, true) && !is_dir($directory)) {
                    throw new \RuntimeException('Gagal membuat direktori: ' . $directory);
                }
            }

            // Clean HTML for PDF
            $cleanHtml = $html;
            // Remove problematic elements
            $cleanHtml = preg_replace('/<img[^>]*>/i', '', $cleanHtml);
            
            try {
                // Set margin untuk PDF (dalam mm) - sesuai standar surat resmi Indonesia
                // Top: 3cm (30mm), Right: 2.5cm (25mm), Bottom: 2cm (20mm), Left: 4cm (40mm)
                $pdf = Pdf::loadHTML($cleanHtml)
                    ->setPaper('a4', 'portrait')
                    ->setOption('enable-local-file-access', true)
                    ->setOption('isHtml5ParserEnabled', true)
                    ->setOption('isRemoteEnabled', false)
                    ->setOption('defaultFont', 'Times New Roman')
                    ->setOption('margin-top', 30)
                    ->setOption('margin-bottom', 20)
                    ->setOption('margin-left', 40)
                    ->setOption('margin-right', 25);
                
                Storage::disk('public')->put($filePath, $pdf->output());
            } catch (\Exception $e) {
                \Log::error('PDF generation error: ' . $e->getMessage());
                throw $e;
            }

            if ($update && method_exists($surat, 'update')) {
                $surat->update(['file_pdf' => $filePath]);
            }

            return [
                'path' => $filePath,
                'url' => asset('storage/' . $filePath),
            ];
        } catch (\Exception $e) {
            \Log::error('Error in generatePdf: ' . $e->getMessage());
            throw $e;
        }
    }

    public function generateWord($surat, $update = true)
    {
        try {
            // Reload surat with relationships
            if (method_exists($surat, 'load')) {
                $surat->load(['template', 'user']);
            }
            
            $data = method_exists($surat, 'toArray') ? $surat->toArray() : $surat;
            $formatted = $this->formatData($data);
            
            // Determine which template view to use
            $templateSlug = $formatted['template']['slug'] ?? 'surat';
            $viewName = 'templates.generator';
            if ($templateSlug === 'surat_permohonan') {
                $viewName = 'templates.generator_permohonan';
            }

            $html = View::make($viewName, ['surat' => $formatted])->render();

            $phpWord = new PhpWord();
            $section = $phpWord->addSection();

            // Extract body content or use full HTML
            $bodyHtml = $html;
            if (preg_match('/<body[^>]*>(.*?)<\/body>/si', $html, $matches)) {
                $bodyHtml = $matches[1];
            } else {
                // If no body tag, extract content between <body> equivalent (container divs)
                if (preg_match('/<div[^>]*class=["\'](?:container|document-container)[^>]*>(.*?)<\/div>/si', $html, $matches)) {
                    $bodyHtml = $matches[1];
                } else {
                    // Remove head and style tags
                    $bodyHtml = preg_replace('/<head[^>]*>.*?<\/head>/si', '', $html);
                }
            }

            // Remove style tags
            $bodyHtml = preg_replace('/<style[^>]*>.*?<\/style>/si', '', $bodyHtml);
            
            // Remove or replace img tags that cause issues
            $bodyHtml = preg_replace('/<img[^>]*>/i', '', $bodyHtml);
            
            // Fix unclosed tags
            $bodyHtml = preg_replace('/<br\s*\/?>/i', '<br/>', $bodyHtml);
            
            // Clean up HTML
            $bodyHtml = preg_replace('/\s+/', ' ', $bodyHtml);
            $bodyHtml = trim($bodyHtml);
            
            $bodyHtml = mb_convert_encoding($bodyHtml, 'HTML-ENTITIES', 'UTF-8');
            
            try {
                PhpWordHtml::addHtml($section, $bodyHtml, false, false);
            } catch (\Exception $e) {
                // Fallback: create simple text version
                $cleanText = strip_tags($bodyHtml);
                $cleanText = html_entity_decode($cleanText, ENT_QUOTES, 'UTF-8');
                $section->addText($cleanText);
                \Log::warning('Word generation fallback used: ' . $e->getMessage());
            }

            $nomorSurat = preg_replace('/[^\w\-]/', '_', $formatted['nomor_surat']);
            $fileName = $nomorSurat . '.docx';
            $filePath = 'surat/' . $fileName;

            $writer = IOFactory::createWriter($phpWord, 'Word2007');

            $fullPath = storage_path('app/public/' . $filePath);
            $directory = dirname($fullPath);

            if (!is_dir($directory)) {
                if (!mkdir($directory, 0755, true) && !is_dir($directory)) {
                    throw new \RuntimeException('Gagal membuat direktori: ' . $directory);
                }
            }

            $writer->save($fullPath);

            if ($update && method_exists($surat, 'update')) {
                $surat->update(['file_word' => $filePath]);
            }

            return [
                'path' => $filePath,
                'url' => asset('storage/' . $filePath),
            ];
        } catch (\Exception $e) {
            \Log::error('Error in generateWord: ' . $e->getMessage());
            throw $e;
        }
    }

    public function formatData($data)
    {
        // Get template info - handle both array and object
        $templateName = null;
        $templateType = null;
        $templateSlug = null;

        if (isset($data['template'])) {
            if (is_array($data['template'])) {
                $templateName = $data['template']['name'] ?? null;
                $templateType = $data['template']['type'] ?? null;
            } elseif (is_object($data['template'])) {
                $templateName = $data['template']->name ?? null;
                $templateType = $data['template']->type ?? null;
            }
        }

        // If template not found in data, try to load from template_id
        if (!$templateName && !empty($data['template_id'])) {
            $templateModel = Template::find($data['template_id']);
            if ($templateModel) {
                $templateName = $templateModel->name;
                $templateType = $templateModel->type;
            }
        }

        if ($templateName) {
            $templateSlug = Str::slug(Str::lower($templateName), '_');
        }

        $templateData = [
            'id' => $data['template_id'] ?? null,
            'name' => $templateName ?? 'Surat',
            'type' => $templateType ?? 'system',
            'slug' => $templateSlug ?? 'surat',
        ];

        $formData = $data['form_data'] ?? [];
        $isUndangan = ($templateSlug === 'surat_undangan');
        $isProposal = ($templateSlug === 'surat_proposal');
        $isPermohonan = ($templateSlug === 'surat_permohonan');

        // Handle tanggal_surat for different templates
        $tanggalSuratFormatted = now()->isoFormat('D MMMM YYYY');
        if (isset($data['tanggal_surat'])) {
            if (($isUndangan || $isProposal || $isPermohonan) && isset($formData['tanggal_surat_text'])) {
                $tanggalSuratFormatted = $formData['tanggal_surat_text'];
            } else {
                try {
                    $tanggalSuratFormatted = Carbon::parse($data['tanggal_surat'])->isoFormat('D MMMM YYYY');
                } catch (\Exception $e) {
                    \Log::warning('Error parsing tanggal_surat: ' . $e->getMessage());
                }
            }
        }

        // Handle penerima for proposal
        $penerima = $data['penerima'] ?? [];
        if ($isProposal && empty($penerima) && isset($formData['kepada'])) {
            $penerima = [$formData['kepada']];
        }

        // Handle tanda_tangan for proposal
        $tandaTangan = $data['tanda_tangan'] ?? [];
        if ($isProposal && empty($tandaTangan)) {
            $tandaTangan = [
                [
                    'jabatan' => 'Ketua Paguyuban Satrio Budoyo Mudo Mayungan',
                    'nama' => $formData['ketua_nama'] ?? '',
                ],
                [
                    'jabatan' => 'Sekretaris Paguyuban Satrio Budoyo Mudo Mayungan',
                    'nama' => $formData['sekretaris_nama'] ?? '',
                ],
            ];
        }

        return [
            'nomor_surat' => $data['nomor_surat'] ?? '-',
            'lampiran' => $data['lampiran'] ?? '-',
            'hal' => $data['hal'] ?? '-',
            'perihal' => $data['perihal'] ?? ($data['hal'] ?? '-'),
            'tanggal_surat' => $tanggalSuratFormatted,
            'tanggal_surat_raw' => isset($data['tanggal_surat'])
                ? (function() use ($data, $isUndangan, $isProposal, $formData) {
                    if (($isUndangan || $isProposal) && isset($formData['tanggal_surat_text'])) {
                        // Try to parse the text date
                        try {
                            return Carbon::createFromLocaleFormat('d F Y', 'id', $formData['tanggal_surat_text'])->toDateString();
                        } catch (\Exception $e) {
                            return now()->toDateString();
                        }
                    }
                    try {
                        if (is_string($data['tanggal_surat'])) {
                            $parsed = Carbon::parse($data['tanggal_surat']);
                            return $parsed->isValid() ? $parsed->toDateString() : now()->toDateString();
                        }
                        return Carbon::parse($data['tanggal_surat'])->toDateString();
                    } catch (\Exception $e) {
                        return now()->toDateString();
                    }
                })()
                : now()->toDateString(),
            'penerima' => $penerima,
            'isi_surat' => $data['isi_surat'] ?? '',
            'tembusan' => $data['tembusan'] ?? [],
            'tanda_tangan' => $tandaTangan,
            'kota_penetapan' => $data['kota_penetapan'] ?? 'Bantul',
            'tanggal_penetapan' => isset($data['tanggal_penetapan'])
                ? Carbon::parse($data['tanggal_penetapan'])->isoFormat('D MMMM YYYY')
                : now()->isoFormat('D MMMM YYYY'),
            'template' => $templateData,
            'form_data' => $formData,
        ];
    }
}
