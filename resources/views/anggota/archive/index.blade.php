@extends('layouts.dashboard')

@section('title', 'Arsip Surat Saya - E-SKATA')

@section('page-title', 'Arsip Surat Pribadi')

@section('sidebar-menu')
    @include('anggota.partials.sidebar')
@endsection

@section('content')
    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Filter Pencarian</h3>
            <button onclick="document.getElementById('filterForm').reset(); window.location.href='{{ route('anggota.archive.index') }}'" class="text-sm text-gray-600 hover:text-gray-900">
                Reset Filter
            </button>
        </div>
        <form id="filterForm" method="GET" action="{{ route('anggota.archive.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nomor, perihal..."
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Template</label>
                <select name="template_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Template</option>
                    @foreach($templates ?? [] as $template)
                        <option value="{{ $template->id }}" {{ request('template_id') == $template->id ? 'selected' : '' }}>
                            {{ $template->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dari</label>
                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Sampai</label>
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Filter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Template Classification Tabs -->
    @if(isset($suratsByTemplate) && $suratsByTemplate->count() > 0)
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Klasifikasi Berdasarkan Template</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($suratsByTemplate as $templateId => $templateSurats)
                @php
                    $template = $templates->firstWhere('id', $templateId);
                @endphp
                @if($template)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-semibold text-gray-900">{{ $template->name }}</h4>
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                            {{ $templateSurats->count() }} surat
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($template->description ?? 'Tidak ada deskripsi', 60) }}</p>
                    <a href="{{ route('anggota.archive.index', ['template_id' => $template->id]) }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        Lihat Semua →
                    </a>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    <!-- Archive Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Show:</label>
                    <select id="showEntries" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="10" {{ request('per_page', 20) == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20</option>
                        <option value="25" {{ request('per_page', 20) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page', 20) == 50 ? 'selected' : '' }}>50</option>
                    </select>
                    <span class="text-sm text-gray-700">entries</span>
                </div>
                
                <div class="flex items-center space-x-2">
                    <input type="text" id="searchInput" placeholder="Cari surat..." class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-48">
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="dataTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nomor Surat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Perihal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Template</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($surats as $index => $surat)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $surats->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $surat->nomor_surat }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ Str::limit($surat->perihal ?? $surat->hal, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800">
                                    {{ $surat->template->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $surat->tanggal_surat ? (is_string($surat->tanggal_surat) ? $surat->tanggal_surat : $surat->tanggal_surat->format('d/m/Y')) : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('anggota.surat.show', $surat->id) }}" class="text-blue-600 hover:text-blue-900 font-medium" title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    @if($surat->file_pdf)
                                        <a href="{{ route('anggota.surat.download', ['id' => $surat->id, 'type' => 'pdf']) }}" class="text-red-600 hover:text-red-900" title="Download PDF">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                        </a>
                                    @endif
                                    @if($surat->file_word)
                                        <a href="{{ route('anggota.surat.download', ['id' => $surat->id, 'type' => 'word']) }}" class="text-blue-600 hover:text-blue-900" title="Download Word">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="mt-4 text-sm text-gray-500">Tidak ada data surat</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="text-sm text-gray-700 mb-2 sm:mb-0">
                Menampilkan {{ $surats->firstItem() ?? 0 }} sampai {{ $surats->lastItem() ?? 0 }} dari {{ $surats->total() }} entri
            </div>
            <div class="flex items-center space-x-2">
                {{ $surats->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#dataTable tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        document.getElementById('showEntries').addEventListener('change', function(e) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', e.target.value);
            window.location.href = url.toString();
        });
    </script>
    @endpush
@endsection
