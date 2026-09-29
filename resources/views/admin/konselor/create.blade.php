<x-app-layout>
    <x-slot name="title">Tambah Konselor</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Konselor</h1>
        <nav class="text-sm text-gray-500 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.konselor.index') }}" class="text-indigo-600 hover:text-indigo-700">Konselor</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-500">Tambah</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <form action="{{ route('admin.konselor.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Akun Info -->
                <div class="col-span-1 md:col-span-2 border-b border-gray-200 pb-4 mb-2">
                    <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Informasi Akun</h2>
                </div>

                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required class="shadow appearance-none @error('nama') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('nama')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email *</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="shadow appearance-none @error('email') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password *</label>
                    <input type="password" name="password" id="password" required class="shadow appearance-none @error('password') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Profil Info -->
                <div class="col-span-1 md:col-span-2 border-b border-gray-200 pb-4 mb-2 mt-4">
                    <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Profil Konselor</h2>
                </div>

                <!-- NIP -->
                <div>
                    <label for="nip" class="block text-gray-700 text-sm font-bold mb-2">NIP</label>
                    <input type="text" name="nip" id="nip" value="{{ old('nip') }}" class="shadow appearance-none @error('nip') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('nip')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No HP -->
                <div>
                    <label for="no_hp" class="block text-gray-700 text-sm font-bold mb-2">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" class="shadow appearance-none @error('no_hp') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('no_hp')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Schools Assignment -->
                <div class="col-span-1 md:col-span-2">
                    <label for="schools" class="block text-gray-700 text-sm font-bold mb-2">Penugasan Sekolah</label>
                    @if(count($schools) > 0)
                        <div class="select2-wrapper">
                            <select name="schools[]" id="schools" class="w-full" multiple="multiple" data-placeholder="Pilih satu atau lebih sekolah...">
                                @foreach($schools as $school)
                                    <option value="{{ $school->id }}" {{ in_array($school->id, old('schools', [])) ? 'selected' : '' }}>
                                        {{ $school->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Bisa memilih lebih dari satu sekolah (multiple choice).</p>
                    @else
                        <p class="text-sm text-gray-500">Belum ada data sekolah. Silakan <a href="{{ route('admin.schools.create') }}" class="text-blue-500 hover:text-blue-800 font-bold hover:underline">tambah sekolah</a> terlebih dahulu.</p>
                    @endif
                    @error('schools')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('admin.konselor.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan</button>
            </div>
        </form>
    </div>

    @push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
        }
        .select2-container--default .select2-selection--multiple {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            min-height: 42px;
            padding: 3px 6px;
            transition: all 0.2s;
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #3b82f6;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            outline: none;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #dbeafe;
            border: 1px solid #bfdbfe;
            border-radius: 0.375rem;
            color: #1e40af;
            padding: 2px 8px 2px 22px;
            font-size: 0.8rem;
            font-weight: 600;
            position: relative;
            margin-top: 4px;
            margin-bottom: 4px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #3b82f6;
            border: none;
            background: transparent;
            position: absolute;
            left: 4px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #ef4444;
        }
        .select2-dropdown {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            font-family: inherit;
            font-size: 0.875rem;
            overflow: hidden;
            background-color: #ffffff;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            padding: 6px 10px;
            background-color: #f8fafc;
            outline: none;
        }
        .select2-results__option {
            padding: 8px 12px;
            font-size: 0.875rem;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #3b82f6;
            color: #ffffff;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #dbeafe;
            color: #1e40af;
            font-weight: 600;
        }
    </style>
    @endpush

    @push('scripts')
    <!-- jQuery and Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#schools').select2({
                placeholder: "Pilih satu atau lebih sekolah...",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    @endpush
</x-app-layout>
