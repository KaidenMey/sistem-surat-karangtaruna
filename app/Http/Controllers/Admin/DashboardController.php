<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Surat;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_surat' => Surat::count(),
            'total_anggota' => User::where('role', 'anggota')->count(),
            'surat_bulan_ini' => Surat::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'surat_hari_ini' => Surat::whereDate('created_at', today())->count(),
        ];

        $recentLogs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentLogs'));
    }
}
