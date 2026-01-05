<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Surat;

class ArchiveController extends Controller
{
    /**
     * Display personal archive
     */
    public function index(Request $request)
    {
        $query = Surat::where('user_id', Auth::id())
            ->with('template');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('tujuan', 'like', "%{$search}%");
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

        return view('anggota.archive.index', compact('surats', 'templates', 'suratsByTemplate'));
    }
}
