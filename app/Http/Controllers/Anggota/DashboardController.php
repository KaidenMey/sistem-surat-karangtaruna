<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Surat;

class DashboardController extends Controller
{
    /**
     * Display anggota dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        $surats = Surat::where('user_id', $user->id)
            ->with('template')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $stats = [
            'total_surat' => Surat::where('user_id', $user->id)->count(),
            'surat_bulan_ini' => Surat::where('user_id', $user->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'surat_hari_ini' => Surat::where('user_id', $user->id)
                ->whereDate('created_at', today())
                ->count(),
        ];

        return view('anggota.dashboard', compact('surats', 'stats'));
    }
}
