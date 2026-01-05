@extends('layouts.dashboard')

@section('title', 'Buat Surat Permohonan - E-SKATA')

@section('page-title', 'Buat Surat Permohonan')

@section('sidebar-menu')
    @include('anggota.partials.sidebar')
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Template: {{ $template->name }}</h3>
                <p class="text-sm text-gray-600 mt-1">{{ $template->description ?? 'Tidak ada deskripsi' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">Form Pembuatan Surat Permohonan Pembinaan Sanggar</h1>
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">Silahkan Periksa Kembali</span>
                <ul class="mt-3 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('anggota.surat.store') }}" method="POST">
            @csrf
            <input type="hidden" name="template_id" value="{{ $template->id }}">
            
            <!-- Informasi Surat -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Informasi Surat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nomor_surat" class="block text-gray-700 text-sm font-bold mb-2">Nomor Surat:</label>
                        <input type="text" id="nomor_surat" name="nomor_surat" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('nomor_surat', '10/SBMM/II/2022') }}" placeholder="10/SBMM/II/2022">
                    </div>
                    <div>
                        <label for="lampiran" class="block text-gray-700 text-sm font-bold mb-2">Lampiran:</label>
                        <input type="text" id="lampiran" name="lampiran" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('lampiran', '5 Lembar') }}" required>
                    </div>
                    <div>
                        <label for="hal" class="block text-gray-700 text-sm font-bold mb-2">Hal:</label>
                        <input type="text" id="hal" name="hal" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('hal', 'Permohonan Pembinaan Sanggar') }}" required>
                    </div>
                    <div>
                        <label for="tanggal_surat" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Surat <span class="text-gray-500 text-xs">(Contoh: Bantul, 28 Februari 2022)</span>:</label>
                        <input type="text" id="tanggal_surat" name="tanggal_surat" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tanggal_surat', 'Bantul, 28 Februari 2022') }}" required>
                    </div>
                </div>
            </div>

            <!-- Penerima Surat -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Penerima Surat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="kepada_utama" class="block text-gray-700 text-sm font-bold mb-2">Kepada (Jabatan Utama):</label>
                        <input type="text" id="kepada_utama" name="kepada_utama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('kepada_utama', 'Bapak Gubernur DIY') }}" required>
                    </div>
                    <div>
                        <label for="cq_kedua" class="block text-gray-700 text-sm font-bold mb-2">c.q (Pihak Kedua):</label>
                        <input type="text" id="cq_kedua" name="cq_kedua" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('cq_kedua', 'c.q Kepala Dinas Kebudayaan (Kundha Kabudayan) DIY') }}" required>
                    </div>
                </div>
            </div>

            <!-- Isi Surat -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Isi Surat</h3>
                <div class="mb-4">
                    <label for="paragraf_pembuka" class="block text-gray-700 text-sm font-bold mb-2">Paragraf Pembuka (Latar Belakang):</label>
                    <textarea id="paragraf_pembuka" name="paragraf_pembuka" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('paragraf_pembuka', 'Dengan hormat, sehubungan dengan adanya program pembinaan sanggar oleh Dinas Kebudayaan DIY, bersama ini kami Kelompok Seni "Satrio Budoyo Mudo Mayungan" yang bergerak di bidang kesenian reog wayang bermaksud untuk mengajukan bantuan pembinaan sanggar guna mengembangkan kelompok seni kami.') }}</textarea>
                </div>
                
                <div class="mb-4">
                    <label for="paragraf_permohonan" class="block text-gray-700 text-sm font-bold mb-2">Paragraf Permohonan:</label>
                    <textarea id="paragraf_permohonan" name="paragraf_permohonan" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('paragraf_permohonan', 'Berkenaan dengan adanya keterbatasan dana pada kelompok seni kami, maka dengan ini kami sampaikan permohonan kepada Bapak Gubernur Daerah Istimewa Yogyakarta melalui Dinas Kebudayaan DIY agar berkenan memberi bantuan pembinaan sanggar.') }}</textarea>
                </div>
                
                <div class="mb-4">
                    <label for="paragraf_penutup" class="block text-gray-700 text-sm font-bold mb-2">Paragraf Penutup:</label>
                    <textarea id="paragraf_penutup" name="paragraf_penutup" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('paragraf_penutup', 'Besar harapan kami agar Bapak/Ibu berkenan mengabulkan permohonan ini. Atas bantuan dan kerja sama yang Bapak/Ibu berikan kami ucapkan terima kasih.') }}</textarea>
                </div>
            </div>

            <!-- Tanda Tangan -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Tanda Tangan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="ketua_nama" class="block text-gray-700 text-sm font-bold mb-2">Ketua Paguyuban (Nama):</label>
                        <input type="text" id="ketua_nama" name="ketua_nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('ketua_nama', 'Imam Arba\'in Dwijaya') }}" required>
                    </div>
                    <div>
                        <label for="sekretaris_nama" class="block text-gray-700 text-sm font-bold mb-2">Sekretaris Paguyuban (Nama):</label>
                        <input type="text" id="sekretaris_nama" name="sekretaris_nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('sekretaris_nama', 'Ferawati Putri Iskatriana') }}" required>
                    </div>
                </div>

                <h4 class="text-md font-semibold text-gray-800 mb-3">Mengetahui: <span class="text-gray-500 text-sm font-normal">(Opsional)</span></h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="mengetahui_1_jabatan" class="block text-gray-700 text-sm font-bold mb-2">Jabatan 1 (Panewu):</label>
                        <input type="text" id="mengetahui_1_jabatan" name="mengetahui_1_jabatan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" value="{{ old('mengetahui_1_jabatan', 'Panewu Kapanewon Sanden') }}">
                        <label for="mengetahui_1_nama" class="block text-gray-700 text-sm font-bold mb-2">Nama/TTD:</label>
                        <input type="text" id="mengetahui_1_nama" name="mengetahui_1_nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('mengetahui_1_nama') }}">
                    </div>
                    <div>
                        <label for="mengetahui_2_jabatan" class="block text-gray-700 text-sm font-bold mb-2">Jabatan 2 (Lurah):</label>
                        <input type="text" id="mengetahui_2_jabatan" name="mengetahui_2_jabatan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" value="{{ old('mengetahui_2_jabatan', 'Lurah Kelurahan Murtigading') }}">
                        <label for="mengetahui_2_nama" class="block text-gray-700 text-sm font-bold mb-2">Nama/TTD:</label>
                        <input type="text" id="mengetahui_2_nama" name="mengetahui_2_nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('mengetahui_2_nama') }}">
                    </div>
                </div>
                <div>
                    <label for="tembusan_jabatan" class="block text-gray-700 text-sm font-bold mb-2">Kepala Dinas (Tembusan):</label>
                    <input type="text" id="tembusan_jabatan" name="tembusan_jabatan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tembusan_jabatan', 'Kepala Dinas Kebudayaan Kabupaten Bantul') }}">
                    <label for="tembusan_nama" class="block text-gray-700 text-sm font-bold mb-2 mt-2">Nama/TTD:</label>
                    <input type="text" id="tembusan_nama" name="tembusan_nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tembusan_nama') }}">
                </div>
            </div>

            <div class="flex items-center justify-center space-x-4">
                <a href="{{ route('anggota.templates.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Generate Surat
                </button>
            </div>
        </form>
    </div>
@endsection

