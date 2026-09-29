<x-app-layout>
    <x-slot name="title">Progress Siswa - {{ $student->user->nama ?? 'Siswa' }}</x-slot>

    <!-- Main Container -->
    <div class="w-full max-w-7xl mx-auto space-y-6" x-data="{ activeTab: 'topics', selectedTopicIdx: 0 }">
        
        <!-- Breadcrumbs & Navigation -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <nav class="text-xs text-slate-400 font-semibold">
                <ol class="list-reset flex items-center gap-1.5 flex-wrap">
                    <li><a href="{{ route('counselor.dashboard') }}" class="hover:text-indigo-600 transition">Dashboard</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li><a href="{{ route('counselor.monitoring.schools') }}" class="hover:text-indigo-600 transition">Monitoring</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li><a href="{{ route('counselor.monitoring.students', $student->kelas_id) }}" class="hover:text-indigo-600 transition">Kelas {{ $student->kelas->nama_kelas ?? 'Kelas' }}</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li class="text-slate-700 font-bold truncate max-w-xs">{{ $student->user->nama ?? 'Detail Progres' }}</li>
                </ol>
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('counselor.monitoring.student.certificate', $student->id) }}" target="_blank"
                   class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl transition shadow-sm">
                    <span class="material-symbols-outlined text-sm">workspace_premium</span>
                    Cetak Sertifikat
                </a>
                <a href="{{ route('counselor.monitoring.student.certificate.docx', $student->id) }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl transition shadow-sm">
                    <span class="material-symbols-outlined text-sm">description</span>
                    Unduh Word (.docx)
                </a>
                <a href="{{ route('counselor.monitoring.students', $student->kelas_id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-extrabold text-xs uppercase tracking-wider rounded-xl transition shadow-2xs">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Kembali ke Kelas
                </a>
            </div>
        </div>

        <!-- Page Header & Student Switcher -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
            <div>
                <p class="text-[11px] font-black text-indigo-600 uppercase tracking-widest mb-1 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base">monitoring</span>
                    MONITORING & PROGRES BELAJAR
                </p>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 leading-tight">
                    {{ $student->user->nama ?? 'Nama Siswa' }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 font-semibold mt-1">
                    {{ $student->kelas->school->nama ?? 'Sekolah' }} • Kelas {{ $student->kelas->nama_kelas ?? '-' }} • NIS: {{ $student->nis ?? '-' }}
                </p>
            </div>

            <!-- Student Switcher Dropdown -->
            @if(isset($classStudents) && $classStudents->isNotEmpty())
                <div class="w-full md:w-80 shrink-0">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1.5">Ganti Peserta Didik (Kelas {{ $student->kelas->nama_kelas }})</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">person</span>
                        <select onchange="window.location.href = '/counselor/students/' + this.value + '/progress'"
                            class="w-full pl-9 pr-9 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-xs font-bold text-slate-800 appearance-none shadow-2xs transition cursor-pointer">
                            @foreach($classStudents as $classStudent)
                                <option value="{{ $classStudent->id }}" {{ $classStudent->id == $student->id ? 'selected' : '' }}>
                                    {{ $classStudent->user->nama }} (NIS: {{ $classStudent->nis }})
                                </option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-base">expand_more</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Topic Navigation Cards (Topik 1 - 5 + Lembar Komitmen Akhir) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-3.5">
            @foreach($modules as $modIndex => $mod)
                @php
                    $stageAssessments = $mod->assessments;
                    $totalAss = $stageAssessments->count();
                    $completedAss = 0;
                    foreach($stageAssessments as $sa) {
                        if (isset($progressList[$sa->id]) && $progressList[$sa->id]->status === 'selesai') {
                            $completedAss++;
                        }
                    }
                    $isModCompleted = $totalAss > 0 && $completedAss >= $totalAss;
                    $isModStarted = $completedAss > 0;
                    $modEvaluation = $evaluations->get($mod->id);
                @endphp
                <div @click="activeTab = 'topics'; selectedTopicIdx = {{ $modIndex }}"
                     class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-200 border cursor-pointer select-none"
                     :class="activeTab === 'topics' && selectedTopicIdx === {{ $modIndex }} ? 'bg-indigo-600 text-white shadow-md border-indigo-600 ring-2 ring-indigo-600/30' : 'bg-white text-slate-800 shadow-2xs border-slate-200/80 hover:border-indigo-300 hover:bg-slate-50'">
                    
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                         :class="activeTab === 'topics' && selectedTopicIdx === {{ $modIndex }} ? 'bg-white/20 text-white' : '{{ $isModCompleted ? 'bg-emerald-50 text-emerald-600' : ($isModStarted ? 'bg-indigo-50 text-indigo-600' : 'bg-slate-100 text-slate-400') }}'">
                        <span class="material-symbols-outlined text-xl"
                            :style="activeTab === 'topics' && selectedTopicIdx === {{ $modIndex }} ? 'font-variation-settings: \'FILL\' 1;' : ''">
                            @if($mod->urutan == 1) psychology
                            @elseif($mod->urutan == 2) favorite
                            @elseif($mod->urutan == 3) all_inclusive
                            @elseif($mod->urutan == 4) chat_bubble
                            @else volunteer_activism
                            @endif
                        </span>
                    </div>

                    <div class="text-left overflow-hidden flex-1">
                        <div class="flex items-center justify-between gap-1">
                            <p class="text-[10px] font-black uppercase tracking-wider"
                               :class="activeTab === 'topics' && selectedTopicIdx === {{ $modIndex }} ? 'text-indigo-200' : 'text-slate-400'">
                                TOPIK {{ $mod->urutan }}
                            </p>
                            @if($isModCompleted)
                                <span class="material-symbols-outlined text-sm" :class="activeTab === 'topics' && selectedTopicIdx === {{ $modIndex }} ? 'text-emerald-200' : 'text-emerald-500'" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            @endif
                        </div>
                        <p class="text-xs font-black truncate"
                           :class="activeTab === 'topics' && selectedTopicIdx === {{ $modIndex }} ? 'text-white' : 'text-slate-800'">
                            {{ $mod->judul }}
                        </p>
                        <p class="text-[10px] font-semibold mt-0.5 truncate"
                           :class="activeTab === 'topics' && selectedTopicIdx === {{ $modIndex }} ? 'text-indigo-100' : 'text-slate-400'">
                            @if($isModCompleted) Selesai ({{ $completedAss }}/{{ $totalAss }})
                            @elseif($isModStarted) Berjalan ({{ $completedAss }}/{{ $totalAss }})
                            @else Belum Mulai
                            @endif
                        </p>
                    </div>
                </div>
            @endforeach

            @if(isset($finalCommitmentModule))
                @php
                    $fcAssessment = $finalCommitmentModule->assessments->first();
                    $fcProg = $fcAssessment ? ($progressList[$fcAssessment->id] ?? null) : null;
                    $isFcCompleted = $fcProg && $fcProg->status === 'selesai';
                @endphp
                <div @click="activeTab = 'commitment'"
                     class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-200 border cursor-pointer select-none"
                     :class="activeTab === 'commitment' ? 'bg-amber-600 text-white shadow-md border-amber-600 ring-2 ring-amber-600/30' : 'bg-white text-slate-800 shadow-2xs border-slate-200/80 hover:border-amber-300 hover:bg-slate-50'">
                    
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                         :class="activeTab === 'commitment' ? 'bg-white/20 text-white' : '{{ $isFcCompleted ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}'">
                        <span class="material-symbols-outlined text-xl"
                            :style="activeTab === 'commitment' ? 'font-variation-settings: \'FILL\' 1;' : ''">
                            handshake
                        </span>
                    </div>

                    <div class="text-left overflow-hidden flex-1">
                        <div class="flex items-center justify-between gap-1">
                            <p class="text-[10px] font-black uppercase tracking-wider"
                               :class="activeTab === 'commitment' ? 'text-amber-200' : 'text-slate-400'">
                                TAHAP AKHIR
                            </p>
                            @if($isFcCompleted)
                                <span class="material-symbols-outlined text-sm" :class="activeTab === 'commitment' ? 'text-emerald-200' : 'text-emerald-500'" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            @endif
                        </div>
                        <p class="text-xs font-black truncate"
                           :class="activeTab === 'commitment' ? 'text-white' : 'text-slate-800'">
                            {{ $finalCommitmentModule->judul }}
                        </p>
                        <p class="text-[10px] font-semibold mt-0.5 truncate"
                           :class="activeTab === 'commitment' ? 'text-amber-100' : 'text-slate-400'">
                            @if($isFcCompleted) Selesai
                            @else Belum Diisi
                            @endif
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Main Content 2-Column Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <!-- Left Column: Student Profile & Key Metrics Sidebar (1/3 Width) -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Profile & Overall Progress Card -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs space-y-6">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-gradient-to-tr from-indigo-600 to-purple-600 text-white rounded-3xl flex items-center justify-center text-2xl font-black mx-auto mb-3 shadow-md shadow-indigo-200">
                            {{ strtoupper(substr($student->user->nama ?? 'S', 0, 1)) }}
                        </div>
                        <h2 class="text-lg font-black text-slate-900 leading-tight">{{ $student->user->nama ?? 'Nama Siswa' }}</h2>
                        <p class="text-xs text-slate-400 font-bold mt-0.5">NIS: {{ $student->nis ?? '-' }} • {{ $student->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        
                        <div class="mt-3 flex items-center justify-center gap-2">
                            <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-lg border border-indigo-100 uppercase tracking-wider">
                                Kelas {{ $student->kelas->nama_kelas ?? '-' }}
                            </span>
                            @if(($progressPercentage ?? 0) >= 100)
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-black rounded-lg border border-emerald-200 uppercase tracking-wider flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[12px]" style="font-variation-settings: 'FILL' 1;">check_circle</span> Selesai
                                </span>
                            @elseif(($progressPercentage ?? 0) > 0)
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-[10px] font-black rounded-lg border border-blue-200 uppercase tracking-wider flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[12px]">timelapse</span> Sedang Berjalan
                                </span>
                            @else
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-lg border border-slate-200 uppercase tracking-wider">
                                    Belum Mulai
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <!-- Progress Bar -->
                    <div>
                        <div class="flex justify-between items-center mb-2 text-xs font-black">
                            <span class="text-slate-500 uppercase tracking-wider text-[10px]">Total Progres Program</span>
                            <span class="text-indigo-600 text-sm font-black">{{ number_format($progressPercentage ?? 0, 0) }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden p-0.5 border border-slate-200/50">
                            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 h-full rounded-full transition-all duration-500" style="width: {{ $progressPercentage ?? 0 }}%"></div>
                        </div>
                        <p class="text-[11px] text-slate-400 font-semibold mt-2 text-center">
                            Tahap Aktif: <strong class="text-slate-700 font-black">{{ $currentStage?->judul ?? 'Program Selesai' }}</strong>
                        </p>
                    </div>

                    <hr class="border-slate-100">

                    <!-- Metadata List -->
                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between items-center py-1 border-b border-slate-50">
                            <span class="text-slate-400 font-semibold">Sekolah</span>
                            <span class="text-slate-800 font-bold truncate max-w-[180px] text-right">{{ $student->kelas->school->nama ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-slate-50">
                            <span class="text-slate-400 font-semibold">Email Akun</span>
                            <span class="text-slate-800 font-bold truncate max-w-[180px] text-right">{{ $student->user->email ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-1">
                            <span class="text-slate-400 font-semibold">Jenis Kelamin</span>
                            <span class="text-slate-800 font-bold truncate max-w-[180px] text-right">{{ $student->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-2.5 pt-2">
                        <a href="{{ route('counselor.evaluasi', ['student_id' => $student->id]) }}" 
                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-wider rounded-2xl shadow-xs transition cursor-pointer">
                            <span class="material-symbols-outlined text-base">rate_review</span>
                            Buka di Meja Kerja Evaluasi
                        </a>
                        <a href="{{ route('counselor.reports.student', $student->id) }}" 
                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200 font-extrabold text-xs rounded-2xl transition cursor-pointer">
                            <span class="material-symbols-outlined text-base text-slate-500">description</span>
                            Lihat Lembar Laporan Lengkap
                        </a>
                        <a href="{{ route('counselor.reports.student.pdf', $student->id) }}" target="_blank"
                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-rose-50 text-rose-700 border border-rose-200 font-extrabold text-xs rounded-2xl transition cursor-pointer">
                            <span class="material-symbols-outlined text-base text-rose-600">picture_as_pdf</span>
                            Download PDF Laporan
                        </a>
                    </div>
                </div>

                <!-- Overall Summary Statistics Card -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-indigo-600 text-base">insights</span>
                        Ringkasan Skor Bimbingan
                    </h3>

                    @php
                        $assessmentCounts = [
                            'Sangat Baik' => 0,
                            'Baik' => 0,
                            'Cukup' => 0,
                            'Kurang' => 0,
                            'Sangat Kurang' => 0,
                        ];
                        foreach($evaluations as $ev) {
                            $s = $ev->getSelfDetails();
                            if ($s['category'] !== '-' && isset($assessmentCounts[$s['category']])) $assessmentCounts[$s['category']]++;
                            $r = $ev->getRefleksiDetails();
                            if ($r['category'] !== '-' && isset($assessmentCounts[$r['category']])) $assessmentCounts[$r['category']]++;
                            $c = $ev->getCommitmentDetails();
                            if ($c['category'] !== '-' && isset($assessmentCounts[$c['category']])) $assessmentCounts[$c['category']]++;
                        }
                        $totalAssEvaluated = array_sum($assessmentCounts);
                    @endphp

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Distribusi Capaian Asesmen</p>
                        <div class="grid grid-cols-5 gap-1 text-center">
                            <div class="p-1.5 rounded-lg bg-emerald-50 border border-emerald-100" title="Sangat Baik">
                                <span class="block text-[9px] font-bold text-emerald-700">SB</span>
                                <span class="text-xs font-black text-emerald-900">{{ $assessmentCounts['Sangat Baik'] }}</span>
                            </div>
                            <div class="p-1.5 rounded-lg bg-blue-50 border border-blue-100" title="Baik">
                                <span class="block text-[9px] font-bold text-blue-700">B</span>
                                <span class="text-xs font-black text-blue-900">{{ $assessmentCounts['Baik'] }}</span>
                            </div>
                            <div class="p-1.5 rounded-lg bg-amber-50 border border-amber-100" title="Cukup">
                                <span class="block text-[9px] font-bold text-amber-700">C</span>
                                <span class="text-xs font-black text-amber-900">{{ $assessmentCounts['Cukup'] }}</span>
                            </div>
                            <div class="p-1.5 rounded-lg bg-orange-50 border border-orange-100" title="Kurang">
                                <span class="block text-[9px] font-bold text-orange-700">K</span>
                                <span class="text-xs font-black text-orange-900">{{ $assessmentCounts['Kurang'] }}</span>
                            </div>
                            <div class="p-1.5 rounded-lg bg-rose-50 border border-rose-100" title="Sangat Kurang">
                                <span class="block text-[9px] font-bold text-rose-700">SK</span>
                                <span class="text-xs font-black text-rose-900">{{ $assessmentCounts['Sangat Kurang'] }}</span>
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-400 font-semibold mt-2">
                            Total {{ $totalAssEvaluated }} Asesmen Tervalidasi
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-center">
                        <div class="p-3 bg-blue-50/60 border border-blue-100 rounded-xl">
                            <p class="text-[10px] font-bold text-blue-600 uppercase">Topik Dievaluasi</p>
                            <p class="text-base font-black text-blue-900 mt-0.5">{{ $evaluations->count() }} / 5</p>
                        </div>
                        <div class="p-3 bg-emerald-50/60 border border-emerald-100 rounded-xl">
                            <p class="text-[10px] font-bold text-emerald-600 uppercase">Asesmen Selesai</p>
                            @php
                                $totalDoneAss = $progressList->where('status', 'selesai')->count();
                            @endphp
                            <p class="text-base font-black text-emerald-900 mt-0.5">{{ $totalDoneAss }} Butir</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Tabbed Detailed Progress & Timeline (2/3 Width) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Main Navigation Tabs -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-2 shadow-xs flex items-center gap-2">
                    <button type="button" @click="activeTab = 'topics'" 
                            class="flex-1 inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl font-bold text-xs transition duration-200 cursor-pointer"
                            :class="activeTab === 'topics' ? 'bg-indigo-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-50'">
                        <span class="material-symbols-outlined text-base">auto_stories</span>
                        Instrumen Topik 1 - 5
                    </button>
                    @if(isset($finalCommitmentModule))
                        @php
                            $fcAssessment = $finalCommitmentModule->assessments->first();
                            $fcProg = $fcAssessment ? ($progressList[$fcAssessment->id] ?? null) : null;
                            $isFcCompleted = $fcProg && $fcProg->status === 'selesai';
                        @endphp
                        <button type="button" @click="activeTab = 'commitment'" 
                                class="flex-1 inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl font-bold text-xs transition duration-200 cursor-pointer"
                                :class="activeTab === 'commitment' ? 'bg-amber-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-50'">
                            <span class="material-symbols-outlined text-base">handshake</span>
                            Lembar Komitmen Siswa
                            @if($isFcCompleted)
                                <span class="inline-flex items-center justify-center w-2 h-2 rounded-full bg-emerald-400"></span>
                            @endif
                        </button>
                    @endif
                    <button type="button" @click="activeTab = 'timeline'" 
                            class="flex-1 inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl font-bold text-xs transition duration-200 cursor-pointer"
                            :class="activeTab === 'timeline' ? 'bg-indigo-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-50'">
                        <span class="material-symbols-outlined text-base">timeline</span>
                        Timeline Aktivitas Belajar
                    </button>
                </div>

                <!-- TAB 1: Topik 1 - 5 Detailed Instruments -->
                <div x-show="activeTab === 'topics'" class="space-y-6">
                    @foreach($modules as $modIndex => $mod)
                        @php
                            $eval = $evaluations->get($mod->id);
                            $selfAssessment = $mod->assessments->first(fn($a) => $a->jenis === 'penilaian_diri' || str_contains(strtolower($a->judul), 'penilaian diri') || str_contains(strtolower($a->judul), 'self'));
                            $refleksiAssessment = $mod->assessments->first(fn($a) => $a->jenis === 'refleksi_diri' || $a->jenis === 'lkpd' || str_contains(strtolower($a->judul), 'refleksi') || str_contains(strtolower($a->judul), 'lkpd'));
                            $commitAssessment = $mod->assessments->first(fn($a) => $a->jenis === 'lembar_komitmen' || str_contains(strtolower($a->judul), 'komitmen'));
                            
                            $selfProg = $selfAssessment ? $progressList->get($selfAssessment->id) : null;
                            $refleksiProg = $refleksiAssessment ? $progressList->get($refleksiAssessment->id) : null;
                            $commitProg = $commitAssessment ? $progressList->get($commitAssessment->id) : null;

                            $maxSelf = $selfAssessment ? ($selfAssessment->questions->sum('score') ?: $selfAssessment->questions->count() ?: 20) : 20;
                            $maxRefleksi = $refleksiAssessment ? ($refleksiAssessment->questions->sum('score') ?: $refleksiAssessment->questions->count() ?: 20) : 20;
                            $maxCommit = $commitAssessment ? ($commitAssessment->questions->sum('score') ?: $commitAssessment->questions->count() ?: 6) : 6;
                        @endphp
                        
                        <div x-show="selectedTopicIdx === {{ $modIndex }}" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                            
                            <!-- Topic Card Header -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                                <div>
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <span class="px-2.5 py-0.5 bg-indigo-50 text-indigo-700 font-black text-[10px] rounded-md uppercase tracking-wider border border-indigo-100">
                                            Topik Pelatihan {{ $mod->urutan }}
                                        </span>
                                        @if($eval)
                                            <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 font-bold text-[10px] rounded-md border border-emerald-200 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[12px]">verified</span> Sudah Dievaluasi Konselor
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 font-bold text-[10px] rounded-md border border-amber-200">
                                                Belum Dievaluasi
                                            </span>
                                        @endif
                                    </div>
                                    <h2 class="text-xl sm:text-2xl font-black text-slate-900">{{ $mod->judul }}</h2>
                                    @if($mod->subtitle)
                                        <p class="text-xs text-indigo-600 font-bold mt-0.5">({{ $mod->subtitle }})</p>
                                    @endif
                                </div>

                                <a href="{{ route('counselor.evaluasi', ['student_id' => $student->id, 'module_id' => $mod->id]) }}" 
                                   class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-black text-xs uppercase tracking-wider rounded-xl transition cursor-pointer shrink-0 border border-indigo-200/60">
                                    <span class="material-symbols-outlined text-sm">edit_note</span>
                                    Input / Perbarui Evaluasi
                                </a>
                            </div>

                            <!-- 3 Instruments Grid (Penilaian Diri, Refleksi Diri, Lembar Komitmen) -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                
                                <!-- 1. Penilaian Diri Card -->
                                <div class="rounded-2xl border border-slate-200 p-4 shadow-2xs flex flex-col justify-between relative overflow-hidden bg-gradient-to-b from-emerald-50/80 to-teal-50/30">
                                    <div>
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center gap-2">
                                                <span class="w-7 h-7 rounded-lg text-white flex items-center justify-center font-bold text-xs bg-emerald-600 shadow-2xs">01</span>
                                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-500">PENILAIAN DIRI</span>
                                            </div>
                                            @if($selfProg && $selfProg->status === 'selesai')
                                                <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[9px] font-black rounded-md">✓ Selesai</span>
                                            @else
                                                <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[9px] font-bold rounded-md">Belum</span>
                                            @endif
                                        </div>

                                        <h4 class="text-xs font-black text-slate-800 mb-1">1. Penilaian Diri</h4>
                                        <p class="text-[11px] text-slate-500 font-medium mb-3">Kesadaran diri terhadap perasaan & tindakan empati.</p>
                                    </div>

                                    <div class="pt-3 border-t border-emerald-100/80 space-y-2">
                                        <div class="flex items-center justify-between text-xs font-bold">
                                            <span class="text-slate-500">Nilai Asesmen Siswa:</span>
                                            <span class="text-emerald-700 font-black text-sm">
                                                {{ $selfProg && $selfProg->status === 'selesai' ? number_format($selfProg->nilai, 0) : '-' }}
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs font-bold">
                                            <span class="text-slate-500">Skor Evaluasi:</span>
                                            <span class="text-slate-800 font-black">
                                                {{ $eval && $eval->self_score !== null ? $eval->self_score . ' / ' . $maxSelf : '-' }}
                                            </span>
                                        </div>
                                        @if($eval && $eval->self_score !== null)
                                            @php $selfDet = $eval->getSelfDetails(); @endphp
                                            <div class="pt-1">
                                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                    {{ $selfDet['category'] }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 2. Refleksi Diri Card -->
                                <div class="rounded-2xl border border-slate-200 p-4 shadow-2xs flex flex-col justify-between relative overflow-hidden bg-gradient-to-b from-blue-50/80 to-indigo-50/30">
                                    <div>
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center gap-2">
                                                <span class="w-7 h-7 rounded-lg text-white flex items-center justify-center font-bold text-xs bg-blue-600 shadow-2xs">02</span>
                                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-500">REFLEKSI DIRI</span>
                                            </div>
                                            @if($refleksiProg && $refleksiProg->status === 'selesai')
                                                <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[9px] font-black rounded-md">✓ Selesai</span>
                                            @else
                                                <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[9px] font-bold rounded-md">Belum</span>
                                            @endif
                                        </div>

                                        <h4 class="text-xs font-black text-slate-800 mb-1">2. Refleksi Diri</h4>
                                        <p class="text-[11px] text-slate-500 font-medium mb-3">Pengerjaan butir soal dan pemahaman konsep empati.</p>
                                    </div>

                                    <div class="pt-3 border-t border-blue-100/80 space-y-2">
                                        <div class="flex items-center justify-between text-xs font-bold">
                                            <span class="text-slate-500">Nilai Refleksi Siswa:</span>
                                            <span class="text-blue-700 font-black text-sm">
                                                {{ $refleksiProg && $refleksiProg->status === 'selesai' ? number_format($refleksiProg->nilai, 0) : '-' }}
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs font-bold">
                                            <span class="text-slate-500">Skor Evaluasi:</span>
                                            <span class="text-slate-800 font-black">
                                                {{ $eval && $eval->lkpd_score !== null ? $eval->lkpd_score . ' / ' . $maxRefleksi : '-' }}
                                            </span>
                                        </div>
                                        @if($eval && $eval->lkpd_score !== null)
                                            @php $refleksiDet = $eval->getRefleksiDetails(); @endphp
                                            <div class="pt-1">
                                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800">
                                                    {{ $refleksiDet['category'] }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 3. Lembar Komitmen Card -->
                                <div class="rounded-2xl border border-slate-200 p-4 shadow-2xs flex flex-col justify-between relative overflow-hidden bg-gradient-to-b from-amber-50/80 to-orange-50/30">
                                    <div>
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center gap-2">
                                                <span class="w-7 h-7 rounded-lg text-white flex items-center justify-center font-bold text-xs bg-amber-600 shadow-2xs">03</span>
                                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-500">LEMBAR KOMITMEN</span>
                                            </div>
                                            @if($commitProg && $commitProg->status === 'selesai')
                                                <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[9px] font-black rounded-md">✓ Selesai</span>
                                            @else
                                                <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[9px] font-bold rounded-md">Belum</span>
                                            @endif
                                        </div>

                                        <h4 class="text-xs font-black text-slate-800 mb-1">3. Lembar Komitmen</h4>
                                        <p class="text-[11px] text-slate-500 font-medium mb-3">Komitmen penerapan perilaku positif dalam keseharian.</p>
                                    </div>

                                    <div class="pt-3 border-t border-amber-100/80 space-y-2">
                                        <div class="flex items-center justify-between text-xs font-bold">
                                            <span class="text-slate-500">Nilai Asesmen Siswa:</span>
                                            <span class="text-amber-700 font-black text-sm">
                                                {{ $commitProg && $commitProg->status === 'selesai' ? number_format($commitProg->nilai, 0) : '-' }}
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs font-bold">
                                            <span class="text-slate-500">Skor Evaluasi:</span>
                                            <span class="text-slate-800 font-black">
                                                {{ $eval && $eval->commitment_score !== null ? $eval->commitment_score . ' / ' . $maxCommit : '-' }}
                                            </span>
                                        </div>
                                        @if($eval && $eval->commitment_score !== null)
                                            @php $commitDet = $eval->getCommitmentDetails(); @endphp
                                            <div class="pt-1">
                                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">
                                                    {{ $commitDet['category'] }}
                                                </span>
                                            </div>
                                        @endif

                                        <!-- Tombol Modal Hasil Lembar Komitmen Siswa -->
                                        @if ($commitProg && $commitProg->status === 'selesai' && !empty($commitProg->answers))
                                            <div class="pt-2.5 border-t border-amber-200/80" x-data="{ showModal_{{ $mod->id }}: false }">
                                                <button type="button" @click="showModal_{{ $mod->id }} = true"
                                                    class="w-full flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold shadow-xs transition duration-200 cursor-pointer">
                                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                                    <span>Lihat Pilihan & Catatan Siswa</span>
                                                </button>

                                                <!-- Modal Detail Hasil Komitmen & Catatan Siswa -->
                                                <div x-show="showModal_{{ $mod->id }}" 
                                                     x-cloak
                                                     x-transition:enter="transition ease-out duration-300"
                                                     x-transition:enter-start="opacity-0"
                                                     x-transition:enter-end="opacity-100"
                                                     x-transition:leave="transition ease-in duration-200"
                                                     x-transition:leave-start="opacity-100"
                                                     x-transition:leave-end="opacity-0"
                                                     class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 sm:p-6"
                                                     @keydown.escape.window="showModal_{{ $mod->id }} = false">
                                                    
                                                    <div @click.away="showModal_{{ $mod->id }} = false"
                                                         x-transition:enter="transition ease-out duration-300"
                                                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                         x-transition:leave="transition ease-in duration-200"
                                                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                         class="bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-2xl w-full flex flex-col max-h-[90vh] overflow-hidden text-left">
                                                        
                                                        <!-- Modal Header -->
                                                        <div class="px-6 py-5 bg-gradient-to-r from-amber-50 via-orange-50/50 to-amber-50/20 border-b border-amber-200/70 flex items-center justify-between">
                                                            <div class="flex items-center gap-3">
                                                                <div class="w-10 h-10 rounded-2xl bg-amber-600 text-white flex items-center justify-center font-bold shadow-sm shrink-0">
                                                                    <span class="material-symbols-outlined text-xl">fact_check</span>
                                                                </div>
                                                                <div>
                                                                    <h3 class="text-base font-extrabold text-slate-900">
                                                                        Hasil Lembar Komitmen & Catatan Siswa
                                                                    </h3>
                                                                    <p class="text-xs text-slate-500 font-medium">
                                                                        Topik {{ $mod->urutan }}: {{ $mod->judul }} • {{ $student->user->nama ?? '-' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <button type="button" @click="showModal_{{ $mod->id }} = false" 
                                                                class="w-8 h-8 rounded-full bg-white/80 hover:bg-white text-slate-400 hover:text-slate-600 flex items-center justify-center transition border border-slate-200 cursor-pointer shadow-2xs">
                                                                <span class="material-symbols-outlined text-lg">close</span>
                                                            </button>
                                                        </div>

                                                        <!-- Modal Body -->
                                                        <div class="p-6 overflow-y-auto space-y-5 flex-1">
                                                            @if($commitProg->finished_at)
                                                                <div class="flex items-center justify-between p-3 bg-amber-50/80 rounded-xl border border-amber-200/60 text-xs">
                                                                    <span class="text-amber-900 font-semibold flex items-center gap-1.5">
                                                                        <span class="material-symbols-outlined text-base text-amber-700">schedule</span>
                                                                        Waktu Pengisian Siswa
                                                                    </span>
                                                                    <span class="font-extrabold text-slate-800">
                                                                        {{ $commitProg->finished_at->format('d M Y, H:i') }} WIB
                                                                    </span>
                                                                </div>
                                                            @endif

                                                            @if ($commitAssessment && $commitAssessment->questions->isNotEmpty())
                                                                <div class="space-y-5">
                                                                    @foreach ($commitAssessment->questions as $q)
                                                                        @php
                                                                            $ans = $commitProg->answers[$q->id] ?? null;
                                                                        @endphp
                                                                        <div class="bg-slate-50/80 border border-slate-200/80 rounded-2xl p-4 sm:p-5 space-y-3">
                                                                            <div class="flex items-start gap-2">
                                                                                <span class="w-6 h-6 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-xs font-black shrink-0 mt-0.5">
                                                                                    {{ $loop->iteration }}
                                                                                </span>
                                                                                <h4 class="font-extrabold text-xs sm:text-sm text-slate-900 leading-snug">
                                                                                    {{ $q->question }}
                                                                                </h4>
                                                                            </div>

                                                                            @if ($q->type === 'checklist')
                                                                                <div class="space-y-2 pt-1 pl-1 sm:pl-8">
                                                                                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Butir Komitmen yang Tersedia & Pilihan Siswa:</p>
                                                                                    @foreach ($q->options as $opt)
                                                                                        @php
                                                                                            $isSelected = is_array($ans) ? in_array((string) $opt->id, array_map('strval', $ans)) : ($ans == $opt->id);
                                                                                        @endphp
                                                                                        <div class="p-3 rounded-xl border transition-all flex items-start gap-3 {{ $isSelected ? 'bg-emerald-50/90 border-emerald-300 text-emerald-950 font-bold shadow-2xs' : 'bg-white border-slate-200/70 text-slate-400 font-medium' }}">
                                                                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-md shrink-0 mt-0.5 text-xs font-black {{ $isSelected ? 'bg-emerald-600 text-white shadow-2xs' : 'bg-slate-100 text-slate-300' }}">
                                                                                                {{ $isSelected ? '✓' : '' }}
                                                                                            </span>
                                                                                            <div class="flex-1 text-xs leading-relaxed">
                                                                                                <span class="{{ $isSelected ? 'text-slate-900' : 'text-slate-400' }}">
                                                                                                    {{ $opt->option }}
                                                                                                </span>
                                                                                            </div>
                                                                                            @if($isSelected)
                                                                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-600 text-white shrink-0">
                                                                                                    Disepakati Siswa
                                                                                                </span>
                                                                                            @else
                                                                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-400 shrink-0">
                                                                                                    Tidak Dipilih
                                                                                                </span>
                                                                                            @endif
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            @elseif ($q->type === 'essay')
                                                                                <div class="pt-1 pl-1 sm:pl-8">
                                                                                    <div class="p-4 bg-amber-50/90 rounded-2xl border border-amber-200 shadow-2xs space-y-1.5">
                                                                                        <div class="flex items-center gap-1.5 text-amber-900 font-extrabold text-xs">
                                                                                            <span class="material-symbols-outlined text-base text-amber-700">edit_note</span>
                                                                                            <span>Catatan / Pernyataan Refleksi Siswa:</span>
                                                                                        </div>
                                                                                        <div class="p-3.5 bg-white rounded-xl border border-amber-200/60 text-xs sm:text-sm text-slate-800 font-medium leading-relaxed whitespace-pre-wrap">
                                                                                            {{ $ans ?: '(Siswa tidak menuliskan catatan tambahan)' }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <div class="pt-1 pl-1 sm:pl-8">
                                                                                    @php
                                                                                        $selectedOpt = $q->options->firstWhere('id', is_array($ans) ? ($ans[0] ?? null) : $ans);
                                                                                    @endphp
                                                                                    <div class="p-3 bg-white rounded-xl border border-slate-200 text-xs text-slate-700">
                                                                                        Pilihan Siswa: <strong class="text-indigo-600 text-sm font-bold">{{ $selectedOpt?->option ?? ($ans ?: '-') }}</strong>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <div class="py-12 text-center text-slate-400 font-medium text-xs">
                                                                    Belum ada butir pertanyaan pada Lembar Komitmen ini.
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <!-- Modal Footer -->
                                                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200/80 flex items-center justify-between">
                                                            <p class="text-[11px] text-slate-500 font-medium italic">
                                                                💡 Catatan komitmen perilaku ini terekam saat siswa menyelesaikan asesmen.
                                                            </p>
                                                            <button type="button" @click="showModal_{{ $mod->id }} = false"
                                                                class="px-5 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-extrabold text-xs transition shadow-xs cursor-pointer">
                                                                Tutup Rincian
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <!-- Counselor Evaluation Notes & Status Box -->
                            @if($eval)
                                @php
                                    $selfDet = $eval->getSelfDetails();
                                    $refleksiDet = $eval->getRefleksiDetails();
                                    $commitDet = $eval->getCommitmentDetails();
                                @endphp
                                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-indigo-600 text-lg">fact_check</span>
                                        <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider">Hasil Evaluasi Asesmen Konselor (Topik {{ $mod->urutan }})</h4>
                                    </div>

                                    <!-- Topic Overall Capaian Banner -->
                                    @php
                                        $topicOverall = $eval->getOverallDetails();
                                    @endphp
                                    <div class="p-4 rounded-xl border {{ $topicOverall['badge'] }} flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div>
                                            <span class="text-[10px] font-black uppercase tracking-wider opacity-75">
                                                Kategori Capaian Topik {{ $mod->urutan }} (Total Seluruh Asesmen):
                                            </span>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="text-sm font-black">{{ $topicOverall['category'] }} ({{ $topicOverall['percentage'] }}%)</span>
                                                <span class="text-xs font-semibold opacity-85">• Total Skor: {{ $topicOverall['total_score'] }} / {{ $topicOverall['total_max'] }}</span>
                                            </div>
                                        </div>
                                        <div class="text-xs font-medium max-w-sm sm:text-right leading-snug opacity-90">
                                            {{ $topicOverall['meaning'] }}
                                        </div>
                                    </div>

                                    <!-- 3 Cards: Penilaian Diri, Refleksi Diri, Lembar Komitmen -->
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                                        <!-- Penilaian Diri -->
                                        <div class="p-3 bg-white rounded-xl border border-slate-200/80 space-y-1">
                                            <p class="text-[10px] font-black uppercase tracking-wider text-emerald-700">1. Penilaian Diri</p>
                                            <div class="flex items-center justify-between">
                                                <span class="font-extrabold text-slate-800">Skor: {{ $eval->self_score ?? 0 }}</span>
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    {{ $selfDet['percentage'] ?? 0 }}%
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Refleksi Diri -->
                                        <div class="p-3 bg-white rounded-xl border border-slate-200/80 space-y-1">
                                            <p class="text-[10px] font-black uppercase tracking-wider text-blue-700">2. Refleksi Diri</p>
                                            <div class="flex items-center justify-between">
                                                <span class="font-extrabold text-slate-800">Skor: {{ $eval->lkpd_score ?? 0 }}</span>
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-blue-50 text-blue-700 border border-blue-200">
                                                    {{ $refleksiDet['percentage'] ?? 0 }}%
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Lembar Komitmen -->
                                        <div class="p-3 bg-white rounded-xl border border-slate-200/80 space-y-1">
                                            <p class="text-[10px] font-black uppercase tracking-wider text-purple-700">3. Lembar Komitmen</p>
                                            <div class="flex items-center justify-between">
                                                <span class="font-extrabold text-slate-800">Skor: {{ $eval->commitment_score ?? 0 }}</span>
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-purple-50 text-purple-700 border border-purple-200">
                                                    {{ $commitDet['percentage'] ?? 0 }}%
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Rekomendasi Tindak Lanjut Konselor (Panduan Resmi LENTERA) -->
                                    @if(!empty($topicOverall['tindak_lanjut']))
                                        <div class="p-4 rounded-xl bg-white border border-slate-200/90 space-y-3">
                                            <div class="flex items-center justify-between">
                                                <span class="text-[11px] font-black text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                                                    <span class="material-symbols-outlined text-indigo-600 text-base">psychology</span>
                                                    Panduan Rekomendasi Tindak Lanjut (Kategori: {{ $topicOverall['category'] }})
                                                </span>
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black {{ $topicOverall['badge'] }}">
                                                    {{ $topicOverall['percentage'] }}%
                                                </span>
                                            </div>

                                            <p class="text-xs text-slate-600 font-medium leading-relaxed">
                                                {{ $topicOverall['deskripsi'] }}
                                            </p>

                                            <div>
                                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1.5">
                                                    Rekomendasi Tindak Lanjut Konselor:
                                                </span>
                                                <ul class="space-y-1.5 text-xs text-slate-700 font-medium">
                                                    @foreach($topicOverall['tindak_lanjut'] as $tl)
                                                        <li class="flex items-start gap-2">
                                                            <span class="material-symbols-outlined text-indigo-600 text-sm shrink-0 mt-0.5">check_circle</span>
                                                            <span class="leading-relaxed">{{ rtrim($tl, ';') }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            @if(!empty($topicOverall['catatan_penting']))
                                                <div class="p-3 rounded-xl bg-amber-50/90 border border-amber-200/80 text-amber-950 text-xs leading-relaxed flex items-start gap-2.5">
                                                    <span class="material-symbols-outlined text-amber-600 text-base shrink-0 mt-0.5">info</span>
                                                    <div>
                                                        <span class="font-black text-[11px] uppercase tracking-wider text-amber-800 block mb-0.5">Catatan Penting Etika Asesmen:</span>
                                                        <p class="text-[11px] font-medium text-amber-900 leading-snug">{{ $topicOverall['catatan_penting'] }}</p>
                                                    </div>
                                                </div>
                                            @endif

                                            @if(in_array($topicOverall['category'], ['Kurang', 'Sangat Kurang']))
                                                <div class="pt-2 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100">
                                                    <p class="text-[11px] text-slate-500 font-medium">
                                                        Diperlukan pembinaan terarah atau pendampingan individual/kelompok.
                                                    </p>
                                                    <a href="{{ route('counselor.layanan.show', $mod->id) }}"
                                                       class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-black shadow-2xs transition">
                                                        <span class="material-symbols-outlined text-sm">support_agent</span>
                                                        Buka Materi Bimbingan Topik {{ $mod->urutan }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    @if($eval->counselor_note)
                                        <div class="p-3.5 bg-white rounded-xl border border-slate-100 text-xs text-slate-700 font-medium leading-relaxed">
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-xs text-indigo-500">rate_review</span>
                                                Catatan Konselor (Topik {{ $mod->urutan }})
                                            </p>
                                            <p class="text-slate-700 font-semibold">{{ $eval->counselor_note }}</p>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-200/70 text-xs text-amber-900 flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-2.5">
                                        <span class="material-symbols-outlined text-amber-600 text-xl">info</span>
                                        <div>
                                            <p class="font-extrabold">Topik Ini Belum Dievaluasi oleh Konselor</p>
                                            <p class="text-[11px] text-amber-700 font-medium">Buka halaman evaluasi untuk memberikan catatan dan validasi skor perkembangan siswa.</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('counselor.evaluasi', ['student_id' => $student->id, 'module_id' => $mod->id]) }}" 
                                       class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-extrabold text-[11px] uppercase tracking-wider rounded-xl transition shadow-2xs cursor-pointer shrink-0">
                                        Input Evaluasi
                                    </a>
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>

                <!-- TAB: Lembar Komitmen Siswa (Tahap Akhir Pasca 5 Topik) -->
                @if(isset($finalCommitmentModule))
                    @php
                        $fcAssessment = $finalCommitmentModule->assessments->first();
                        $fcProg = $fcAssessment ? ($progressList[$fcAssessment->id] ?? null) : null;
                        $isFcCompleted = $fcProg && $fcProg->status === 'selesai';
                    @endphp
                    <div x-show="activeTab === 'commitment'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                        
                        <!-- Header -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                            <div>
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span class="px-2.5 py-0.5 bg-amber-50 text-amber-800 font-black text-[10px] rounded-md uppercase tracking-wider border border-amber-200">
                                        Tahap Akhir Layanan Model LENTERA
                                    </span>
                                    @if($isFcCompleted)
                                        <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 font-bold text-[10px] rounded-md border border-emerald-200 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[12px]" style="font-variation-settings: 'FILL' 1;">check_circle</span> Lembar Komitmen Selesai
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 bg-slate-100 text-slate-500 font-bold text-[10px] rounded-md border border-slate-200">
                                            Belum Diisi Siswa
                                        </span>
                                    @endif
                                </div>
                                <h2 class="text-xl sm:text-2xl font-black text-slate-900">{{ $finalCommitmentModule->judul }}</h2>
                                <p class="text-xs text-slate-500 font-semibold mt-0.5">Komitmen penerapan empati & anti-perundungan yang dicantumkan pada halaman belakang sertifikat.</p>
                            </div>

                            @if($isFcCompleted)
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('counselor.monitoring.student.certificate', $student->id) }}" target="_blank"
                                       class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl transition shadow-xs">
                                        <span class="material-symbols-outlined text-sm">workspace_premium</span>
                                        Lihat di Sertifikat
                                    </a>
                                </div>
                            @endif
                        </div>

                        @if($isFcCompleted && !empty($fcProg->answers))
                            @if($fcProg->finished_at)
                                <div class="flex items-center justify-between p-3.5 bg-amber-50/80 rounded-2xl border border-amber-200/60 text-xs">
                                    <span class="text-amber-900 font-bold flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-base text-amber-700">schedule</span>
                                        Waktu Penyelesaian Komitmen:
                                    </span>
                                    <span class="font-black text-slate-800">
                                        {{ $fcProg->finished_at->format('d M Y, H:i') }} WIB
                                    </span>
                                </div>
                            @endif

                            @if($fcAssessment && $fcAssessment->questions->isNotEmpty())
                                <div class="space-y-5">
                                    @foreach($fcAssessment->questions as $q)
                                        @php
                                            $ans = $fcProg->answers[$q->id] ?? null;
                                        @endphp
                                        <div class="bg-slate-50/80 border border-slate-200/80 rounded-2xl p-4 sm:p-5 space-y-3">
                                            <div class="flex items-start gap-2">
                                                <span class="w-6 h-6 rounded-lg bg-amber-600 text-white flex items-center justify-center text-xs font-black shrink-0 mt-0.5">
                                                    {{ $loop->iteration }}
                                                </span>
                                                <h4 class="font-extrabold text-xs sm:text-sm text-slate-900 leading-snug">
                                                    {{ $q->question }}
                                                </h4>
                                            </div>

                                            @if($q->type === 'checklist')
                                                <div class="space-y-2 pt-1 pl-1 sm:pl-8">
                                                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Butir Komitmen yang Disepakati Siswa:</p>
                                                    @foreach($q->options as $opt)
                                                        @php
                                                            $isSelected = is_array($ans) ? in_array((string) $opt->id, array_map('strval', $ans)) : ($ans == $opt->id);
                                                        @endphp
                                                        <div class="p-3 rounded-xl border transition-all flex items-start gap-3 {{ $isSelected ? 'bg-emerald-50/90 border-emerald-300 text-emerald-950 font-bold shadow-2xs' : 'bg-white border-slate-200/70 text-slate-400 font-medium opacity-60' }}">
                                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-md shrink-0 mt-0.5 text-xs font-black {{ $isSelected ? 'bg-emerald-600 text-white shadow-2xs' : 'bg-slate-100 text-slate-300' }}">
                                                                {{ $isSelected ? '✓' : '' }}
                                                            </span>
                                                            <div class="flex-1 text-xs leading-relaxed">
                                                                <span class="{{ $isSelected ? 'text-slate-900 font-extrabold' : 'text-slate-400' }}">
                                                                    {{ $opt->option }}
                                                                </span>
                                                            </div>
                                                            @if($isSelected)
                                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-600 text-white shrink-0">
                                                                    Disepakati Siswa
                                                                </span>
                                                            @else
                                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-400 shrink-0">
                                                                    Tidak Dipilih
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @elseif($q->type === 'essay')
                                                <div class="pt-1 pl-1 sm:pl-8">
                                                    <div class="p-4 bg-amber-50/90 rounded-2xl border border-amber-200 shadow-2xs space-y-1.5">
                                                        <div class="flex items-center gap-1.5 text-amber-900 font-extrabold text-xs">
                                                            <span class="material-symbols-outlined text-base text-amber-700">edit_note</span>
                                                            <span>Pernyataan / Ikrar Komitmen Pribadi Siswa:</span>
                                                        </div>
                                                        <div class="p-3.5 bg-white rounded-xl border border-amber-200/60 text-xs sm:text-sm text-slate-800 font-medium leading-relaxed whitespace-pre-wrap">
                                                            {{ $ans ?: '(Siswa belum menuliskan komitmen pribadi)' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="py-12 px-6 rounded-2xl bg-amber-50/40 border border-amber-200/60 text-center space-y-3">
                                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center mx-auto">
                                    <span class="material-symbols-outlined text-2xl">pending_actions</span>
                                </div>
                                <h3 class="text-sm font-black text-slate-800">Siswa Belum Mengisi Lembar Komitmen</h3>
                                <p class="text-xs text-slate-500 font-medium max-w-md mx-auto">
                                    Lembar komitmen ini merupakan tahap akhir setelah siswa menyelesaikan Topik 1 s.d. 5. Jawaban komitmen siswa akan otomatis disinkronkan ke halaman belakang sertifikat.
                                </p>
                            </div>
                        @endif

                    </div>
                @endif

                <!-- TAB 2: Activity Timeline -->
                <div x-show="activeTab === 'timeline'" class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">
                    <div class="border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-black text-slate-900 flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-600 text-xl">timeline</span>
                            Kronologi Aktivitas Belajar
                        </h3>
                        <p class="text-xs text-slate-400 font-semibold mt-0.5">Rekaman tahapan pengerjaan materi dan penyelesaian asesmen oleh siswa.</p>
                    </div>

                    <div class="relative border-l-2 border-indigo-100 ml-4 space-y-6 pt-2">
                        @forelse($timeline ?? [] as $item)
                            <div class="relative pl-7">
                                <!-- Timeline Marker Dot -->
                                @if($item['status'] === 'completed')
                                    <div class="absolute -left-[11px] top-1 w-5 h-5 rounded-full bg-emerald-500 border-4 border-white shadow-xs flex items-center justify-center text-white">
                                        <span class="material-symbols-outlined text-[10px]" style="font-variation-settings: 'FILL' 1;">check</span>
                                    </div>
                                @elseif($item['status'] === 'in_progress')
                                    <div class="absolute -left-[11px] top-1 w-5 h-5 rounded-full bg-amber-500 border-4 border-white shadow-xs flex items-center justify-center text-white">
                                        <span class="material-symbols-outlined text-[10px]">timelapse</span>
                                    </div>
                                @elseif($item['status'] === 'available')
                                    <div class="absolute -left-[11px] top-1 w-5 h-5 rounded-full bg-indigo-500 border-4 border-white shadow-xs"></div>
                                @else
                                    <div class="absolute -left-[11px] top-1 w-5 h-5 rounded-full bg-slate-300 border-4 border-white shadow-xs flex items-center justify-center text-white">
                                        <span class="material-symbols-outlined text-[10px]">lock</span>
                                    </div>
                                @endif

                                <!-- Timeline Content Box -->
                                <div class="bg-slate-50 hover:bg-slate-100/80 transition rounded-2xl p-4 border border-slate-100">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="px-2 py-0.5 text-[9px] font-black uppercase tracking-wider rounded-md {{ $item['type'] === 'assessment' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ $item['type_label'] ?? 'Aktivitas' }}
                                            </span>
                                            <h4 class="text-sm font-black text-slate-800">{{ $item['title'] ?? 'Judul' }}</h4>
                                        </div>
                                        
                                        @if(isset($item['score']) && $item['score'] !== null)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 shrink-0">
                                                Nilai: {{ number_format($item['score'], 0) }}
                                            </span>
                                        @endif
                                    </div>

                                    <p class="text-xs text-slate-500 font-semibold">{{ $item['description'] ?? '' }}</p>

                                    @if(isset($item['completed_at']) && $item['completed_at'])
                                        <p class="text-[11px] text-slate-400 font-bold mt-2 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">event_available</span>
                                            Selesai pada: {{ \Carbon\Carbon::parse($item['completed_at'])->format('d M Y, H:i') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="pl-7 text-xs text-slate-400 font-bold">
                                Belum ada riwayat aktivitas pengerjaan oleh siswa ini.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
