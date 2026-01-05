@extends('layouts.dashboard')

@section('title', 'Buat Surat Baru - E-SKATA')

@section('page-title', 'Buat Surat Baru')

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
        <h1 class="text-2xl font-bold mb-6 text-center">Form Pembuatan Surat</h1>
        
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
            
            <!-- Field Standar (Selalu Ada) -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Informasi Surat</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="nomor_surat" class="block text-gray-700 text-sm font-bold mb-2">Nomor Surat:</label>
                        <input type="text" id="nomor_surat" name="nomor_surat" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('nomor_surat') }}" placeholder="Akan di-generate otomatis jika kosong">
                    </div>
                    <div>
                        <label for="tanggal_surat" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Surat:</label>
                        <input type="date" id="tanggal_surat" name="tanggal_surat" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tanggal_surat', date('Y-m-d')) }}" required>
                    </div>
                    <div>
                        <label for="lampiran" class="block text-gray-700 text-sm font-bold mb-2">Lampiran:</label>
                        <input type="text" id="lampiran" name="lampiran" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('lampiran', '-') }}" required>
                    </div>
                    <div>
                        <label for="hal" class="block text-gray-700 text-sm font-bold mb-2">Hal:</label>
                        <input type="text" id="hal" name="hal" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('hal') }}" required>
                    </div>
                </div>
            </div>

            <!-- Penerima Surat -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Penerima Surat</h3>
                <label class="block text-gray-700 text-sm font-bold mb-2">Penerima Surat (Yth.):</label>
                <div id="penerima-container">
                    @if(old('penerima') && count(old('penerima')) > 0)
                        @foreach(old('penerima') as $index => $penerima)
                            <div class="repeater-item flex items-center mb-2">
                                <input type="text" name="penerima[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline flex-grow mr-2" value="{{ $penerima }}" required>
                                <button type="button" onclick="removeRepeaterItem(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">Hapus</button>
                            </div>
                        @endforeach
                    @else
                        <div class="repeater-item flex items-center mb-2">
                            <input type="text" name="penerima[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline flex-grow mr-2" value="{{ old('penerima.0') }}" required>
                            <button type="button" onclick="removeRepeaterItem(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">Hapus</button>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addRepeaterItem('penerima-container', 'penerima[]')" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tambah Penerima</button>
            </div>

            <!-- Field Khusus Template (Dynamic) -->
            @if($template->form_fields && is_array($template->form_fields) && count($template->form_fields) > 0)
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Isi Surat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($template->form_fields as $field)
                        @php
                            $fieldName = $field['name'] ?? '';
                            $fieldLabel = $field['label'] ?? $fieldName;
                            $fieldType = $field['type'] ?? 'text';
                            $fieldRequired = $field['required'] ?? false;
                            $oldValue = old($fieldName, '');
                        @endphp
                        
                        <div class="{{ $fieldType === 'textarea' ? 'md:col-span-2' : '' }}">
                            <label for="{{ $fieldName }}" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ $fieldLabel }}
                                @if($fieldRequired)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>
                            
                            @if($fieldType === 'textarea')
                                <textarea id="{{ $fieldName }}" name="{{ $fieldName }}" rows="6"
                                    {{ $fieldRequired ? 'required' : '' }}
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $oldValue }}</textarea>
                            @elseif($fieldType === 'date')
                                <input type="date" id="{{ $fieldName }}" name="{{ $fieldName }}" value="{{ $oldValue }}"
                                    {{ $fieldRequired ? 'required' : '' }}
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @elseif($fieldType === 'number')
                                <input type="number" id="{{ $fieldName }}" name="{{ $fieldName }}" value="{{ $oldValue }}"
                                    {{ $fieldRequired ? 'required' : '' }}
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @elseif($fieldType === 'email')
                                <input type="email" id="{{ $fieldName }}" name="{{ $fieldName }}" value="{{ $oldValue }}"
                                    {{ $fieldRequired ? 'required' : '' }}
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @else
                                <input type="text" id="{{ $fieldName }}" name="{{ $fieldName }}" value="{{ $oldValue }}"
                                    {{ $fieldRequired ? 'required' : '' }}
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @endif
                            
                            @error($fieldName)
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Isi Surat (Hanya untuk template admin) -->
            @if($template->type === 'admin')
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Isi Surat</h3>
                <label for="isi_surat" class="block text-gray-700 text-sm font-bold mb-2">Isi Surat:</label>
                <textarea id="isi_surat" name="isi_surat" rows="15" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('isi_surat') }}</textarea>
            </div>
            @else
            <!-- Hidden field untuk isi_surat pada template system (akan di-generate dari form_fields) -->
            <input type="hidden" name="isi_surat" value="">
            @endif

            <!-- Tanda Tangan -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Tanda Tangan</h3>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="kota_penetapan" class="block text-gray-700 text-sm font-bold mb-2">Kota Penetapan TTD:</label>
                        <input type="text" id="kota_penetapan" name="kota_penetapan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('kota_penetapan', 'Bantul') }}" required>
                    </div>
                    <div>
                        <label for="tanggal_penetapan" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Penetapan TTD:</label>
                        <input type="date" id="tanggal_penetapan" name="tanggal_penetapan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tanggal_penetapan', date('Y-m-d')) }}" required>
                    </div>
                </div>
                
                <label class="block text-gray-700 text-sm font-bold mb-2">Penanda Tangan:</label>
                <div id="tanda-tangan-container">
                    @if(old('tanda_tangan') && is_array(old('tanda_tangan')) && count(old('tanda_tangan')) > 0)
                        @foreach(old('tanda_tangan') as $index => $ttd)
                            <div class="tanda-tangan-item border rounded-lg p-4 mb-4 bg-gray-50">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="font-semibold text-gray-700">Penanda Tangan {{ $index + 1 }}</h4>
                                    <button type="button" onclick="removeTandaTangan(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">Hapus</button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Jabatan:</label>
                                        <input type="text" name="tanda_tangan[{{ $index }}][jabatan]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $ttd['jabatan'] ?? '' }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                                        <input type="text" name="tanda_tangan[{{ $index }}][nama]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $ttd['nama'] ?? '' }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">NIP: <span class="text-gray-500 text-xs">(Opsional)</span></label>
                                        <input type="text" name="tanda_tangan[{{ $index }}][nip]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $ttd['nip'] ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @if($template->type === 'system')
                            {{-- Default 2 penandatangan untuk template system --}}
                            <div class="tanda-tangan-item border rounded-lg p-4 mb-4 bg-gray-50">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="font-semibold text-gray-700">Ketua</h4>
                                    <button type="button" onclick="removeTandaTangan(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">Hapus</button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Jabatan:</label>
                                        <input type="text" name="tanda_tangan[0][jabatan]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tanda_tangan.0.jabatan', 'Ketua') }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                                        <input type="text" name="tanda_tangan[0][nama]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tanda_tangan.0.nama') }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">NIP:</label>
                                        <input type="text" name="tanda_tangan[0][nip]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tanda_tangan.0.nip') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="tanda-tangan-item border rounded-lg p-4 mb-4 bg-gray-50">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="font-semibold text-gray-700">Sekretaris</h4>
                                    <button type="button" onclick="removeTandaTangan(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">Hapus</button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Jabatan:</label>
                                        <input type="text" name="tanda_tangan[1][jabatan]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tanda_tangan.1.jabatan', 'Sekretaris') }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                                        <input type="text" name="tanda_tangan[1][nama]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tanda_tangan.1.nama') }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">NIP: <span class="text-gray-500 text-xs">(Opsional)</span></label>
                                        <input type="text" name="tanda_tangan[1][nip]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tanda_tangan.1.nip') }}">
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="tanda-tangan-item border rounded-lg p-4 mb-4 bg-gray-50">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="font-semibold text-gray-700">Penanda Tangan 1</h4>
                                    <button type="button" onclick="removeTandaTangan(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">Hapus</button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Jabatan:</label>
                                        <input type="text" name="tanda_tangan[0][jabatan]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tanda_tangan.0.jabatan') }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                                        <input type="text" name="tanda_tangan[0][nama]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tanda_tangan.0.nama') }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-sm font-bold mb-2">NIP: <span class="text-gray-500 text-xs">(Opsional)</span></label>
                                        <input type="text" name="tanda_tangan[0][nip]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tanda_tangan.0.nip') }}">
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                <button type="button" onclick="addTandaTangan()" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tambah Penanda Tangan</button>
            </div>

            <!-- Tembusan (Opsional) -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Tembusan <span class="text-gray-500 text-sm font-normal">(Opsional)</span></h3>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tembusan:</label>
                <div id="tembusan-container">
                    @if(old('tembusan') && count(old('tembusan')) > 0)
                        @foreach(old('tembusan') as $index => $tembusan)
                            <div class="repeater-item flex items-center mb-2">
                                <input type="text" name="tembusan[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline flex-grow mr-2" value="{{ $tembusan }}">
                                <button type="button" onclick="removeRepeaterItem(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">Hapus</button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" onclick="addRepeaterItem('tembusan-container', 'tembusan[]')" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tambah Tembusan</button>
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

    <script>
        function addRepeaterItem(containerId, name) {
            const container = document.getElementById(containerId);
            const newItem = document.createElement('div');
            newItem.className = 'repeater-item flex items-center mb-2';
            newItem.innerHTML = `
                <input type="text" name="${name}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline flex-grow mr-2">
                <button type="button" onclick="removeRepeaterItem(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">Hapus</button>
            `;
            container.appendChild(newItem);
        }

        function removeRepeaterItem(button) {
            const item = button.closest('.repeater-item');
            if (item) {
                item.remove();
            }
        }

        let tandaTanganIndex = {{ old('tanda_tangan') && is_array(old('tanda_tangan')) ? count(old('tanda_tangan')) : ($template->type === 'system' ? 2 : 1) }};

        function addTandaTangan() {
            const container = document.getElementById('tanda-tangan-container');
            const newItem = document.createElement('div');
            newItem.className = 'tanda-tangan-item border rounded-lg p-4 mb-4 bg-gray-50';
            newItem.innerHTML = `
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-semibold text-gray-700">Penanda Tangan ${tandaTanganIndex + 1}</h4>
                    <button type="button" onclick="removeTandaTangan(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">Hapus</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Jabatan:</label>
                        <input type="text" name="tanda_tangan[${tandaTanganIndex}][jabatan]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                        <input type="text" name="tanda_tangan[${tandaTanganIndex}][nama]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">NIP: <span class="text-gray-500 text-xs">(Opsional)</span></label>
                        <input type="text" name="tanda_tangan[${tandaTanganIndex}][nip]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
            `;
            container.appendChild(newItem);
            tandaTanganIndex++;
        }

        function removeTandaTangan(button) {
            const item = button.closest('.tanda-tangan-item');
            if (item && item.parentElement.children.length > 1) {
                item.remove();
                // Re-number items
                const items = document.querySelectorAll('.tanda-tangan-item');
                items.forEach((item, index) => {
                    const title = item.querySelector('h4');
                    if (title) {
                        title.textContent = `Penanda Tangan ${index + 1}`;
                    }
                });
            } else {
                alert('Minimal harus ada satu penanda tangan');
            }
        }
    </script>
@endsection
