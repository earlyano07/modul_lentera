<x-app-layout>
    @php
        $video = $module->materials->where('jenis', \App\Models\Material::JENIS_VIDEO)->first();
    @endphp
    <div class="w-full space-y-8" x-data="{
        step: 1,
        showVideoModal: false,
        videoSourceType: '{{ $video && !$video->isYoutubeVideo() && $video->video ? 'file' : 'youtube' }}',
        videoUrl: '{{ $video && $video->isYoutubeVideo() ? $video->video : '' }}',
        videoFileLabel: '',
        showKartuCreateModal: false,
        showKartuEditModal: false,
        createKartuFileName: '',
        editKartuFileName: '',
        kartuEditForm: {
            id: '',
            file_url: null,
            situasi: '',
            peran: '',
            diskusi: '',
            update_url: ''
        },
        openKartuCreateModal() {
            this.createKartuFileName = '';
            this.showKartuCreateModal = true;
            this.$nextTick(() => this.$refs.createSituasiInput?.focus());
        },
        openKartuEditModal(data) {
            this.kartuEditForm = { ...data };
            this.editKartuFileName = '';
            this.showKartuEditModal = true;
            this.$nextTick(() => this.$refs.editSituasiInput?.focus());
        },
        showAssessmentCreateModal: false,
        showAssessmentEditModal: false,
        assessmentCreateForm: {
            judul: '',
            deskripsi: '',
            catatan: '',
            jenis: 'lkpd',
            urutan: {{ ($module->assessments->max('urutan') ?? 0) + 1 }}
        },
        assessmentEditForm: {
            id: '',
            judul: '',
            deskripsi: '',
            catatan: '',
            jenis: 'lkpd',
            urutan: 1,
            update_url: ''
        },
        openAssessmentCreateModal(defaultJenis = 'lkpd') {
            this.assessmentCreateForm.jenis = defaultJenis;
            this.assessmentCreateForm.judul = '';
            this.assessmentCreateForm.deskripsi = '';
            this.assessmentCreateForm.catatan = '';
            this.showAssessmentCreateModal = true;
            this.$nextTick(() => this.$refs.createAssessmentJudulInput?.focus());
        },
        openAssessmentEditModal(data) {
            this.assessmentEditForm = {
                id: data.id || '',
                judul: data.judul || '',
                deskripsi: data.deskripsi || '',
                catatan: data.catatan || '',
                jenis: data.jenis || 'lkpd',
                urutan: data.urutan || 1,
                update_url: data.update_url || ''
            };
            this.showAssessmentEditModal = true;
            this.$nextTick(() => this.$refs.editAssessmentJudulInput?.focus());
        },
        init() {
            const urlParams = new URLSearchParams(window.location.search);
            const urlStep = urlParams.get('step') || window.location.hash.replace('#step', '');
            const savedStep = localStorage.getItem('admin_module_step_{{ $module->id }}');
    
            if (urlStep) {
                this.step = parseInt(urlStep);
            } else if ({{ request('step') ? 'true' : 'false' }}) {
                this.step = {{ (int) request('step') }};
            } else if (savedStep) {
                this.step = parseInt(savedStep);
            }
    
            this.$watch('step', (val) => {
                localStorage.setItem('admin_module_step_{{ $module->id }}', val);
                const currentUrl = new URL(window.location);
                currentUrl.searchParams.set('step', val);
                window.history.replaceState({}, '', currentUrl);
            });
        }
    }">
        <!-- Main Content with Dynamic Blur -->
        <div
            :class="(showVideoModal || showKartuCreateModal || showKartuEditModal || showAssessmentCreateModal ||
                showAssessmentEditModal) ?
            'filter blur-[4px] pointer-events-none transition-all duration-300 space-y-8' :
            'transition-all duration-300 space-y-8'">
            <!-- Header & Top Navigation -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-150 pb-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.modules.index') }}"
                        class="p-2 hover:bg-gray-100 rounded-xl transition text-gray-500 hover:text-gray-700">
                        <span class="material-symbols-outlined block">arrow_back</span>
                    </a>
                    <div>
                        <div class="flex items-center gap-2">
                            <span
                                class="px-2 py-0.5 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-md uppercase tracking-wider">Topik
                                Layanan</span>
                            <span class="text-xs text-gray-400 font-bold">Modul {{ $module->urutan }}</span>
                        </div>
                        <h1 class="text-2xl font-black text-slate-800 mt-1">{{ $module->judul }}</h1>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div
                    class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-semibold shadow-xs">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Timeline Step Indicator (Top) -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
                <div class="flex justify-between items-start relative">
                    <!-- Progress Line Background -->
                    <div class="absolute top-5 left-10 right-10 h-0.5 bg-gray-100 -z-10"></div>
                    <!-- Progress Line Active -->
                    <div class="absolute top-5 left-10 h-0.5 bg-indigo-600 -z-10 transition-all duration-500"
                        :class="{
                            'w-0': step === 1,
                            'w-1/3': step === 2,
                            'w-2/3': step === 3,
                            'w-[92%]': step === 4
                        }">
                    </div>

                    <!-- Step 1 -->
                    <div class="flex flex-col items-center gap-2 cursor-pointer group" @click="step = 1">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300"
                            :class="step === 1 ? 'bg-blue-600 text-white shadow-lg ring-4 ring-blue-100' : (step > 1 ?
                                'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 text-gray-500')">
                            <template x-if="step > 1">
                                <span class="material-symbols-outlined text-sm font-bold">check</span>
                            </template>
                            <template x-if="step === 1">
                                <span>1</span>
                            </template>
                        </div>
                        <div class="text-center">
                            <p class="text-xs sm:text-sm font-bold"
                                :class="step === 1 ? 'text-blue-600' : 'text-gray-500'">Modeling</p>
                            <p class="text-[10px] hidden sm:block text-gray-400 max-w-[120px]">Video Kejadian</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center gap-2 cursor-pointer group" @click="step = 2">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300"
                            :class="step === 2 ? 'bg-emerald-600 text-white shadow-lg ring-4 ring-emerald-100' : (step > 2 ?
                                'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 text-gray-500')">
                            <template x-if="step > 2">
                                <span class="material-symbols-outlined text-sm font-bold">check</span>
                            </template>
                            <template x-if="step <= 2">
                                <span>2</span>
                            </template>
                        </div>
                        <div class="text-center">
                            <p class="text-xs sm:text-sm font-bold"
                                :class="step === 2 ? 'text-emerald-600' : 'text-gray-500'">Role Playing</p>
                            <p class="text-[10px] hidden sm:block text-gray-400 max-w-[120px]">Kartu Situasi</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center gap-2 cursor-pointer group" @click="step = 3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300"
                            :class="step === 3 ? 'bg-amber-500 text-white shadow-lg ring-4 ring-amber-100' : (step > 3 ?
                                'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 text-gray-500')">
                            <template x-if="step > 3">
                                <span class="material-symbols-outlined text-sm font-bold">check</span>
                            </template>
                            <template x-if="step <= 3">
                                <span>3</span>
                            </template>
                        </div>
                        <div class="text-center">
                            <p class="text-xs sm:text-sm font-bold"
                                :class="step === 3 ? 'text-amber-500' : 'text-gray-500'">Performance Feedback</p>
                            <p class="text-[10px] hidden sm:block text-gray-400 max-w-[120px]">Umpan Balik</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center gap-2 cursor-pointer group" @click="step = 4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300"
                            :class="step === 4 ? 'bg-indigo-600 text-white shadow-lg ring-4 ring-indigo-100' :
                                'bg-gray-100 text-gray-500'">
                            <span>4</span>
                        </div>
                        <div class="text-center">
                            <p class="text-xs sm:text-sm font-bold"
                                :class="step === 4 ? 'text-indigo-600' : 'text-gray-500'">Transfer of Training</p>
                            <p class="text-[10px] hidden sm:block text-gray-400 max-w-[120px]">LKPD Online</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Outer dynamic grid layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <!-- Left Column: Main Content Area card -->
                <div :class="(step === 1 || step === 2) ? 'lg:col-span-2' : 'lg:col-span-3'">
                    <div
                        class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-200 min-h-[400px] flex flex-col justify-between">
                        <div>
                            <!-- TAHAP 1: MODELING -->
                            <div x-show="step === 1" x-transition class="space-y-6">
                                <div class="flex justify-between items-start border-b border-gray-100 pb-4">
                                    <div>
                                        <span
                                            class="px-2.5 py-1 bg-blue-500 text-white text-xs font-bold rounded-lg uppercase tracking-wider">Tahap
                                            1</span>
                                        <h3 class="text-xl font-black text-slate-800 mt-2">Modeling (Video / Ilustrasi
                                            Kejadian)</h3>
                                        <p class="text-sm text-gray-500 mt-0.5 font-semibold">Siswa diperlihatkan video
                                            atau ilustrasi kejadian mengenai empati dan bullying.</p>
                                    </div>
                                    <button type="button" @click="showVideoModal = true"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 border border-transparent rounded-xl text-xs font-black text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition uppercase tracking-wide cursor-pointer">
                                        <span class="material-symbols-outlined text-sm">video_call</span>
                                        {{ $video ? 'Ganti / Edit Video' : '+ Tambah Video Modeling' }}
                                    </button>
                                </div>

                                <!-- Video Preview & Materials Detail -->
                                @if ($video)
                                    <div
                                        class="bg-black rounded-2xl overflow-hidden aspect-video max-w-4xl mx-auto shadow-lg relative group">
                                        @if ($video->isYoutubeVideo())
                                            <iframe class="w-full h-full" src="{{ $video->getYoutubeEmbedUrl() }}"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen></iframe>
                                        @elseif($video->video)
                                            <video class="w-full h-full" controls>
                                                <source src="{{ asset('storage/' . $video->video) }}" type="video/mp4">
                                                Browser Anda tidak mendukung tag video.
                                            </video>
                                        @else
                                            <div
                                                class="w-full h-full flex flex-col items-center justify-center bg-slate-900 text-slate-400 p-6 text-center">
                                                <span
                                                    class="material-symbols-outlined text-[64px] mb-2 text-slate-600">play_circle</span>
                                                <p class="text-sm font-semibold">Tonton video contoh perilaku empati
                                                    sesuai arahan konselor.</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div
                                        class="max-w-4xl mx-auto bg-slate-50 border border-slate-200 rounded-xl p-5 flex justify-between items-start gap-4 shadow-sm">
                                        <div class="flex-1">
                                            <h4
                                                class="font-bold text-sm text-slate-800 mb-1.5 flex items-center gap-1.5">
                                                <span
                                                    class="material-symbols-outlined text-[18px] text-indigo-600">description</span>
                                                {{ $video->judul }}
                                            </h4>
                                            @if ($video->isi)
                                                <div class="text-xs text-slate-600 leading-relaxed font-semibold">
                                                    {!! $video->isi !!}</div>
                                            @else
                                                <div class="text-xs text-slate-400 italic">Media peraga tahap modeling
                                                    topik {{ $module->judul }}</div>
                                            @endif
                                        </div>
                                        <div class="flex space-x-2 shrink-0">
                                            <button type="button" @click="showVideoModal = true"
                                                class="px-3 py-1 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50 shadow-xs cursor-pointer">Edit</button>
                                            <form action="{{ route('admin.materials.destroy', $video) }}"
                                                method="POST" onsubmit="return confirm('Hapus video modeling ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1 bg-white border border-red-300 rounded-lg text-xs font-semibold text-red-650 hover:bg-red-50 shadow-xs cursor-pointer">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="p-8 bg-slate-50 border border-slate-200 rounded-2xl text-center text-sm text-slate-500 font-medium max-w-xl mx-auto space-y-3">
                                        <div
                                            class="h-12 w-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto">
                                            <span class="material-symbols-outlined text-2xl">videocam_off</span>
                                        </div>
                                        <p class="text-xs font-bold text-slate-600">Video / ilustrasi kejadian belum
                                            ditambahkan untuk topik ini.</p>
                                        <button type="button" @click="showVideoModal = true"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs transition cursor-pointer">
                                            <span class="material-symbols-outlined text-sm">add_circle</span>
                                            Tambah Video Sekarang
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <!-- TAHAP 2: ROLE PLAYING -->
                            <div x-show="step === 2" x-transition class="space-y-6">
                                @php
                                    $kartuList = $module->materials->where(
                                        'jenis',
                                        \App\Models\Material::JENIS_KARTU_SITUASI,
                                    );
                                @endphp
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-gray-100 pb-4">
                                    <div>
                                        <span
                                            class="px-2.5 py-1 bg-emerald-500 text-white text-xs font-bold rounded-lg uppercase tracking-wider">Tahap
                                            2</span>
                                        <h3 class="text-xl font-black text-slate-800 mt-2">Role Playing (Kartu Situasi)
                                        </h3>
                                        <p class="text-sm text-gray-500 mt-0.5 font-semibold">Siswa melatih respon
                                            empati secara berkelompok dengan memperagakan skenario kasus.</p>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0 flex-wrap">
                                        @if ($kartuList->count() > 0)
                                            <a href="{{ route('kartu-situasi.print', $module) }}" target="_blank"
                                                class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-emerald-200 text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-xl text-xs font-black shadow-xs transition uppercase tracking-wide cursor-pointer">
                                                <span class="material-symbols-outlined text-sm">print</span>
                                                Cetak / PDF
                                            </a>
                                            <a href="{{ route('kartu-situasi.docx', $module) }}"
                                                class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-blue-200 text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-xl text-xs font-black shadow-xs transition uppercase tracking-wide cursor-pointer">
                                                <span class="material-symbols-outlined text-sm">download</span>
                                                Word (.docx)
                                            </a>
                                        @endif
                                        <button type="button" @click="openKartuCreateModal()"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 border border-transparent rounded-xl text-xs font-black text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition uppercase tracking-wide cursor-pointer">
                                            <span class="material-symbols-outlined text-sm">add_circle</span>
                                            + Tambah Kartu Situasi
                                        </button>
                                    </div>
                                </div>

                                @if ($kartuList->count() > 0)
                                    <div
                                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 justify-center w-full">
                                        @foreach ($kartuList as $kartu)
                                            <div
                                                class="w-full bg-white border-2 border-emerald-600/30 rounded-[2rem] p-6 shadow-md relative overflow-hidden flex flex-col justify-between">
                                                <div>
                                                    <!-- Card Header -->
                                                    <div class="flex items-center gap-3 mb-4">
                                                        <div
                                                            class="w-9 h-9 rounded-full bg-[#006d2c] text-white flex items-center justify-center text-base font-black shrink-0">
                                                            {{ $loop->iteration }}
                                                        </div>
                                                        <h4
                                                            class="flex-grow text-center text-sm font-black text-[#006d2c] uppercase tracking-wide leading-tight">
                                                            {{ $kartu->judul }}
                                                        </h4>
                                                        <div class="flex items-center gap-1">
                                                            <button type="button"
                                                                @click="openKartuEditModal({{ json_encode([
                                                                    'id' => $kartu->id,
                                                                    'file_url' => $kartu->file_path ? asset('storage/' . $kartu->file_path) : null,
                                                                    'situasi' => $kartu->situasi ?? '',
                                                                    'peran' => $kartu->peran ?? '',
                                                                    'diskusi' => $kartu->diskusi ?? '',
                                                                    'update_url' => route('admin.materials.update', $kartu),
                                                                ]) }})"
                                                                class="p-1.5 text-gray-500 hover:text-emerald-600 rounded-lg bg-gray-50 border border-gray-200 hover:bg-emerald-50/50 shadow-xs cursor-pointer">
                                                                <span
                                                                    class="material-symbols-outlined text-[16px] block">edit</span>
                                                            </button>
                                                            <form
                                                                action="{{ route('admin.materials.destroy', $kartu) }}"
                                                                method="POST" class="inline-block"
                                                                onsubmit="return confirm('Hapus kartu situasi ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="step" value="2">
                                                                <button type="submit"
                                                                    class="p-1.5 text-red-500 hover:text-red-700 rounded-lg bg-gray-50 border border-gray-200 hover:bg-red-50/50 shadow-xs cursor-pointer"><span
                                                                        class="material-symbols-outlined text-[16px] block">delete</span></button>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <!-- Card Photo / Illustration -->
                                                    @if ($kartu->file_path)
                                                        <div
                                                            class="my-4 overflow-hidden rounded-2xl border border-gray-100 shadow-sm aspect-[16/10]">
                                                            <img src="{{ asset('storage/' . $kartu->file_path) }}"
                                                                class="w-full h-full object-cover">
                                                        </div>
                                                    @else
                                                        <div
                                                            class="my-4 overflow-hidden rounded-2xl border border-emerald-100 bg-emerald-50/20 shadow-sm flex items-center justify-center min-h-[160px] p-6 text-center text-emerald-700/60">
                                                            <div class="flex flex-col items-center gap-1">
                                                                <span
                                                                    class="material-symbols-outlined text-[48px]">school</span>
                                                                <span
                                                                    class="text-[10px] font-bold uppercase tracking-wider">Ilustrasi
                                                                    Kegiatan Pelatihan</span>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <!-- Situasi Description -->
                                                    <div class="mt-4">
                                                        <span
                                                            class="inline-block px-3 py-1 bg-[#006d2c] text-white text-[10px] font-extrabold rounded-md uppercase tracking-wider mb-2">
                                                            Situasi
                                                        </span>
                                                        <p
                                                            class="text-xs text-slate-700 font-semibold leading-relaxed">
                                                            {{ $kartu->situasi }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Peran & Diskusi Grid -->
                                                <div
                                                    class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-t border-emerald-100/50 mt-5 pt-4">
                                                    <div>
                                                        <div
                                                            class="flex items-center gap-1.5 text-[#006d2c] font-extrabold text-[10px] uppercase tracking-wider mb-2">
                                                            <span
                                                                class="material-symbols-outlined text-[14px]">person</span>
                                                            <span>Peran</span>
                                                        </div>
                                                        @php
                                                            $peranList = array_filter(
                                                                array_map('trim', explode("\n", $kartu->peran)),
                                                            );
                                                        @endphp
                                                        <ul class="space-y-1">
                                                            @foreach ($peranList as $item)
                                                                <li
                                                                    class="flex items-start gap-1.5 text-[10px] text-slate-600 font-semibold leading-normal">
                                                                    <span
                                                                        class="text-emerald-600 text-[8px] mt-0.5 select-none">●</span>
                                                                    <span>{{ $item }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>

                                                    <div>
                                                        <div
                                                            class="flex items-center gap-1.5 text-[#006d2c] font-extrabold text-[10px] uppercase tracking-wider mb-2">
                                                            <span
                                                                class="material-symbols-outlined text-[14px]">chat</span>
                                                            <span>Diskusikan</span>
                                                        </div>
                                                        @php
                                                            $diskusiList = array_filter(
                                                                array_map('trim', explode("\n", $kartu->diskusi)),
                                                            );
                                                        @endphp
                                                        <ul class="space-y-1">
                                                            @foreach ($diskusiList as $item)
                                                                <li
                                                                    class="flex items-start gap-1.5 text-[10px] text-slate-600 font-semibold leading-normal">
                                                                    <span
                                                                        class="text-emerald-600 text-[8px] mt-0.5 select-none">●</span>
                                                                    <span>{{ $item }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>

                                                <!-- Card Action Footer -->
                                                <div
                                                    class="mt-4 pt-3 border-t border-emerald-100/60 flex items-center justify-end gap-2">
                                                    <a href="{{ route('kartu-situasi.print-single', $kartu) }}"
                                                        target="_blank"
                                                        class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-2.5 py-1.5 rounded-lg transition">
                                                        <span
                                                            class="material-symbols-outlined text-[14px]">print</span>
                                                        Cetak Kartu Ini
                                                    </a>
                                                    <a href="{{ route('kartu-situasi.docx-single', $kartu) }}"
                                                        class="inline-flex items-center gap-1 text-[11px] font-bold text-blue-700 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-2.5 py-1.5 rounded-lg transition">
                                                        <span
                                                            class="material-symbols-outlined text-[14px]">download</span>
                                                        Word
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div
                                        class="p-8 bg-slate-50 border border-slate-200 rounded-2xl text-center text-sm text-slate-500 font-medium max-w-xl mx-auto space-y-3">
                                        <div
                                            class="h-12 w-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto">
                                            <span class="material-symbols-outlined text-2xl">style</span>
                                        </div>
                                        <p class="text-xs font-bold text-slate-600">Kartu situasi belum ditambahkan
                                            untuk topik ini.</p>
                                        <button type="button" @click="openKartuCreateModal()"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs transition cursor-pointer">
                                            <span class="material-symbols-outlined text-sm">add_circle</span>
                                            Tambah Kartu Situasi Sekarang
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <!-- TAHAP 3: PERFORMANCE FEEDBACK -->
                            <div x-show="step === 3" x-transition class="space-y-6">
                                <div class="flex justify-between items-start border-b border-gray-100 pb-4">
                                    <div>
                                        <span
                                            class="px-2.5 py-1 bg-amber-500 text-white text-xs font-bold rounded-lg uppercase tracking-wider">Tahap
                                            3</span>
                                        <h3 class="text-xl font-black text-slate-800 mt-2">Performance Feedback (Umpan
                                            Balik Konselor)</h3>
                                        <p class="text-sm text-gray-500 mt-0.5 font-semibold">Tahap evaluasi keaktifan
                                            dan pemberian umpan balik langsung oleh konselor kepada siswa setelah
                                            bermain peran.</p>
                                    </div>
                                </div>

                                <!-- Guide Feedback Edit Form -->
                                <div
                                    class="bg-indigo-50/40 border border-indigo-100/80 rounded-2xl p-5 shadow-xs mb-6">
                                    <div class="flex items-center gap-2 mb-3 text-indigo-900">
                                        <span class="material-symbols-outlined text-lg">auto_stories</span>
                                        <h4 class="text-xs font-black uppercase tracking-wider">Panduan Bimbingan
                                            Konselor (Tahap 3)</h4>
                                    </div>
                                    <form action="{{ route('admin.modules.update', $module) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="judul" value="{{ $module->judul }}">
                                        <input type="hidden" name="subtitle" value="{{ $module->subtitle }}">
                                        <input type="hidden" name="deskripsi" value="{{ $module->deskripsi }}">
                                        <input type="hidden" name="fokus_utama" value="{{ $module->fokus_utama }}">
                                        <input type="hidden" name="urutan" value="{{ $module->urutan }}">
                                        <input type="hidden" name="status"
                                            value="{{ $module->status ? '1' : '0' }}">

                                        <textarea name="guide_feedback" rows="3"
                                            class="shadow-xs border border-gray-200 rounded-xl w-full py-3 px-4 text-gray-700 leading-relaxed focus:outline-none focus:ring-2 focus:ring-indigo-200 text-xs font-semibold bg-white"
                                            placeholder="Tuliskan instruksi konselor untuk memandu diskusi pengerjaan dan umpan balik pengerjaan asesmen...">{{ old('guide_feedback', $module->guide_feedback) }}</textarea>
                                        <div class="mt-2.5 flex justify-end">
                                            <button type="submit"
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold py-2 px-4 rounded-xl text-xs shadow-md hover:shadow-lg transition-all flex items-center gap-1.5 uppercase tracking-wide">
                                                <span class="material-symbols-outlined text-xs">save</span>
                                                Simpan Panduan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- TAHAP 4: TRANSFER OF TRAINING -->
                            <div x-show="step === 4" x-transition class="space-y-6">
                                @php
                                    $lkpd = $module->assessments
                                        ->where('jenis', \App\Models\Assessment::JENIS_LKPD)
                                        ->first();
                                @endphp
                                <div class="flex justify-between items-start border-b border-gray-100 pb-4">
                                    <div>
                                        <span
                                            class="px-2.5 py-1 bg-purple-500 text-white text-xs font-bold rounded-lg uppercase tracking-wider">Tahap
                                            4</span>
                                        <h3 class="text-xl font-black text-slate-800 mt-2">Transfer of Training (LKPD
                                            Online & Lembar Komitmen)</h3>
                                        <p class="text-sm text-gray-500 mt-0.5 font-semibold">Siswa mengintegrasikan
                                            keterampilan empati dalam kehidupan sehari-hari melalui Lembar Kerja Peserta
                                            Didik (LKPD).</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('counselor.monitoring.schools') }}"
                                            class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white hover:bg-gray-50 rounded-xl text-xs font-semibold text-gray-700 shadow-sm transition">
                                            Lihat Pengerjaan Siswa
                                        </a>
                                        <button type="button" @click="openAssessmentCreateModal('lkpd')"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 border border-transparent rounded-xl text-xs font-black text-white bg-purple-600 hover:bg-purple-700 shadow-sm transition uppercase tracking-wide cursor-pointer">
                                            <span class="material-symbols-outlined text-sm">add_circle</span>
                                            + Tambah Asesmen
                                        </button>
                                    </div>
                                </div>

                                <!-- Guide Transfer Edit Form -->
                                <div
                                    class="bg-indigo-50/40 border border-indigo-100/80 rounded-2xl p-5 shadow-xs mb-6">
                                    <div class="flex items-center gap-2 mb-3 text-indigo-900">
                                        <span class="material-symbols-outlined text-lg">auto_stories</span>
                                        <h4 class="text-xs font-black uppercase tracking-wider">Panduan Bimbingan
                                            Konselor (Tahap 4)</h4>
                                    </div>
                                    <form action="{{ route('admin.modules.update', $module) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="judul" value="{{ $module->judul }}">
                                        <input type="hidden" name="subtitle" value="{{ $module->subtitle }}">
                                        <input type="hidden" name="deskripsi" value="{{ $module->deskripsi }}">
                                        <input type="hidden" name="fokus_utama" value="{{ $module->fokus_utama }}">
                                        <input type="hidden" name="urutan" value="{{ $module->urutan }}">
                                        <input type="hidden" name="status"
                                            value="{{ $module->status ? '1' : '0' }}">

                                        <textarea name="guide_transfer" rows="4"
                                            class="shadow-xs border border-gray-200 rounded-xl w-full py-3 px-4 text-gray-700 leading-relaxed focus:outline-none focus:ring-2 focus:ring-indigo-200 text-xs font-semibold bg-white"
                                            placeholder="Tuliskan instruksi konselor untuk membagi lembar komitmen dan merefleksikan rencana nyata siswa...">{{ old('guide_transfer', $module->guide_transfer) }}</textarea>
                                        <div class="mt-2.5 flex justify-end">
                                            <button type="submit"
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold py-2 px-4 rounded-xl text-xs shadow-md hover:shadow-lg transition-all flex items-center gap-1.5 uppercase tracking-wide">
                                                <span class="material-symbols-outlined text-xs">save</span>
                                                Simpan Panduan
                                            </button>
                                        </div>
                                    </form>
                                </div>



                                <!-- Assessments List (Pre-Test, Post-Test, and LKPD) -->
                                <h3 class="text-sm font-bold text-slate-800 mb-3">Daftar Paket Asesmen</h3>
                                <div class="border rounded-xl overflow-hidden bg-white mb-6">
                                    <ul class="divide-y divide-gray-200">
                                        @forelse($module->assessments as $assessment)
                                            <li class="p-4 hover:bg-slate-50/50 flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <span
                                                        class="h-8 w-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-sm mr-3">{{ $assessment->urutan }}</span>
                                                    <div>
                                                        <h4 class="text-sm font-semibold text-gray-900">
                                                            {{ $assessment->judul }}</h4>
                                                        <div class="mt-1 flex items-center gap-2">
                                                            @if ($assessment->jenis == 'penilaian_diri')
                                                                <span
                                                                    class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded">Penilaian
                                                                    Diri</span>
                                                            @elseif($assessment->jenis == 'refleksi_diri')
                                                                <span
                                                                    class="px-2 py-0.5 bg-indigo-100 text-indigo-800 text-[10px] font-bold rounded">Refleksi
                                                                    Diri</span>
                                                            @elseif($assessment->jenis == 'lembar_komitmen')
                                                                <span
                                                                    class="px-2 py-0.5 bg-amber-100 text-amber-800 text-[10px] font-bold rounded">Lembar
                                                                    Komitmen</span>
                                                            @else
                                                                <span
                                                                    class="px-2 py-0.5 bg-purple-100 text-purple-800 text-[10px] font-bold rounded">LKPD
                                                                    Ujian</span>
                                                            @endif
                                                            <span
                                                                class="text-xs text-gray-500 font-semibold flex items-center gap-1">
                                                                <span
                                                                    class="material-symbols-outlined text-[14px]">checklist</span>
                                                                {{ $assessment->questions->count() }} Pertanyaan
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('admin.assessments.show', $assessment) }}"
                                                        class="px-3 py-1 bg-purple-50 text-purple-700 border border-purple-200 rounded-lg text-xs font-semibold hover:bg-purple-100 transition shadow-xs flex items-center gap-1">Detail
                                                        & Soal</a>
                                                    <button type="button"
                                                        @click="openAssessmentEditModal({{ json_encode([
                                                            'id' => $assessment->id,
                                                            'judul' => $assessment->judul,
                                                            'deskripsi' => $assessment->deskripsi,
                                                            'catatan' => $assessment->catatan,
                                                            'jenis' => $assessment->jenis,
                                                            'urutan' => $assessment->urutan,
                                                            'update_url' => route('admin.assessments.update', $assessment),
                                                        ]) }})"
                                                        class="px-3 py-1 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50 shadow-xs cursor-pointer">
                                                        Edit
                                                    </button>
                                                    <form
                                                        action="{{ route('admin.assessments.destroy', $assessment) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Hapus asesmen ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="step" value="4">
                                                        <button type="submit"
                                                            class="px-3 py-1 bg-white border border-red-300 rounded-lg text-xs font-semibold text-red-600 hover:bg-red-50 shadow-xs cursor-pointer">Hapus</button>
                                                    </form>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="p-4 text-center text-xs text-gray-500">Belum ada asesmen/LKPD
                                                untuk topik ini.</li>
                                        @endforelse
                                    </ul>
                                </div>


                            </div>
                        </div>

                        <!-- Footer Aksi (Pojok Kanan Bawah) -->
                        <div class="mt-8 border-t border-slate-100 pt-6 flex justify-end">
                            <button x-show="step < 4" @click="step++"
                                class="inline-flex items-center px-6 py-3 bg-[#005bbf] text-white font-bold rounded-xl hover:bg-[#004493] text-xs sm:text-sm shadow-md hover:shadow-lg transition-all gap-1.5 group">
                                Lanjut ke Tahap Berikutnya
                                <span
                                    class="material-symbols-outlined group-hover:translate-x-1 transition-transform text-sm sm:text-base">arrow_forward</span>
                            </button>

                            <a x-show="step === 4" href="{{ route('admin.modules.index') }}"
                                class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 text-xs sm:text-sm shadow-md hover:shadow-lg transition-all gap-1.5">
                                Selesai Sesi Management
                                <span class="material-symbols-outlined text-sm sm:text-base">check_circle</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Sidebar Counselor Guide Forms -->
                <div x-show="step === 1 || step === 2" class="lg:col-span-1 space-y-6">
                    <!-- TAHAP 1 GUIDE FORM -->
                    <div x-show="step === 1" x-transition>
                        <div
                            class="bg-indigo-50/40 border border-indigo-100/80 rounded-2xl p-5 shadow-xs sticky top-6 max-h-[85vh] overflow-y-auto">
                            <div class="flex items-center gap-2 mb-3 text-indigo-900">
                                <span class="material-symbols-outlined text-lg">auto_stories</span>
                                <h4 class="text-xs font-black uppercase tracking-wider">Panduan Bimbingan (Tahap 1)
                                </h4>
                            </div>
                            <form action="{{ route('admin.modules.update', $module) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="judul" value="{{ $module->judul }}">
                                <input type="hidden" name="subtitle" value="{{ $module->subtitle }}">
                                <input type="hidden" name="deskripsi" value="{{ $module->deskripsi }}">
                                <input type="hidden" name="fokus_utama" value="{{ $module->fokus_utama }}">
                                <input type="hidden" name="urutan" value="{{ $module->urutan }}">
                                <input type="hidden" name="status" value="{{ $module->status ? '1' : '0' }}">

                                <textarea name="guide_modeling" rows="3"
                                    class="shadow-xs border border-gray-200 rounded-xl w-full py-3 px-4 text-gray-700 leading-relaxed focus:outline-none focus:ring-2 focus:ring-indigo-500/20 text-xs font-semibold bg-white"
                                    placeholder="Tuliskan instruksi konselor untuk mengarahkan diskusi modeling video...">{{ old('guide_modeling', $module->guide_modeling) }}</textarea>
                                <div class="mt-2.5 flex justify-end">
                                    <button type="submit"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold py-2 px-4 rounded-xl text-xs shadow-md hover:shadow-lg transition-all flex items-center gap-1.5 uppercase tracking-wide">
                                        <span class="material-symbols-outlined text-xs">save</span>
                                        Simpan Panduan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- TAHAP 2 GUIDE FORM -->
                    <div x-show="step === 2" x-transition>
                        <div
                            class="bg-indigo-50/40 border border-indigo-100/80 rounded-2xl p-5 shadow-xs sticky top-6 max-h-[85vh] overflow-y-auto">
                            <div class="flex items-center gap-2 mb-3 text-indigo-900">
                                <span class="material-symbols-outlined text-lg">auto_stories</span>
                                <h4 class="text-xs font-black uppercase tracking-wider">Panduan Bimbingan (Tahap 2)
                                </h4>
                            </div>
                            <form action="{{ route('admin.modules.update', $module) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="judul" value="{{ $module->judul }}">
                                <input type="hidden" name="subtitle" value="{{ $module->subtitle }}">
                                <input type="hidden" name="deskripsi" value="{{ $module->deskripsi }}">
                                <input type="hidden" name="fokus_utama" value="{{ $module->fokus_utama }}">
                                <input type="hidden" name="urutan" value="{{ $module->urutan }}">
                                <input type="hidden" name="status" value="{{ $module->status ? '1' : '0' }}">

                                <textarea name="guide_role_playing" rows="3"
                                    class="shadow-xs border border-gray-200 rounded-xl w-full py-3 px-4 text-gray-700 leading-relaxed focus:outline-none focus:ring-2 focus:ring-indigo-250 text-xs font-semibold bg-white"
                                    placeholder="Tuliskan instruksi konselor untuk membagi kelompok dan memandu role playing...">{{ old('guide_role_playing', $module->guide_role_playing) }}</textarea>
                                <div class="mt-2.5 flex justify-end">
                                    <button type="submit"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold py-2 px-4 rounded-xl text-xs shadow-md hover:shadow-lg transition-all flex items-center gap-1.5 uppercase tracking-wide">
                                        <span class="material-symbols-outlined text-xs">save</span>
                                        Simpan Panduan
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Video Modeling Modal -->
        <div x-show="showVideoModal" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-250"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <!-- Backdrop with Blur -->
            <div class="fixed inset-0 transition-all duration-300"
                style="background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);"
                @click="showVideoModal = false"></div>

            <!-- Modal Content Container -->
            <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
                <div x-show="showVideoModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-250"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-lg p-6 md:p-8 flex flex-col max-h-[90vh] z-10 border border-slate-100">

                    <!-- Close Button -->
                    <button type="button" @click="showVideoModal = false"
                        class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition p-1 hover:bg-slate-100 rounded-lg cursor-pointer">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <!-- Modal Header -->
                    <div class="mb-5 border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-blue-600 text-2xl">video_library</span>
                            {{ $video ? 'Ganti / Edit Video Modeling' : 'Tambah Video Modeling' }}
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Tahap 1 Modeling — Media video peraga
                            empati</p>
                    </div>

                    <!-- Otomatis Bawa Data Topik Info Box -->
                    <div class="mb-5 p-3 bg-blue-50/70 border border-blue-100/80 rounded-xl flex items-center gap-3">
                        <div
                            class="h-9 w-9 rounded-lg bg-blue-600 text-white flex items-center justify-center font-black text-xs shrink-0 shadow-2xs">
                            {{ $module->urutan }}
                        </div>
                        <div class="text-xs overflow-hidden">
                            <p class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Tersimpan Otomatis
                                Untuk Topik</p>
                            <p class="font-extrabold text-slate-800 truncate">{{ $module->judul }}</p>
                        </div>
                    </div>

                    <!-- Form -->
                    <div class="overflow-y-auto flex-1 px-1">
                        <form action="{{ route('admin.modules.materials.store', $module) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-5">
                            @csrf
                            <input type="hidden" name="jenis" value="video">
                            <input type="hidden" name="step" value="1">

                            <!-- Source Type Selector Tabs -->
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih
                                    Sumber Video *</label>
                                <div
                                    class="grid grid-cols-2 gap-3 p-1 bg-slate-100/80 rounded-xl border border-slate-200/60">
                                    <button type="button" @click="videoSourceType = 'youtube'"
                                        :class="videoSourceType === 'youtube' ?
                                            'bg-white text-blue-600 shadow-xs font-black' :
                                            'text-slate-600 hover:text-slate-800 font-bold'"
                                        class="py-2.5 px-3 rounded-lg text-xs transition duration-200 flex items-center justify-center gap-1.5 cursor-pointer">
                                        <span
                                            class="material-symbols-outlined text-base text-red-500">smart_display</span>
                                        URL YouTube
                                    </button>
                                    <button type="button" @click="videoSourceType = 'file'"
                                        :class="videoSourceType === 'file' ?
                                            'bg-white text-blue-600 shadow-xs font-black' :
                                            'text-slate-600 hover:text-slate-800 font-bold'"
                                        class="py-2.5 px-3 rounded-lg text-xs transition duration-200 flex items-center justify-center gap-1.5 cursor-pointer">
                                        <span
                                            class="material-symbols-outlined text-base text-blue-500">upload_file</span>
                                        Upload Berkas MP4
                                    </button>
                                </div>
                            </div>

                            <!-- Input 1: YouTube URL -->
                            <div x-show="videoSourceType === 'youtube'" x-transition>
                                <label for="modal_video_url"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tautan
                                    / Link YouTube</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                        <span class="material-symbols-outlined text-base text-red-500">link</span>
                                    </span>
                                    <input type="url" name="video" id="modal_video_url" x-model="videoUrl"
                                        placeholder="https://www.youtube.com/watch?v=..."
                                        class="pl-9 w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition">
                                </div>
                                <p class="text-[10px] text-slate-400 mt-1 font-medium">Mendukung link format
                                    youtube.com, youtu.be, maupun YouTube Shorts</p>
                            </div>

                            <!-- Input 2: Upload File Video -->
                            <div x-show="videoSourceType === 'file'" x-transition style="display: none;">
                                <label
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Berkas
                                    Video (MP4 / WebM)</label>
                                <div
                                    class="relative flex flex-col items-center justify-center p-5 border-2 border-dashed border-slate-200 hover:border-blue-400 bg-slate-50/50 rounded-2xl cursor-pointer transition duration-200 group">
                                    <input type="file" name="video_file" id="modal_video_file"
                                        accept="video/mp4,video/webm"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        @change="const file = $event.target.files[0]; videoFileLabel = file ? file.name : ''">
                                    <div class="text-center">
                                        <span
                                            class="material-symbols-outlined text-slate-400 group-hover:text-blue-500 text-3xl transition duration-200 mb-1">movie</span>
                                        <p class="text-xs font-extrabold text-slate-700"
                                            x-text="videoFileLabel ? videoFileLabel : 'Pilih Berkas Video'"></p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">Format: MP4, WebM (Maksimal:
                                            100MB)</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4 mt-6">
                                <button type="button" @click="showVideoModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-wider transition cursor-pointer">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition duration-200 flex items-center gap-1.5 cursor-pointer">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                    Simpan Video Modeling
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Kartu Situasi Modal -->
        <div x-show="showKartuCreateModal" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-250"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <!-- Backdrop with Blur -->
            <div class="fixed inset-0 transition-all duration-300"
                style="background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);"
                @click="showKartuCreateModal = false"></div>

            <!-- Modal Content Container -->
            <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
                <div x-show="showKartuCreateModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-250"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-2xl p-6 md:p-8 flex flex-col max-h-[90vh] z-10 border border-slate-100">

                    <!-- Close Button -->
                    <button type="button" @click="showKartuCreateModal = false"
                        class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition p-1 hover:bg-slate-100 rounded-lg cursor-pointer">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <!-- Modal Header -->
                    <div class="mb-5 border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-emerald-600 text-2xl">style</span>
                            Tambah Kartu Situasi Baru
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Tahap 2 Role Playing — Skenario kasus dan
                            latihan bermain peran</p>
                    </div>

                    <!-- Otomatis Bawa Data Topik Info Box -->
                    <div
                        class="mb-5 p-3 bg-emerald-50/70 border border-emerald-100/80 rounded-xl flex items-center gap-3">
                        <div
                            class="h-9 w-9 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-black text-xs shrink-0 shadow-2xs">
                            {{ $module->urutan }}
                        </div>
                        <div class="text-xs overflow-hidden">
                            <p class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">Tersimpan
                                Otomatis Untuk Topik</p>
                            <p class="font-extrabold text-slate-800 truncate">{{ $module->judul }}</p>
                        </div>
                    </div>

                    <!-- Form -->
                    <div class="overflow-y-auto flex-1 px-1">
                        <form action="{{ route('admin.modules.materials.store', $module) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <input type="hidden" name="jenis" value="kartu_situasi">
                            <input type="hidden" name="step" value="2">

                            <!-- Field 1: Foto / Ilustrasi -->
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Foto
                                    / Ilustrasi Kartu Situasi</label>
                                <div
                                    class="relative flex flex-col items-center justify-center p-4 border-2 border-dashed border-slate-200 hover:border-emerald-400 bg-slate-50/50 rounded-2xl cursor-pointer transition duration-200 group">
                                    <input type="file" name="file_upload" id="create_kartu_file" accept="image/*"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        @change="const file = $event.target.files[0]; createKartuFileName = file ? file.name : ''">
                                    <div class="text-center">
                                        <span
                                            class="material-symbols-outlined text-slate-400 group-hover:text-emerald-500 text-2xl transition duration-200 mb-1">image</span>
                                        <p class="text-xs font-extrabold text-slate-700"
                                            x-text="createKartuFileName ? createKartuFileName : 'Pilih Foto / Gambar Ilustrasi'">
                                        </p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">Format: JPG, PNG, WEBP (Maks: 5MB)
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Field 2: Situasi -->
                            <div>
                                <label for="create_kartu_situasi"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Situasi
                                    *</label>
                                <textarea name="situasi" id="create_kartu_situasi" x-ref="createSituasiInput" rows="3" required
                                    placeholder="Deskripsikan situasi atau skenario perundungan yang terjadi..."
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition"></textarea>
                            </div>

                            <!-- Field 3: Peran -->
                            <div>
                                <label for="create_kartu_peran"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Peran
                                    *</label>
                                <textarea name="peran" id="create_kartu_peran" rows="3" required
                                    placeholder="Tuliskan daftar peran (pisahkan setiap peran dengan baris baru / Enter)&#10;Contoh:&#10;Dimas (Siswa korban)&#10;Dua teman sebaya&#10;Satu pelaku perundungan"
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition font-mono"></textarea>
                                <p class="text-[10px] text-slate-400 mt-1 font-medium">💡 Pisahkan tiap tokoh / peran
                                    dengan baris baru (Enter).</p>
                            </div>

                            <!-- Field 4: Diskusikan -->
                            <div>
                                <label for="create_kartu_diskusi"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Diskusikan
                                    *</label>
                                <textarea name="diskusi" id="create_kartu_diskusi" rows="3" required
                                    placeholder="Tuliskan pertanyaan diskusi refleksi (pisahkan setiap pertanyaan dengan baris baru / Enter)&#10;Contoh:&#10;Mengapa Dimas hanya terdiam?&#10;Bagaimana perasaan Dimas saat itu?&#10;Apa tindakan empati yang tepat dilakukan?"
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition font-mono"></textarea>
                                <p class="text-[10px] text-slate-400 mt-1 font-medium">💡 Pisahkan tiap butir
                                    pertanyaan diskusi dengan baris baru (Enter).</p>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4 mt-6">
                                <button type="button" @click="showKartuCreateModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-wider transition cursor-pointer">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition duration-200 flex items-center gap-1.5 cursor-pointer">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                    Simpan Kartu Situasi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Kartu Situasi Modal -->
        <div x-show="showKartuEditModal" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-250"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <!-- Backdrop with Blur -->
            <div class="fixed inset-0 transition-all duration-300"
                style="background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);"
                @click="showKartuEditModal = false"></div>

            <!-- Modal Content Container -->
            <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
                <div x-show="showKartuEditModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-250"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-2xl p-6 md:p-8 flex flex-col max-h-[90vh] z-10 border border-slate-100">

                    <!-- Close Button -->
                    <button type="button" @click="showKartuEditModal = false"
                        class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition p-1 hover:bg-slate-100 rounded-lg cursor-pointer">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <!-- Modal Header -->
                    <div class="mb-5 border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-emerald-600 text-2xl">edit_note</span>
                            Edit Kartu Situasi
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Perbarui skenario kasus, peran, atau
                            pertanyaan diskusi</p>
                    </div>

                    <!-- Form -->
                    <div class="overflow-y-auto flex-1 px-1">
                        <form :action="kartuEditForm.update_url" method="POST" enctype="multipart/form-data"
                            class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="jenis" value="kartu_situasi">
                            <input type="hidden" name="step" value="2">

                            <!-- Field 1: Foto / Ilustrasi -->
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Foto
                                    / Ilustrasi Kartu Situasi</label>
                                <template x-if="kartuEditForm.file_url">
                                    <div
                                        class="mb-3 flex items-center gap-3 p-2 bg-slate-50 border border-slate-200 rounded-xl w-fit">
                                        <img :src="kartuEditForm.file_url" alt="Foto Kartu"
                                            class="w-14 h-14 object-cover rounded-lg bg-white border border-slate-100">
                                        <div class="text-xs">
                                            <p class="font-bold text-slate-700">Foto Saat Ini</p>
                                            <p class="text-[10px] text-slate-400">Pilih file baru jika ingin mengganti
                                            </p>
                                        </div>
                                    </div>
                                </template>
                                <div
                                    class="relative flex flex-col items-center justify-center p-4 border-2 border-dashed border-slate-200 hover:border-emerald-400 bg-slate-50/50 rounded-2xl cursor-pointer transition duration-200 group">
                                    <input type="file" name="file_upload" id="edit_kartu_file" accept="image/*"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        @change="const file = $event.target.files[0]; editKartuFileName = file ? file.name : ''">
                                    <div class="text-center">
                                        <span
                                            class="material-symbols-outlined text-slate-400 group-hover:text-emerald-500 text-2xl transition duration-200 mb-1">image</span>
                                        <p class="text-xs font-extrabold text-slate-700"
                                            x-text="editKartuFileName ? editKartuFileName : 'Pilih Foto Baru'"></p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">Format: JPG, PNG, WEBP (Maks: 5MB)
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Field 2: Situasi -->
                            <div>
                                <label for="edit_kartu_situasi"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Situasi
                                    *</label>
                                <textarea name="situasi" id="edit_kartu_situasi" x-ref="editSituasiInput" x-model="kartuEditForm.situasi"
                                    rows="3" required placeholder="Deskripsikan situasi perundungan..."
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition"></textarea>
                            </div>

                            <!-- Field 3: Peran -->
                            <div>
                                <label for="edit_kartu_peran"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Peran
                                    *</label>
                                <textarea name="peran" id="edit_kartu_peran" x-model="kartuEditForm.peran" rows="3" required
                                    placeholder="Tuliskan daftar peran (pisahkan dengan baris baru / Enter)..."
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition font-mono"></textarea>
                                <p class="text-[10px] text-slate-400 mt-1 font-medium">💡 Pisahkan tiap tokoh / peran
                                    dengan baris baru (Enter).</p>
                            </div>

                            <!-- Field 4: Diskusikan -->
                            <div>
                                <label for="edit_kartu_diskusi"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Diskusikan
                                    *</label>
                                <textarea name="diskusi" id="edit_kartu_diskusi" x-model="kartuEditForm.diskusi" rows="3" required
                                    placeholder="Tuliskan pertanyaan diskusi (pisahkan dengan baris baru / Enter)..."
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition font-mono"></textarea>
                                <p class="text-[10px] text-slate-400 mt-1 font-medium">💡 Pisahkan tiap butir
                                    pertanyaan diskusi dengan baris baru (Enter).</p>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4 mt-6">
                                <button type="button" @click="showKartuEditModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-wider transition cursor-pointer">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition duration-200 flex items-center gap-1.5 cursor-pointer">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- CREATE ASSESSMENT MODAL -->
        <div x-show="showAssessmentCreateModal" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-250"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <!-- Backdrop with Blur -->
            <div class="fixed inset-0 transition-all duration-300"
                style="background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);"
                @click="showAssessmentCreateModal = false"></div>

            <!-- Modal Content Container -->
            <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
                <div x-show="showAssessmentCreateModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-250"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-lg p-6 md:p-8 flex flex-col max-h-[90vh] z-10 border border-slate-100">

                    <!-- Close Button -->
                    <button type="button" @click="showAssessmentCreateModal = false"
                        class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition p-1 hover:bg-slate-100 rounded-lg cursor-pointer">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <!-- Modal Header -->
                    <div class="mb-5 border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-purple-600 text-2xl">assignment_add</span>
                            Tambah Paket Asesmen
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Tahap 4 Transfer of Training — LKPD,
                            Penilaian Diri, atau Lembar Komitmen</p>
                    </div>

                    <!-- Otomatis Bawa Data Topik Info Box -->
                    <div
                        class="mb-5 p-3 bg-purple-50/70 border border-purple-100/80 rounded-xl flex items-center gap-3">
                        <div
                            class="h-9 w-9 rounded-lg bg-purple-600 text-white flex items-center justify-center font-black text-xs shrink-0 shadow-2xs">
                            {{ $module->urutan }}
                        </div>
                        <div class="text-xs overflow-hidden">
                            <p class="text-[10px] font-bold text-purple-600 uppercase tracking-wider">Tersimpan
                                Otomatis Untuk Topik</p>
                            <p class="font-extrabold text-slate-800 truncate">{{ $module->judul }}</p>
                        </div>
                    </div>

                    <!-- Form -->
                    <div class="overflow-y-auto flex-1 px-1">
                        <form action="{{ route('admin.modules.assessments.store', $module) }}" method="POST"
                            class="space-y-4">
                            @csrf
                            <input type="hidden" name="step" value="4">

                            <!-- Field 1: Judul Assessment -->
                            <div>
                                <label for="create_assessment_judul"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul
                                    Asesmen *</label>
                                <input type="text" name="judul" id="create_assessment_judul"
                                    x-ref="createAssessmentJudulInput" x-model="assessmentCreateForm.judul" required
                                    placeholder="Contoh: Lembar Kerja Peserta Didik (LKPD) / Penilaian Diri"
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition">
                            </div>

                            <!-- Field 2: Jenis Assessment -->
                            <div>
                                <label for="create_assessment_jenis"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jenis
                                    Asesmen *</label>
                                <select name="jenis" id="create_assessment_jenis"
                                    x-model="assessmentCreateForm.jenis" required
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition">
                                    <option value="penilaian_diri">Penilaian Diri</option>
                                    <option value="refleksi_diri">Refleksi Diri</option>
                                    <option value="lembar_komitmen">Lembar Komitmen</option>
                                </select>
                            </div>

                            <!-- Field 3: Urutan -->
                            <div>
                                <label for="create_assessment_urutan"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor
                                    Urut *</label>
                                <input type="number" name="urutan" id="create_assessment_urutan"
                                    x-model="assessmentCreateForm.urutan" min="1" required
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition">
                            </div>

                            <!-- Field 4: Bahan Bacaan / Situasi Kasus -->
                            <div>
                                <label for="create_assessment_deskripsi"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Bahan
                                    Bacaan / Situasi Kasus (Opsional)</label>
                                <textarea name="deskripsi" id="create_assessment_deskripsi" x-model="assessmentCreateForm.deskripsi" rows="3"
                                    placeholder="Misal: Bacalah situasi berikut. Raka sering dipanggil..."
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition"></textarea>
                            </div>

                            <!-- Field 5: Catatan Penilaian / Footnote -->
                            <div>
                                <label for="create_assessment_catatan"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Catatan
                                    Penilaian / Footnote (Opsional)</label>
                                <input type="text" name="catatan" id="create_assessment_catatan"
                                    x-model="assessmentCreateForm.catatan"
                                    placeholder="Misal: Catatan: Butir nomor 4 adalah pernyataan negatif sehingga skornya dibalik."
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition">
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4 mt-6">
                                <button type="button" @click="showAssessmentCreateModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-wider transition cursor-pointer">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition duration-200 flex items-center gap-1.5 cursor-pointer">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                    Simpan Asesmen
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- EDIT ASSESSMENT MODAL -->
        <div x-show="showAssessmentEditModal" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-250"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <!-- Backdrop with Blur -->
            <div class="fixed inset-0 transition-all duration-300"
                style="background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);"
                @click="showAssessmentEditModal = false"></div>

            <!-- Modal Content Container -->
            <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
                <div x-show="showAssessmentEditModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-250"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-xl p-6 md:p-8 flex flex-col max-h-[90vh] z-10 border border-slate-100">

                    <!-- Close Button -->
                    <button type="button" @click="showAssessmentEditModal = false"
                        class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition p-1 hover:bg-slate-100 rounded-lg cursor-pointer">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <!-- Modal Header -->
                    <div class="mb-5 border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-purple-600 text-2xl">edit_document</span>
                            Edit Paket Asesmen
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Perbarui judul, kategori, nomor urut,
                            serta bahan bacaan situasi dan catatan</p>
                    </div>

                    <!-- Form -->
                    <div class="overflow-y-auto flex-1 px-1">
                        <form :action="assessmentEditForm.update_url" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="step" value="4">

                            <!-- Field 1: Judul Assessment -->
                            <div>
                                <label for="edit_assessment_judul"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul
                                    Asesmen *</label>
                                <input type="text" name="judul" id="edit_assessment_judul"
                                    x-ref="editAssessmentJudulInput" x-model="assessmentEditForm.judul" required
                                    placeholder="Judul Asesmen..."
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition">
                            </div>

                            <!-- Field 2: Jenis Assessment -->
                            <div>
                                <label for="edit_assessment_jenis"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jenis
                                    Asesmen *</label>
                                <select name="jenis" id="edit_assessment_jenis" x-model="assessmentEditForm.jenis"
                                    required
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition">
                                    <option value="penilaian_diri">Penilaian Diri</option>
                                    <option value="refleksi_diri">Refleksi Diri</option>
                                    <option value="lembar_komitmen">Lembar Komitmen</option>
                                </select>
                            </div>

                            <!-- Field 3: Urutan -->
                            <div>
                                <label for="edit_assessment_urutan"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor
                                    Urut *</label>
                                <input type="number" name="urutan" id="edit_assessment_urutan"
                                    x-model="assessmentEditForm.urutan" min="1" required
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition">
                            </div>

                            <!-- Field 4: Bahan Bacaan / Situasi Kasus -->
                            <div>
                                <label for="edit_assessment_deskripsi"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Bahan
                                    Bacaan / Situasi Kasus (Opsional)</label>
                                <textarea name="deskripsi" id="edit_assessment_deskripsi" x-model="assessmentEditForm.deskripsi" rows="3"
                                    placeholder="Misal: Bacalah situasi berikut. Raka sering dipanggil..."
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition"></textarea>
                            </div>

                            <!-- Field 5: Catatan Penilaian / Footnote -->
                            <div>
                                <label for="edit_assessment_catatan"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Catatan
                                    Penilaian / Footnote (Opsional)</label>
                                <input type="text" name="catatan" id="edit_assessment_catatan"
                                    x-model="assessmentEditForm.catatan"
                                    placeholder="Misal: Catatan: Butir nomor 4 adalah pernyataan negatif sehingga skornya dibalik."
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition">
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4 mt-6">
                                <button type="button" @click="showAssessmentEditModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-wider transition cursor-pointer">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition duration-200 flex items-center gap-1.5 cursor-pointer">
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
        <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const editors = ['guide_modeling', 'guide_role_playing', 'guide_feedback', 'guide_transfer'];
                editors.forEach(name => {
                    const el = document.querySelector(`textarea[name="${name}"]`);
                    if (el) {
                        ClassicEditor
                            .create(el, {
                                toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList',
                                    '|', 'undo', 'redo'
                                ]
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    }
                });
            });
        </script>
        <style>
            .ck-editor__editable_inline {
                min-height: 280px;
                font-size: 0.825rem !important;
                line-height: 1.6 !important;
                border-radius: 0 0 16px 16px !important;
                border-color: #e2e8f0 !important;
                padding: 1rem 1.5rem !important;
            }

            .ck-editor__editable_inline ol {
                list-style-type: decimal !important;
                padding-left: 1.5rem !important;
                margin-top: 0.5rem !important;
                margin-bottom: 0.5rem !important;
            }

            .ck-editor__editable_inline ul {
                list-style-type: disc !important;
                padding-left: 1.5rem !important;
                margin-top: 0.5rem !important;
                margin-bottom: 0.5rem !important;
            }

            .ck-editor__editable_inline li {
                margin-bottom: 0.25rem !important;
            }

            .ck-toolbar {
                border-radius: 16px 16px 0 0 !important;
                background-color: #f8fafc !important;
                border-color: #e2e8f0 !important;
            }

            .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
                border-color: #e2e8f0 !important;
            }
        </style>
    @endpush
</x-app-layout>
