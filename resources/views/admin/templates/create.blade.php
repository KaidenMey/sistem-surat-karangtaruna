@extends('layouts.dashboard')

@section('title', 'Tambah Template - E-SKATA')

@section('page-title', 'Tambah Template Baru')

@section('sidebar-menu')
    @include('admin.partials.sidebar')
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form action="{{ route('admin.templates.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Template *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">File Template (Word/DOCX) *</label>
                    <input type="file" id="file" name="file" accept=".docx" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-sm text-gray-500">
                        Format: DOCX (Max: 10MB)<br>
                        <strong>Penting:</strong> Gunakan placeholder seperti {nama_penerima}, {alamat}, {isi_surat}, dll di dalam template Word Anda.
                        Sistem akan otomatis mengganti placeholder dengan data yang diisi user.
                    </p>
                    @error('file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Field yang Perlu Diisi User</h3>
                            <p class="text-sm text-gray-600 mt-1">Tentukan field-field yang akan muncul di form saat user membuat surat</p>
                        </div>
                        <button type="button" onclick="addField()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">
                            + Tambah Field
                        </button>
                    </div>

                    <div id="formFieldsContainer" class="space-y-4">
                        <!-- Fields will be added here dynamically -->
                    </div>

                    <input type="hidden" name="form_fields" id="formFieldsJson" value="{{ old('form_fields', '[]') }}">
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Aktifkan template</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.templates.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        let fieldIndex = 0;
        const fieldTypes = {
            'text': 'Text',
            'textarea': 'Textarea',
            'date': 'Date',
            'number': 'Number',
            'email': 'Email'
        };

        function addField() {
            const container = document.getElementById('formFieldsContainer');
            const fieldHtml = `
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200" data-field-index="${fieldIndex}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Field (Placeholder)</label>
                            <input type="text" name="field_name_${fieldIndex}" placeholder="nama_penerima" 
                                class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                            <p class="text-xs text-gray-500 mt-1">Gunakan di template: {nama_penerima}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Label</label>
                            <input type="text" name="field_label_${fieldIndex}" placeholder="Nama Penerima" 
                                class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                            <select name="field_type_${fieldIndex}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                                ${Object.entries(fieldTypes).map(([value, label]) => 
                                    `<option value="${value}">${label}</option>`
                                ).join('')}
                            </select>
                        </div>
                        <div class="flex items-end">
                            <div class="flex items-center space-x-2 w-full">
                                <label class="flex items-center">
                                    <input type="checkbox" name="field_required_${fieldIndex}" checked
                                        class="rounded border-gray-300 text-blue-600">
                                    <span class="ml-2 text-sm text-gray-700">Required</span>
                                </label>
                                <button type="button" onclick="removeField(${fieldIndex})" 
                                    class="ml-auto px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', fieldHtml);
            fieldIndex++;
            updateFormFieldsJson();
        }

        function removeField(index) {
            const field = document.querySelector(`[data-field-index="${index}"]`);
            if (field) {
                field.remove();
                updateFormFieldsJson();
            }
        }

        function updateFormFieldsJson() {
            const fields = [];
            const fieldContainers = document.querySelectorAll('[data-field-index]');
            
            fieldContainers.forEach(container => {
                const index = container.getAttribute('data-field-index');
                const name = container.querySelector(`[name="field_name_${index}"]`)?.value;
                const label = container.querySelector(`[name="field_label_${index}"]`)?.value;
                const type = container.querySelector(`[name="field_type_${index}"]`)?.value;
                const required = container.querySelector(`[name="field_required_${index}"]`)?.checked;
                
                if (name && label && type) {
                    fields.push({
                        name: name,
                        label: label,
                        type: type,
                        required: required
                    });
                }
            });
            
            document.getElementById('formFieldsJson').value = JSON.stringify(fields);
        }

        // Update JSON saat form berubah
        document.addEventListener('input', function(e) {
            if (e.target.name && e.target.name.startsWith('field_')) {
                updateFormFieldsJson();
            }
        });

        // Load existing fields if editing
        @if(old('form_fields'))
            const existingFields = {!! old('form_fields', '[]') !!};
            existingFields.forEach(field => {
                addField();
                const lastIndex = fieldIndex - 1;
                document.querySelector(`[name="field_name_${lastIndex}"]`).value = field.name || '';
                document.querySelector(`[name="field_label_${lastIndex}"]`).value = field.label || '';
                document.querySelector(`[name="field_type_${lastIndex}"]`).value = field.type || 'text';
                document.querySelector(`[name="field_required_${lastIndex}"]`).checked = field.required || false;
            });
            updateFormFieldsJson();
        @endif

        // Update JSON before form submit
        document.querySelector('form').addEventListener('submit', function(e) {
            updateFormFieldsJson();
        });
    </script>
    @endpush
@endsection

