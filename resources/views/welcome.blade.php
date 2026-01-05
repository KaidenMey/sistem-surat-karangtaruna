@extends('layouts.app')

@section('title', 'E-SKATA - Sistem Elektronik Surat Karang Taruna')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <!-- Navigation Header -->
    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">E-SKATA</h1>
                        <p class="text-xs text-gray-500 hidden sm:block">Sistem Elektronik Surat Karang Taruna</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative overflow-hidden pt-20 pb-32">
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <div class="inline-block mb-6">
                    <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                        ✨ Sistem Terbaru 2025
                    </span>
                </div>
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-gray-900 mb-6 leading-tight">
                    Kelola Surat Karang Taruna
                    <span class="block bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        Lebih Mudah & Efisien
                    </span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-600 mb-10 max-w-3xl mx-auto leading-relaxed">
                    Platform digital terintegrasi untuk pengelolaan surat resmi Karang Taruna dengan 
                    <span class="font-semibold text-gray-800">template siap pakai</span>, 
                    <span class="font-semibold text-gray-800">penomoran otomatis</span>, dan 
                    <span class="font-semibold text-gray-800">arsip digital</span> yang aman.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="group bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 flex items-center space-x-2">
                        <span>Mulai Sekarang</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    <a href="{{ route('login') }}" class="bg-white text-gray-700 px-8 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl border-2 border-gray-200 hover:border-blue-300 transform hover:-translate-y-1 transition-all duration-300">
                        Masuk ke Akun
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Decorative Elements -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-indigo-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white/50 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Fitur Unggulan
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Semua yang Anda butuhkan untuk mengelola surat resmi Karang Taruna dalam satu platform
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Template Profesional</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Berbagai template surat resmi siap pakai dengan kop surat standar Karang Taruna
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Penomoran Otomatis</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Sistem penomoran surat otomatis yang terorganisir sesuai standar format resmi
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Arsip Digital</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Penyimpanan arsip surat secara digital yang aman, terorganisir, dan mudah dicari
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Keamanan Terjamin</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Sistem keamanan berlapis dengan enkripsi data dan kontrol akses yang ketat
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center text-white">
                    <div class="inline-block bg-white/20 backdrop-blur-sm rounded-2xl p-6 mb-4">
                        <svg class="w-12 h-12 text-white mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <p class="text-5xl font-extrabold mb-2">
                        @php
                            try {
                                $suratCount = \App\Models\Surat::count();
                            } catch (\Exception $e) {
                                $suratCount = 0;
                            }
                        @endphp
                        {{ number_format($suratCount) }}
                    </p>
                    <p class="text-blue-100 text-lg font-semibold">Total Surat</p>
                </div>

                <div class="text-center text-white">
                    <div class="inline-block bg-white/20 backdrop-blur-sm rounded-2xl p-6 mb-4">
                        <svg class="w-12 h-12 text-white mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <p class="text-5xl font-extrabold mb-2">
                        @php
                            try {
                                $anggotaCount = \App\Models\User::where('role', 'anggota')->count();
                            } catch (\Exception $e) {
                                $anggotaCount = 0;
                            }
                        @endphp
                        {{ number_format($anggotaCount) }}
                    </p>
                    <p class="text-blue-100 text-lg font-semibold">Total Anggota</p>
                </div>

                <div class="text-center text-white">
                    <div class="inline-block bg-white/20 backdrop-blur-sm rounded-2xl p-6 mb-4">
                        <svg class="w-12 h-12 text-white mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                        </svg>
                    </div>
                    <p class="text-5xl font-extrabold mb-2">
                        @php
                            try {
                                $templateCount = \App\Models\Template::where('is_active', true)->count();
                            } catch (\Exception $e) {
                                $templateCount = 0;
                            }
                        @endphp
                        {{ number_format($templateCount) }}
                    </p>
                    <p class="text-blue-100 text-lg font-semibold">Template Tersedia</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl p-12 border border-blue-100">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Siap Memulai?
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Bergabunglah dengan Karang Taruna yang sudah menggunakan E-SKATA untuk pengelolaan surat yang lebih efisien
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                        Daftar Sekarang - Gratis
                    </a>
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-semibold text-lg transition-colors">
                        Sudah punya akun? Masuk →
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white">E-SKATA</h3>
                    </div>
                    <p class="text-gray-400">
                        Sistem Elektronik untuk pengelolaan surat Karang Taruna yang modern dan terintegrasi.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Fitur Utama</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white transition-colors">Template Surat</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Penomoran Otomatis</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Arsip Digital</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Keamanan Data</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Karang Taruna Morosene</li>
                        <li>Kabupaten Bantul, Yogyakarta</li>
                        <li>Email: kt.morosene@gmail.com</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} E-SKATA. Hak Cipta Dilindungi. Sistem Elektronik Surat Karang Taruna.</p>
            </div>
        </div>
    </footer>
</div>

<style>
    @keyframes blob {
        0% {
            transform: translate(0px, 0px) scale(1);
        }
        33% {
            transform: translate(30px, -50px) scale(1.1);
        }
        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }
        100% {
            transform: translate(0px, 0px) scale(1);
        }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    .bg-grid-pattern {
        background-image: 
            linear-gradient(to right, rgba(0,0,0,0.1) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(0,0,0,0.1) 1px, transparent 1px);
        background-size: 50px 50px;
    }
</style>
@endsection
