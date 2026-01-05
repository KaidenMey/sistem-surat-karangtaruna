<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surat;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    /**
     * Display all surats (system archive)
     */
    public function index(Request $request)
    {
        $query = Surat::with(['user', 'template']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('tujuan', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by template
        if ($request->filled('template_id')) {
            $query->where('template_id', $request->template_id);
        }

        // Filter by date
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_surat', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_surat', '<=', $request->tanggal_sampai);
        }

        $perPage = $request->get('per_page', 20);
        $surats = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Get templates for filter
        $templates = \App\Models\Template::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Group surats by template for classification
        $suratsByTemplate = $surats->groupBy('template_id');

        return view('admin.archive.index', compact('surats', 'templates', 'suratsByTemplate'));
    }

    /**
     * Download surat file (PDF or Word)
     */
    public function download(Request $request, $id, $type = 'pdf')
    {
        $surat = Surat::findOrFail($id);
        
        $filePath = $type === 'word' ? $surat->file_word : $surat->file_pdf;

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        // Clean filename - remove invalid characters
        $cleanNomorSurat = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $surat->nomor_surat);
        $fileName = 'Surat_' . $cleanNomorSurat . '_' . time() . '.' . ($type === 'word' ? 'docx' : 'pdf');
        return Storage::disk('public')->download($filePath, $fileName);
    }
}
