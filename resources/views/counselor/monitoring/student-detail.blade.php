<x-app-layout>
    <x-slot name="title">Detail Siswa - {{ $student->nama ?? 'Siswa' }}</x-slot>

    <div class="mb-6">
        <a href="javascript:history.back()" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                    {{ substr($student->nama ?? 'S', 0, 1) }}
                </div>
                <h2 class="text-xl font-bold text-center text-gray-900">{{ $student->nama ?? 'Nama Siswa' }}</h2>
                <p class="text-center text-gray-500 text-sm mb-6">NIS: {{ $student->nis ?? '-' }}</p>

                <div class="space-y-3">
                    <div class="flex justify-between pb-3 border-b border-gray-100">
                        <span class="text-gray-500 text-sm">Sekolah</span>
                        <span class="text-gray-950 font-medium text-sm">{{ $student->kelas->school->nama ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between pb-3 border-b border-gray-100">
                        <span class="text-gray-500 text-sm">Kelas</span>
                        <span class="text-gray-900 font-medium text-sm">{{ $student->kelas->nama_kelas ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between pb-3 border-b border-gray-100">
                        <span class="text-gray-500 text-sm">Status</span>
                        @if(($progressPercentage ?? 0) >= 100)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Selesai</span>
                        @elseif(($progressPercentage ?? 0) > 0)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">Sedang</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Belum Mulai</span>
                        @endif
                    </div>
                </div>

                <div class="mt-8">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Total Progress</span>
                        <span class="text-sm font-bold text-emerald-600">{{ $progressPercentage ?? 0 }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-emerald-400 to-emerald-600 h-2 rounded-full" style="width: {{ $progressPercentage ?? 0 }}%"></div>
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3">
                    <a href="{{ route('counselor.reports.student', $student->id) }}" class="w-full flex justify-center items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-medium transition-colors shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Lihat Laporan Penuh
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Timeline -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Timeline Pembelajaran</h3>
                
                <div class="relative border-l-2 border-gray-200 ml-4 space-y-8">
                    @forelse($timeline ?? [] as $item)
                    <div class="relative pl-8">
                        @if($item['status'] === 'completed')
                            <div class="absolute -left-[11px] top-1 w-5 h-5 rounded-full bg-green-500 border-4 border-white shadow flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        @elseif($item['status'] === 'in_progress')
                            <div class="absolute -left-[11px] top-1 w-5 h-5 rounded-full bg-amber-500 border-4 border-white shadow flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        @elseif($item['status'] === 'available')
                            <div class="absolute -left-[11px] top-1 w-5 h-5 rounded-full bg-blue-500 border-4 border-white shadow flex items-center justify-center"></div>
                        @else
                            <div class="absolute -left-[11px] top-1 w-5 h-5 rounded-full bg-gray-300 border-4 border-white shadow flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                        @endif
                        
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-base font-semibold text-gray-900">{{ $item['title'] ?? 'Modul' }}</h4>
                                @if(isset($item['score']))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                                        Nilai: {{ $item['score'] }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500">{{ $item['type_label'] ?? 'Materi' }}</p>
                            @if(isset($item['completed_at']))
                                <p class="text-xs text-gray-400 mt-2">Diselesaikan pada: {{ \Carbon\Carbon::parse($item['completed_at'])->format('d M Y, H:i') }}</p>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="pl-8 text-gray-500 text-sm">Belum ada aktivitas pembelajaran.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
