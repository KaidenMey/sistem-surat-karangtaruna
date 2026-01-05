@extends('layouts.dashboard')

@section('title', 'Buat Surat Proposal - E-SKATA')

@section('page-title', 'Buat Surat Proposal')

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
        <h1 class="text-2xl font-bold mb-6 text-center">Form Pembuatan Surat Proposal</h1>
        
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
            
            <!-- Info Surat -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Informasi Surat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nomor_surat" class="block text-gray-700 text-sm font-bold mb-2">Nomor Surat:</label>
                        <input type="text" id="nomor_surat" name="nomor_surat" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('nomor_surat', '05/SBMM/IX/2025') }}" placeholder="05/SBMM/IX/2025">
                    </div>
                    <div>
                        <label for="hal" class="block text-gray-700 text-sm font-bold mb-2">Perihal:</label>
                        <input type="text" id="hal" name="hal" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('hal', 'Proposal Kegiatan Gelar Wisata Budaya') }}" required>
                        <input type="hidden" name="perihal" value="{{ old('hal', 'Proposal Kegiatan Gelar Wisata Budaya') }}">
                    </div>
                    <div>
                        <label for="lampiran" class="block text-gray-700 text-sm font-bold mb-2">Lampiran:</label>
                        <input type="text" id="lampiran" name="lampiran" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('lampiran', '3 lembar') }}" required>
                    </div>
                    <div>
                        <label for="tanggal_surat" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Surat <span class="text-gray-500 text-xs">(Contoh: 11 Februari 2025)</span>:</label>
                        <input type="text" id="tanggal_surat" name="tanggal_surat" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tanggal_surat', date('d F Y')) }}" required>
                    </div>
                </div>
            </div>

            <!-- Penerima -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Penerima Surat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="kepada" class="block text-gray-700 text-sm font-bold mb-2">Kepada:</label>
                        <input type="text" id="kepada" name="kepada" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('kepada', 'Bapak Gubernur DIY') }}" required>
                    </div>
                    <div>
                        <label for="cq" class="block text-gray-700 text-sm font-bold mb-2">c.q (Pihak Kedua):</label>
                        <input type="text" id="cq" name="cq" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('cq', 'Kepala Dinas Pariwisata DIY di Yogyakarta') }}" required>
                    </div>
                </div>
            </div>

            <!-- Isi Surat -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Isi Surat</h3>
                <div class="mb-4">
                    <label for="paragraf_pembuka" class="block text-gray-700 text-sm font-bold mb-2">Paragraf Pembuka (Setelah Assalamu'alaikum):</label>
                    <textarea id="paragraf_pembuka" name="paragraf_pembuka" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('paragraf_pembuka', 'Dengan memanjatkan Puji syukur atas kehadirat Allah SWT, semoga kita senantiasa dalam keadaan sehat serta selalu berada dalam lindungan-Nya. Sehubungan dengan adanya agenda Morosene dalam rangka meningkatkan wisata dan budaya, bersama ini kami paguyuban reog wayang Satrio Budoyo Mudo Mayungan bermaksud untuk mengadakan pentas reog wayang yang akan diselenggarakan pada:') }}</textarea>
                </div>
                
                <div class="mb-4">
                    <h4 class="text-md font-semibold text-gray-800 mb-3">Detail Kegiatan:</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="hari_tanggal_kegiatan" class="block text-gray-700 text-sm font-bold mb-2">Hari, Tanggal:</label>
                            <input type="text" id="hari_tanggal_kegiatan" name="hari_tanggal_kegiatan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('hari_tanggal_kegiatan', 'Sabtu, 24 Oktober 2014') }}" required>
                        </div>
                        <div>
                            <label for="tempat_kegiatan" class="block text-gray-700 text-sm font-bold mb-2">Tempat:</label>
                            <input type="text" id="tempat_kegiatan" name="tempat_kegiatan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tempat_kegiatan', 'Lapangan Bola Voli Mayungan') }}" required>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="paragraf_permohonan" class="block text-gray-700 text-sm font-bold mb-2">Paragraf Permohonan:</label>
                    <textarea id="paragraf_permohonan" name="paragraf_permohonan" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('paragraf_permohonan', 'Sehubungan dengan hal tersebut, kami selaku panitia pelaksana mengharapkan kesediaan Bapak/Ibu untuk berkenan memberikan bantuan dana demi terselenggaranya kegiatan tersebut.') }}</textarea>
                </div>
                
                <div class="mb-4">
                    <label for="paragraf_penutup" class="block text-gray-700 text-sm font-bold mb-2">Paragraf Penutup:</label>
                    <textarea id="paragraf_penutup" name="paragraf_penutup" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('paragraf_penutup', 'Demikian surat permohonan ini kami sampaikan. Besar harapan kami kiranya Bapak/Ibu dapat berpartisipasi dalam kegiatan ini. Atas bantuan dan perhatiannya kami ucapkan terima kasih.') }}</textarea>
                </div>
            </div>

            <!-- Tanda Tangan -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Tanda Tangan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="kota_penetapan" class="block text-gray-700 text-sm font-bold mb-2">Kota Penetapan:</label>
                        <input type="text" id="kota_penetapan" name="kota_penetapan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('kota_penetapan', 'Bantul') }}" required>
                    </div>
                    <div>
                        <label for="tanggal_penetapan" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Penetapan TTD:</label>
                        <input type="date" id="tanggal_penetapan" name="tanggal_penetapan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tanggal_penetapan', date('Y-m-d')) }}" required>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="ketua_nama" class="block text-gray-700 text-sm font-bold mb-2">Ketua Paguyuban (Nama):</label>
                        <input type="text" id="ketua_nama" name="ketua_nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('ketua_nama', 'Imam Arba\'in Dwijaya') }}" required>
                    </div>
                    <div>
                        <label for="sekretaris_nama" class="block text-gray-700 text-sm font-bold mb-2">Sekretaris Paguyuban (Nama):</label>
                        <input type="text" id="sekretaris_nama" name="sekretaris_nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('sekretaris_nama', 'Nia Trinadani') }}" required>
                    </div>
                </div>

                <h4 class="text-md font-semibold text-gray-800 mb-3">Mengetahui: <span class="text-gray-500 text-sm font-normal">(Opsional)</span></h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="mengetahui_1_jabatan" class="block text-gray-700 text-sm font-bold mb-2">Jabatan 1:</label>
                        <input type="text" id="mengetahui_1_jabatan" name="mengetahui_1_jabatan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" value="{{ old('mengetahui_1_jabatan', 'Panewu Kapanewon Sanden') }}">
                        <label for="mengetahui_1_nama" class="block text-gray-700 text-sm font-bold mb-2">Nama/TTD:</label>
                        <input type="text" id="mengetahui_1_nama" name="mengetahui_1_nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('mengetahui_1_nama') }}">
                    </div>
                    <div>
                        <label for="mengetahui_2_jabatan" class="block text-gray-700 text-sm font-bold mb-2">Jabatan 2:</label>
                        <input type="text" id="mengetahui_2_jabatan" name="mengetahui_2_jabatan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" value="{{ old('mengetahui_2_jabatan', 'Lurah Kelurahan Murtigading') }}">
                        <label for="mengetahui_2_nama" class="block text-gray-700 text-sm font-bold mb-2">Nama/TTD:</label>
                        <input type="text" id="mengetahui_2_nama" name="mengetahui_2_nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('mengetahui_2_nama') }}">
                    </div>
                    <div>
                        <label for="mengetahui_3_jabatan" class="block text-gray-700 text-sm font-bold mb-2">Jabatan 3:</label>
                        <input type="text" id="mengetahui_3_jabatan" name="mengetahui_3_jabatan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" value="{{ old('mengetahui_3_jabatan', 'Kepala Dinas Pariwisata Kabupaten Bantul') }}">
                        <label for="mengetahui_3_nama" class="block text-gray-700 text-sm font-bold mb-2">Nama/TTD:</label>
                        <input type="text" id="mengetahui_3_nama" name="mengetahui_3_nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('mengetahui_3_nama') }}">
                    </div>
                </div>
            </div>

            <!-- Tembusan -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Tembusan <span class="text-gray-500 text-sm font-normal">(Opsional)</span></h3>
                <label for="tembusan" class="block text-gray-700 text-sm font-bold mb-2">Tembusan:</label>
                <input type="text" id="tembusan" name="tembusan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tembusan', 'Kepala Dinas Pariwisata Kabupaten Bantul') }}">
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

