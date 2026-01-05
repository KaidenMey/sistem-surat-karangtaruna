@extends('layouts.dashboard')

@section('title', 'Detail Anggota - E-SKATA')

@section('page-title', 'Detail Anggota')

@section('sidebar-menu')
    @include('admin.partials.sidebar')
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Anggota</h3>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Edit
                </a>
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                <p class="text-lg text-gray-900">{{ $user->name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                <p class="text-lg text-gray-900">{{ $user->email }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">No. Telepon</label>
                <p class="text-lg text-gray-900">{{ $user->phone ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Daftar</label>
                <p class="text-lg text-gray-900">{{ $user->created_at->format('d F Y') }}</p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">Alamat</label>
                <p class="text-lg text-gray-900">{{ $user->address ?? '-' }}</p>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200">
            <h4 class="text-md font-semibold text-gray-900 mb-4">Statistik</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600">Total Surat Dibuat</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $user->surats_count }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

