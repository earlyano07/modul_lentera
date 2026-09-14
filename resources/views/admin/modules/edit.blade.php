<x-app-layout>
    <x-slot name="title">Edit Detail Topik</x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.modules.show', $module) }}" class="p-2 hover:bg-slate-100 rounded-xl transition text-slate-500 hover:text-slate-700">
                    <span class="material-symbols-outlined block">arrow_back</span>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight">Edit Detail Topik: {{ $module->judul }}</h1>
                    <p class="text-xs text-slate-400 font-semibold mt-0.5">Perbarui informasi utama untuk Topik {{ $module->urutan }}</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <form action="{{ route('admin.modules.update', $module) }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ fileName: '' }">
                @csrf
                @method('PUT')
                
                <!-- 1. Urutan Topik -->
                <div class="max-w-xs">
                    <label for="urutan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Urutan Topik (No) *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <span class="material-symbols-outlined text-base">tag</span>
                        </span>
                        <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $module->urutan) }}" required min="0" 
                            class="pl-9 w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('urutan') border-red-500 @enderror">
                    </div>
                    @error('urutan')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 2. Judul Topik -->
                <div>
                    <label for="judul" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Topik *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <span class="material-symbols-outlined text-base">title</span>
                        </span>
                        <input type="text" name="judul" id="judul" value="{{ old('judul', $module->judul) }}" required placeholder="Contoh: Empathy Awareness"
                            class="pl-9 w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('judul') border-red-500 @enderror">
                    </div>
                    @error('judul')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 3. Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Topik</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Tuliskan deskripsi ringkas mengenai materi dan tujuan topik ini..."
                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $module->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 4. Ilustrasi Gambar -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ilustrasi Gambar</label>
                    @if($module->ilustrasi)
                        <div class="mb-3 flex items-center gap-3 p-2 bg-slate-50 border border-slate-200 rounded-xl w-fit">
                            <img src="{{ asset('storage/' . $module->ilustrasi) }}" alt="Preview" class="w-16 h-16 object-contain rounded-lg bg-white border border-slate-100 p-1">
                            <div class="text-xs">
                                <p class="font-bold text-slate-700">Gambar Saat Ini</p>
                                <p class="text-[10px] text-slate-400">Pilih file baru jika ingin mengganti gambar</p>
                            </div>
                        </div>
                    @endif
                    <div class="relative flex flex-col items-center justify-center p-6 border-2 border-dashed border-slate-200 hover:border-indigo-400 bg-slate-50/50 rounded-2xl cursor-pointer transition duration-200 group">
                        <input type="file" name="ilustrasi" id="ilustrasi" accept="image/*" 
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                            @change="const file = $event.target.files[0]; fileName = file ? file.name : ''">
                        <div class="text-center">
                            <span class="material-symbols-outlined text-slate-400 group-hover:text-indigo-500 text-3xl transition duration-200 mb-1">image</span>
                            <p class="text-xs font-extrabold text-slate-700" x-text="fileName ? fileName : 'Pilih File Gambar Baru'"></p>
                            <p class="text-[10px] text-slate-400 mt-0.5">Format: JPG, PNG, WEBP (Maks: 2MB)</p>
                        </div>
                    </div>
                    @error('ilustrasi')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between border-t border-slate-100 pt-6 mt-6">
                    <a href="{{ route('admin.modules.show', $module) }}" class="px-5 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 font-bold text-xs uppercase tracking-wider transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition duration-200 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">save</span>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
