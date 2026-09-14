<x-app-layout>
    <x-slot name="title">Edit Fasilitas</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Fasilitas: {{ $material->judul }}</h1>
        <nav class="text-sm text-gray-500 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.modules.index') }}" class="text-indigo-600 hover:text-indigo-700">Topik</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.modules.show', $material->module_id) }}" class="text-indigo-600 hover:text-indigo-700">Management Content</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-500">Edit Fasilitas</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" x-data="{ jenis: '{{ old('jenis', $material->jenis) }}' }">
        <form action="{{ route('admin.materials.update', $material) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6">
                <!-- Urutan -->
                <div class="w-1/3">
                    <label for="urutan" class="block text-gray-700 text-sm font-bold mb-2">Urutan (No)</label>
                    <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $material->urutan) }}" required class="shadow appearance-none @error('urutan') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('urutan')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Fasilitas -->
                <div>
                    <label for="jenis" class="block text-gray-700 text-sm font-bold mb-2">Jenis Fasilitas *</label>
                    <select name="jenis" id="jenis" x-model="jenis" required class="shadow appearance-none @error('jenis') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach(\App\Models\Material::JENIS_OPTIONS as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('jenis')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Judul -->
                <div>
                    <label for="judul" class="block text-gray-700 text-sm font-bold mb-2">Judul Fasilitas *</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul', $material->judul) }}" required class="shadow appearance-none @error('judul') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('judul')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Video Field (Shown only if jenis is video) -->
                @php
                    $isVideoFile = $material->video && !str_starts_with($material->video, 'http');
                    $initialVideoType = old('video_type', $isVideoFile ? 'file' : 'url');
                @endphp
                <div x-show="jenis === 'video'" class="border border-slate-200 rounded-2xl bg-slate-50/50 p-6" x-data="{ videoType: '{{ $initialVideoType }}' }">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tipe Video</label>
                    <div class="flex items-center space-x-6 mb-4">
                        <label class="inline-flex items-center">
                            <input type="radio" x-model="videoType" name="video_type" value="url" class="rounded-full shadow-xs border border-gray-300 text-blue-500 focus:ring-blue-500 focus:ring-opacity-20">
                            <span class="ml-2 text-sm text-slate-700">YouTube URL</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" x-model="videoType" name="video_type" value="file" class="rounded-full shadow-xs border border-gray-300 text-blue-500 focus:ring-blue-500 focus:ring-opacity-20">
                            <span class="ml-2 text-sm text-slate-700">Upload File Video</span>
                        </label>
                    </div>

                    <div x-show="videoType === 'url'">
                        <label for="video" class="block text-gray-700 text-sm font-bold mb-2">URL Video YouTube</label>
                        <input type="url" name="video" id="video" value="{{ old('video', $isVideoFile ? '' : $material->video) }}" placeholder="https://www.youtube.com/watch?v=..." class="shadow appearance-none @error('video') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('video')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="videoType === 'file'" style="display: none;">
                        <label for="video_file" class="block text-gray-700 text-sm font-bold mb-2">Upload File Video (MP4)</label>
                        @if($isVideoFile)
                            <p class="text-xs text-slate-500 mb-2">File saat ini: <a href="{{ asset('storage/' . $material->video) }}" target="_blank" class="text-indigo-600 underline font-semibold">Lihat Video</a></p>
                        @endif
                        <input type="file" name="video_file" id="video_file" accept="video/mp4,video/webm" class="shadow appearance-none @error('video_file') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline file:bg-gray-100 file:border-0 file:rounded-md file:px-2 file:py-1 file:font-semibold file:text-xs file:text-gray-700 hover:file:bg-gray-200">
                        <p class="mt-1.5 text-xs text-slate-400">Biarkan kosong jika tidak ingin mengubah file video.</p>
                        @error('video_file')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Kartu Situasi Fields (Shown only if jenis is kartu_situasi) -->
                <div x-show="jenis === 'kartu_situasi'" class="space-y-4 border border-slate-200 rounded-2xl bg-slate-50/50 p-6">
                    <div>
                        <label for="file_upload" class="block text-gray-700 text-sm font-bold mb-2">Foto / Ilustrasi Kartu Situasi</label>
                        @if($material->file_path && $material->jenis === 'kartu_situasi')
                            <p class="text-xs text-gray-500 mb-2">File saat ini: <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="text-indigo-600 underline font-semibold">{{ basename($material->file_path) }}</a></p>
                        @endif
                        <input type="file" name="file_upload" id="file_upload" accept="image/*" class="shadow appearance-none @error('file_upload') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline file:bg-gray-100 file:border-0 file:rounded-md file:px-2 file:py-1 file:font-semibold file:text-xs file:text-gray-700 hover:file:bg-gray-200">
                        <p class="mt-1.5 text-xs text-slate-400">Unggah file gambar (PNG/JPG) baru jika ingin mengubah ilustrasi.</p>
                        @error('file_upload')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="situasi" class="block text-gray-700 text-sm font-bold mb-2">Situasi</label>
                        <textarea name="situasi" id="situasi" rows="3" placeholder="Deskripsikan situasi perundungan..." class="shadow appearance-none @error('situasi') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('situasi', $material->situasi) }}</textarea>
                        @error('situasi')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="peran" class="block text-gray-700 text-sm font-bold mb-2">Peran (Pisahkan dengan baris baru untuk poin list)</label>
                        <textarea name="peran" id="peran" rows="3" placeholder="Contoh:&#10;Dimas (siswa)&#10;Dua teman&#10;Satu pelaku" class="shadow appearance-none @error('peran') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('peran', $material->peran) }}</textarea>
                        @error('peran')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="diskusi" class="block text-gray-700 text-sm font-bold mb-2">Diskusikan (Pisahkan dengan baris baru untuk poin list)</label>
                        <textarea name="diskusi" id="diskusi" rows="4" placeholder="Contoh:&#10;Mengapa Dimas diam?&#10;Bagaimana perasaan Dimas?&#10;Apa yang bisa dilakukan Dimas?" class="shadow appearance-none @error('diskusi') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('diskusi', $material->diskusi) }}</textarea>
                        @error('diskusi')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Isi Teks (WYSIWYG) -->
                <div>
                    <label for="isi" class="block text-gray-700 text-sm font-bold mb-2">Isi / Deskripsi / Konten Teks</label>
                    <textarea name="isi" id="isi" rows="10" class="shadow appearance-none @error('isi') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('isi', $material->isi) }}</textarea>
                    @error('isi')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('admin.modules.show', $material->module_id) }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan Perubahan</button>
            </div>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>
