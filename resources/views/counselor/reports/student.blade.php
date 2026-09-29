<x-app-layout>
    <x-slot name="title">Laporan Siswa - {{ $student->nama ?? 'Siswa' }}</x-slot>

    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('counselor.monitoring.student.detail', $student->id) }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Detail
        </a>
        <a href="{{ route('counselor.reports.student.pdf', $student->id) }}?print=1" target="_blank" class="inline-flex items-center px-4 py-2.5 bg-emerald-600 border border-transparent rounded-xl text-xs sm:text-sm font-bold text-white hover:bg-emerald-700 transition-all shadow-sm gap-2">
            <span class="material-symbols-outlined text-base">print</span>
            Cetak / Unduh PDF (A4)
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" id="report-container">
        <!-- Header -->
        <div class="bg-gray-50 p-6 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-emerald-600 text-white rounded-lg flex items-center justify-center text-2xl font-bold shadow-md">
                    L
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Laporan Hasil Belajar</h2>
                    <p class="text-gray-500">Program LENTERA LMS</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Tanggal Cetak:</p>
                <p class="font-medium text-gray-900">{{ date('d F Y') }}</p>
            </div>
        </div>

        <div class="p-8">
            <!-- Student Identity -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Identitas Siswa</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                    <div class="grid grid-cols-3 gap-2">
                        <div class="text-gray-500 text-sm">Nama Lengkap</div>
                        <div class="col-span-2 font-medium text-gray-900 text-sm">: {{ $student->nama ?? '-' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="text-gray-500 text-sm">NIS</div>
                        <div class="col-span-2 font-medium text-gray-900 text-sm">: {{ $student->nis ?? '-' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="text-gray-500 text-sm">Sekolah</div>
                        <div class="col-span-2 font-medium text-gray-900 text-sm">: {{ $student->kelas->school->nama ?? '-' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="text-gray-500 text-sm">Kelas</div>
                        <div class="col-span-2 font-medium text-gray-900 text-sm">: {{ $student->kelas->nama_kelas ?? '-' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="text-gray-500 text-sm">Jenis Kelamin</div>
                        <div class="col-span-2 font-medium text-gray-900 text-sm">: {{ $student->jenis_kelamin ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Progress Overview -->
            <div class="mb-8 p-6 bg-emerald-50 rounded-xl border border-emerald-100 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h4 class="text-emerald-900 font-bold mb-1">Status Penyelesaian Program</h4>
                    <p class="text-emerald-700 text-sm">Berdasarkan seluruh modul dan asesmen yang tersedia.</p>
                </div>
                <div class="flex items-center gap-4 w-full md:w-1/2">
                    <div class="w-full bg-white rounded-full h-4 border border-emerald-200">
                        <div class="bg-gradient-to-r from-emerald-400 to-emerald-600 h-full rounded-full" style="width: {{ $progressPercentage ?? 0 }}%"></div>
                    </div>
                    <span class="text-xl font-bold text-emerald-800">{{ $progressPercentage ?? 0 }}%</span>
                </div>
            </div>

            <!-- Assessment Results -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Hasil Asesmen</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 border border-gray-200 js-datatable">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th scope="col" class="px-6 py-3 border-r border-gray-200">Nama Asesmen</th>
                                <th scope="col" class="px-6 py-3 border-r border-gray-200">Modul</th>
                                <th scope="col" class="px-6 py-3 border-r border-gray-200 text-center">Nilai</th>
                                <th scope="col" class="px-6 py-3 border-r border-gray-200 text-center">Kategori</th>
                                <th scope="col" class="px-6 py-3">Tanggal Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assessmentResults ?? [] as $result)
                            @php
                                $val = (float)($result->nilai ?? $result->score ?? 0);
                                $cat = \App\Models\StudentEvaluation::getCategoryFromPercentage($val);
                            @endphp
                            <tr class="bg-white border-b border-gray-200 hover:bg-slate-50/60 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-900 border-r border-gray-200">{{ $result->assessment->judul ?? 'Asesmen' }}</td>
                                <td class="px-6 py-4 border-r border-gray-200 font-medium text-gray-600">{{ $result->assessment->module->judul ?? '-' }}</td>
                                <td class="px-6 py-4 text-center border-r border-gray-200">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-lg font-black text-xs {{ $val >= 75 ? 'bg-emerald-100 text-emerald-800' : ($val >= 65 ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                                        {{ number_format($val, 0) }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center border-r border-gray-200">
                                    <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $cat['badge'] ?? 'bg-slate-100 text-slate-700' }}">
                                        {{ $cat['category'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-medium">{{ \Carbon\Carbon::parse($result->finished_at ?? $result->created_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-6 text-center text-gray-500">Belum ada asesmen yang diselesaikan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if(isset($evaluations) && $evaluations->count() > 0)
            <!-- Counselor Evaluation & Notes -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Catatan & Evaluasi Konselor</h3>
                <div class="space-y-4">
                    @foreach($evaluations as $eval)
                    @php
                        $cat = $eval->category;
                        $hasNotes = $eval->notes || $eval->self_note || $eval->commitment_note || $eval->lkpd_note;
                    @endphp
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                            <h4 class="font-extrabold text-sm text-slate-800 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                Topik {{ $eval->module->urutan ?? 1 }}: {{ $eval->module->judul ?? 'Modul' }}
                            </h4>
                            @if($cat)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $cat['badge'] ?? 'bg-indigo-100 text-indigo-800' }}">
                                Capaian: {{ $cat['category'] }} ({{ number_format($eval->percentage, 0) }}%)
                            </span>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-3 text-xs">
                            <div class="bg-white p-3 rounded-lg border border-slate-100">
                                <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider mb-0.5">Penilaian Diri:</span>
                                <span class="font-bold text-slate-700">{{ $eval->self_score !== null ? $eval->self_score . ' Poin' : '-' }}</span>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-slate-100">
                                <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider mb-0.5">Refleksi Diri:</span>
                                <span class="font-bold text-slate-700">{{ $eval->lkpd_score !== null ? $eval->lkpd_score . ' Poin' : '-' }}</span>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-slate-100">
                                <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider mb-0.5">Lembar Komitmen:</span>
                                <span class="font-bold text-slate-700">{{ $eval->commitment_score !== null ? $eval->commitment_score . ' Poin' : '-' }}</span>
                            </div>
                        </div>

                        @if($hasNotes)
                        <div class="text-xs text-slate-700 leading-relaxed font-medium bg-white p-3.5 rounded-lg border border-slate-100">
                            <span class="text-slate-500 block text-[10px] uppercase font-black tracking-wider mb-1">Catatan Perkembangan Konselor:</span>
                            <p>{{ $eval->notes ?: ($eval->self_note ?: ($eval->commitment_note ?: $eval->lkpd_note)) }}</p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
