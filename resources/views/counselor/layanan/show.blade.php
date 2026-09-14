<x-app-layout>
    <x-slot name="title">Modul Intervensi Empati - {{ $module->judul }}</x-slot>

    <div x-data="{ step: 1 }" class="max-w-7xl mx-auto">
        <!-- Breadcrumb & Header -->
        <div class="mb-8">
            <a href="{{ route('counselor.layanan') }}" class="flex items-center gap-2 text-primary hover:underline font-semibold text-sm mb-2">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Kembali ke Layanan
            </a>
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-on-surface">Modul LENTERA - {{ $module->judul }}</h2>
                    <p class="text-on-surface-variant mt-1 font-medium">{{ $module->subtitle }}</p>
                </div>
                <div class="flex items-center gap-2 bg-primary-container/10 px-4 py-2 rounded-lg border border-primary-container/20 self-start sm:self-auto">
                    <span class="material-symbols-outlined text-primary text-xl">timer</span>
                    <span class="font-semibold text-primary text-sm">Durasi Sesi: 45 Menit</span>
                </div>
            </div>
        </div>

        <!-- Progress Steps (Navigasi Langkah) -->
        <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm border border-outline-variant/30 mb-8">
            <div class="flex justify-between items-start relative">
                <!-- Progress Line Background -->
                <div class="absolute top-5 left-10 right-10 h-0.5 bg-outline-variant -z-10"></div>
                <!-- Progress Line Active -->
                <div class="absolute top-5 left-10 h-0.5 bg-primary -z-10 transition-all duration-500"
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
                         :class="step === 1 ? 'bg-primary text-white shadow-lg ring-4 ring-primary/20' : (step > 1 ? 'bg-emerald-600 text-white shadow-sm' : 'bg-surface-container-high text-secondary')">
                        <template x-if="step > 1">
                            <span class="material-symbols-outlined text-sm font-bold">check</span>
                        </template>
                        <template x-if="step === 1">
                            <span>1</span>
                        </template>
                    </div>
                    <div class="text-center">
                        <p class="text-xs sm:text-sm font-bold" :class="step === 1 ? 'text-primary' : 'text-on-surface-variant'">Modeling</p>
                        <p class="text-[10px] hidden sm:block text-on-surface-variant/60 max-w-[120px]">Video / Ilustrasi</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center gap-2 cursor-pointer group" @click="step = 2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300"
                         :class="step === 2 ? 'bg-primary text-white shadow-lg ring-4 ring-primary/20' : (step > 2 ? 'bg-emerald-600 text-white shadow-sm' : 'bg-surface-container-high text-secondary')">
                        <template x-if="step > 2">
                            <span class="material-symbols-outlined text-sm font-bold">check</span>
                        </template>
                        <template x-if="step <= 2">
                            <span>2</span>
                        </template>
                    </div>
                    <div class="text-center">
                        <p class="text-xs sm:text-sm font-bold" :class="step === 2 ? 'text-primary' : 'text-on-surface-variant'">Role Playing</p>
                        <p class="text-[10px] hidden sm:block text-on-surface-variant/60 max-w-[120px]">Kartu Situasi</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center gap-2 cursor-pointer group" @click="step = 3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300"
                         :class="step === 3 ? 'bg-primary text-white shadow-lg ring-4 ring-primary/20' : (step > 3 ? 'bg-emerald-600 text-white shadow-sm' : 'bg-surface-container-high text-secondary')">
                        <template x-if="step > 3">
                            <span class="material-symbols-outlined text-sm font-bold">check</span>
                        </template>
                        <template x-if="step <= 3">
                            <span>3</span>
                        </template>
                    </div>
                    <div class="text-center">
                        <p class="text-xs sm:text-sm font-bold" :class="step === 3 ? 'text-primary' : 'text-on-surface-variant'">Feedback</p>
                        <p class="text-[10px] hidden sm:block text-on-surface-variant/60 max-w-[120px]">Umpan Balik</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="flex flex-col items-center gap-2 cursor-pointer group" @click="step = 4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300"
                         :class="step === 4 ? 'bg-primary text-white shadow-lg ring-4 ring-primary/20' : 'bg-surface-container-high text-secondary'">
                        <span>4</span>
                    </div>
                    <div class="text-center">
                        <p class="text-xs sm:text-sm font-bold" :class="step === 4 ? 'text-primary' : 'text-on-surface-variant'">Transfer of Training</p>
                        <p class="text-[10px] hidden sm:block text-on-surface-variant/60 max-w-[120px]">LKPD Online</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Outer dynamic grid layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Left Column: Main Content Area card -->
            <div :class="(step === 1 || step === 2) ? 'lg:col-span-2' : 'lg:col-span-3'">
                <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 shadow-sm border border-outline-variant/30 min-h-[400px] flex flex-col justify-between">
                    <div>
                        <!-- TAHAP 1: MODELING -->
                        <div x-show="step === 1" x-transition class="space-y-6">
                            @php
                                $video = $module->materials->where('jenis', \App\Models\Material::JENIS_VIDEO)->first();
                            @endphp
                            <div>
                                <span class="px-2.5 py-1 bg-blue-500 text-white text-xs font-bold rounded-lg uppercase tracking-wider">Tahap 1</span>
                                <h3 class="text-xl font-black text-on-surface mt-2">Modeling (Video / Ilustrasi Kejadian)</h3>
                                <p class="text-sm text-on-surface-variant mt-1 font-semibold font-medium">Siswa diperlihatkan video atau ilustrasi kejadian mengenai empati dan bullying sebagai contoh/model perilaku yang sesuai.</p>
                            </div>

                            @if($video)
                                <div class="bg-black rounded-2xl overflow-hidden aspect-video w-full shadow-lg relative group">
                                    @if($video->isYoutubeVideo())
                                        <iframe class="w-full h-full" src="{{ $video->getYoutubeEmbedUrl() }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    @elseif($video->video)
                                        <video class="w-full h-full" controls>
                                            <source src="{{ asset('storage/' . $video->video) }}" type="video/mp4">
                                            Browser Anda tidak mendukung tag video.
                                        </video>
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center bg-slate-900 text-slate-400 p-6 text-center">
                                            <span class="material-symbols-outlined text-[64px] mb-2 text-slate-600">play_circle</span>
                                            <p class="text-sm font-semibold">Tonton video contoh perilaku empati sesuai arahan konselor.</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-5 mt-4">
                                    <h4 class="font-bold text-sm text-slate-800 mb-1.5 flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[18px] text-primary">description</span>
                                        {{ $video->judul }}
                                    </h4>
                                    <div class="text-xs text-slate-600 leading-relaxed font-semibold">{!! $video->isi !!}</div>
                                </div>
                            @else
                                <div class="p-8 bg-slate-50 border border-slate-200 rounded-2xl text-center text-sm text-slate-500 font-medium max-w-xl mx-auto">
                                    Video / ilustrasi kejadian belum ditambahkan untuk topik ini.
                                </div>
                            @endif
                        </div>

                        <!-- TAHAP 2: ROLE PLAYING -->
                        <div x-show="step === 2" x-transition class="space-y-6">
                            @php
                                $kartuList = $module->materials->where('jenis', \App\Models\Material::JENIS_KARTU_SITUASI);
                            @endphp
                            <div>
                                <span class="px-2.5 py-1 bg-emerald-500 text-white text-xs font-bold rounded-lg uppercase tracking-wider">Tahap 2</span>
                                <h3 class="text-xl font-black text-on-surface mt-2">Role Playing (Kartu Situasi)</h3>
                                <p class="text-sm text-on-surface-variant mt-1 font-semibold font-medium">Siswa melatih respon empati secara berkelompok dengan memperagakan peran berdasarkan skenario kasus kartu situasi.</p>
                            </div>

                            @if($kartuList->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 justify-center w-full">
                                    @foreach($kartuList as $kartu)
                                        <!-- Premium Kartu Situasi Render (Mockup Style) -->
                                        <div class="w-full bg-white border-2 border-emerald-600/30 rounded-[2rem] p-6 shadow-md relative overflow-hidden flex flex-col justify-between">
                                            <div>
                                                <!-- Card Header -->
                                                <div class="flex items-center gap-3 mb-4">
                                                    <div class="w-9 h-9 rounded-full bg-[#006d2c] text-white flex items-center justify-center text-base font-black shrink-0">
                                                        {{ $loop->iteration }}
                                                    </div>
                                                    <h4 class="flex-grow text-center text-sm font-black text-[#006d2c] uppercase tracking-wide leading-tight">
                                                        {{ $kartu->judul }}
                                                    </h4>
                                                    <div class="w-9 h-9 shrink-0"></div>
                                                </div>

                                                <!-- Card Photo / Illustration -->
                                                @if($kartu->file_path)
                                                    <div class="my-4 overflow-hidden rounded-2xl border border-gray-100 shadow-sm aspect-[16/10]">
                                                        <img src="{{ asset('storage/' . $kartu->file_path) }}" class="w-full h-full object-cover">
                                                    </div>
                                                @else
                                                    <div class="my-4 overflow-hidden rounded-2xl border border-emerald-100 bg-emerald-50/20 shadow-sm flex items-center justify-center min-h-[160px] p-6 text-center text-emerald-700/60">
                                                        <div class="flex flex-col items-center gap-1">
                                                            <span class="material-symbols-outlined text-[48px]">school</span>
                                                            <span class="text-[10px] font-bold uppercase tracking-wider">Ilustrasi Kegiatan Pelatihan</span>
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- Situasi Description -->
                                                <div class="mt-4">
                                                    <span class="inline-block px-3 py-1 bg-[#006d2c] text-white text-[10px] font-extrabold rounded-md uppercase tracking-wider mb-2">
                                                        Situasi
                                                    </span>
                                                    <p class="text-xs text-slate-700 font-semibold leading-relaxed">
                                                        {{ $kartu->situasi }}
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Peran & Diskusi Grid -->
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-t border-emerald-100/50 mt-5 pt-4">
                                                <!-- Peran -->
                                                <div>
                                                    <div class="flex items-center gap-1.5 text-[#006d2c] font-extrabold text-[10px] uppercase tracking-wider mb-2">
                                                        <span class="material-symbols-outlined text-[14px]">person</span>
                                                        <span>Peran</span>
                                                    </div>
                                                    @php
                                                        $peranList = array_filter(array_map('trim', explode("\n", $kartu->peran)));
                                                    @endphp
                                                    <ul class="space-y-1">
                                                        @foreach($peranList as $item)
                                                            <li class="flex items-start gap-1.5 text-[10px] text-slate-600 font-semibold leading-normal">
                                                                <span class="text-emerald-600 text-[8px] mt-0.5 select-none">●</span>
                                                                <span>{{ $item }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>

                                                <!-- Diskusi -->
                                                <div>
                                                    <div class="flex items-center gap-1.5 text-[#006d2c] font-extrabold text-[10px] uppercase tracking-wider mb-2">
                                                        <span class="material-symbols-outlined text-[14px]">chat</span>
                                                        <span>Diskusikan</span>
                                                    </div>
                                                    @php
                                                        $diskusiList = array_filter(array_map('trim', explode("\n", $kartu->diskusi)));
                                                    @endphp
                                                    <ul class="space-y-1">
                                                        @foreach($diskusiList as $item)
                                                            <li class="flex items-start gap-1.5 text-[10px] text-slate-600 font-semibold leading-normal">
                                                                <span class="text-emerald-600 text-[8px] mt-0.5 select-none">●</span>
                                                                <span>{{ $item }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-8 bg-slate-50 border border-slate-200 rounded-2xl text-center text-sm text-slate-500 font-medium max-w-xl mx-auto">
                                    Kartu situasi belum ditambahkan untuk topik ini.
                                </div>
                            @endif
                        </div>

                        <!-- TAHAP 3: PERFORMANCE FEEDBACK -->
                        <div x-show="step === 3" x-transition class="space-y-6">
                            <div>
                                <span class="px-2.5 py-1 bg-amber-500 text-white text-xs font-bold rounded-lg uppercase tracking-wider">Tahap 3</span>
                                <h3 class="text-xl font-black text-on-surface mt-2">Performance Feedback (Umpan Balik Konselor)</h3>
                                <p class="text-sm text-on-surface-variant mt-1 font-semibold font-medium">Konselor memberikan evaluasi, umpan balik positif, dan saran perbaikan atas simulasi role playing yang telah diperagakan oleh siswa.</p>
                            </div>

                            <div class="max-w-3xl mx-auto space-y-6 counselor-steps-rendered">
                                {!! $module->guide_feedback !!}
                            </div>
                        </div>

                        <!-- TAHAP 4: TRANSFER OF TRAINING -->
                        <div x-show="step === 4" x-transition class="space-y-6">
                            @php
                                $lkpd = $module->assessments->where('jenis', \App\Models\Assessment::JENIS_LKPD)->first();
                            @endphp
                            <div>
                                <span class="px-2.5 py-1 bg-purple-500 text-white text-xs font-bold rounded-lg uppercase tracking-wider">Tahap 4</span>
                                <h3 class="text-xl font-black text-on-surface mt-2">Transfer of Training (LKPD Online)</h3>
                                <p class="text-sm text-on-surface-variant mt-1 font-semibold font-medium">Siswa mengintegrasikan keterampilan empati dalam kehidupan sehari-hari melalui Lembar Kerja Peserta Didik (LKPD) online terintegrasi.</p>
                            </div>

                            <!-- Premium Counselor Guide Alert Card -->
                            @if($module->guide_transfer)
                                <div class="bg-indigo-50/70 border border-indigo-150 rounded-2xl p-5 shadow-xs flex items-start gap-4">
                                    <div class="flex-grow">
                                        <h4 class="text-xs font-black text-indigo-900 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                            <span>📖 Panduan Bimbingan Konselor</span>
                                            <span class="px-1.5 py-0.5 bg-indigo-100 text-indigo-850 text-[9px] font-black rounded uppercase">Tahap 4</span>
                                        </h4>
                                        <div class="text-xs text-indigo-950/80 leading-relaxed font-semibold prose prose-sm max-w-none counselor-steps-rendered">
                                            {!! $module->guide_transfer !!}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($lkpd)
                                <div class="max-w-4xl mx-auto bg-purple-50/50 border border-purple-200/50 rounded-2xl p-6">
                                    <h4 class="font-bold text-sm text-purple-900 flex items-center gap-1.5 mb-2">
                                        <span class="material-symbols-outlined text-[18px]">quiz</span>
                                        {{ $lkpd->judul }}
                                    </h4>
                                    <p class="text-xs text-on-surface-variant font-semibold">Lembar Kerja Peserta Didik (LKPD) ini memuat total <strong>{{ $lkpd->questions->count() }} Pertanyaan Pilihan Ganda</strong> yang mewakili 3 aspek bimbingan (Mengenali Situasi, Penilaian Diri, dan Komitmen).</p>
                                </div>
                            @else
                                <div class="p-8 bg-slate-50 border border-slate-200 rounded-2xl text-center text-sm text-slate-500 font-medium max-w-xl mx-auto">
                                    LKPD Ujian Online belum ditambahkan untuk topik ini.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Footer Aksi (Pojok Kanan Bawah) -->
                    <div class="mt-8 border-t border-slate-100 pt-6 flex justify-end">
                        <!-- Button Lanjut (Langkah 1 s.d. 3) -->
                        <button x-show="step < 4" @click="step++" class="inline-flex items-center px-6 py-3 bg-[#005bbf] text-white font-bold rounded-xl hover:bg-[#004493] text-xs sm:text-sm shadow-md hover:shadow-lg transition-all gap-1.5 group">
                            Lanjut ke Tahap Berikutnya
                            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform text-sm sm:text-base">arrow_forward</span>
                        </button>

                        <!-- Button Selesai (Langkah 4) -->
                        <a x-show="step === 4" href="{{ route('counselor.layanan') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 text-xs sm:text-sm shadow-md hover:shadow-lg transition-all gap-1.5">
                            Selesai Sesi Bimbingan
                            <span class="material-symbols-outlined text-sm sm:text-base">check_circle</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar Standalone Counselor Guide -->
            <div x-show="step === 1 || step === 2" class="lg:col-span-1 space-y-6">
                <!-- TAHAP 1: MODELING GUIDE -->
                <div x-show="step === 1" x-transition>
                    @if($module->guide_modeling)
                        <div class="bg-indigo-50/70 border border-indigo-150 rounded-2xl p-5 shadow-xs sticky top-6">
                            <div class="flex items-start gap-3">
                                <div class="flex-grow">
                                    <h4 class="text-xs font-black text-indigo-900 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                        <span>📖 Panduan Konselor</span>
                                        <span class="px-1.5 py-0.5 bg-indigo-100 text-indigo-805 text-[9px] font-black rounded uppercase">Tahap 1</span>
                                    </h4>
                                    <div class="text-xs text-indigo-950/80 leading-relaxed font-semibold prose prose-sm max-w-none counselor-steps-rendered">
                                        {!! $module->guide_modeling !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- TAHAP 2: ROLE PLAYING GUIDE -->
                <div x-show="step === 2" x-transition>
                    @if($module->guide_role_playing)
                        <div class="bg-indigo-50/70 border border-indigo-150 rounded-2xl p-5 shadow-xs sticky top-6">
                            <div class="flex items-start gap-3">
                                <div class="flex-grow">
                                    <h4 class="text-xs font-black text-indigo-900 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                        <span>📖 Panduan Konselor</span>
                                        <span class="px-1.5 py-0.5 bg-indigo-100 text-indigo-850 text-[9px] font-black rounded uppercase">Tahap 2</span>
                                    </h4>
                                    <div class="text-xs text-indigo-950/80 leading-relaxed font-semibold prose prose-sm max-w-none counselor-steps-rendered">
                                        {!! $module->guide_role_playing !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
