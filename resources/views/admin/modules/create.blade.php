<x-app-layout>
    <x-slot name="title">Tambah Topik</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Topik</h1>
        <nav class="text-sm text-gray-500 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.modules.index') }}" class="text-indigo-600 hover:text-indigo-700">Topik</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-500">Tambah</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <form action="{{ route('admin.modules.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 gap-6">
                <!-- Urutan -->
                <div class="w-1/3">
                    <label for="urutan" class="block text-gray-700 text-sm font-bold mb-2">Urutan (No)</label>
                    <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $nextOrder ?? 1) }}" required class="shadow appearance-none @error('urutan') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('urutan')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Judul -->
                <div>
                    <label for="judul" class="block text-gray-700 text-sm font-bold mb-2">Judul Topik *</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required class="shadow appearance-none @error('judul') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('judul')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subtitle -->
                <div>
                    <label for="subtitle" class="block text-gray-700 text-sm font-bold mb-2">Subtitle (Deskripsi Singkat)</label>
                    <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle') }}" placeholder="Contoh: kesadaran terhadap bullying" class="shadow appearance-none @error('subtitle') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('subtitle')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Lengkap</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="shadow appearance-none @error('deskripsi') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fokus Utama -->
                <div>
                    <label for="fokus_utama" class="block text-gray-700 text-sm font-bold mb-2">Fokus Utama</label>
                    <textarea name="fokus_utama" id="fokus_utama" rows="3" placeholder="Fokus pembelajaran topik ini" class="shadow appearance-none @error('fokus_utama') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('fokus_utama') }}</textarea>
                    @error('fokus_utama')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ilustrasi -->
                <div>
                    <label for="ilustrasi" class="block text-gray-700 text-sm font-bold mb-2">Ilustrasi (Gambar)</label>
                    <input type="file" name="ilustrasi" id="ilustrasi" accept="image/*" class="shadow appearance-none @error('ilustrasi') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline file:bg-gray-100 file:border-0 file:rounded-md file:px-2 file:py-1 file:font-semibold file:text-xs file:text-gray-700 hover:file:bg-gray-200">
                    @error('ilustrasi')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Panduan Konselor (Modeling) -->
                <div>
                    <label for="guide_modeling" class="block text-gray-700 text-sm font-bold mb-2">Panduan Konselor - Modeling (Tahap 1)</label>
                    <textarea name="guide_modeling" id="guide_modeling" rows="3" class="shadow appearance-none @error('guide_modeling') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh panduan Modeling...">{{ old('guide_modeling') }}</textarea>
                    @error('guide_modeling')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Panduan Konselor (Role Playing) -->
                <div>
                    <label for="guide_role_playing" class="block text-gray-700 text-sm font-bold mb-2">Panduan Konselor - Role Playing (Tahap 2)</label>
                    <textarea name="guide_role_playing" id="guide_role_playing" rows="3" class="shadow appearance-none @error('guide_role_playing') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh panduan Role Playing...">{{ old('guide_role_playing') }}</textarea>
                    @error('guide_role_playing')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Panduan Konselor (Performance Feedback) -->
                <div>
                    <label for="guide_feedback" class="block text-gray-700 text-sm font-bold mb-2">Panduan Konselor - Performance Feedback (Tahap 3)</label>
                    <textarea name="guide_feedback" id="guide_feedback" rows="3" class="shadow appearance-none @error('guide_feedback') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh panduan Performance Feedback...">{{ old('guide_feedback') }}</textarea>
                    @error('guide_feedback')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Panduan Konselor (Transfer of Training) -->
                <div>
                    <label for="guide_transfer" class="block text-gray-700 text-sm font-bold mb-2">Panduan Konselor - Transfer of Training (Tahap 4)</label>
                    <textarea name="guide_transfer" id="guide_transfer" rows="3" class="shadow appearance-none @error('guide_transfer') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh panduan Transfer of Training...">{{ old('guide_transfer') }}</textarea>
                    @error('guide_transfer')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="shadow-xs border border-gray-300 rounded text-blue-500 focus:ring-blue-500 focus:ring-opacity-20">
                        <span class="ml-2 text-sm text-slate-700">Aktif (Bisa diakses siswa)</span>
                    </label>
                    @error('status')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('admin.modules.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
