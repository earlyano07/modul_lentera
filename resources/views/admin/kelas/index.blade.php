<x-app-layout>
    <x-slot name="title">Daftar Kelas</x-slot>

    <div x-data="kelasManager()">
        <!-- Main Content Area with Dynamic Blur Filter -->
        <div :class="(showCreateModal || showEditModal) ? 'filter blur-[4px] pointer-events-none transition-all duration-300' : 'transition-all duration-300'">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Kelas</h1>
                    <nav class="text-sm text-gray-500 mt-1">
                        <ol class="list-reset flex">
                            <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700">Dashboard</a></li>
                            <li><span class="mx-2">/</span></li>
                            <li class="text-gray-500">Kelas</li>
                        </ol>
                    </nav>
                </div>
                <button type="button" @click="openCreateModal()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Kelas
                </button>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs font-semibold shadow-xs">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 js-datatable">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Kelas</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Sekolah</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tingkat</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tahun Ajaran</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah Siswa</th>
                                <th class="px-6 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($kelasList as $kelas)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-extrabold text-slate-800">{{ $kelas->nama_kelas }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-600">{{ $kelas->school->nama ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-slate-100 text-slate-700">
                                        {{ $kelas->tingkat }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-500">{{ $kelas->tahun_ajaran }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/50">
                                        <span class="material-symbols-outlined text-[14px]">groups</span>
                                        {{ $kelas->students_count ?? 0 }} siswa
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button" 
                                            @click="openEditModal({{ json_encode([
                                                'id' => $kelas->id,
                                                'school_id' => $kelas->school_id,
                                                'nama_kelas' => $kelas->nama_kelas,
                                                'tingkat' => $kelas->tingkat,
                                                'tahun_ajaran' => $kelas->tahun_ajaran,
                                                'update_url' => route('admin.kelas.update', $kelas)
                                            ]) }})" 
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-extrabold bg-slate-100 text-slate-700 hover:bg-slate-200 transition shadow-2xs cursor-pointer">
                                            <span class="material-symbols-outlined text-[14px]">edit</span>
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.kelas.destroy', $kelas) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kelas ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-extrabold bg-rose-50 text-rose-600 hover:bg-rose-100 transition shadow-2xs cursor-pointer">
                                                <span class="material-symbols-outlined text-[14px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 whitespace-nowrap text-center text-sm text-slate-400">Tidak ada data kelas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create Kelas Modal -->
        <div x-show="showCreateModal" 
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
                 @click="showCreateModal = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
                <div x-show="showCreateModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-250"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-lg p-6 md:p-8 flex flex-col max-h-[90vh] z-10 border border-slate-100">
                    
                    <button type="button" @click="showCreateModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition p-1 hover:bg-slate-100 rounded-lg">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-600 text-2xl">class</span>
                            Tambah Kelas Baru
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Lengkapi informasi kelas baru</p>
                    </div>

                    <div class="overflow-y-auto flex-1 px-1">
                        <form action="{{ route('admin.kelas.store') }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label for="create_school_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Sekolah *</label>
                                <select name="school_id" id="create_school_id" required
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                    <option value="">-- Pilih Sekolah --</option>
                                    @foreach($schools as $school)
                                        <option value="{{ $school->id }}">{{ $school->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="create_nama_kelas" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kelas *</label>
                                <input type="text" name="nama_kelas" id="create_nama_kelas" x-ref="createNamaKelasInput" required placeholder="Contoh: VII A, VIII B, X IPA 1"
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="create_tingkat" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tingkat *</label>
                                    <input type="text" name="tingkat" id="create_tingkat" required placeholder="Contoh: 7, 8, 9, 10"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                                <div>
                                    <label for="create_tahun_ajaran" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tahun Ajaran *</label>
                                    <input type="text" name="tahun_ajaran" id="create_tahun_ajaran" value="{{ date('Y') . '/' . (date('Y') + 1) }}" required placeholder="Contoh: 2026/2027"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4 mt-6">
                                <button type="button" @click="showCreateModal = false"
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

        <!-- Edit Kelas Modal -->
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
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-lg p-6 md:p-8 flex flex-col max-h-[90vh] z-10 border border-slate-100">
                    
                    <button type="button" @click="showEditModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition p-1 hover:bg-slate-100 rounded-lg">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-600 text-2xl">edit_note</span>
                            Edit Detail Kelas
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Perbarui informasi kelas</p>
                    </div>

                    <div class="overflow-y-auto flex-1 px-1">
                        <form :action="form.update_url" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="edit_school_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Sekolah *</label>
                                <select name="school_id" id="edit_school_id" x-model="form.school_id" required
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                    <option value="">-- Pilih Sekolah --</option>
                                    @foreach($schools as $school)
                                        <option value="{{ $school->id }}">{{ $school->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="edit_nama_kelas" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Kelas *</label>
                                <input type="text" name="nama_kelas" id="edit_nama_kelas" x-ref="editNamaKelasInput" x-model="form.nama_kelas" required
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="edit_tingkat" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tingkat *</label>
                                    <input type="text" name="tingkat" id="edit_tingkat" x-model="form.tingkat" required
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                                <div>
                                    <label for="edit_tahun_ajaran" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tahun Ajaran *</label>
                                    <input type="text" name="tahun_ajaran" id="edit_tahun_ajaran" x-model="form.tahun_ajaran" required
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
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
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('kelasManager', () => ({
                showCreateModal: false,
                showEditModal: false,
                form: {
                    id: '',
                    school_id: '',
                    nama_kelas: '',
                    tingkat: '',
                    tahun_ajaran: '',
                    update_url: ''
                },
                openCreateModal() {
                    this.showCreateModal = true;
                    this.$nextTick(() => {
                        this.$refs.createNamaKelasInput?.focus();
                    });
                },
                openEditModal(data) {
                    this.form = { ...data };
                    this.showEditModal = true;
                    this.$nextTick(() => {
                        this.$refs.editNamaKelasInput?.focus();
                        this.$refs.editNamaKelasInput?.select();
                    });
                }
            }));
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @endpush
</x-app-layout>
