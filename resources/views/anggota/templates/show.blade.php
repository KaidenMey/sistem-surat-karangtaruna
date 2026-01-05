@extends('layouts.dashboard')

@section('title', 'Detail Template - E-SKATA')

@section('page-title', 'Detail Template')

@section('sidebar-menu')
    @include('anggota.partials.sidebar')
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">{{ $template->name }}</h3>
            <a href="{{ route('anggota.surat.create', ['template_id' => $template->id]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Gunakan Template Ini
            </a>
        </div>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tipe Template</label>
                @if($template->isSystemTemplate())
                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">Template Default Sistem</span>
                @else
                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">Template Admin</span>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Deskripsi</label>
                <p class="text-gray-900">{{ $template->description ?? 'Tidak ada deskripsi' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                @if($template->is_active)
                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">Aktif</span>
                @else
                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                @endif
            </div>

            @if($template->form_fields && count($template->form_fields) > 0)
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Field yang Perlu Diisi</label>
                    <div class="space-y-2">
                        @foreach($template->form_fields as $field)
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-700">{{ $field['label'] ?? $field['name'] }}</span>
                                <span class="px-2 py-0.5 text-xs rounded bg-gray-100 text-gray-600">{{ $field['type'] ?? 'text' }}</span>
                                @if($field['required'] ?? false)
                                    <span class="px-2 py-0.5 text-xs rounded bg-red-100 text-red-600">Wajib</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <a href="{{ route('anggota.templates.index') }}" class="text-blue-600 hover:text-blue-700">
                ← Kembali ke Daftar Template
            </a>
        </div>
    </div>
@endsection

