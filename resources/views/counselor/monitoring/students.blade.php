<x-app-layout>
    <x-slot name="title">Data Siswa - {{ $kelas->nama_kelas ?? 'Kelas' }}</x-slot>

    <!-- Breadcrumb -->
    <nav class="flex text-xs text-slate-400 font-semibold mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
                <a href="{{ route('counselor.monitoring.schools') }}" class="hover:text-indigo-600 transition-colors">Sekolah</a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="mx-1 text-slate-300">/</span>
                    <a href="{{ route('counselor.monitoring.kelas', $kelas->school_id ?? 1) }}" class="hover:text-indigo-600 transition-colors">{{ $kelas->school->nama ?? 'Sekolah' }}</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="mx-1 text-slate-300">/</span>
                    <span class="text-slate-700 font-bold">{{ $kelas->nama_kelas ?? 'Kelas' }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-md border border-indigo-100 uppercase tracking-wider">
                    Monitoring Peserta Didik
                </span>
                <span class="text-xs font-bold text-slate-400">{{ $kelas->school->nama ?? 'Sekolah' }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Kelas: {{ $kelas->nama_kelas ?? 'Kelas' }}</h1>
            <p class="mt-1 text-xs sm:text-sm text-slate-500 font-medium">Pantau ketercapaian dan kemajuan asesmen empati siswa secara real-time.</p>
        </div>
        <div class="flex items-center gap-2.5 flex-wrap">
            <a href="{{ route('counselor.evaluasi', ['kelas_id' => $kelas->id, 'school_id' => $kelas->school_id]) }}" 
               class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-extrabold rounded-xl shadow-xs transition cursor-pointer">
                <span class="material-symbols-outlined text-sm">rate_review</span>
                Evaluasi Kelas
            </a>
            <a href="{{ route('counselor.reports.kelas', $kelas->id) }}" 
               class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-extrabold rounded-xl shadow-2xs transition">
                <span class="material-symbols-outlined text-sm text-slate-500">description</span>
                Laporan Kelas
            </a>
        </div>
    </div>

    <!-- Summary Metrics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3.5 mb-8">
        <div class="p-4 bg-white rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between mb-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Siswa</span>
                <span class="material-symbols-outlined text-slate-400 text-base">groups</span>
            </div>
            <p class="text-xl font-black text-slate-800">{{ $totalSiswa ?? count($studentsData ?? []) }}</p>
            <p class="text-[10px] text-slate-400 font-medium mt-0.5">Terdaftar di kelas</p>
        </div>

        <div class="p-4 bg-white rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between mb-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Rata-rata Kelas</span>
                <span class="material-symbols-outlined text-indigo-500 text-base">trending_up</span>
            </div>
            <p class="text-xl font-black text-indigo-600">{{ $avgProgress ?? 0 }}%</p>
            <p class="text-[10px] text-slate-400 font-medium mt-0.5">Kemajuan materi</p>
        </div>

        <div class="p-4 bg-white rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between mb-1">
                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Selesai Program</span>
                <span class="material-symbols-outlined text-emerald-500 text-base">check_circle</span>
            </div>
            <p class="text-xl font-black text-emerald-600">{{ $totalSelesai ?? 0 }}</p>
            <p class="text-[10px] text-slate-400 font-medium mt-0.5">100% tuntas</p>
        </div>

        <div class="p-4 bg-white rounded-2xl border border-slate-200/80 shadow-2xs">
            <div class="flex items-center justify-between mb-1">
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Sedang Berjalan</span>
                <span class="material-symbols-outlined text-blue-500 text-base">timelapse</span>
            </div>
            <p class="text-xl font-black text-blue-600">{{ $totalSedang ?? 0 }}</p>
            <p class="text-[10px] text-slate-400 font-medium mt-0.5">Proses pengerjaan</p>
        </div>

        <div class="p-4 bg-white rounded-2xl border border-slate-200/80 shadow-2xs col-span-2 lg:col-span-1">
            <div class="flex items-center justify-between mb-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Belum Mulai</span>
                <span class="material-symbols-outlined text-slate-400 text-base">hourglass_empty</span>
            </div>
            <p class="text-xl font-black text-slate-600">{{ $totalBelum ?? 0 }}</p>
            <p class="text-[10px] text-slate-400 font-medium mt-0.5">Perlu dorongan</p>
        </div>
    </div>

    <!-- Students Table -->
    <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 js-datatable">
                <thead class="bg-slate-50/70">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Peserta Didik</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Tahap Aktif</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Total Progress</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-black text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse($studentsData ?? [] as $data)
                    @php
                        $student = is_array($data) ? $data['student'] : $data->student;
                        $currentStage = is_array($data) ? ($data['current_stage'] ?? '-') : ($data->current_stage ?? '-');
                        $currentModule = is_array($data) ? ($data['current_module'] ?? null) : ($data->current_module ?? null);
                        $activeAssessment = is_array($data) ? ($data['active_assessment'] ?? null) : ($data->active_assessment ?? null);
                        $stageDetails = is_array($data) ? ($data['stage_details'] ?? null) : ($data->stage_details ?? null);
                        $progressPercentage = is_array($data) ? ($data['progress_percentage'] ?? 0) : ($data->progress_percentage ?? 0);
                        $status = is_array($data) ? ($data['status'] ?? 'Belum Mulai') : ($data->status ?? 'Belum Mulai');
                        $isCompleted = is_array($data) ? ($data['is_completed'] ?? false) : ($data->is_completed ?? false);
                        $studentNama = $student->user->nama ?? $student->nama ?? 'Siswa';
                        $studentNis = $student->nis ?? '-';
                        $studentId = $student->id;
                    @endphp
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <!-- Nama Siswa -->
                        <td class="px-6 py-4.5 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-9 w-9 rounded-2xl bg-indigo-50 border border-indigo-100/80 flex items-center justify-center text-indigo-700 font-black mr-3 text-xs shadow-2xs">
                                    {{ strtoupper(substr($studentNama, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-sm font-black text-slate-800">{{ $studentNama }}</div>
                                    <div class="text-xs text-slate-400 font-semibold mt-0.5">NIS: {{ $studentNis }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Tahap Aktif -->
                        <td class="px-6 py-4.5 whitespace-nowrap">
                            @if($isCompleted)
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200/60 text-xs font-black">
                                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                    Program Selesai
                                </div>
                            @elseif($currentModule)
                                <div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-1.5 py-0.5 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded border border-indigo-100">
                                            Topik {{ $currentModule->urutan }}
                                        </span>
                                        <span class="text-xs font-black text-slate-800 truncate max-w-[200px]" title="{{ $currentModule->judul }}">
                                            {{ $currentModule->judul }}
                                        </span>
                                    </div>
                                    @if($stageDetails)
                                        <div class="text-[11px] font-semibold text-slate-500 mt-1 flex items-center gap-1">
                                            @if($activeAssessment)
                                                <span class="material-symbols-outlined text-[13px] text-indigo-500">arrow_right</span>
                                                <span class="text-indigo-700 font-bold truncate max-w-[150px]" title="{{ $activeAssessment->judul }}">{{ $activeAssessment->judul }}</span>
                                            @endif
                                            <span class="text-slate-400">({{ $stageDetails->completed_assessments }}/{{ $stageDetails->total_assessments }} Selesai)</span>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <span class="text-xs font-black text-slate-700">{{ $currentStage }}</span>
                            @endif
                        </td>

                        <!-- Progress Bar & Percentage -->
                        <td class="px-6 py-4.5 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-28 bg-slate-100 rounded-full h-2.5 overflow-hidden p-0.5 border border-slate-200/60">
                                    <div class="h-full rounded-full transition-all duration-500 {{ $progressPercentage >= 100 ? 'bg-emerald-500' : ($progressPercentage > 0 ? 'bg-gradient-to-r from-indigo-500 to-emerald-500' : 'bg-slate-300') }}" 
                                         style="width: {{ $progressPercentage }}%"></div>
                                </div>
                                <span class="text-xs font-black text-slate-800">{{ $progressPercentage }}%</span>
                            </div>
                        </td>

                        <!-- Status Badge -->
                        <td class="px-6 py-4.5 whitespace-nowrap">
                            @if($isCompleted || $progressPercentage >= 100)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-black rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200/60 shadow-2xs">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Selesai
                                </span>
                            @elseif($status === 'Sedang Mengerjakan')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-black rounded-xl bg-amber-50 text-amber-800 border border-amber-200/60 shadow-2xs">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Sedang Mengerjakan
                                </span>
                            @elseif($progressPercentage > 0 || $status === 'Sedang Berjalan')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-black rounded-xl bg-blue-50 text-blue-700 border border-blue-200/60 shadow-2xs">
                                    <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                    Sedang Berjalan
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-xl bg-slate-100 text-slate-600 border border-slate-200/60">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                    Belum Mulai
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4.5 whitespace-nowrap text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('counselor.evaluasi', ['student_id' => $studentId, 'kelas_id' => $kelas->id, 'school_id' => $kelas->school_id]) }}" 
                                   title="Buka Lembar Evaluasi Siswa"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-extrabold bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition shadow-2xs">
                                    <span class="material-symbols-outlined text-[14px]">rate_review</span>
                                    Evaluasi
                                </a>
                                <a href="{{ route('counselor.monitoring.student.detail', $studentId) }}" 
                                   title="Lihat Detail Progress Bimbingan"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-extrabold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition shadow-2xs">
                                    <span class="material-symbols-outlined text-[14px]">visibility</span>
                                    Detail
                                </a>
                                <a href="{{ route('counselor.monitoring.student.certificate', $studentId) }}" 
                                   target="_blank"
                                   title="Cetak Sertifikat (Web / PDF)"
                                   class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl text-xs font-extrabold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200/60 transition shadow-2xs">
                                    <span class="material-symbols-outlined text-[14px]">workspace_premium</span>
                                    Sertifikat
                                </a>
                                <a href="{{ route('counselor.monitoring.student.certificate.docx', $studentId) }}" 
                                   title="Unduh Sertifikat Format Word (.docx)"
                                   class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl text-xs font-extrabold bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200/60 transition shadow-2xs">
                                    <span class="material-symbols-outlined text-[14px]">description</span>
                                    Word
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 whitespace-nowrap text-center text-sm text-slate-400">
                            <span class="material-symbols-outlined text-4xl text-slate-300 block mb-2">person_off</span>
                            Tidak ada data siswa di kelas ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
