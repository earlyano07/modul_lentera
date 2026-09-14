<x-app-layout>
    <x-slot name="title">Evaluasi Peserta Didik - LENTERA</x-slot>

    <!-- Main Scrollable Area -->
    <div class="w-full max-w-7xl mx-auto space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <p class="font-label-sm text-label-sm text-primary uppercase tracking-wider mb-1">EVALUASI PESERTA DIDIK
                </p>
                <h2 class="font-headline-lg text-headline-lg text-on-surface mb-2">{{ $selectedModule->judul }}</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Menilai pemahaman, kesadaran diri, dan
                    komitmen peserta didik pada setiap topik pelatihan.</p>
            </div>

            <!-- Student Selector -->
            @if ($students->isNotEmpty())
                <div class="w-full md:w-80">
                    <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Pilih Peserta
                        Didik</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">person</span>
                        <select
                            onchange="window.location.href = '?student_id=' + this.value + '&module_id={{ $selectedModule->id }}'"
                            class="w-full pl-10 pr-10 py-3 rounded-lg border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary appearance-none font-body-md text-body-md shadow-sm">
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}"
                                    {{ $selectedStudent?->id == $student->id ? 'selected' : '' }}>
                                    {{ $student->user->nama }} | Kelas {{ $student->kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        <span
                            class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Topic Nav (5 Topik in 5 Columns) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5">
            @foreach ($modules as $mod)
                @php
                    $isActive = $selectedModule->id == $mod->id;
                @endphp
                <a href="?student_id={{ $selectedStudent?->id }}&module_id={{ $mod->id }}"
                    class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-200 border {{ $isActive ? 'bg-indigo-600 text-white shadow-md border-indigo-600 ring-2 ring-indigo-600/30' : 'bg-white text-slate-800 shadow-2xs border-slate-200/80 hover:border-indigo-300 hover:bg-slate-50' }}">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ $isActive ? 'bg-white/20 text-white' : 'bg-indigo-50 text-indigo-600' }}">
                        <span class="material-symbols-outlined text-xl"
                            style="{{ $isActive ? "font-variation-settings: 'FILL' 1;" : '' }}">
                            @if ($loop->iteration == 1)
                                psychology
                            @elseif($loop->iteration == 2)
                                favorite
                            @elseif($loop->iteration == 3)
                                all_inclusive
                            @elseif($loop->iteration == 4)
                                chat_bubble
                            @else
                                volunteer_activism
                            @endif
                        </span>
                    </div>
                    <div class="text-left overflow-hidden">
                        <p class="text-[10px] font-black uppercase tracking-wider {{ $isActive ? 'text-indigo-200' : 'text-slate-400' }}">
                            TOPIK {{ $mod->urutan }}
                        </p>
                        <p class="text-xs font-black truncate {{ $isActive ? 'text-white' : 'text-slate-800' }}">
                            {{ $mod->judul }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Alert / Notification -->
        @if (session('success'))
            <div
                class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-base text-emerald-500">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        @if (!$selectedStudent)
            <div
                class="bg-surface-container-lowest rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.05)] border border-outline-variant p-12 text-center">
                <span class="material-symbols-outlined text-3xl text-outline">group_off</span>
                <h3 class="font-headline-sm text-headline-sm text-on-surface mt-2">Tidak Ada Data Peserta Didik</h3>
                <p class="text-xs text-on-surface-variant mt-1">Silakan tambahkan data peserta didik terlebih dahulu.
                </p>
            </div>
        @else
            <!-- Evaluasi Main Form Grid -->
            <div x-data="evaluasiForm()" class="w-full">
                <form action="{{ route('counselor.evaluasi.store') }}" method="POST" class="w-full space-y-6">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $selectedStudent->id }}">
                    <input type="hidden" name="module_id" value="{{ $selectedModule->id }}">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start w-full">
                        <!-- Input Section (2 Columns / 66.6% Width) -->
                        <div
                            class="lg:col-span-2 bg-surface-container-lowest rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.05)] border border-outline-variant p-6 space-y-6">
                            <div
                                class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-outline-variant pb-3">
                                <div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface">INPUT HASIL EVALUASI
                                    </h3>
                                    <p class="text-xs text-on-surface-variant">Penilaian konselor terintegrasi dengan
                                        aktivitas pengerjaan siswa</p>
                                </div>
                                @if ($assessmentProgress && $assessmentProgress->status === 'selesai')
                                    <button type="button" @click="syncFromAssessment()"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200/80 rounded-xl text-xs font-extrabold shadow-2xs transition duration-200 cursor-pointer shrink-0">
                                        <span class="material-symbols-outlined text-sm text-emerald-600">sync</span>
                                        Sinkronkan Nilai Asesmen
                                    </button>
                                @endif
                            </div>

                            <!-- Live Assessment Integration Banner -->
                            @if ($assessmentProgress && $assessmentProgress->status === 'selesai')
                                <div
                                    class="p-4 rounded-2xl bg-gradient-to-r from-emerald-50 via-teal-50 to-blue-50/40 border border-emerald-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-2xs">
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="h-10 w-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-sm shrink-0 shadow-2xs">
                                            <span class="material-symbols-outlined text-xl">fact_check</span>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider bg-emerald-600 text-white">
                                                    ✓ Asesmen Siswa Selesai
                                                </span>
                                                <span class="text-[11px] font-bold text-slate-500">
                                                    {{ $assessmentProgress->finished_at?->format('d M Y H:i') }}
                                                </span>
                                            </div>
                                            <h4 class="text-xs font-black text-slate-800 mt-1">
                                                {{ $assessmentProgress->assessment->judul ?? 'Asesmen / LKPD Topik ' . $selectedModule->urutan }}
                                            </h4>
                                            <p class="text-[11px] text-slate-600 font-semibold mt-0.5">
                                                Nilai Asesmen Siswa: <strong
                                                    class="text-emerald-700 font-black text-xs">{{ number_format($assessmentProgress->nilai, 0) }}
                                                    / 100</strong>
                                                <span class="text-slate-400 mx-1">•</span>
                                                Konversi LKPD: <strong
                                                    class="text-blue-700 font-black text-xs">{{ $recommendedScores['lkpd'] ?? 0 }}/20</strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 sm:self-center">
                                        <div class="text-right hidden sm:block">
                                            <p class="text-[10px] font-bold text-slate-400 uppercase">Skor Terintegrasi
                                            </p>
                                            <p class="text-xs font-black text-emerald-700">Tersinkronisasi Otomatis</p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($assessmentProgress && $assessmentProgress->status === 'sedang_mengerjakan')
                                <div
                                    class="p-3.5 rounded-2xl bg-amber-50/80 border border-amber-200/80 flex items-center gap-3 text-xs text-amber-800 font-semibold shadow-2xs">
                                    <span class="material-symbols-outlined text-amber-600 text-xl">timelapse</span>
                                    <div>
                                        <p class="font-extrabold">Siswa Sedang Mengerjakan Asesmen Topik Ini</p>
                                        <p class="text-[11px] text-amber-700 font-medium">Nilai akan otomatis
                                            terintegrasi setelah siswa mengirimkan jawaban.</p>
                                    </div>
                                </div>
                            @else
                                <div
                                    class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center gap-3 text-xs text-slate-600 font-semibold shadow-2xs">
                                    <span class="material-symbols-outlined text-slate-400 text-xl">info</span>
                                    <div>
                                        <p class="font-extrabold text-slate-700">Siswa Belum Mengerjakan Asesmen Topik
                                            Ini di Aplikasi</p>
                                        <p class="text-[11px] text-slate-500 font-medium">Konselor dapat melakukan
                                            evaluasi dan memberikan penilaian observasi langsung di bawah ini.</p>
                                    </div>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Card 1: LKPD (Blue Theme) -->
                                <div
                                    class="rounded-2xl border border-outline-variant/50 p-4 shadow-sm flex flex-col hover:shadow-md transition-all relative overflow-hidden bg-gradient-to-b from-blue-50 to-indigo-50/30">
                                    <!-- Badge & Instrument Label -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="w-8 h-8 rounded-full text-white flex items-center justify-center font-bold text-xs shadow-sm bg-blue-600 shrink-0">
                                                01
                                            </span>
                                            <span
                                                class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500 truncate">
                                                LKPD ONLINE
                                            </span>
                                        </div>
                                        @if ($lkpdProgress && $lkpdProgress->status === 'selesai')
                                            <span
                                                class="inline-flex items-center gap-0.5 text-[9px] font-black px-1.5 py-0.5 bg-emerald-100 text-emerald-800 rounded-md">
                                                <span class="material-symbols-outlined text-[11px]">bolt</span>
                                                Terkoneksi
                                            </span>
                                        @endif
                                    </div>
                                    <!-- Judul & Deskripsi -->
                                    <h4 class="text-sm font-bold text-on-surface leading-snug min-h-[38px]">
                                        1. LEMBAR KERJA (LKPD)
                                    </h4>
                                    <p
                                        class="text-[11px] text-on-surface-variant font-medium mt-1 leading-normal italic mb-3">
                                        Menilai pemahaman konsep materi dan penyelesaian LKPD.
                                    </p>

                                    <div class="mt-auto space-y-3">
                                        <div>
                                            <label class="block text-xs font-semibold text-on-surface mb-1">Skor yang
                                                 diperoleh</label>
                                            <div class="flex items-center gap-2">
                                                <input
                                                    class="w-16 px-2.5 py-1.5 rounded-lg border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary text-center font-bold text-base bg-white"
                                                    type="number" name="lkpd_score" x-model="lkpdScore" min="0"
                                                    max="{{ $maxLkpdScore }}" required />
                                                <span class="text-xs text-on-surface-variant font-bold">/
                                                    {{ $maxLkpdScore }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-on-surface mb-1">Kategori</label>
                                            <div class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold"
                                                :class="lkpdDetails.badgeClass" x-text="lkpdDetails.category">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-on-surface mb-1">Catatan
                                                Konselor</label>
                                            <textarea
                                                class="w-full px-2.5 py-1.5 rounded-lg border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary text-xs resize-none bg-white"
                                                name="lkpd_note" placeholder="Tulis catatan..." rows="2">{{ old('lkpd_note', $evaluation->lkpd_note ?? '') }}</textarea>
                                        </div>
                                        <div
                                            class="flex justify-between items-center pt-2 border-t border-outline-variant text-[11px]">
                                            <button type="button"
                                                class="text-on-surface-variant hover:text-primary flex items-center gap-0.5"><span
                                                     class="material-symbols-outlined text-[14px]">info</span>
                                                Indikator</button>
                                            <button type="button"
                                                class="text-primary font-medium hover:underline">Rubrik</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 2: Penilaian Diri (Green Theme) -->
                                <div
                                    class="rounded-2xl border border-outline-variant/50 p-4 shadow-sm flex flex-col hover:shadow-md transition-all relative overflow-hidden bg-gradient-to-b from-emerald-50 to-green-50/30">
                                    <!-- Badge & Instrument Label -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="w-8 h-8 rounded-full text-white flex items-center justify-center font-bold text-xs shadow-sm bg-emerald-600 shrink-0">
                                                02
                                            </span>
                                            <span
                                                class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500 truncate">
                                                PENILAIAN DIRI
                                            </span>
                                        </div>
                                        @if ($selfProgress && $selfProgress->status === 'selesai')
                                            <span
                                                class="inline-flex items-center gap-0.5 text-[9px] font-black px-1.5 py-0.5 bg-emerald-100 text-emerald-800 rounded-md">
                                                <span class="material-symbols-outlined text-[11px]">bolt</span>
                                                Terkoneksi
                                            </span>
                                        @endif
                                    </div>
                                    <!-- Judul & Deskripsi -->
                                    <h4 class="text-sm font-bold text-on-surface leading-snug min-h-[38px]">
                                        2. PENILAIAN DIRI
                                    </h4>
                                    <p
                                        class="text-[11px] text-on-surface-variant font-medium mt-1 leading-normal italic mb-3">
                                        Menilai kesadaran diri terhadap perilaku & perasaan.
                                    </p>

                                    <div class="mt-auto space-y-3">
                                        <div>
                                            <label class="block text-xs font-semibold text-on-surface mb-1">Skor yang
                                                 diperoleh</label>
                                            <div class="flex items-center gap-2">
                                                <input
                                                    class="w-16 px-2.5 py-1.5 rounded-lg border border-outline-variant focus:border-tertiary focus:ring-1 focus:ring-tertiary text-center font-bold text-base bg-white"
                                                    type="number" name="self_score" x-model="selfScore"
                                                    min="0" max="{{ $maxSelfScore }}" required />
                                                <span class="text-xs text-on-surface-variant font-bold">/
                                                    {{ $maxSelfScore }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-on-surface mb-1">Kategori</label>
                                            <div class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold"
                                                :class="selfDetails.badgeClass" x-text="selfDetails.category">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-on-surface mb-1">Catatan
                                                Konselor</label>
                                            <textarea
                                                class="w-full px-2.5 py-1.5 rounded-lg border border-outline-variant focus:border-tertiary focus:ring-1 focus:ring-tertiary text-xs resize-none bg-white"
                                                name="self_note" placeholder="Tulis catatan..." rows="2">{{ old('self_note', $evaluation->self_note ?? '') }}</textarea>
                                        </div>
                                        <div
                                            class="flex justify-between items-center pt-2 border-t border-outline-variant text-[11px]">
                                            <button type="button"
                                                class="text-on-surface-variant hover:text-tertiary flex items-center gap-0.5"><span
                                                     class="material-symbols-outlined text-[14px]">info</span>
                                                Indikator</button>
                                            <button type="button"
                                                class="text-tertiary font-medium hover:underline">Rubrik</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 3: Lembar Komitmen (Amber Theme) -->
                                <div
                                    class="rounded-2xl border border-outline-variant/50 p-4 shadow-sm flex flex-col hover:shadow-md transition-all relative overflow-hidden bg-gradient-to-b from-amber-50 to-orange-50/30">
                                    <!-- Badge & Instrument Label -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="w-8 h-8 rounded-full text-white flex items-center justify-center font-bold text-xs shadow-sm bg-amber-600 shrink-0">
                                                03
                                            </span>
                                            <span
                                                class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500 truncate">
                                                LEMBAR KOMITMEN
                                            </span>
                                        </div>
                                        @if ($commitmentProgress && $commitmentProgress->status === 'selesai')
                                            <span
                                                class="inline-flex items-center gap-0.5 text-[9px] font-black px-1.5 py-0.5 bg-emerald-100 text-emerald-800 rounded-md">
                                                <span class="material-symbols-outlined text-[11px]">bolt</span>
                                                Terkoneksi
                                            </span>
                                        @endif
                                    </div>
                                    <!-- Judul & Deskripsi -->
                                    <h4 class="text-sm font-bold text-on-surface leading-snug min-h-[38px]">
                                        3. LEMBAR KOMITMEN
                                    </h4>
                                    <p
                                        class="text-[11px] text-on-surface-variant font-medium mt-1 leading-normal italic mb-3">
                                        Menilai keseriusan menyusun komitmen perilaku.
                                    </p>

                                    <div class="mt-auto space-y-3">
                                        <div>
                                            <label class="block text-xs font-semibold text-on-surface mb-1">Skor yang
                                                diperoleh</label>
                                            <div class="flex items-center gap-2">
                                                <input
                                                    class="w-16 px-2.5 py-1.5 rounded-lg border border-outline-variant focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-center font-bold text-base bg-white"
                                                    type="number" name="commitment_score" x-model="commitmentScore"
                                                    min="0" max="{{ $maxCommitmentScore }}" required />
                                                <span class="text-xs text-on-surface-variant font-bold">/
                                                    {{ $maxCommitmentScore }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-on-surface mb-1">Kategori</label>
                                            <div class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold"
                                                :class="commitmentDetails.badgeClass"
                                                x-text="commitmentDetails.category">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-on-surface mb-1">Catatan
                                                Konselor</label>
                                            <textarea
                                                class="w-full px-2.5 py-1.5 rounded-lg border border-outline-variant focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-xs resize-none bg-white"
                                                name="commitment_note" placeholder="Tulis catatan..." rows="2">{{ old('commitment_note', $evaluation->commitment_note ?? '') }}</textarea>
                                        </div>
                                        <div
                                            class="flex justify-between items-center pt-2 border-t border-outline-variant text-[11px]">
                                            <button type="button"
                                                class="text-on-surface-variant hover:text-orange-600 flex items-center gap-0.5"><span
                                                    class="material-symbols-outlined text-[14px]">info</span>
                                                Indikator</button>
                                            <button type="button"
                                                class="text-orange-600 font-medium hover:underline">Rubrik</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Sidebar Summary Section (1 Column / 33.3% Width) -->
                        <div
                            class="lg:col-span-1 bg-surface-container-lowest rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.05)] border border-outline-variant p-6 sticky top-6">
                            <h3 class="font-headline-sm text-headline-sm text-on-surface mb-4">RINGKASAN TOPIK
                                {{ $selectedModule->urutan }}</h3>
                            <div class="space-y-3 mb-6">
                                <h4 class="font-label-sm text-label-sm text-on-surface-variant">Ringkasan Kategori</h4>

                                <div
                                    class="flex items-center justify-between p-2 rounded hover:bg-surface-container-low transition-colors font-medium">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-sm">menu_book</span>
                                        <span class="font-body-sm text-body-sm text-on-surface">LKPD</span>
                                    </div>
                                    <div class="px-2.5 py-1 rounded-md text-xs font-semibold"
                                        :class="lkpdDetails.badgeClass" x-text="lkpdDetails.category"></div>
                                </div>

                                <div
                                    class="flex items-center justify-between p-2 rounded hover:bg-surface-container-low transition-colors font-medium">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-tertiary text-sm">favorite</span>
                                        <span class="font-body-sm text-body-sm text-on-surface">Penilaian Diri</span>
                                    </div>
                                    <div class="px-2.5 py-1 rounded-md text-xs font-semibold"
                                        :class="selfDetails.badgeClass" x-text="selfDetails.category"></div>
                                </div>

                                <div
                                    class="flex items-center justify-between p-2 rounded hover:bg-surface-container-low transition-colors font-medium">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="material-symbols-outlined text-orange-650 text-sm">handshake</span>
                                        <span class="font-body-sm text-body-sm text-on-surface">Komitmen</span>
                                    </div>
                                    <div class="px-2.5 py-1 rounded-md text-xs font-semibold"
                                        :class="commitmentDetails.badgeClass" x-text="commitmentDetails.category">
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-outline-variant pt-4 mb-6">
                                <h4 class="font-label-sm text-label-sm text-on-surface-variant mb-3">Status
                                    Perkembangan Topik</h4>
                                <div class="rounded-lg p-4 text-center border transition-all"
                                    :class="overallDetails.bgClass">
                                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full mb-2"
                                        :class="overallDetails.iconClass">
                                        <span class="material-symbols-outlined text-2xl" x-text="overallDetails.icon"
                                            style="font-variation-settings: 'FILL' 1;"></span>
                                    </div>
                                    <h5 class="font-headline-sm text-headline-sm mb-1"
                                        :class="overallDetails.textClass" x-text="overallDetails.category"></h5>
                                    <p class="text-xs text-on-surface-variant mb-1">Skor Rata-rata (Kode)</p>
                                    <p class="font-display-lg text-display-lg text-on-surface mb-1 text-3xl font-extrabold"
                                        x-text="overallDetails.average"></p>
                                    <p class="text-[11px] text-on-surface-variant">Kategori: 3,26 - 4,00</p>
                                </div>
                            </div>

                            <!-- Recommendations / Tip -->
                            <div class="rounded-lg p-3 flex gap-3 items-start border transition duration-200"
                                :class="overallDetails.tipBgClass">
                                <span class="material-symbols-outlined shrink-0 text-lg"
                                    :class="overallDetails.tipIconClass">lightbulb</span>
                                <p class="text-xs text-on-surface-variant leading-relaxed">
                                    <strong :class="overallDetails.tipIconClass"
                                        x-text="overallDetails.strongTip"></strong>
                                    <span x-text="overallDetails.tip"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div
                        class="flex flex-col md:flex-row items-center justify-between gap-4 bg-surface-container-lowest p-4 rounded-xl shadow-sm border border-outline-variant mt-4 w-full">
                        <div
                            class="flex items-center gap-3 text-xs text-on-surface-variant bg-surface-container-low p-3 rounded-lg w-full md:w-auto">
                            <span class="material-symbols-outlined text-primary text-base">info</span>
                            <p class="leading-tight">Penilaian dilakukan berdasarkan hasil kegiatan dalam layanan Topik
                                {{ $selectedModule->urutan }}.<br />Pastikan semua data telah diisi sebelum menyimpan.
                            </p>
                        </div>
                        <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                            <a href="{{ route('counselor.layanan') }}"
                                class="px-5 py-2.5 rounded-lg border border-outline-variant text-on-surface font-semibold text-xs hover:bg-surface-container-high transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">close</span> Batal
                            </a>
                            <button type="button" @click="resetForm"
                                class="px-5 py-2.5 rounded-lg border border-outline-variant text-on-surface font-semibold text-xs hover:bg-surface-container-high transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">refresh</span> Reset
                            </button>
                            <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs transition-colors shadow-md flex items-center gap-2 cursor-pointer">
                                <span class="material-symbols-outlined text-sm">save</span> Simpan Hasil Evaluasi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('evaluasiForm', () => ({
                    lkpdScore: '{{ old('lkpd_score', $evaluation->lkpd_score ?? ($recommendedScores['lkpd'] ?? '')) }}',
                    selfScore: '{{ old('self_score', $evaluation->self_score ?? ($recommendedScores['self'] ?? '')) }}',
                    commitmentScore: '{{ old('commitment_score', $evaluation->commitment_score ?? ($recommendedScores['commitment'] ?? '')) }}',
                    recommendedLkpd: '{{ $recommendedScores['lkpd'] ?? '' }}',
                    recommendedSelf: '{{ $recommendedScores['self'] ?? '' }}',
                    recommendedCommitment: '{{ $recommendedScores['commitment'] ?? '' }}',
                    maxLkpd: {{ $maxLkpdScore }},
                    maxSelf: {{ $maxSelfScore }},
                    maxCommitment: {{ $maxCommitmentScore }},

                    syncFromAssessment() {
                        if (this.recommendedLkpd !== '') this.lkpdScore = this.recommendedLkpd;
                        if (this.recommendedSelf !== '') this.selfScore = this.recommendedSelf;
                        if (this.recommendedCommitment !== '') this.commitmentScore = this
                            .recommendedCommitment;
                    },

                    get lkpdDetails() {
                        let score = parseFloat(this.lkpdScore);
                        if (this.lkpdScore === '' || isNaN(score)) return {
                            category: '-',
                            code: 0,
                            badgeClass: 'bg-surface-container-low text-outline'
                        };
                        let pct = (score / this.maxLkpd) * 100;
                        if (pct >= 80) return {
                            category: 'Berkembang Sangat Baik',
                            code: 4,
                            badgeClass: 'bg-tertiary-fixed text-on-tertiary-fixed-variant'
                        };
                        if (pct >= 55) return {
                            category: 'Berkembang Baik',
                            code: 3,
                            badgeClass: 'bg-tertiary-fixed-dim text-on-tertiary-fixed-variant'
                        };
                        if (pct >= 30) return {
                            category: 'Mulai Berkembang',
                            code: 2,
                            badgeClass: 'bg-secondary-container text-on-secondary-container'
                        };
                        return {
                            category: 'Memerlukan Pendampingan',
                            code: 1,
                            badgeClass: 'bg-error-container text-error'
                        };
                    },

                    get selfDetails() {
                        let score = parseFloat(this.selfScore);
                        if (this.selfScore === '' || isNaN(score)) return {
                            category: '-',
                            code: 0,
                            badgeClass: 'bg-surface-container-low text-outline'
                        };
                        let pct = (score / this.maxSelf) * 100;
                        if (pct >= 80) return {
                            category: 'Berkembang Sangat Baik',
                            code: 4,
                            badgeClass: 'bg-tertiary-fixed text-on-tertiary-fixed-variant'
                        };
                        if (pct >= 60) return {
                            category: 'Berkembang Baik',
                            code: 3,
                            badgeClass: 'bg-tertiary-fixed-dim text-on-tertiary-fixed-variant'
                        };
                        if (pct >= 40) return {
                            category: 'Mulai Berkembang',
                            code: 2,
                            badgeClass: 'bg-secondary-container text-on-secondary-container'
                        };
                        return {
                            category: 'Memerlukan Pendampingan',
                            code: 1,
                            badgeClass: 'bg-error-container text-error'
                        };
                    },

                    get commitmentDetails() {
                        let score = parseFloat(this.commitmentScore);
                        if (this.commitmentScore === '' || isNaN(score)) return {
                            category: '-',
                            code: 0,
                            badgeClass: 'bg-surface-container-low text-outline'
                        };
                        let pct = (score / this.maxCommitment) * 100;
                        if (pct >= 80) return {
                            category: 'Berkembang Sangat Baik',
                            code: 4,
                            badgeClass: 'bg-tertiary-fixed text-on-tertiary-fixed-variant'
                        };
                        if (pct >= 50) return {
                            category: 'Berkembang Baik',
                            code: 3,
                            badgeClass: 'bg-tertiary-fixed-dim text-on-tertiary-fixed-variant'
                        };
                        if (pct >= 30) return {
                            category: 'Mulai Berkembang',
                            code: 2,
                            badgeClass: 'bg-secondary-container text-on-secondary-container'
                        };
                        return {
                            category: 'Memerlukan Pendampingan',
                            code: 1,
                            badgeClass: 'bg-error-container text-error'
                        };
                    },

                    get overallDetails() {
                        let lkpd = this.lkpdDetails;
                        let self = this.selfDetails;
                        let commit = this.commitmentDetails;

                        if (lkpd.code === 0 || self.code === 0 || commit.code === 0) {
                            return {
                                average: '-',
                                category: 'Belum Lengkap',
                                strongTip: 'Lengkapi semua nilai',
                                tip: ' instrumen untuk melihat ringkasan perkembangan.',
                                bgClass: 'bg-surface-container-low border-outline-variant',
                                iconClass: 'bg-outline text-white',
                                textClass: 'text-outline',
                                tipBgClass: 'bg-surface-container-low border-outline-variant',
                                tipIconClass: 'text-outline',
                                icon: 'pending'
                            };
                        }

                        let avg = ((lkpd.code + self.code + commit.code) / 3).toFixed(2);

                        if (avg >= 3.26) {
                            return {
                                average: avg,
                                category: 'Berkembang Sangat Baik',
                                strongTip: 'Pertahankan konsistensi',
                                tip: ' dan berikan penguatan agar peserta terus berkembang.',
                                bgClass: 'bg-tertiary-fixed/10 border-tertiary-fixed-dim',
                                iconClass: 'bg-tertiary-container text-on-tertiary-container',
                                textClass: 'text-tertiary',
                                tipBgClass: 'bg-primary-fixed/30 border-primary-fixed-dim',
                                tipIconClass: 'text-primary',
                                icon: 'star'
                            };
                        }
                        if (avg >= 2.51) {
                            return {
                                average: avg,
                                category: 'Berkembang Baik',
                                strongTip: 'Siswa berkembang baik',
                                tip: '. Berikan motivasi tambahan agar potensinya maksimal.',
                                bgClass: 'bg-primary-fixed/20 border-primary-fixed-dim',
                                iconClass: 'bg-primary-container text-on-primary-container',
                                textClass: 'text-primary',
                                tipBgClass: 'bg-primary-fixed/30 border-primary-fixed-dim',
                                tipIconClass: 'text-primary',
                                icon: 'verified'
                            };
                        }
                        if (avg >= 1.76) {
                            return {
                                average: avg,
                                category: 'Mulai Berkembang',
                                strongTip: 'Terus pantau',
                                tip: ' dan bimbing siswa secara berkala untuk meningkatkan kepedulian.',
                                bgClass: 'bg-amber-100 border-amber-350',
                                iconClass: 'bg-amber-500 text-white',
                                textClass: 'text-amber-700',
                                tipBgClass: 'bg-amber-100 border-amber-350',
                                tipIconClass: 'text-amber-700',
                                icon: 'trending_up'
                            };
                        }
                        return {
                            average: avg,
                            category: 'Memerlukan Pendampingan',
                            strongTip: 'Intervensi khusus',
                            tip: ' dan pendampingan personal lebih lanjut sangat dibutuhkan.',
                            bgClass: 'bg-error-container/30 border-error-container',
                            iconClass: 'bg-error text-white',
                            textClass: 'text-error',
                            tipBgClass: 'bg-error-container/30 border-error-container',
                            tipIconClass: 'text-error',
                            icon: 'warning'
                        };
                    },

                    resetForm() {
                        this.lkpdScore = '';
                        this.selfScore = '';
                        this.commitmentScore = '';
                    }
                }))
            })
        </script>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @endpush
</x-app-layout>
