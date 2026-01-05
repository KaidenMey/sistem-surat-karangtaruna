<a href="{{ route('anggota.dashboard') }}" class="flex items-center space-x-3 px-3 py-2 {{ request()->routeIs('anggota.dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
    </svg>
    <span>Dashboard</span>
</a>

<a href="{{ route('anggota.templates.index') }}" class="flex items-center space-x-3 px-3 py-2 {{ request()->routeIs('anggota.templates.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
    </svg>
    <span>Template Surat</span>
</a>

<a href="{{ route('anggota.archive.index') }}" class="flex items-center space-x-3 px-3 py-2 {{ request()->routeIs('anggota.archive.*') || request()->routeIs('anggota.surat.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
    </svg>
    <span>Arsip Surat Saya</span>
</a>








