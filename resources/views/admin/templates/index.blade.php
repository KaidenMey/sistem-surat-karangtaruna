@extends('layouts.dashboard')

@section('title', 'Kelola Template - E-SKATA')

@section('page-title', 'Kelola Template Surat')

@section('sidebar-menu')
    @include('admin.partials.sidebar')
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Daftar Template</h3>
                <p class="text-sm text-gray-600 mt-1">Kelola template surat yang tersedia</p>
            </div>
            <a href="{{ route('admin.templates.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Template</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-2">
                <label class="text-sm text-gray-700">Show:</label>
                <select id="showEntries" class="border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span class="text-sm text-gray-700">entries</span>
            </div>
            
            <div class="flex items-center space-x-2">
                <button onclick="exportTable('copy')" class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50 transition">Copy</button>
                <button onclick="exportTable('csv')" class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50 transition">CSV</button>
                <button onclick="exportTable('excel')" class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50 transition">Excel</button>
                <button onclick="exportTable('pdf')" class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50 transition">PDF</button>
                <button onclick="window.print()" class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50 transition">Print</button>
            </div>
            
            <div class="flex items-center space-x-2">
                <label class="text-sm text-gray-700">Search:</label>
                <input type="text" id="searchInput" placeholder="Cari template..." class="border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-48">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="dataTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Template</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($templates as $index => $template)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $templates->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $template->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($template->description ?? '-', 50) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($template->is_active)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $template->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.templates.show', $template->id) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                    @if(!$template->isSystemTemplate())
                                        <a href="{{ route('admin.templates.edit', $template->id) }}" class="text-green-600 hover:text-green-900">Edit</a>
                                        <form action="{{ route('admin.templates.destroy', $template->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus template ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-xs">(System Template)</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                Tidak ada data template
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="text-sm text-gray-700 mb-2 sm:mb-0">
                Showing {{ $templates->firstItem() ?? 0 }} to {{ $templates->lastItem() ?? 0 }} of {{ $templates->total() }} entries
            </div>
            <div class="flex items-center space-x-2">
                {{ $templates->links() }}
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
            window.location.href = '{{ route('admin.templates.index') }}?per_page=' + e.target.value;
        });

        function exportTable(format) {
            alert('Fitur export ' + format.toUpperCase() + ' akan segera tersedia');
        }
    </script>
    @endpush
@endsection

