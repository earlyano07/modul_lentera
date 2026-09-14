<x-app-layout>
    <x-slot name="title">Laporan Kelas - {{ $kelas->nama_kelas ?? 'Kelas' }}</x-slot>

    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('counselor.monitoring.students', $kelas->id) }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Monitoring
        </a>
        <a href="{{ route('counselor.reports.kelas.pdf', $kelas->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-emerald-700 transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak PDF
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="bg-gray-50 p-6 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-emerald-600 text-white rounded-lg flex items-center justify-center text-2xl font-bold shadow-md">
                    {{ $kelas->tingkat ?? 'X' }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Laporan Kelas: {{ $kelas->nama_kelas ?? 'Kelas' }}</h2>
                    <p class="text-gray-500">{{ $kelas->school->nama ?? 'Sekolah' }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Total Siswa:</p>
                <p class="font-bold text-xl text-gray-900">{{ count($studentsData ?? []) }}</p>
            </div>
        </div>

        <div class="p-8">
            <!-- Summary Stats -->
            @php
                $totalSelesai = collect($studentsData ?? [])->where('is_completed', true)->count();
                $totalSedang = collect($studentsData ?? [])->where('is_completed', false)->filter(fn($s) => ($s->progress_percentage ?? 0) > 0)->count();
                $totalBelum = collect($studentsData ?? [])->filter(fn($s) => ($s->progress_percentage ?? 0) == 0)->count();
                
                $totalSiswa = count($studentsData ?? []);
                $persentaseSelesai = $totalSiswa > 0 ? round(($totalSelesai / $totalSiswa) * 100) : 0;
            @endphp
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-center">
                    <p class="text-sm text-gray-500 mb-1">Penyelesaian Kelas</p>
                    <p class="text-2xl font-bold text-emerald-600">{{ $persentaseSelesai }}%</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg border border-green-100 text-center">
                    <p class="text-sm text-green-600 mb-1">Selesai Program</p>
                    <p class="text-2xl font-bold text-green-700">{{ $totalSelesai }} Siswa</p>
                </div>
                <div class="bg-amber-50 p-4 rounded-lg border border-amber-100 text-center">
                    <p class="text-sm text-amber-600 mb-1">Sedang Mengerjakan</p>
                    <p class="text-2xl font-bold text-amber-700">{{ $totalSedang }} Siswa</p>
                </div>
                <div class="bg-red-50 p-4 rounded-lg border border-red-100 text-center">
                    <p class="text-sm text-red-600 mb-1">Belum Mulai</p>
                    <p class="text-2xl font-bold text-red-700">{{ $totalBelum }} Siswa</p>
                </div>
            </div>

            <!-- Students Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 js-datatable">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider w-12">No</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Siswa</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">NIS</th>
                            <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Progress</th>
                            <th scope="col" class="px-6 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($studentsData ?? [] as $index => $data)
                        @php
                            $student = is_array($data) ? $data['student'] : $data->student;
                            $progressPercentage = is_array($data) ? ($data['progress_percentage'] ?? 0) : ($data->progress_percentage ?? 0);
                            $isCompleted = is_array($data) ? ($data['is_completed'] ?? false) : ($data->is_completed ?? false);
                            $studentNama = $student->user->nama ?? $student->nama ?? 'Siswa';
                            $studentNis = $student->nis ?? '-';
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-center text-xs font-bold text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-extrabold text-sm text-slate-800">{{ $studentNama }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-600">{{ $studentNis }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center gap-2 justify-center">
                                    <div class="w-20 bg-slate-100 rounded-full h-2">
                                        <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                                    </div>
                                    <span class="text-xs font-bold text-slate-700 w-8 text-right">{{ $progressPercentage }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
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
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 whitespace-nowrap text-center text-sm text-slate-400">Belum ada data siswa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
