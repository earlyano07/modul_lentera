<x-app-layout>
    <x-slot name="title">LKPD Online - Daftar Topik</x-slot>

    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Lembar Kerja Peserta Didik (LKPD)</h1>
        <p class="mt-2 text-sm text-slate-600 font-medium">Selesaikan Lembar Kerja Peserta Didik (LKPD) online untuk setiap topik bimbingan empati secara berurutan.</p>
    </div>

    <!-- Progress Tracker -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-8 sticky top-4 z-10">
        <div class="flex justify-between items-center mb-2.5">
            <span class="font-bold text-slate-700 text-xs sm:text-sm uppercase tracking-wider">Total Kemajuan Bimbingan</span>
            <span class="font-black text-primary text-base sm:text-lg">{{ $progressPercentage ?? 0 }}%</span>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-3">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500" style="width: {{ $progressPercentage ?? 0 }}%"></div>
        </div>
    </div>

    <!-- Pre-Test Alert Banner -->
    @if(!$preTestCompleted && $preTest)
        <div class="mb-8 p-6 bg-indigo-50 border border-indigo-200/50 rounded-2xl flex flex-col md:flex-row md:items-center justify-between gap-6 shadow-sm">
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-[36px] text-indigo-600 mt-1">assignment_turned_in</span>
                <div>
                    <h4 class="font-bold text-indigo-900 text-base">Asesmen Awal (Pre-Test) Belum Selesai</h4>
                    <p class="text-xs text-indigo-700 font-semibold mt-1 max-w-2xl leading-relaxed">Selamat datang di LENTERA! Silakan kerjakan Asesmen Awal terlebih dahulu sebelum Anda dapat mengakses pengerjaan Lembar Kerja Peserta Didik (LKPD) pada 5 topik bimbingan empati.</p>
                </div>
            </div>
            <a href="{{ route('student.assessment.show', $preTest->id) }}" target="_blank" class="inline-flex items-center justify-center px-5 py-3 bg-[#1a73e8] text-white font-bold rounded-xl hover:bg-[#004493] text-xs sm:text-sm shadow-md hover:shadow-lg transition-all gap-1.5 shrink-0">
                Mulai Pre-Test
                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
        </div>
    @endif

    <!-- Post-Test Alert Banner -->
    @if($completedAllLkpd && $postTest && !$postTestCompleted)
        <div class="mb-8 p-6 bg-emerald-50 border border-emerald-200/50 rounded-2xl flex flex-col md:flex-row md:items-center justify-between gap-6 shadow-sm animate-pulse">
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-[36px] text-emerald-600 mt-1 animate-bounce">emoji_events</span>
                <div>
                    <h4 class="font-bold text-emerald-900 text-base">Selamat! Seluruh LKPD Selesai Dikerjakan</h4>
                    <p class="text-xs text-emerald-700 font-semibold mt-1 max-w-2xl leading-relaxed">Anda telah menyelesaikan LKPD untuk 5 topik intervensi empati. Sekarang, silakan kerjakan Asesmen Akhir (Post-Test) untuk melengkapi seluruh proses bimbingan Anda.</p>
                </div>
            </div>
            <a href="{{ route('student.assessment.show', $postTest->id) }}" target="_blank" class="inline-flex items-center justify-center px-5 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 text-xs sm:text-sm shadow-md hover:shadow-lg transition-all gap-1.5 shrink-0">
                Mulai Post-Test
                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
        </div>
    @endif

    <!-- List of 5 Topics -->
    <h2 class="text-lg font-extrabold text-slate-800 mb-5 flex items-center gap-2">
        <span class="material-symbols-outlined text-primary text-xl">auto_stories</span>
        Daftar Topik Pelatihan (Topik 1 - 5)
    </h2>

    <div class="grid grid-cols-1 gap-5">
        @foreach($topiks as $topik)
            @php
                $stageAssessments = $topik->assessments->whereNotIn('jenis', ['pre_test', 'post_test']);
                $totalAssessments = $stageAssessments->count();
                $completedAssessments = \App\Models\StudentProgress::where('student_id', $student->id)
                    ->whereIn('assessment_id', $stageAssessments->pluck('id'))
                    ->where('status', 'selesai')
                    ->count();
                
                // Can access module if pre-test is done AND progressService allows module
                $canAccess = $preTestCompleted && app(\App\Services\ProgressService::class)->canAccessModule($student, $topik);
                $isFullyCompleted = $totalAssessments > 0 && $completedAssessments >= $totalAssessments;
            @endphp

            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden transition-all duration-300 {{ $canAccess ? 'hover:shadow-md hover:border-slate-300 group' : 'opacity-70 bg-slate-50/70' }}">
                <!-- Border Accent -->
                <div class="absolute top-0 left-0 w-2 h-full {{ $isFullyCompleted ? 'bg-emerald-500' : ($canAccess ? 'bg-indigo-600' : 'bg-slate-300') }}"></div>

                <div class="flex-grow pl-3">
                    <div class="flex items-center gap-2.5 mb-2 flex-wrap">
                        <span class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider {{ $isFullyCompleted ? 'bg-emerald-100 text-emerald-800' : ($canAccess ? 'bg-indigo-100 text-indigo-800' : 'bg-slate-100 text-slate-500') }}">
                            Topik {{ $topik->urutan }}
                        </span>
                        @if($isFullyCompleted)
                            <span class="inline-flex items-center gap-1 text-[10px] font-extrabold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md">
                                <span class="material-symbols-outlined text-[12px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                Semua Asesmen Selesai ({{ $completedAssessments }}/{{ $totalAssessments }})
                            </span>
                        @elseif($completedAssessments > 0)
                            <span class="inline-flex items-center gap-1 text-[10px] font-extrabold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-md">
                                <span class="material-symbols-outlined text-[12px]">timelapse</span>
                                Sebagian Selesai ({{ $completedAssessments }}/{{ $totalAssessments }})
                            </span>
                        @elseif($canAccess)
                            <span class="text-[10px] font-extrabold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-md">
                                Tersedia (3 Asesmen)
                            </span>
                        @else
                            <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md flex items-center gap-0.5">
                                <span class="material-symbols-outlined text-[12px]">lock</span> Terkunci
                            </span>
                        @endif
                    </div>

                    <a href="{{ $canAccess ? route('student.module', $topik->id) : '#' }}" class="block">
                        <h3 class="text-lg sm:text-xl font-black text-slate-900 leading-tight group-hover:text-indigo-600 transition-colors">
                            {{ $topik->judul }}
                        </h3>
                    </a>
                    <p class="text-xs text-slate-500 font-bold mt-1">({{ $topik->subtitle }})</p>
                    
                    <!-- 3 Instruments Chips -->
                    <div class="flex items-center gap-2 mt-3 flex-wrap">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-[10px] font-black border border-blue-100">
                            <span class="material-symbols-outlined text-[12px]">assignment</span> LKPD
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-[10px] font-black border border-emerald-100">
                            <span class="material-symbols-outlined text-[12px]">favorite</span> Penilaian Diri
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 text-[10px] font-black border border-amber-100">
                            <span class="material-symbols-outlined text-[12px]">handshake</span> Lembar Komitmen
                        </span>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="shrink-0 self-stretch sm:self-auto flex items-center">
                    @if($canAccess)
                        <a href="{{ route('student.module', $topik->id) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 {{ $isFullyCompleted ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-indigo-600 hover:bg-indigo-700' }} text-white font-black rounded-xl text-xs sm:text-sm transition shadow-md hover:shadow-lg gap-2 cursor-pointer">
                            <span>{{ $isFullyCompleted ? 'Lihat Asesmen' : 'Pilih Asesmen' }}</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    @else
                        <button disabled class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-slate-100 text-slate-400 border border-slate-200 font-bold rounded-xl text-xs cursor-not-allowed gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">lock</span>
                            Terkunci
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
