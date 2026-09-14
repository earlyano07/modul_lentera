<x-app-layout>
    <x-slot name="title">{{ $module->judul ?? 'Topik Pembelajaran' }}</x-slot>

    <!-- Breadcrumb -->
    <nav class="flex text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('student.roadmap') }}" class="hover:text-indigo-600 font-semibold transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">assignment</span>
                    Daftar Topik LKPD
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mx-1 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="text-slate-900 font-extrabold line-clamp-1">Topik {{ $module->urutan }}: {{ $module->judul }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header Module -->
    <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 p-8 mb-8 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-2.5 h-full bg-indigo-600"></div>
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
            <div>
                <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-800 text-[10px] font-black rounded-md mb-3 uppercase tracking-widest border border-indigo-100">Topik Pelatihan {{ $module->urutan }}</span>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mb-1.5">{{ $module->judul ?? 'Judul Topik' }}</h1>
                @if($module->subtitle)
                    <p class="text-xs sm:text-sm font-bold text-indigo-600 mb-3 italic">({{ $module->subtitle }})</p>
                @endif
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-3xl font-medium">{{ $module->deskripsi ?? 'Deskripsi lengkap tentang topik ini.' }}</p>
            </div>
        </div>
    </div>

    <!-- Tahap 4: Transfer of Training (Pilihan Asesmen & LKPD) -->
    @php
        $stageAssessments = $module->assessments->whereNotIn('jenis', ['pre_test', 'post_test'])->sortBy('urutan');
    @endphp
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <span class="inline-block px-3 py-1 bg-purple-50 text-purple-800 text-[10px] font-black rounded-md uppercase tracking-wider border border-purple-100 mb-1.5">
                    Instrumen Asesmen Online
                </span>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 leading-tight">Pilih Lembar Kerja & Asesmen</h2>
                <p class="text-xs text-slate-500 font-semibold mt-1">Selesaikan 3 instrumen di bawah ini untuk melengkapi evaluasi bimbingan pada Topik {{ $module->urutan }}.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($stageAssessments as $assessment)
                @php
                    $assessmentProgress = \App\Models\StudentProgress::where('student_id', auth()->user()->student->id)
                        ->where('assessment_id', $assessment->id)
                        ->first();
                    $canAccess = app(\App\Services\ProgressService::class)->canAccessAssessment(auth()->user()->student, $assessment);
                    $isCompleted = $assessmentProgress?->status === 'selesai';
                    $hasQuestions = $assessment->questions->count() > 0;
                    
                    // Theme color per index
                    $themeColors = [
                        1 => ['bg' => 'from-blue-50 to-indigo-50/40', 'border' => 'border-blue-200/80', 'badge' => 'bg-blue-600', 'btn' => 'bg-blue-600 hover:bg-blue-700', 'icon' => 'assignment', 'type' => 'LKPD ONLINE'],
                        2 => ['bg' => 'from-emerald-50 to-teal-50/40', 'border' => 'border-emerald-200/80', 'badge' => 'bg-emerald-600', 'btn' => 'bg-emerald-600 hover:bg-emerald-700', 'icon' => 'favorite', 'type' => 'PENILAIAN DIRI'],
                        3 => ['bg' => 'from-amber-50 to-orange-50/40', 'border' => 'border-amber-200/80', 'badge' => 'bg-amber-600', 'btn' => 'bg-amber-600 hover:bg-amber-700', 'icon' => 'handshake', 'type' => 'LEMBAR KOMITMEN'],
                    ];
                    $color = $themeColors[$loop->iteration] ?? $themeColors[1];
                @endphp
                <div class="bg-gradient-to-b {{ $color['bg'] }} rounded-3xl border {{ $color['border'] }} p-6 shadow-xs flex flex-col justify-between hover:shadow-md transition-all relative overflow-hidden">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded-xl text-white flex items-center justify-center font-black text-xs shadow-2xs {{ $color['badge'] }}">
                                    0{{ $loop->iteration }}
                                </span>
                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-500">
                                    {{ $color['type'] }}
                                </span>
                            </div>
                            @if($isCompleted)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    <span class="material-symbols-outlined text-[12px]">check_circle</span>
                                    Selesai ({{ number_format($assessmentProgress->nilai, 0) }}%)
                                </span>
                            @elseif($canAccess && $hasQuestions)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black bg-purple-100 text-purple-800 border border-purple-200">
                                    Tersedia
                                </span>
                            @elseif(!$hasQuestions)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black bg-slate-100 text-slate-500 border border-slate-200">
                                    Segera Hadir
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black bg-slate-100 text-slate-500 border border-slate-200">
                                    Terkunci
                                </span>
                            @endif
                        </div>

                        <h3 class="text-base font-black text-slate-900 leading-snug mb-2 min-h-[44px]">
                            {{ $assessment->judul }}
                        </h3>
                        <p class="text-xs text-slate-500 font-bold mb-6 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-slate-400">checklist</span>
                            {{ $assessment->questions->count() }} Butir Pertanyaan
                        </p>
                    </div>

                    <div class="pt-4 border-t border-slate-200/60">
                        @if($isCompleted)
                            <a href="{{ route('student.assessment.show', $assessment->id) }}" class="w-full inline-flex items-center justify-center px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-black text-xs transition shadow-2xs gap-2 cursor-pointer">
                                <span class="material-symbols-outlined text-[16px]">visibility</span>
                                Lihat Hasil Pengerjaan
                            </a>
                        @elseif($canAccess && $hasQuestions)
                            <a href="{{ route('student.assessment.show', $assessment->id) }}" class="w-full inline-flex items-center justify-center px-5 py-3 {{ $color['btn'] }} text-white rounded-xl font-black text-xs transition shadow-2xs gap-2 cursor-pointer">
                                <span class="material-symbols-outlined text-[16px]">quiz</span>
                                Mulai Kerjakan
                            </a>
                        @elseif(!$hasQuestions)
                            <button disabled class="w-full inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-400 rounded-xl font-bold text-xs cursor-not-allowed border border-slate-200 gap-1.5">
                                <span class="material-symbols-outlined text-[16px]">schedule</span>
                                Belum Ada Soal
                            </button>
                        @else
                            <button disabled class="w-full inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-400 rounded-xl font-bold text-xs cursor-not-allowed border border-slate-200 gap-1.5">
                                <span class="material-symbols-outlined text-[16px]">lock</span>
                                Terkunci
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white rounded-3xl border border-slate-200 p-12 text-center text-xs text-slate-400 font-bold">
                    Belum ada instrumen asesmen pada topik ini.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
