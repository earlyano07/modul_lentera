<x-app-layout>
    <x-slot name="title">Data Peserta - Sekolah Binaan</x-slot>

    <div x-data="{
        openAssignModal: false,
        search: '',
        selected: {{ json_encode(array_map('strval', $assignedSchoolIds ?? [])) }},
        allSchoolIds: {{ json_encode(array_map('strval', $allSchools->pluck('id')->toArray())) }},
        selectAll() {
            this.selected = [...this.allSchoolIds];
        },
        deselectAll() {
            this.selected = [];
        },
        matchesSearch(name, address) {
            if (!this.search.trim()) return true;
            const q = this.search.toLowerCase().trim();
            return name.toLowerCase().includes(q) || address.toLowerCase().includes(q);
        }
    }">

        <!-- Header Section -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                        Data Peserta
                    </span>
                    <span class="text-xs text-slate-500 font-medium">
                        {{ $schools->count() }} Sekolah Ditugaskan
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Monitoring Sekolah Binaan</h1>
                <p class="mt-1 text-sm text-slate-600">Pilih sekolah binaan Anda untuk memantau data kelas, aktivitas, dan perkembangan empati siswa.</p>
            </div>

            <div class="flex items-center gap-3">
                <button type="button"
                        @click="openAssignModal = true"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-sm font-semibold rounded-xl shadow-xs transition-all cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span>Assign Sekolah</span>
                </button>
            </div>
        </div>

        <!-- Flash Success Notification -->
        @if(session('success'))
        <div class="mb-6 flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl" role="alert">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        @endif

        <!-- Grid Cards Sekolah Binaan -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($schools ?? [] as $school)
            <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 flex flex-col justify-between hover:shadow-md hover:border-emerald-300 transition-all group">
                <div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                            Aktif Dibimbing
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-700 transition-colors leading-snug mb-1">
                        {{ $school->nama }}
                    </h3>
                    <p class="text-slate-500 text-xs mb-5 line-clamp-2">
                        {{ $school->alamat ?? 'Alamat tidak tersedia' }}
                    </p>
                </div>

                <div>
                    <div class="border-t border-slate-100 pt-4 mb-4 flex items-center justify-between">
                        <div>
                            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Total Kelas</p>
                            <p class="text-base font-bold text-slate-800">{{ $school->kelas_count ?? 0 }} Kelas</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Status Binaan</p>
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Terhubung
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('counselor.monitoring.kelas', $school->id) }}"
                       class="inline-flex items-center justify-center w-full px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold text-sm transition-all shadow-xs active:scale-[0.98]">
                        <span>Lihat Daftar Kelas</span>
                        <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-16 px-6 text-center bg-white rounded-2xl border-2 border-slate-200 border-dashed">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Sekolah Binaan Ditugaskan</h3>
                <p class="text-sm text-slate-500 max-w-md mx-auto mb-6">
                    Anda belum ditugaskan ke sekolah manapun. Silakan klik tombol di bawah untuk memilih sekolah yang akan Anda dampingi dan pantau data peserta didiknya.
                </p>
                <button type="button"
                        @click="openAssignModal = true"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span>Assign Sekolah Sekarang</span>
                </button>
            </div>
            @endforelse
        </div>

        <!-- Modal Assign Sekolah (Alpine.js) -->
        <div x-show="openAssignModal"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             aria-labelledby="modal-title"
             role="dialog"
             aria-modal="true">

            <!-- Backdrop -->
            <div x-show="openAssignModal"
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="openAssignModal = false"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="openAssignModal"
                     x-transition:enter="ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-slate-200">

                    <!-- Form Penugasan Sekolah -->
                    <form action="{{ route('counselor.monitoring.schools.assign') }}" method="POST">
                        @csrf

                        <!-- Header Modal -->
                        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900" id="modal-title">
                                    Assign Sekolah Binaan
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    Pilih sekolah yang ingin Anda dampingi dan pantau data peserta didiknya.
                                </p>
                            </div>
                            <button type="button"
                                    @click="openAssignModal = false"
                                    class="text-slate-400 hover:text-slate-600 rounded-lg p-1.5 hover:bg-slate-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Body Modal -->
                        <div class="px-6 py-5">
                            <!-- Search & Quick Selection Tools -->
                            <div class="mb-4 space-y-3">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text"
                                           x-model="search"
                                           placeholder="Cari nama atau alamat sekolah..."
                                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                </div>

                                <div class="flex items-center justify-between text-xs text-slate-500 pt-1">
                                    <div class="flex items-center gap-2">
                                        <button type="button"
                                                @click="selectAll()"
                                                class="font-semibold text-emerald-600 hover:text-emerald-700 hover:underline">
                                            Pilih Semua
                                        </button>
                                        <span>•</span>
                                        <button type="button"
                                                @click="deselectAll()"
                                                class="font-semibold text-slate-500 hover:text-slate-700 hover:underline">
                                            Kosongkan
                                        </button>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800" x-text="selected.length"></span> dari {{ $allSchools->count() }} sekolah dipilih
                                    </div>
                                </div>
                            </div>

                            <!-- List Sekolah -->
                            <div class="max-h-72 overflow-y-auto divide-y divide-slate-100 border border-slate-200 rounded-xl">
                                @forelse($allSchools ?? [] as $sc)
                                @php
                                    $scIdStr = (string)$sc->id;
                                    $scNama = addslashes($sc->nama);
                                    $scAlamat = addslashes($sc->alamat ?? '');
                                @endphp
                                <label x-show="matchesSearch('{{ $scNama }}', '{{ $scAlamat }}')"
                                       class="flex items-start gap-3.5 p-3.5 hover:bg-slate-50/80 transition-colors cursor-pointer select-none">
                                    <div class="pt-0.5">
                                        <input type="checkbox"
                                               name="schools[]"
                                               value="{{ $sc->id }}"
                                               x-model="selected"
                                               class="w-4 h-4 text-emerald-600 border-slate-300 rounded-sm focus:ring-emerald-500 focus:ring-2 cursor-pointer">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between gap-2">
                                            <p class="text-sm font-bold text-slate-900 truncate">
                                                {{ $sc->nama }}
                                            </p>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-600 shrink-0">
                                                {{ $sc->kelas_count ?? 0 }} Kelas
                                            </span>
                                        </div>
                                        <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">
                                            {{ $sc->alamat ?? 'Alamat belum diatur' }}
                                        </p>
                                    </div>
                                </label>
                                @empty
                                <div class="py-8 text-center text-xs text-slate-400">
                                    Belum ada data sekolah terdaftar di sistem.
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Footer Modal -->
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 rounded-b-2xl">
                            <button type="button"
                                    @click="openAssignModal = false"
                                    class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                                Batal
                            </button>
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-sm font-semibold rounded-xl shadow-xs transition-all cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Simpan Penugasan</span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>
