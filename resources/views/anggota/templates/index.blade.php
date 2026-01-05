@extends('layouts.dashboard')

@section('title', 'Template Surat - E-SKATA')

@section('page-title', 'Daftar Template Surat')

@section('sidebar-menu')
    @include('anggota.partials.sidebar')
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900">Pilih Template</h3>
        <p class="text-sm text-gray-600 mt-1">Pilih template surat yang ingin Anda gunakan</p>
    </div>

    <!-- System Templates (Default) -->
    @if($systemTemplates->count() > 0)
        <div class="mb-8">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-1 h-8 bg-blue-600 rounded"></div>
                <h3 class="text-xl font-bold text-gray-900">Template Default Sistem</h3>
            </div>
            <p class="text-sm text-gray-600 mb-4">Template standar yang tersedia langsung di sistem</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($systemTemplates as $template)
                    @php
                        $isUndangan = strtolower($template->name) === 'surat undangan';
                        $isProposal = strtolower($template->name) === 'surat proposal';
                        $isPermohonan = strtolower($template->name) === 'surat permohonan';
                        $isDisabled = !$isUndangan && !$isProposal && !$isPermohonan;
                    @endphp
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition border-2 border-blue-200 {{ $isDisabled ? 'opacity-50' : '' }}">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $template->name }}</h4>
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">Default</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($template->description ?? 'Template standar sistem', 100) }}</p>
                            @if($isDisabled)
                                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-3 py-2 rounded mb-4 text-sm">
                                    Template sedang dalam perbaikan
                                </div>
                            @endif
                            <div class="flex items-center justify-between">
                                <a href="{{ route('anggota.templates.show', $template->id) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    Lihat Detail →
                                </a>
                                @if($isDisabled)
                                    <button disabled class="bg-gray-400 text-white px-4 py-2 rounded-lg cursor-not-allowed text-sm font-medium">
                                        Tidak Tersedia
                                    </button>
                                @else
                                    <a href="{{ route('anggota.surat.create', ['template_id' => $template->id]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                        Gunakan
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Admin Templates (Custom) -->
    @if($adminTemplates->count() > 0)
        <div class="mb-8">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-1 h-8 bg-green-600 rounded"></div>
                <h3 class="text-xl font-bold text-gray-900">Template Admin</h3>
            </div>
            <p class="text-sm text-gray-600 mb-4">Template khusus yang dibuat oleh admin</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($adminTemplates as $template)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $template->name }}</h4>
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Custom</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($template->description ?? 'Template khusus admin', 100) }}</p>
                            <div class="flex items-center justify-between">
                                <a href="{{ route('anggota.templates.show', $template->id) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    Lihat Detail →
                                </a>
                                <a href="{{ route('anggota.surat.create', ['template_id' => $template->id]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                    Gunakan
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($systemTemplates->count() == 0 && $adminTemplates->count() == 0)
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
            </svg>
            <p class="mt-4 text-gray-500">Belum ada template yang tersedia</p>
        </div>
    @endif
@endsection

