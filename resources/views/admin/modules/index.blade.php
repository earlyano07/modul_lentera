<x-app-layout>
    <x-slot name="title">Daftar Topik</x-slot>

    <div x-data="moduleManager()">
        <!-- Main Content Area with Dynamic Blur Filter -->
        <div :class="(showCreateModal || showEditModal) ? 'filter blur-[4px] pointer-events-none transition-all duration-300' : 'transition-all duration-300'">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Topik Pelatihan</h1>
                    <nav class="text-sm text-gray-500 mt-1">
                        <ol class="list-reset flex">
                            <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700">Dashboard</a></li>
                            <li><span class="mx-2">/</span></li>
                            <li class="text-gray-500">Topik</li>
                        </ol>
                    </nav>
                </div>
                <button type="button" @click="openCreateModal()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Topik
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
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-16">Urutan</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Judul Topik</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Fasilitas</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Assessment</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($modules as $module)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center h-7 w-7 rounded-lg bg-slate-100 text-slate-700 font-extrabold text-xs">
                                        {{ $module->urutan }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-extrabold text-slate-800">{{ $module->judul }}</div>
                                    @if($module->subtitle)
                                        <div class="text-xs text-indigo-600 font-semibold italic">{{ $module->subtitle }}</div>
                                    @endif
                                    <div class="text-xs text-slate-500 truncate max-w-xs mt-0.5">{{ Str::limit($module->deskripsi, 60) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/50">
                                        <span class="material-symbols-outlined text-[14px]">inventory_2</span>
                                        {{ $module->materials_count ?? 0 }} item
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200/50">
                                        <span class="material-symbols-outlined text-[14px]">quiz</span>
                                        {{ $module->assessments_count ?? 0 }} tes
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($module->status)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-md bg-slate-100 text-slate-600 border border-slate-200/50">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.modules.show', $module) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-extrabold bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition shadow-2xs">
                                            <span class="material-symbols-outlined text-[14px]">settings</span>
                                            Content
                                        </a>
                                        <button type="button" 
                                            @click="openEditModal({{ json_encode([
                                                'id' => $module->id,
                                                'urutan' => $module->urutan,
                                                'judul' => $module->judul,
                                                'deskripsi' => $module->deskripsi,
                                                'ilustrasi' => $module->ilustrasi ? asset('storage/' . $module->ilustrasi) : null,
                                                'update_url' => route('admin.modules.update', $module)
                                            ]) }})" 
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-extrabold bg-slate-100 text-slate-700 hover:bg-slate-200 transition shadow-2xs cursor-pointer">
                                            <span class="material-symbols-outlined text-[14px]">edit</span>
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.modules.destroy', $module) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus topik ini berserta isinya?');">
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
                                <td colspan="6" class="px-6 py-8 whitespace-nowrap text-center text-sm text-slate-400">Tidak ada data topik.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create Topic Modal -->
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
                            <span class="material-symbols-outlined text-indigo-600 text-2xl">add_box</span>
                            Tambah Topik Baru
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Lengkapi informasi topik pelatihan baru</p>
                    </div>

                    <div class="overflow-y-auto flex-1 px-1">
                        <form action="{{ route('admin.modules.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                            @csrf

                            <div>
                                <label for="create_urutan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Urutan Topik (No) *</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <span class="material-symbols-outlined text-base">tag</span>
                                    </span>
                                    <input type="number" name="urutan" id="create_urutan" x-ref="createUrutanInput" value="{{ $nextOrder ?? 1 }}" required min="0"
                                        class="pl-9 w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div>
                                <label for="create_judul" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Topik *</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <span class="material-symbols-outlined text-base">title</span>
                                    </span>
                                    <input type="text" name="judul" id="create_judul" required placeholder="Contoh: Empathy Awareness"
                                        class="pl-9 w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div>
                                <label for="create_deskripsi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Topik</label>
                                <textarea name="deskripsi" id="create_deskripsi" rows="4" placeholder="Tuliskan deskripsi ringkas mengenai materi dan tujuan topik ini..."
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition"></textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ilustrasi Gambar</label>
                                <div class="relative flex flex-col items-center justify-center p-4 border-2 border-dashed border-slate-200 hover:border-indigo-400 bg-slate-50/50 rounded-2xl cursor-pointer transition duration-200 group">
                                    <input type="file" name="ilustrasi" id="create_ilustrasi" accept="image/*" 
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        @change="const file = $event.target.files[0]; createFileName = file ? file.name : ''">
                                    <div class="text-center">
                                        <span class="material-symbols-outlined text-slate-400 group-hover:text-indigo-500 text-2xl transition duration-200 mb-1">image</span>
                                        <p class="text-xs font-extrabold text-slate-700" x-text="createFileName ? createFileName : 'Pilih File Gambar'"></p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">Format: JPG, PNG, WEBP (Maks: 2MB)</p>
                                    </div>
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
                                    Simpan Topik
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Topic Modal -->
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
                            <span class="material-symbols-outlined text-indigo-600 text-2xl">edit_note</span>
                            Edit Detail Topik
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Perbarui informasi utama topik pelatihan</p>
                    </div>

                    <div class="overflow-y-auto flex-1 px-1">
                        <form :action="form.update_url" method="POST" enctype="multipart/form-data" class="space-y-5">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="modal_urutan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Urutan Topik (No) *</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <span class="material-symbols-outlined text-base">tag</span>
                                    </span>
                                    <input type="number" name="urutan" id="modal_urutan" x-ref="editUrutanInput" x-model="form.urutan" required min="0"
                                        class="pl-9 w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div>
                                <label for="modal_judul" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Topik *</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <span class="material-symbols-outlined text-base">title</span>
                                    </span>
                                    <input type="text" name="judul" id="modal_judul" x-model="form.judul" required placeholder="Contoh: Empathy Awareness"
                                        class="pl-9 w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div>
                                <label for="modal_deskripsi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Topik</label>
                                <textarea name="deskripsi" id="modal_deskripsi" x-model="form.deskripsi" rows="4" placeholder="Tuliskan deskripsi ringkas mengenai materi dan tujuan topik ini..."
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition"></textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ilustrasi Gambar</label>
                                <template x-if="form.ilustrasi">
                                    <div class="mb-3 flex items-center gap-3 p-2 bg-slate-50 border border-slate-200 rounded-xl w-fit">
                                        <img :src="form.ilustrasi" alt="Preview" class="w-14 h-14 object-contain rounded-lg bg-white border border-slate-100 p-1">
                                        <div class="text-xs">
                                            <p class="font-bold text-slate-700">Gambar Saat Ini</p>
                                            <p class="text-[10px] text-slate-400">Pilih file baru jika ingin mengganti</p>
                                        </div>
                                    </div>
                                </template>
                                <div class="relative flex flex-col items-center justify-center p-4 border-2 border-dashed border-slate-200 hover:border-indigo-400 bg-slate-50/50 rounded-2xl cursor-pointer transition duration-200 group">
                                    <input type="file" name="ilustrasi" id="modal_ilustrasi" accept="image/*" 
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        @change="const file = $event.target.files[0]; editFileName = file ? file.name : ''">
                                    <div class="text-center">
                                        <span class="material-symbols-outlined text-slate-400 group-hover:text-indigo-500 text-2xl transition duration-200 mb-1">image</span>
                                        <p class="text-xs font-extrabold text-slate-700" x-text="editFileName ? editFileName : 'Pilih File Gambar Baru'"></p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">Format: JPG, PNG, WEBP (Maks: 2MB)</p>
                                    </div>
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
            Alpine.data('moduleManager', () => ({
                showCreateModal: false,
                showEditModal: false,
                createFileName: '',
                editFileName: '',
                form: {
                    id: '',
                    urutan: '',
                    judul: '',
                    deskripsi: '',
                    ilustrasi: '',
                    update_url: ''
                },
                openCreateModal() {
                    this.createFileName = '';
                    this.showCreateModal = true;
                    this.$nextTick(() => {
                        this.$refs.createUrutanInput?.focus();
                        this.$refs.createUrutanInput?.select();
                    });
                },
                openEditModal(data) {
                    this.form = { ...data };
                    this.editFileName = '';
                    this.showEditModal = true;
                    this.$nextTick(() => {
                        this.$refs.editUrutanInput?.focus();
                        this.$refs.editUrutanInput?.select();
                    });
                }
            }));
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @endpush
</x-app-layout>
