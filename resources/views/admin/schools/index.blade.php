<x-app-layout>
    <x-slot name="title">Daftar Sekolah</x-slot>

    <div x-data="schoolManager()">
        <!-- Main Content Area with Dynamic Blur Filter -->
        <div :class="(showCreateModal || showEditModal) ? 'filter blur-[4px] pointer-events-none transition-all duration-300' : 'transition-all duration-300'">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Sekolah</h1>
                    <nav class="text-sm text-gray-500 mt-1">
                        <ol class="list-reset flex">
                            <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700">Dashboard</a></li>
                            <li><span class="mx-2">/</span></li>
                            <li class="text-gray-500">Sekolah</li>
                        </ol>
                    </nav>
                </div>
                <button type="button" @click="openCreateModal()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Sekolah
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
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Sekolah</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Alamat</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">NPSN</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah Kelas</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($schools as $school)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($school->logo)
                                            <img class="h-9 w-9 rounded-xl object-cover mr-3 border border-slate-100 shadow-2xs" src="{{ Storage::url($school->logo) }}" alt="">
                                        @else
                                            <div class="h-9 w-9 rounded-xl bg-indigo-50 border border-indigo-100 mr-3 flex items-center justify-center text-indigo-600 font-black text-xs shadow-2xs">
                                                {{ substr($school->nama, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="text-sm font-extrabold text-slate-800">{{ $school->nama }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs text-slate-500 truncate max-w-xs">{{ $school->alamat ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-600">{{ $school->npsn ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/50">
                                        <span class="material-symbols-outlined text-[14px]">class</span>
                                        {{ $school->kelas_count ?? 0 }} kelas
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($school->status)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-md bg-rose-50 text-rose-700 border border-rose-200/50">
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.schools.show', $school) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-extrabold bg-blue-50 text-blue-700 hover:bg-blue-100 transition shadow-2xs">
                                            <span class="material-symbols-outlined text-[14px]">visibility</span>
                                            Detail
                                        </a>
                                        <button type="button" 
                                            @click="openEditModal({{ json_encode([
                                                'id' => $school->id,
                                                'nama' => $school->nama,
                                                'npsn' => $school->npsn,
                                                'telepon' => $school->telepon,
                                                'alamat' => $school->alamat,
                                                'status' => (bool)$school->status,
                                                'logo_url' => $school->logo ? Storage::url($school->logo) : null,
                                                'update_url' => route('admin.schools.update', $school)
                                            ]) }})" 
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-extrabold bg-slate-100 text-slate-700 hover:bg-slate-200 transition shadow-2xs cursor-pointer">
                                            <span class="material-symbols-outlined text-[14px]">edit</span>
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.schools.destroy', $school) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus sekolah ini?');">
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
                                <td colspan="6" class="px-6 py-8 whitespace-nowrap text-center text-sm text-slate-400">Tidak ada data sekolah.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create School Modal -->
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
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-xl p-6 md:p-8 flex flex-col max-h-[90vh] z-10 border border-slate-100">
                    
                    <button type="button" @click="showCreateModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition p-1 hover:bg-slate-100 rounded-lg">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-600 text-2xl">domain_add</span>
                            Tambah Sekolah Baru
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Lengkapi formulir informasi sekolah di bawah ini</p>
                    </div>

                    <div class="overflow-y-auto flex-1 px-1">
                        <form action="{{ route('admin.schools.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf

                            <div>
                                <label for="create_nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Sekolah *</label>
                                <input type="text" name="nama" id="create_nama" x-ref="createNamaInput" required placeholder="Contoh: SMP Negeri 1 Jakarta"
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="create_npsn" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">NPSN</label>
                                    <input type="text" name="npsn" id="create_npsn" placeholder="Nomor Pokok Sekolah"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                                <div>
                                    <label for="create_telepon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Telepon</label>
                                    <input type="text" name="telepon" id="create_telepon" placeholder="Contoh: 021-1234567"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div>
                                <label for="create_alamat" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat</label>
                                <textarea name="alamat" id="create_alamat" rows="2" placeholder="Alamat lengkap sekolah..."
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition"></textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Logo Sekolah</label>
                                <div class="relative flex flex-col items-center justify-center p-4 border-2 border-dashed border-slate-200 hover:border-indigo-400 bg-slate-50/50 rounded-2xl cursor-pointer transition duration-200 group">
                                    <input type="file" name="logo" id="create_logo" accept="image/*" 
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        @change="const file = $event.target.files[0]; createLogoName = file ? file.name : ''">
                                    <div class="text-center">
                                        <span class="material-symbols-outlined text-slate-400 group-hover:text-indigo-500 text-2xl transition duration-200 mb-1">image</span>
                                        <p class="text-xs font-extrabold text-slate-700" x-text="createLogoName ? createLogoName : 'Pilih Logo Sekolah'"></p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">Format: JPG, PNG, WEBP (Maks: 2MB)</p>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-1">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="status" value="1" checked class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-xs font-bold text-slate-700">Status Aktif</span>
                                </label>
                            </div>

                            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4 mt-6">
                                <button type="button" @click="showCreateModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-wider transition">
                                    Batal
                                </button>
                                <button type="submit" 
                                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition duration-200 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                    Simpan Sekolah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit School Modal -->
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
                        <form :action="form.update_url" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="edit_nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Sekolah *</label>
                                <input type="text" name="nama" id="edit_nama" x-ref="editNamaInput" x-model="form.nama" required
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="edit_npsn" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">NPSN</label>
                                    <input type="text" name="npsn" id="edit_npsn" x-model="form.npsn"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                                <div>
                                    <label for="edit_telepon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Telepon</label>
                                    <input type="text" name="telepon" id="edit_telepon" x-model="form.telepon"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div>
                                <label for="edit_alamat" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat</label>
                                <textarea name="alamat" id="edit_alamat" x-model="form.alamat" rows="2"
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition"></textarea>
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
                            </div>

                            <div class="pt-1">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="status" value="1" x-model="form.status" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-xs font-bold text-slate-700">Status Aktif</span>
                                </label>
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
            Alpine.data('schoolManager', () => ({
                showCreateModal: false,
                showEditModal: false,
                createLogoName: '',
                editLogoName: '',
                form: {
                    id: '',
                    nama: '',
                    npsn: '',
                    telepon: '',
                    alamat: '',
                    status: true,
                    logo_url: '',
                    update_url: ''
                },
                openCreateModal() {
                    this.createLogoName = '';
                    this.showCreateModal = true;
                    this.$nextTick(() => {
                        this.$refs.createNamaInput?.focus();
                    });
                },
                openEditModal(data) {
                    this.form = { ...data };
                    this.editLogoName = '';
                    this.showEditModal = true;
                    this.$nextTick(() => {
                        this.$refs.editNamaInput?.focus();
                        this.$refs.editNamaInput?.select();
                    });
                }
            }));
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @endpush
</x-app-layout>
