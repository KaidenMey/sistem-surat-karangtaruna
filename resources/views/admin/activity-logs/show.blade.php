@extends('layouts.dashboard')

@section('title', 'Detail Log Aktivitas - E-SKATA')

@section('page-title', 'Detail Log Aktivitas')

@section('sidebar-menu')
    @include('admin.partials.sidebar')
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Detail Log Aktivitas</h3>
            <a href="{{ route('admin.activity-logs.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Waktu</label>
                <p class="text-lg text-gray-900">{{ $log->created_at->format('d F Y H:i:s') }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">User</label>
                <p class="text-lg text-gray-900">{{ $log->user->name ?? 'System' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Aksi</label>
                <p>
                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">{{ $log->action }}</span>
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">IP Address</label>
                <p class="text-lg text-gray-900">{{ $log->ip_address ?? '-' }}</p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">Deskripsi</label>
                <p class="text-lg text-gray-900">{{ $log->description ?? '-' }}</p>
            </div>

            @if($log->metadata)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">Metadata</label>
                <pre class="bg-gray-50 p-4 rounded-lg text-sm overflow-x-auto">{{ json_encode($log->metadata, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif
        </div>
    </div>
@endsection








