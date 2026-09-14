<x-app-layout>
    <x-slot name="title">Tambah Assessment</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Assessment</h1>
        <nav class="text-sm text-gray-500 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.modules.index') }}" class="text-indigo-600 hover:text-indigo-700">Topik</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.modules.show', $module) }}" class="text-indigo-600 hover:text-indigo-700">Management Content</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-500">Tambah Assessment</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <form action="{{ route('admin.modules.assessments.store', $module) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Urutan -->
                <div class="col-span-1">
                    <label for="urutan" class="block text-gray-700 text-sm font-bold mb-2">Urutan (No)</label>
                    <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $nextOrder ?? 1) }}" required class="shadow appearance-none @error('urutan') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('urutan')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis -->
                <div class="col-span-1">
                    <label for="jenis" class="block text-gray-700 text-sm font-bold mb-2">Jenis Assessment *</label>
                    <select name="jenis" id="jenis" required class="shadow appearance-none @error('jenis') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="pre_test" {{ old('jenis', request('jenis')) == 'pre_test' ? 'selected' : '' }}>Pre Test</option>
                        <option value="post_test" {{ old('jenis', request('jenis')) == 'post_test' ? 'selected' : '' }}>Post Test</option>
                        <option value="lkpd" {{ old('jenis', request('jenis')) == 'lkpd' ? 'selected' : '' }}>Lembar Kerja Peserta Didik (LKPD)</option>
                    </select>
                    @error('jenis')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Judul -->
                <div class="col-span-1 md:col-span-2">
                    <label for="judul" class="block text-gray-700 text-sm font-bold mb-2">Judul Assessment *</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required placeholder="Contoh: Pre-Test Modul 1" class="shadow appearance-none @error('judul') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('judul')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Skor Maksimal -->
                <div class="col-span-1">
                    <label for="max_skor" class="block text-gray-700 text-sm font-bold mb-2">Skor Maksimal</label>
                    <div class="relative">
                        <input type="number" name="max_skor" id="max_skor" value="{{ old('max_skor', 0) }}" min="0" class="shadow appearance-none @error('max_skor') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <p class="mt-1.5 text-xs text-slate-400">Total skor jika semua jawaban benar.</p>
                    @error('max_skor')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('admin.modules.show', request('module_id', $module->id)) }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
