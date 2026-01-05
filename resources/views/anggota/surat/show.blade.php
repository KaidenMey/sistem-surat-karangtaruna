@extends('layouts.dashboard')

@section('title', 'Detail Surat - E-SKATA')

@section('page-title', 'Detail Surat')

@section('sidebar-menu')
    @include('anggota.partials.sidebar')
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Detail Surat</h3>
                <p class="text-sm text-gray-500 mt-1">Nomor: {{ $surat->nomor_surat }}</p>
            </div>
            <a href="{{ route('anggota.archive.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Arsip</span>
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('warning'))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Perhatian!</strong>
                <span class="block sm:inline">{{ session('warning') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Preview Surat -->
        <div class="bg-white rounded-xl shadow-lg p-6 mt-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Preview Surat</h3>
                <div class="flex items-center space-x-2">
                    @if($surat->file_pdf)
                        <a href="{{ route('anggota.surat.download', ['id' => $surat->id, 'type' => 'pdf']) }}" target="_blank" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <span>Download PDF</span>
                        </a>
                    @else
                        <a href="{{ route('anggota.surat.download', ['id' => $surat->id, 'type' => 'pdf']) }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>Generate & Download PDF</span>
                        </a>
                    @endif
                    @if($surat->file_word)
                        <a href="{{ route('anggota.surat.download', ['id' => $surat->id, 'type' => 'word']) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <span>Download Word</span>
                        </a>
                    @else
                        <a href="{{ route('anggota.surat.download', ['id' => $surat->id, 'type' => 'word']) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>Generate & Download Word</span>
                        </a>
                    @endif
                </div>
            </div>
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 overflow-auto">
                @php
                    $fileExists = $surat->file_html && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat->file_html);
                @endphp
                @if($fileExists)
                    <iframe src="{{ asset('storage/' . $surat->file_html) }}" class="w-full border-0 rounded-lg" style="min-height: 800px; height: 1000px;"></iframe>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="mt-4 text-gray-500">Preview belum tersedia. Silakan klik tombol Download PDF atau Word untuk generate file.</p>
                        <div class="mt-4 flex justify-center space-x-4">
                            <a href="{{ route('anggota.surat.download', ['id' => $surat->id, 'type' => 'pdf']) }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                Generate & Download PDF
                            </a>
                            <a href="{{ route('anggota.surat.download', ['id' => $surat->id, 'type' => 'word']) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Generate & Download Word
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Surat</label>
                <p class="text-lg font-semibold text-gray-900">{{ $surat->nomor_surat }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Surat</label>
                <p class="text-lg text-gray-900">
                    @if($surat->tanggal_surat)
                        @if(is_string($surat->tanggal_surat))
                            {{ $surat->tanggal_surat }}
                        @else
                            {{ $surat->tanggal_surat->format('d F Y') }}
                        @endif
                    @else
                        -
                    @endif
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Lampiran</label>
                <p class="text-lg text-gray-900">{{ $surat->lampiran ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Hal</label>
                <p class="text-lg text-gray-900">{{ $surat->hal ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Template</label>
                <p class="text-lg text-gray-900">{{ $surat->template->name }}</p>
            </div>

            @if($surat->penerima && is_array($surat->penerima))
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">Penerima</label>
                <div class="bg-gray-50 rounded-lg p-4">
                    <ol class="list-decimal list-inside space-y-1">
                        @foreach($surat->penerima as $penerima)
                            <li class="text-gray-900">{{ $penerima }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
            @endif

            @if($surat->isi_surat)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">Isi Surat</label>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-900 whitespace-pre-line">{{ $surat->isi_surat }}</p>
                </div>
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Kota Penetapan</label>
                <p class="text-lg text-gray-900">{{ $surat->kota_penetapan ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Penetapan</label>
                <p class="text-lg text-gray-900">{{ $surat->tanggal_penetapan ? $surat->tanggal_penetapan->format('d F Y') : '-' }}</p>
            </div>

            @if($surat->tanda_tangan && is_array($surat->tanda_tangan) && count($surat->tanda_tangan) > 0)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">Penanda Tangan</label>
                <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                    @foreach($surat->tanda_tangan as $index => $ttd)
                        <div class="border-b border-gray-200 pb-3 last:border-0 last:pb-0">
                            <h4 class="font-semibold text-gray-700 mb-2">Penanda Tangan {{ $index + 1 }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Jabatan</label>
                                    <p class="text-sm text-gray-900">{{ $ttd['jabatan'] ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Nama</label>
                                    <p class="text-sm text-gray-900">{{ $ttd['nama'] ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">NIP</label>
                                    <p class="text-sm text-gray-900">{{ $ttd['nip'] ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @else
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Jabatan Penanda Tangan</label>
                <p class="text-lg text-gray-900">{{ $surat->jabatan_penanda_tangan ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Penanda Tangan</label>
                <p class="text-lg text-gray-900">{{ $surat->nama_penanda_tangan ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">NIP Penanda Tangan</label>
                <p class="text-lg text-gray-900">{{ $surat->nip_penanda_tangan ?? '-' }}</p>
            </div>
            @endif

            @if($surat->tembusan && is_array($surat->tembusan) && count($surat->tembusan) > 0)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">Tembusan</label>
                <div class="bg-gray-50 rounded-lg p-4">
                    <ol class="list-decimal list-inside space-y-1">
                        @foreach($surat->tembusan as $tembusan)
                            <li class="text-gray-900">{{ $tembusan }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection


