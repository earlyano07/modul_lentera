<x-app-layout>
    <x-slot name="title">Daftar Konselor</x-slot>

    <div x-data="konselorManager()">
        <!-- Main Content Area with Dynamic Blur Filter -->
        <div :class="(showCreateModal || showEditModal) ? 'filter blur-[4px] pointer-events-none transition-all duration-300' : 'transition-all duration-300'">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Konselor</h1>
                    <nav class="text-sm text-gray-500 mt-1">
                        <ol class="list-reset flex">
                            <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700">Dashboard</a></li>
                            <li><span class="mx-2">/</span></li>
                            <li class="text-gray-500">Konselor</li>
                        </ol>
                    </nav>
                </div>
                <button type="button" @click="openCreateModal()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Konselor
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
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Konselor</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">NIP</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">No HP</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Sekolah yang Ditangani</th>
                                <th class="px-6 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($konselors as $konselor)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-9 w-9 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-black text-xs mr-3 shadow-2xs">
                                            {{ substr($konselor->user->nama ?? 'C', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-extrabold text-slate-800">{{ $konselor->user->nama ?? '-' }}</div>
                                            <div class="text-xs text-slate-500 font-medium">{{ $konselor->user->email ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-600">{{ $konselor->nip ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-600">{{ $konselor->no_hp ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    @if(isset($konselor->schools) && $konselor->schools->count() > 0)
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach($konselor->schools as $school)
                                                <span class="inline-flex items-center px-2.5 py-0.5 bg-slate-100 text-slate-700 text-xs rounded-md font-bold border border-slate-200/50">{{ $school->nama }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-slate-400 italic text-xs">Belum ada sekolah</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button" 
                                            @click="openEditModal({{ json_encode([
                                                'id' => $konselor->id,
                                                'nama' => $konselor->user->nama ?? '',
                                                'email' => $konselor->user->email ?? '',
                                                'nip' => $konselor->nip ?? '',
                                                'no_hp' => $konselor->no_hp ?? '',
                                                'school_ids' => $konselor->schools->pluck('id')->toArray(),
                                                'update_url' => route('admin.konselor.update', $konselor)
                                            ]) }})" 
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-extrabold bg-slate-100 text-slate-700 hover:bg-slate-200 transition shadow-2xs cursor-pointer">
                                            <span class="material-symbols-outlined text-[14px]">edit</span>
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.konselor.destroy', $konselor) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus konselor ini?');">
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
                                <td colspan="5" class="px-6 py-8 whitespace-nowrap text-center text-sm text-slate-400">Tidak ada data konselor.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create Konselor Modal -->
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
                            <span class="material-symbols-outlined text-indigo-600 text-2xl">person_add</span>
                            Tambah Konselor Baru
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Lengkapi data akun dan penugasan konselor</p>
                    </div>

                    <div class="overflow-y-auto flex-1 px-1">
                        <form action="{{ route('admin.konselor.store') }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label for="create_nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap *</label>
                                <input type="text" name="nama" id="create_nama" x-ref="createNamaInput" required placeholder="Contoh: Dra. Siti Rahayu, M.Pd"
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="create_email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email *</label>
                                    <input type="email" name="email" id="create_email" required placeholder="konselor@sekolah.sch.id"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                                <div>
                                    <label for="create_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password *</label>
                                    <input type="password" name="password" id="create_password" required minlength="8" placeholder="Minimal 8 karakter"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="create_nip" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">NIP *</label>
                                    <input type="text" name="nip" id="create_nip" required placeholder="198001012005011001"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                                <div>
                                    <label for="create_no_hp" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor HP/WA</label>
                                    <input type="text" name="no_hp" id="create_no_hp" placeholder="081234567890"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div>
                                <label for="create_schools" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Sekolah yang Ditangani</label>
                                <div class="select2-wrapper">
                                    <select name="schools[]" id="create_schools" class="w-full" multiple="multiple" data-placeholder="Pilih satu atau lebih sekolah...">
                                        @foreach($schools as $school)
                                            <option value="{{ $school->id }}">{{ $school->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-[10px] text-slate-400 font-semibold mt-1">Bisa memilih lebih dari satu sekolah (multiple choice).</p>
                            </div>

                            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4 mt-6">
                                <button type="button" @click="showCreateModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-wider transition">
                                    Batal
                                </button>
                                <button type="submit" 
                                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition duration-200 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                    Simpan Konselor
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Konselor Modal -->
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
                            Edit Data Konselor
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Perbarui profil dan sekolah penugasan</p>
                    </div>

                    <div class="overflow-y-auto flex-1 px-1">
                        <form :action="form.update_url" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="edit_nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap *</label>
                                <input type="text" name="nama" id="edit_nama" x-ref="editNamaInput" x-model="form.nama" required
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="edit_email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email *</label>
                                    <input type="email" name="email" id="edit_email" x-model="form.email" required
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                                <div>
                                    <label for="edit_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password Baru</label>
                                    <input type="password" name="password" id="edit_password" placeholder="Kosongkan jika tidak diubah" minlength="8"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="edit_nip" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">NIP *</label>
                                    <input type="text" name="nip" id="edit_nip" x-model="form.nip" required
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                                <div>
                                    <label for="edit_no_hp" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor HP/WA</label>
                                    <input type="text" name="no_hp" id="edit_no_hp" x-model="form.no_hp"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div>
                                <label for="edit_schools" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Sekolah yang Ditangani</label>
                                <div class="select2-wrapper">
                                    <select name="schools[]" id="edit_schools" class="w-full" multiple="multiple" data-placeholder="Pilih satu atau lebih sekolah...">
                                        @foreach($schools as $school)
                                            <option value="{{ $school->id }}">{{ $school->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-[10px] text-slate-400 font-semibold mt-1">Bisa memilih lebih dari satu sekolah (multiple choice).</p>
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
            border-radius: 0.75rem;
            min-height: 42px;
            padding: 3px 6px;
            transition: all 0.2s;
            font-family: inherit;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #6366f1;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
            outline: none;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #e0e7ff;
            border: 1px solid #c7d2fe;
            border-radius: 0.5rem;
            color: #4338ca;
            padding: 2px 8px 2px 22px;
            font-size: 0.75rem;
            font-weight: 700;
            position: relative;
            margin-top: 4px;
            margin-bottom: 4px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #6366f1;
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
        .select2-container--default .select2-search--inline .select2-search__field {
            font-family: inherit;
            font-size: 0.75rem;
            margin-top: 6px;
            padding-left: 4px;
            color: #1e293b;
        }
        .select2-dropdown {
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            font-family: inherit;
            font-size: 0.75rem;
            overflow: hidden;
            z-index: 9999999 !important;
            background-color: #ffffff;
        }
        .select2-container--open {
            z-index: 9999999 !important;
        }
        .select2-container--default .select2-search--dropdown {
            padding: 8px;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 6px 10px;
            font-family: inherit;
            font-size: 0.75rem;
            background-color: #f8fafc;
            outline: none;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            border-color: #6366f1;
            background-color: #ffffff;
        }
        .select2-results__option {
            padding: 8px 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #4f46e5;
            color: #ffffff;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #e0e7ff;
            color: #4338ca;
            font-weight: 700;
        }
    </style>
    @endpush

    @push('scripts')
    <!-- jQuery and Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('konselorManager', () => ({
                showCreateModal: false,
                showEditModal: false,
                form: {
                    id: '',
                    nama: '',
                    email: '',
                    nip: '',
                    no_hp: '',
                    school_ids: [],
                    update_url: ''
                },
                openCreateModal() {
                    this.showCreateModal = true;
                    this.$nextTick(() => {
                        this.$refs.createNamaInput?.focus();
                        if (typeof $ !== 'undefined') {
                            const $el = $('#create_schools');
                            if (!$el.hasClass('select2-hidden-accessible')) {
                                $el.select2({
                                    placeholder: "Pilih satu atau lebih sekolah...",
                                    allowClear: true,
                                    width: '100%',
                                    dropdownParent: $el.closest('.select2-wrapper')
                                });
                            }
                            $el.val([]).trigger('change');
                        }
                    });
                },
                openEditModal(data) {
                    this.form = { ...data };
                    this.showEditModal = true;
                    this.$nextTick(() => {
                        this.$refs.editNamaInput?.focus();
                        this.$refs.editNamaInput?.select();
                        if (typeof $ !== 'undefined') {
                            const $el = $('#edit_schools');
                            if (!$el.hasClass('select2-hidden-accessible')) {
                                $el.select2({
                                    placeholder: "Pilih satu atau lebih sekolah...",
                                    allowClear: true,
                                    width: '100%',
                                    dropdownParent: $el.closest('.select2-wrapper')
                                });
                            }
                            $el.val(data.school_ids || []).trigger('change');
                        }
                    });
                }
            }));
        });

        $(document).ready(function() {
            $('#create_schools').select2({
                placeholder: "Pilih satu atau lebih sekolah...",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#create_schools').closest('.select2-wrapper')
            });

            $('#edit_schools').select2({
                placeholder: "Pilih satu atau lebih sekolah...",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#edit_schools').closest('.select2-wrapper')
            });
        });
    </script>
    @endpush
</x-app-layout>
