@extends('layouts.dashboard')

@section('title', 'Dashboard Anggota - E-SKATA')

@section('page-title', 'Dashboard')

@section('sidebar-menu')
    @include('anggota.partials.sidebar')
@endsection

@section('content')
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-lg p-6 mb-6 text-white">
        <h3 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}</h3>
        <p class="text-blue-100">Berikut adalah ringkasan surat yang telah Anda buat</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Surat -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Surat Saya</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_surat'] }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Surat Bulan Ini -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Surat Bulan Ini</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['surat_bulan_ini'] }}</p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Surat Hari Ini -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Surat Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['surat_hari_ini'] }}</p>
                </div>
                <div class="w-14 h-14 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <a href="{{ route('anggota.templates.index') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition flex items-center space-x-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">Buat Surat Baru</h3>
                <p class="text-sm text-gray-600">Pilih template untuk membuat surat baru</p>
            </div>
        </a>

        <a href="{{ route('anggota.archive.index') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition flex items-center space-x-4">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">Arsip Surat</h3>
                <p class="text-sm text-gray-600">Lihat dan kelola surat yang telah dibuat</p>
            </div>
        </a>
    </div>

    <!-- Recent Surats -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Riwayat Surat Terbaru</h3>
            <a href="{{ route('anggota.archive.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                Lihat Semua →
            </a>
        </div>
        
        @if($surats->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Surat</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Template</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($surats as $surat)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $surat->nomor_surat }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $surat->perihal }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                    {{ $surat->template->name }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                    {{ $surat->tanggal_surat->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <a href="{{ route('anggota.surat.show', $surat->id) }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="mt-2">Belum ada surat yang dibuat</p>
                <a href="{{ route('anggota.templates.index') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-700 font-medium">
                    Buat surat pertama Anda →
                </a>
            </div>
        @endif
    </div>
@endsection

