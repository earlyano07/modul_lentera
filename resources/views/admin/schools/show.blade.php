<x-app-layout>
    <x-slot name="title">Detail Sekolah</x-slot>

    <div x-data="schoolDetailManager()">
        <!-- Main Content Area with Dynamic Blur Filter when Any Modal is Open -->
        <div :class="(showEditModal || showCreateClassModal || showCreateStudentModal) ? 'filter blur-[4px] pointer-events-none transition-all duration-300' : 'transition-all duration-300'">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Detail Sekolah: {{ $school->nama }}</h1>
                    <nav class="text-sm text-gray-500 mt-1">
                        <ol class="list-reset flex">
                            <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700">Dashboard</a></li>
                            <li><span class="mx-2">/</span></li>
                            <li><a href="{{ route('admin.schools.index') }}" class="text-indigo-600 hover:text-indigo-700">Sekolah</a></li>
                            <li><span class="mx-2">/</span></li>
                            <li class="text-gray-500">Detail</li>
                        </ol>
                    </nav>
                </div>
                <div class="flex space-x-3">
                    <button type="button" 
                        @click="openEditModal()" 
                        class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 rounded-xl shadow-xs text-sm font-extrabold text-slate-700 bg-white hover:bg-slate-50 transition cursor-pointer">
                        <span class="material-symbols-outlined text-[16px] text-indigo-600">edit_square</span>
                        Edit Sekolah
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs font-semibold shadow-xs flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600 text-sm">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- School Info -->
                <div class="col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="text-center mb-6">
                            @if($school->logo)
                                <img src="{{ Storage::url($school->logo) }}" alt="Logo" class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-gray-100">
                            @else
                                <div class="w-32 h-32 mx-auto rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-3xl">S</div>
                            @endif
                            <h2 class="mt-4 text-xl font-bold text-gray-900">{{ $school->nama }}</h2>
                            <p class="text-sm text-gray-500 mt-1">NPSN: {{ $school->npsn ?? '-' }}</p>
                            <div class="mt-2">
                                @if($school->status)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Nonaktif</span>
                                @endif
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4 space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Telepon</p>
                                <p class="text-sm text-gray-900">{{ $school->telepon ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Alamat</p>
                                <p class="text-sm text-gray-900">{{ $school->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-1 lg:col-span-2 space-y-6">
                    <!-- Classes List -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                            <h3 class="text-lg font-medium text-gray-900">Daftar Kelas</h3>
                            <button type="button" 
                                @click="openCreateClassModal()" 
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-extrabold bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200/60 transition cursor-pointer">
                                <span class="material-symbols-outlined text-[16px]">add</span>
                                Tambah Kelas
                            </button>
                        </div>
                        <div class="p-0">
                            @if(isset($school->kelas) && $school->kelas->count() > 0)
                                <ul class="divide-y divide-gray-200">
                                    @foreach($school->kelas as $kelas)
                                    <li class="px-6 py-4 flex items-center justify-between hover:bg-gray-50/80 transition">
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $kelas->nama_kelas }}</p>
                                            <p class="text-xs text-gray-500 font-medium">Tingkat: {{ $kelas->tingkat }} | Tahun: {{ $kelas->tahun_ajaran }}</p>
                                        </div>
                                        <div class="flex items-center gap-2.5">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/50">
                                                {{ $kelas->students_count ?? $kelas->students?->count() ?? 0 }} Siswa
                                            </span>
                                            <button type="button" 
                                                @click="openCreateStudentModal({{ $kelas->id }}, '{{ addslashes($kelas->nama_kelas) }}')"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-extrabold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200/60 transition shadow-2xs cursor-pointer"
                                                title="Tambah Siswa ke kelas {{ $kelas->nama_kelas }}">
                                                <span class="material-symbols-outlined text-[15px]">person_add</span>
                                                Tambah Siswa
                                            </button>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="p-6 text-center text-gray-500 text-sm">Belum ada kelas.</div>
                            @endif
                        </div>
                    </div>

                    <!-- Counselors List -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-medium text-gray-900">Konselor Ditugaskan</h3>
                        </div>
                        <div class="p-0">
                            @if(isset($school->counselors) && $school->counselors->count() > 0)
                                <ul class="divide-y divide-gray-200">
                                    @foreach($school->counselors as $counselor)
                                    <li class="px-6 py-4 flex items-center hover:bg-gray-50">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mr-3">
                                            {{ substr($counselor->user->nama ?? 'C', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $counselor->user->nama ?? '-' }}</p>
                                            <p class="text-sm text-gray-500">NIP: {{ $counselor->nip ?? '-' }}</p>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="p-6 text-center text-gray-500 text-sm">Belum ada konselor.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1. Edit School Modal -->
        <div x-show="showEditModal" 
             class="fixed inset-0 z-[100] overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-250"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="fixed inset-0 transition-all duration-300" 
                 style="background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);" 
                 @click="showEditModal = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
                <div x-show="showEditModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-250"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-xl p-6 md:p-8 flex flex-col max-h-[90vh] z-10 border border-slate-100">
                    
                    <button type="button" @click="showEditModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition p-1 hover:bg-slate-100 rounded-lg">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-600 text-2xl">edit_square</span>
                            Edit Detail Sekolah
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Perbarui data informasi sekolah</p>
                    </div>

                    <div class="overflow-y-auto flex-1 px-1">
                        <form action="{{ route('admin.schools.update', $school) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="_modal" value="edit">
                            <input type="hidden" name="_redirect_to" value="{{ route('admin.schools.show', $school) }}">

                            <div>
                                <label for="edit_nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Sekolah *</label>
                                <input type="text" name="nama" id="edit_nama" x-ref="editNamaInput" x-model="form.nama" required
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('nama') border-rose-500 bg-rose-50/30 @enderror">
                                @error('nama')
                                    <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="edit_npsn" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">NPSN</label>
                                    <input type="text" name="npsn" id="edit_npsn" x-model="form.npsn"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('npsn') border-rose-500 bg-rose-50/30 @enderror">
                                    @error('npsn')
                                        <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="edit_telepon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Telepon</label>
                                    <input type="text" name="telepon" id="edit_telepon" x-model="form.telepon"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('telepon') border-rose-500 bg-rose-50/30 @enderror">
                                    @error('telepon')
                                        <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="edit_alamat" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat</label>
                                <textarea name="alamat" id="edit_alamat" x-model="form.alamat" rows="2"
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('alamat') border-rose-500 bg-rose-50/30 @enderror"></textarea>
                                @error('alamat')
                                    <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Logo Sekolah</label>
                                <template x-if="form.logo_url">
                                    <div class="mb-3 flex items-center gap-3 p-2 bg-slate-50 border border-slate-200 rounded-xl w-fit">
                                        <img :src="form.logo_url" alt="Logo" class="w-12 h-12 object-cover rounded-lg bg-white border border-slate-100">
                                        <div class="text-xs">
                                            <p class="font-bold text-slate-700">Logo Saat Ini</p>
                                            <p class="text-[10px] text-slate-400">Pilih file baru jika ingin mengganti</p>
                                        </div>
                                    </div>
                                </template>
                                <div class="relative flex flex-col items-center justify-center p-4 border-2 border-dashed border-slate-200 hover:border-indigo-400 bg-slate-50/50 rounded-2xl cursor-pointer transition duration-200 group">
                                    <input type="file" name="logo" id="edit_logo" accept="image/*" 
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        @change="const file = $event.target.files[0]; editLogoName = file ? file.name : ''">
                                    <div class="text-center">
                                        <span class="material-symbols-outlined text-slate-400 group-hover:text-indigo-500 text-2xl transition duration-200 mb-1">image</span>
                                        <p class="text-xs font-extrabold text-slate-700" x-text="editLogoName ? editLogoName : 'Pilih File Logo Baru'"></p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">Format: JPG, PNG, WEBP (Maks: 2MB)</p>
                                    </div>
                                </div>
                                @error('logo')
                                    <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-1">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="status" value="1" x-model="form.status" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-xs font-bold text-slate-700">Status Aktif</span>
                                </label>
                                @error('status')
                                    <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4 mt-6">
                                <button type="button" @click="showEditModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-wider transition">
                                    Batal
                                </button>
                                <button type="submit" 
                                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition duration-200 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Create Class Modal -->
        <div x-show="showCreateClassModal" 
             class="fixed inset-0 z-[100] overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-250"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="fixed inset-0 transition-all duration-300" 
                 style="background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);" 
                 @click="showCreateClassModal = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
                <div x-show="showCreateClassModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-250"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-lg p-6 md:p-8 flex flex-col max-h-[90vh] z-10 border border-slate-100">
                    
                    <button type="button" @click="showCreateClassModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition p-1 hover:bg-slate-100 rounded-lg">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-600 text-2xl">class</span>
                            Tambah Kelas Baru
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Tambahkan rombongan belajar baru untuk {{ $school->nama }}</p>
                    </div>

                    <div class="overflow-y-auto flex-1 px-1">
                        <form action="{{ route('admin.kelas.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="_modal" value="create_class">
                            <input type="hidden" name="school_id" value="{{ $school->id }}">
                            <input type="hidden" name="_redirect_to" value="{{ route('admin.schools.show', $school) }}">

                            <!-- Sekolah Info Banner -->
                            <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-indigo-600 text-lg">school</span>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Sekolah</p>
                                    <p class="text-xs font-extrabold text-slate-800">{{ $school->nama }}</p>
                                </div>
                            </div>

                            <div>
                                <label for="create_nama_kelas" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kelas *</label>
                                <input type="text" name="nama_kelas" id="create_nama_kelas" x-ref="classNamaInput" x-model="classForm.nama_kelas" required placeholder="Contoh: VII A, VIII B, IX C"
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('nama_kelas') border-rose-500 bg-rose-50/30 @enderror">
                                @error('nama_kelas')
                                    <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="create_tingkat" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tingkat *</label>
                                    <input type="text" name="tingkat" id="create_tingkat" x-model="classForm.tingkat" required placeholder="Contoh: VII, VIII, 7, 8"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('tingkat') border-rose-500 bg-rose-50/30 @enderror">
                                    @error('tingkat')
                                        <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="create_tahun_ajaran" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tahun Ajaran *</label>
                                    <input type="text" name="tahun_ajaran" id="create_tahun_ajaran" x-model="classForm.tahun_ajaran" required placeholder="Contoh: 2025/2026"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('tahun_ajaran') border-rose-500 bg-rose-50/30 @enderror">
                                    @error('tahun_ajaran')
                                        <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4 mt-6">
                                <button type="button" @click="showCreateClassModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-wider transition">
                                    Batal
                                </button>
                                <button type="submit" 
                                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition duration-200 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                    Simpan Kelas
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Create Student Modal -->
        <div x-show="showCreateStudentModal" 
             class="fixed inset-0 z-[100] overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-250"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="fixed inset-0 transition-all duration-300" 
                 style="background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);" 
                 @click="showCreateStudentModal = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
                <div x-show="showCreateStudentModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-250"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-xl p-6 md:p-8 flex flex-col max-h-[90vh] z-10 border border-slate-100">
                    
                    <button type="button" @click="showCreateStudentModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition p-1 hover:bg-slate-100 rounded-lg">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-emerald-600 text-2xl">person_add</span>
                            Tambah Siswa Baru
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Tambahkan data siswa baru ke kelas yang dipilih</p>
                    </div>

                    <div class="overflow-y-auto flex-1 px-1">
                        <form action="{{ route('admin.students.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="_modal" value="create_student">
                            <input type="hidden" name="school_id" value="{{ $school->id }}">
                            <input type="hidden" name="_redirect_to" value="{{ route('admin.schools.show', $school) }}">

                            <!-- Info Kelas Terpilih -->
                            <div class="p-3 bg-emerald-50/70 border border-emerald-100 rounded-xl flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-emerald-600 text-lg">school</span>
                                    <div>
                                        <p class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">Sekolah</p>
                                        <p class="text-xs font-extrabold text-slate-800">{{ $school->nama }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">Target Kelas</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-black bg-emerald-600 text-white" x-text="studentForm.nama_kelas"></span>
                                </div>
                            </div>

                            <!-- Pilihan Kelas (Dropdown agar fleksibel jika ingin pindah) -->
                            <div>
                                <label for="create_student_kelas_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kelas *</label>
                                <select name="kelas_id" id="create_student_kelas_id" x-model="studentForm.kelas_id" @change="studentForm.nama_kelas = $event.target.options[$event.target.selectedIndex].text" required
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('kelas_id') border-rose-500 bg-rose-50/30 @enderror">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($school->kelas as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kelas }} (Tingkat {{ $k->tingkat }})</option>
                                    @endforeach
                                </select>
                                @error('kelas_id')
                                    <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="create_student_nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap Siswa *</label>
                                    <input type="text" name="nama" id="create_student_nama" x-ref="studentNamaInput" x-model="studentForm.nama" required placeholder="Contoh: Muhammad Rizky"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('nama') border-rose-500 bg-rose-50/30 @enderror">
                                    @error('nama')
                                        <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="create_student_nis" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">NIS *</label>
                                    <input type="text" name="nis" id="create_student_nis" x-model="studentForm.nis" required placeholder="Nomor Induk Siswa"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('nis') border-rose-500 bg-rose-50/30 @enderror">
                                    @error('nis')
                                        <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="create_student_username" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Username (Opsional)</label>
                                    <input type="text" name="username" id="create_student_username" x-model="studentForm.username" placeholder="Otomatis jika dikosongkan"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('username') border-rose-500 bg-rose-50/30 @enderror">
                                    @error('username')
                                        <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="create_student_email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email (Opsional)</label>
                                    <input type="email" name="email" id="create_student_email" x-model="studentForm.email" placeholder="siswa@sekolah.sch.id"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('email') border-rose-500 bg-rose-50/30 @enderror">
                                    @error('email')
                                        <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="create_student_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password *</label>
                                    <input type="password" name="password" id="create_student_password" x-model="studentForm.password" required minlength="8" placeholder="Minimal 8 karakter"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('password') border-rose-500 bg-rose-50/30 @enderror">
                                    @error('password')
                                        <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="create_student_jenis_kelamin" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jenis Kelamin *</label>
                                    <select name="jenis_kelamin" id="create_student_jenis_kelamin" x-model="studentForm.jenis_kelamin" required
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('jenis_kelamin') border-rose-500 bg-rose-50/30 @enderror">
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="create_student_tanggal_lahir" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Lahir *</label>
                                <input type="date" name="tanggal_lahir" id="create_student_tanggal_lahir" x-model="studentForm.tanggal_lahir" required
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('tanggal_lahir') border-rose-500 bg-rose-50/30 @enderror">
                                @error('tanggal_lahir')
                                    <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4 mt-6">
                                <button type="button" @click="showCreateStudentModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-wider transition">
                                    Batal
                                </button>
                                <button type="submit" 
                                    class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition duration-200 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm">person_add</span>
                                    Simpan Siswa
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        (function() {
            function initSchoolDetailManager() {
                if (typeof Alpine !== 'undefined') {
                    Alpine.data('schoolDetailManager', () => ({
                        showEditModal: {{ $errors->any() && old('_modal') === 'edit' ? 'true' : 'false' }},
                        showCreateClassModal: {{ $errors->any() && old('_modal') === 'create_class' ? 'true' : 'false' }},
                        showCreateStudentModal: {{ $errors->any() && old('_modal') === 'create_student' ? 'true' : 'false' }},
                        editLogoName: '',
                        form: {
                            nama: @json(old('nama', $school->nama)),
                            npsn: @json(old('npsn', $school->npsn ?? '')),
                            telepon: @json(old('telepon', $school->telepon ?? '')),
                            alamat: @json(old('alamat', $school->alamat ?? '')),
                            status: {{ old('status', $school->status) ? 'true' : 'false' }},
                            logo_url: @json($school->logo ? Storage::url($school->logo) : '')
                        },
                        classForm: {
                            nama_kelas: @json(old('nama_kelas', '')),
                            tingkat: @json(old('tingkat', '')),
                            tahun_ajaran: @json(old('tahun_ajaran', date('Y') . '/' . (date('Y') + 1)))
                        },
                        studentForm: {
                            kelas_id: @json(old('kelas_id', '')),
                            nama_kelas: '',
                            nama: @json(old('nama', '')),
                            username: @json(old('username', '')),
                            email: @json(old('email', '')),
                            password: '',
                            nis: @json(old('nis', '')),
                            jenis_kelamin: @json(old('jenis_kelamin', 'L')),
                            tanggal_lahir: @json(old('tanggal_lahir', ''))
                        },
                        openEditModal() {
                            this.editLogoName = '';
                            this.showEditModal = true;
                            this.$nextTick(() => {
                                this.$refs.editNamaInput?.focus();
                                this.$refs.editNamaInput?.select();
                            });
                        },
                        openCreateClassModal() {
                            this.classForm.nama_kelas = '';
                            this.classForm.tingkat = '';
                            this.showCreateClassModal = true;
                            this.$nextTick(() => {
                                this.$refs.classNamaInput?.focus();
                            });
                        },
                        openCreateStudentModal(kelasId, namaKelas) {
                            this.studentForm.kelas_id = kelasId;
                            this.studentForm.nama_kelas = namaKelas || '';
                            this.studentForm.nama = '';
                            this.studentForm.username = '';
                            this.studentForm.email = '';
                            this.studentForm.password = '';
                            this.studentForm.nis = '';
                            this.studentForm.jenis_kelamin = 'L';
                            this.studentForm.tanggal_lahir = '';
                            this.showCreateStudentModal = true;
                            this.$nextTick(() => {
                                this.$refs.studentNamaInput?.focus();
                            });
                        }
                    }));
                }
            }

            if (window.Alpine) {
                initSchoolDetailManager();
            } else {
                document.addEventListener('alpine:init', initSchoolDetailManager);
            }
        })();
    </script>
    @endpush
</x-app-layout>
