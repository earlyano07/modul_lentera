<x-app-layout>
    <x-slot name="title">Tambah Fasilitas</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Fasilitas Baru</h1>
        <nav class="text-sm text-gray-500 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.modules.index') }}" class="text-indigo-600 hover:text-indigo-700">Topik</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.modules.show', $module) }}" class="text-indigo-600 hover:text-indigo-700">Management Content</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-500">Tambah Fasilitas</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" x-data="{ jenis: '{{ old('jenis', request('jenis', 'video')) }}' }">
        <form action="{{ route('admin.modules.materials.store', $module) }}" method="POST" enctype="multipart/form-data">
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
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required class="shadow appearance-none @error('judul') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('judul')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Video Field (Shown only if jenis is video) -->
                <div x-show="jenis === 'video'" class="border border-slate-200 rounded-2xl bg-slate-50/50 p-6" x-data="{ videoType: 'url' }">
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
                        <input type="url" name="video" id="video" value="{{ old('video') }}" placeholder="https://www.youtube.com/watch?v=..." class="shadow appearance-none @error('video') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('video')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="videoType === 'file'" style="display: none;">
                        <label for="video_file" class="block text-gray-700 text-sm font-bold mb-2">Upload File Video (MP4)</label>
                        <input type="file" name="video_file" id="video_file" accept="video/mp4,video/webm" class="shadow appearance-none @error('video_file') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline file:bg-gray-100 file:border-0 file:rounded-md file:px-2 file:py-1 file:font-semibold file:text-xs file:text-gray-700 hover:file:bg-gray-200">
                        @error('video_file')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Kartu Situasi Fields (Shown only if jenis is kartu_situasi) -->
                <div x-show="jenis === 'kartu_situasi'" class="space-y-4 border border-slate-200 rounded-2xl bg-slate-50/50 p-6">
                    <div>
                        <label for="file_upload" class="block text-gray-700 text-sm font-bold mb-2">Foto / Ilustrasi Kartu Situasi</label>
                        <input type="file" name="file_upload" id="file_upload" accept="image/*" class="shadow appearance-none @error('file_upload') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline file:bg-gray-100 file:border-0 file:rounded-md file:px-2 file:py-1 file:font-semibold file:text-xs file:text-gray-700 hover:file:bg-gray-200">
                        <p class="mt-1.5 text-xs text-slate-400">Unggah file gambar (PNG/JPG) untuk ilustrasi kartu situasi.</p>
                        @error('file_upload')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="situasi" class="block text-gray-700 text-sm font-bold mb-2">Situasi</label>
                        <textarea name="situasi" id="situasi" rows="3" placeholder="Deskripsikan situasi perundungan..." class="shadow appearance-none @error('situasi') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('situasi') }}</textarea>
                        @error('situasi')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="peran" class="block text-gray-700 text-sm font-bold mb-2">Peran (Pisahkan dengan baris baru untuk poin list)</label>
                        <textarea name="peran" id="peran" rows="3" placeholder="Contoh:&#10;Dimas (siswa)&#10;Dua teman&#10;Satu pelaku" class="shadow appearance-none @error('peran') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('peran') }}</textarea>
                        @error('peran')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="diskusi" class="block text-gray-700 text-sm font-bold mb-2">Diskusikan (Pisahkan dengan baris baru untuk poin list)</label>
                        <textarea name="diskusi" id="diskusi" rows="4" placeholder="Contoh:&#10;Mengapa Dimas diam?&#10;Bagaimana perasaan Dimas?&#10;Apa yang bisa dilakukan Dimas?" class="shadow appearance-none @error('diskusi') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('diskusi') }}</textarea>
                        @error('diskusi')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Isi Teks (WYSIWYG) -->
                <div>
                    <label for="isi" class="block text-gray-700 text-sm font-bold mb-2">Isi / Deskripsi / Konten Teks</label>
                    <textarea name="isi" id="isi" rows="10" class="shadow appearance-none @error('isi') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('isi') }}</textarea>
                    <p class="mt-1.5 text-xs text-slate-400">Tuliskan materi teks atau instruksi pengerjaan fasilitas pendukung di sini.</p>
                    @error('isi')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('admin.modules.show', $module) }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan Fasilitas</button>
            </div>
        </form>
    </div>
    
    <!-- Include Alpine.js if not already in layout -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>
