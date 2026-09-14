<x-app-layout>
    <x-slot name="title">Data Siswa - {{ $kelas->nama_kelas ?? 'Kelas' }}</x-slot>

    <!-- Breadcrumb -->
    <nav class="flex text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('counselor.monitoring.schools') }}" class="hover:text-emerald-600 transition-colors">Sekolah</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="{{ route('counselor.monitoring.kelas', $kelas->school_id ?? 1) }}" class="hover:text-emerald-600 transition-colors">{{ $kelas->school->nama ?? 'Sekolah' }}</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="text-gray-900 font-medium">{{ $kelas->nama_kelas ?? 'Kelas' }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Monitoring Siswa: {{ $kelas->nama_kelas ?? 'Kelas' }}</h1>
            <p class="mt-1 text-gray-600">Pantau progres pembelajaran siswa.</p>
        </div>
        <a href="{{ route('counselor.reports.kelas', $kelas->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Laporan Kelas
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 js-datatable">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Siswa</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tahap Aktif</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Progress</th>
                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse($studentsData ?? [] as $data)
                    @php
                        $student = is_array($data) ? $data['student'] : $data->student;
                        $currentStage = is_array($data) ? ($data['current_stage'] ?? '-') : ($data->current_stage ?? '-');
                        $progressPercentage = is_array($data) ? ($data['progress_percentage'] ?? 0) : ($data->progress_percentage ?? 0);
                        $isCompleted = is_array($data) ? ($data['is_completed'] ?? false) : ($data->is_completed ?? false);
                        $studentNama = $student->user->nama ?? $student->nama ?? 'Siswa';
                        $studentNis = $student->nis ?? '-';
                        $studentId = $student->id;
                    @endphp
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 font-extrabold mr-3 text-xs shadow-2xs">
                                    {{ substr($studentNama, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-extrabold text-slate-800">{{ $studentNama }}</div>
                                    <div class="text-xs text-slate-500 font-medium">NIS: {{ $studentNis }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-xs font-extrabold text-slate-700">{{ $currentStage }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-24 bg-slate-100 rounded-full h-2">
                                    <div class="bg-emerald-500 h-2 rounded-full transition-all duration-300" style="width: {{ $progressPercentage }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-700">{{ $progressPercentage }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($isCompleted)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Selesai
                                </span>
                            @elseif($progressPercentage > 0)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-md bg-amber-50 text-amber-700 border border-amber-200/50">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                    Sedang
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-md bg-slate-100 text-slate-600 border border-slate-200/50">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                    Belum Mulai
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            <a href="{{ route('counselor.monitoring.student.detail', $studentId) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-extrabold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition shadow-2xs">
                                <span class="material-symbols-outlined text-[14px]">visibility</span>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 whitespace-nowrap text-center text-sm text-slate-400">
                            Tidak ada data siswa di kelas ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
