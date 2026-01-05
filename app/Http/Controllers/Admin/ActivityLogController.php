<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    /**
     * Display activity logs
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by date
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }

        $perPage = $request->get('per_page', 50);
        $logs = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return view('admin.activity-logs.index', compact('logs'));
    }

    /**
     * Show detailed log
     */
    public function show($id)
    {
        $log = ActivityLog::with('user')->findOrFail($id);
        return view('admin.activity-logs.show', compact('log'));
    }

    /**
     * Reset all activity logs
     */
    public function reset()
    {
        ActivityLog::truncate();

        return redirect()
            ->route('admin.activity-logs.index')
            ->with('success', 'Log aktivitas berhasil direset.');
    }
}
