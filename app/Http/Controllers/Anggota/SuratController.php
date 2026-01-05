<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use App\Models\Surat;
use App\Models\Template;
use App\Services\SuratNumberService;
use App\Services\SuratGeneratorService;
use App\Traits\LogsActivity;

class SuratController extends Controller
{
    use LogsActivity;

    protected $suratNumberService;
    protected $suratGeneratorService;

    public function __construct(SuratNumberService $suratNumberService, SuratGeneratorService $suratGeneratorService)
    {
        $this->suratNumberService = $suratNumberService;
        $this->suratGeneratorService = $suratGeneratorService;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $templateId = $request->get('template_id');
        
        if (!$templateId) {
            return redirect()->route('anggota.templates.index')
                ->with('error', 'Pilih template terlebih dahulu.');
        }

        $template = Template::where('is_active', true)->findOrFail($templateId);
        
        // Use new form for Surat Undangan
        if (strtolower($template->name) === 'surat undangan') {
            return view('anggota.surat.create_undangan', compact('template'));
        }
        
        // Use new form for Surat Proposal
        if (strtolower($template->name) === 'surat proposal') {
            return view('anggota.surat.create_proposal', compact('template'));
        }
        
        // Use new form for Surat Permohonan
        if (strtolower($template->name) === 'surat permohonan') {
            return view('anggota.surat.create_permohonan', compact('template'));
        }
        
        return view('anggota.surat.create', compact('template'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $template = Template::findOrFail($request->template_id);
        $isUndangan = strtolower($template->name) === 'surat undangan';
        $isProposal = strtolower($template->name) === 'surat proposal';
        $isPermohonan = strtolower($template->name) === 'surat permohonan';
        
        // Build validation rules
        $rules = [
            'template_id' => 'required|exists:templates,id',
            'nomor_surat' => 'nullable|string|max:255',
            'lampiran' => 'required|string|max:255',
            'hal' => 'required|string|max:255',
            'penerima' => 'required|array|min:1',
            'penerima.*' => 'required|string|max:255',
            'isi_surat' => 'nullable|string',
            'kota_penetapan' => 'required|string|max:255',
            'tanggal_penetapan' => 'required|date',
            'tanda_tangan' => 'required|array|min:1',
            'tanda_tangan.*.jabatan' => 'required|string|max:255',
            'tanda_tangan.*.nama' => 'required|string|max:255',
            'tanda_tangan.*.nip' => 'nullable|string|max:255',
            'tembusan' => 'nullable|array',
            'tembusan.*' => 'nullable|string|max:255',
        ];
        
        // Skip kota_penetapan and tanggal_penetapan for Permohonan
        if ($isPermohonan) {
            unset($rules['kota_penetapan']);
            unset($rules['tanggal_penetapan']);
        }
        
        // For Surat Undangan, Proposal, and Permohonan, tanggal_surat is text, otherwise it's date
        if ($isUndangan || $isProposal || $isPermohonan) {
            $rules['tanggal_surat'] = 'required|string|max:255';
        } else {
            $rules['tanggal_surat'] = 'required|date';
        }
        
        // For Surat Undangan, add new field validations and skip old form_fields
        if ($isUndangan) {
            $rules['nama_acara_panitia'] = 'nullable|string|max:255';
            $rules['nama_kegiatan_utama'] = 'nullable|string|max:255';
            $rules['deskripsi_kegiatan'] = 'nullable|string|max:1000';
            $rules['hari_tanggal_acara'] = 'nullable|string|max:255';
            $rules['waktu_acara'] = 'nullable|string|max:255';
            $rules['tempat_acara'] = 'nullable|string|max:255';
            $rules['acara_utama'] = 'nullable|string|max:255';
            $rules['catatan_tambahan'] = 'nullable|string|max:1000';
        } elseif ($isProposal) {
            // For Surat Proposal, add new field validations
            $rules['hal'] = 'required|string|max:255';
            $rules['kepada'] = 'required|string|max:255';
            $rules['cq'] = 'required|string|max:255';
            $rules['paragraf_pembuka'] = 'required|string|max:2000';
            $rules['hari_tanggal_kegiatan'] = 'required|string|max:255';
            $rules['tempat_kegiatan'] = 'required|string|max:255';
            $rules['paragraf_permohonan'] = 'required|string|max:2000';
            $rules['paragraf_penutup'] = 'required|string|max:2000';
            $rules['ketua_nama'] = 'required|string|max:255';
            $rules['sekretaris_nama'] = 'required|string|max:255';
            $rules['mengetahui_1_jabatan'] = 'nullable|string|max:255';
            $rules['mengetahui_1_nama'] = 'nullable|string|max:255';
            $rules['mengetahui_2_jabatan'] = 'nullable|string|max:255';
            $rules['mengetahui_2_nama'] = 'nullable|string|max:255';
            $rules['mengetahui_3_jabatan'] = 'nullable|string|max:255';
            $rules['mengetahui_3_nama'] = 'nullable|string|max:255';
            $rules['tembusan'] = 'nullable|string|max:255';
            // Skip penerima and tanda_tangan validation for proposal
            unset($rules['penerima']);
            unset($rules['penerima.*']);
            unset($rules['tanda_tangan']);
            unset($rules['tanda_tangan.*.jabatan']);
            unset($rules['tanda_tangan.*.nama']);
            unset($rules['tanda_tangan.*.nip']);
        } elseif ($isPermohonan) {
            // For Surat Permohonan, add new field validations
            $rules['hal'] = 'required|string|max:255';
            $rules['kepada_utama'] = 'required|string|max:255';
            $rules['cq_kedua'] = 'required|string|max:255';
            $rules['paragraf_pembuka'] = 'required|string|max:2000';
            $rules['paragraf_permohonan'] = 'required|string|max:2000';
            $rules['paragraf_penutup'] = 'required|string|max:2000';
            $rules['ketua_nama'] = 'required|string|max:255';
            $rules['sekretaris_nama'] = 'required|string|max:255';
            $rules['mengetahui_1_jabatan'] = 'nullable|string|max:255';
            $rules['mengetahui_1_nama'] = 'nullable|string|max:255';
            $rules['mengetahui_2_jabatan'] = 'nullable|string|max:255';
            $rules['mengetahui_2_nama'] = 'nullable|string|max:255';
            $rules['tembusan_jabatan'] = 'nullable|string|max:255';
            $rules['tembusan_nama'] = 'nullable|string|max:255';
            // Skip penerima and tanda_tangan validation for permohonan
            unset($rules['penerima']);
            unset($rules['penerima.*']);
            unset($rules['tanda_tangan']);
            unset($rules['tanda_tangan.*.jabatan']);
            unset($rules['tanda_tangan.*.nama']);
            unset($rules['tanda_tangan.*.nip']);
        } else {
            // For other templates, use form_fields validation
        if ($template->form_fields && is_array($template->form_fields)) {
            foreach ($template->form_fields as $field) {
                $fieldName = $field['name'] ?? null;
                $fieldRequired = $field['required'] ?? false;
                $fieldType = $field['type'] ?? 'text';
                
                if ($fieldName) {
                    $rule = $fieldType === 'email' ? 'email' : 'string';
                    if ($fieldType === 'number') {
                        $rule = 'numeric';
                    }
                    if ($fieldRequired) {
                        $rule .= '|required';
                    } else {
                        $rule .= '|nullable';
                    }
                    if ($fieldType === 'textarea') {
                        $rule .= '|max:5000';
                    } else {
                        $rule .= '|max:255';
                    }
                    $rules[$fieldName] = $rule;
                    }
                }
            }
        }
        
        $validated = $request->validate($rules);

        // $nomorSurat = $validated['nomor_surat'] ?? $this->suratNumberService->generateNomorSurat();
        $nomorSurat = $this->suratNumberService->generateNomorSurat();


        $formData = [];
        
        // For Surat Undangan, collect all new fields
        if ($isUndangan) {
            $formData['nama_acara_panitia'] = $request->input('nama_acara_panitia');
            $formData['nama_kegiatan_utama'] = $request->input('nama_kegiatan_utama');
            $formData['deskripsi_kegiatan'] = $request->input('deskripsi_kegiatan');
            $formData['hari_tanggal_acara'] = $request->input('hari_tanggal_acara');
            $formData['waktu_acara'] = $request->input('waktu_acara');
            $formData['tempat_acara'] = $request->input('tempat_acara');
            $formData['acara_utama'] = $request->input('acara_utama');
            $formData['catatan_tambahan'] = $request->input('catatan_tambahan');
            $formData['tanggal_surat_text'] = $validated['tanggal_surat']; // Store original text format
        } elseif ($isProposal) {
            // For Surat Proposal, collect all new fields
            $formData['kepada'] = $request->input('kepada');
            $formData['cq'] = $request->input('cq');
            $formData['paragraf_pembuka'] = $request->input('paragraf_pembuka');
            $formData['hari_tanggal_kegiatan'] = $request->input('hari_tanggal_kegiatan');
            $formData['tempat_kegiatan'] = $request->input('tempat_kegiatan');
            $formData['paragraf_permohonan'] = $request->input('paragraf_permohonan');
            $formData['paragraf_penutup'] = $request->input('paragraf_penutup');
            $formData['ketua_nama'] = $request->input('ketua_nama');
            $formData['sekretaris_nama'] = $request->input('sekretaris_nama');
            $formData['mengetahui_1_jabatan'] = $request->input('mengetahui_1_jabatan');
            $formData['mengetahui_1_nama'] = $request->input('mengetahui_1_nama');
            $formData['mengetahui_2_jabatan'] = $request->input('mengetahui_2_jabatan');
            $formData['mengetahui_2_nama'] = $request->input('mengetahui_2_nama');
            $formData['mengetahui_3_jabatan'] = $request->input('mengetahui_3_jabatan');
            $formData['mengetahui_3_nama'] = $request->input('mengetahui_3_nama');
            $formData['tembusan'] = $request->input('tembusan');
            $formData['tanggal_surat_text'] = $validated['tanggal_surat']; // Store original text format
        } elseif ($isPermohonan) {
            // For Surat Permohonan, collect all new fields
            $formData['kepada_utama'] = $request->input('kepada_utama');
            $formData['cq_kedua'] = $request->input('cq_kedua');
            $formData['paragraf_pembuka'] = $request->input('paragraf_pembuka');
            $formData['paragraf_permohonan'] = $request->input('paragraf_permohonan');
            $formData['paragraf_penutup'] = $request->input('paragraf_penutup');
            $formData['ketua_nama'] = $request->input('ketua_nama');
            $formData['sekretaris_nama'] = $request->input('sekretaris_nama');
            $formData['mengetahui_1_jabatan'] = $request->input('mengetahui_1_jabatan');
            $formData['mengetahui_1_nama'] = $request->input('mengetahui_1_nama');
            $formData['mengetahui_2_jabatan'] = $request->input('mengetahui_2_jabatan');
            $formData['mengetahui_2_nama'] = $request->input('mengetahui_2_nama');
            $formData['tembusan_jabatan'] = $request->input('tembusan_jabatan');
            $formData['tembusan_nama'] = $request->input('tembusan_nama');
            $formData['tanggal_surat_text'] = $validated['tanggal_surat']; // Store original text format
        } else {
            // For other templates, use form_fields
        if ($template->form_fields && is_array($template->form_fields)) {
            foreach ($template->form_fields as $field) {
                $fieldName = $field['name'] ?? null;
                if ($fieldName && $request->has($fieldName)) {
                    $formData[$fieldName] = $request->input($fieldName);
                    }
                }
            }
        }

        // Generate isi_surat untuk template system dari form_fields
        $isiSurat = $validated['isi_surat'] ?? '';
        if ($template->type === 'system' && empty($isiSurat)) {
            // Untuk template system, isi_surat akan di-generate di generator
            $isiSurat = '';
        }
        
        // Convert tanggal_surat text to date for Surat Undangan, Proposal, and Permohonan
        $tanggalSurat = $validated['tanggal_surat'];
        if (($isUndangan || $isProposal || $isPermohonan) && is_string($tanggalSurat)) {
            // Try to parse the date string, if fails use today
            try {
                $parsedDate = \Carbon\Carbon::createFromLocaleFormat('d F Y', 'id', $tanggalSurat);
                $tanggalSurat = $parsedDate->toDateString();
            } catch (\Exception $e) {
                // If parsing fails, use today's date
                $tanggalSurat = now()->toDateString();
            }
        }
        
        // For Proposal and Permohonan, set hal and perihal
        $hal = $validated['hal'] ?? '';
        $perihal = ($isProposal || $isPermohonan) ? ($validated['hal'] ?? '') : ($validated['hal'] ?? '');
        
        // For Proposal and Permohonan, set penerima
        $penerima = [];
        if ($isProposal) {
            $penerima[] = $validated['kepada'] ?? '';
        } elseif ($isPermohonan) {
            $penerima[] = $validated['kepada_utama'] ?? '';
        } else {
            $penerima = $validated['penerima'] ?? [];
        }
        
        // For Proposal and Permohonan, set tanda_tangan structure
        $tandaTangan = [];
        if ($isProposal) {
            $tandaTangan = [
                [
                    'jabatan' => 'Ketua Paguyuban Satrio Budoyo Mudo Mayungan',
                    'nama' => $validated['ketua_nama'] ?? '',
                ],
                [
                    'jabatan' => 'Sekretaris Paguyuban Satrio Budoyo Mudo Mayungan',
                    'nama' => $validated['sekretaris_nama'] ?? '',
                ],
            ];
        } elseif ($isPermohonan) {
            $tandaTangan = [
                [
                    'jabatan' => 'Ketua Paguyuban Satrio Budoyo Mudo Mayungan',
                    'nama' => $validated['ketua_nama'] ?? '',
                ],
                [
                    'jabatan' => 'Sekretaris Satrio Budoyo Mudo Mayungan',
                    'nama' => $validated['sekretaris_nama'] ?? '',
                ],
            ];
        } else {
            $tandaTangan = $validated['tanda_tangan'] ?? [];
        }

        $surat = Surat::create([
            'user_id' => Auth::id(),
            'template_id' => $validated['template_id'],
            'nomor_surat' => $nomorSurat,
            'perihal' => $perihal, 
            'lampiran' => $validated['lampiran'],
            'hal' => $hal,
            'penerima' => $penerima,
            'isi_surat' => $isiSurat,
            'kota_penetapan' => $isPermohonan ? null : ($validated['kota_penetapan'] ?? 'Bantul'),
            'tanggal_penetapan' => $isPermohonan ? null : ($validated['tanggal_penetapan'] ?? now()),
            'tanda_tangan' => $tandaTangan,
            'jabatan_penanda_tangan' => $tandaTangan[0]['jabatan'] ?? null,
            'nama_penanda_tangan' => $tandaTangan[0]['nama'] ?? null,
            'nip_penanda_tangan' => $tandaTangan[0]['nip'] ?? null,
            'tembusan' => $isProposal ? ($validated['tembusan'] ? [$validated['tembusan']] : []) : ($isPermohonan ? ($validated['tembusan_jabatan'] ? [$validated['tembusan_jabatan']] : []) : ($validated['tembusan'] ?? [])),
            'tanggal_surat' => $tanggalSurat,
            'form_data' => !empty($formData) ? $formData : null,
        ]);

        // Generate surat files
        $generateError = null;
        $hasPdf = false;
        $hasWord = false;
        
        try {
            $result = $this->suratGeneratorService->generateSurat($surat);
            $surat->refresh(); // Refresh to get updated file paths
            
            // Check if PDF and Word were generated
            $hasPdf = !empty($result['pdf_path']) || ($surat->file_pdf && Storage::disk('public')->exists($surat->file_pdf));
            $hasWord = !empty($result['word_path']) || ($surat->file_word && Storage::disk('public')->exists($surat->file_word));
            
            // If PDF or Word failed but HTML exists, show warning
            if (isset($result['error']) || !$hasPdf || !$hasWord) {
                $generateError = 'PDF/Word generation failed';
            }
        } catch (\Exception $e) {
            \Log::error('Error generating surat: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            $generateError = $e->getMessage();
            
            // Try to generate HTML only as fallback
            try {
                $surat->load(['template', 'user']);
                $data = $surat->toArray();
                $formatted = $this->suratGeneratorService->formatData($data);
                $html = View::make('templates.generator', ['surat' => $formatted])->render();
                $nomorSurat = preg_replace('/[^\w\-]/', '_', $formatted['nomor_surat']);
                $fileName = $nomorSurat . '.html';
                $filePath = 'surat/' . $fileName;
                
                $directory = storage_path('app/public/surat');
                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }
                
                Storage::disk('public')->put($filePath, $html);
                $surat->update(['file_html' => $filePath]);
                $surat->refresh();
            } catch (\Exception $htmlError) {
                \Log::error('Error generating HTML fallback: ' . $htmlError->getMessage());
            }
        }

        $this->logActivity('create_surat', 'Surat', $surat->id, "Created surat: {$surat->nomor_surat}");

        // Always redirect to show page
        if ($generateError) {
            return redirect()->route('anggota.surat.show', $surat->id)
                ->with('warning', 'Surat berhasil dibuat dengan nomor: ' . $nomorSurat . '. Namun terjadi error saat generate file PDF/Word. Silakan coba download ulang atau hubungi administrator jika masalah berlanjut.');
        }

        return redirect()->route('anggota.surat.show', $surat->id)
            ->with('success', 'Surat berhasil dibuat dan di-generate. Nomor surat: ' . $nomorSurat);
    }

    /**
     * 
     */
    public function show(string $id)
    {
        $surat = Surat::where('user_id', Auth::id())
            ->with(['template', 'user'])
            ->findOrFail($id);

        return view('anggota.surat.show', compact('surat'));
    }

    /**
     * 
     */
    public function download(Request $request, $id, $type = 'pdf')
    {
        $surat = Surat::where('user_id', Auth::id())->findOrFail($id);
        
        // Check if the requested file exists
        $filePath = $type === 'word' ? $surat->file_word : $surat->file_pdf;
        $fileExists = $filePath && Storage::disk('public')->exists($filePath);
        
        if (!$fileExists) {
            // Try to generate the specific file type
            try {
                if ($type === 'pdf') {
                    $result = $this->suratGeneratorService->generatePdf($surat, true);
                    $surat->refresh();
                    $filePath = $surat->file_pdf;
                } else {
                    $result = $this->suratGeneratorService->generateWord($surat, true);
                    $surat->refresh();
                    $filePath = $surat->file_word;
                }
                
                // Verify file was created
                if (!$filePath || !Storage::disk('public')->exists($filePath)) {
                    // If still not exists, try full regeneration
                    $this->suratGeneratorService->generateSurat($surat);
                    $surat->refresh();
                    $filePath = $type === 'word' ? $surat->file_word : $surat->file_pdf;
                }
            } catch (\Exception $e) {
                \Log::error('Error generating file for download: ' . $e->getMessage());
                \Log::error('Stack trace: ' . $e->getTraceAsString());
                return redirect()->back()->with('error', 'Gagal generate file: ' . $e->getMessage());
            }
        }

        // Final check
        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'File belum tersedia. Silakan hubungi administrator.');
        }

        // Clean filename for download
        $cleanNomorSurat = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $surat->nomor_surat);
        $extension = $type === 'word' ? 'docx' : 'pdf';
        $fileName = 'Surat_' . $cleanNomorSurat . '_' . time() . '.' . $extension;
        
        try {
            return Storage::disk('public')->download($filePath, $fileName);
        } catch (\Exception $e) {
            \Log::error('Error downloading file: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal download file. Silakan coba lagi.');
        }
    }
}
