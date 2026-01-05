@extends('layouts.dashboard')

@section('title', 'Detail Template - E-SKATA')

@section('page-title', 'Detail Template')

@section('sidebar-menu')
    @include('admin.partials.sidebar')
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Template</h3>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.templates.edit', $template->id) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Edit
                </a>
                <a href="{{ route('admin.templates.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Template</label>
                <p class="text-lg text-gray-900">{{ $template->name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                <p>
                    @if($template->is_active)
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">Aktif</span>
                    @else
                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                    @endif
                </p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">Deskripsi</label>
                <p class="text-lg text-gray-900">{{ $template->description ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Dibuat</label>
                <p class="text-lg text-gray-900">{{ $template->created_at->format('d F Y') }}</p>
            </div>

            @if($template->file_path)
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">File Template</label>
                <a href="{{ Storage::url($template->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-700 underline">
                    Download File
                </a>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">File template </label>
            </div>
            @endif
        </div>
    </div>
@endsection








