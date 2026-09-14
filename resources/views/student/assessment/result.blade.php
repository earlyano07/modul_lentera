<x-app-layout>
    <x-slot name="title">Hasil Asesmen - {{ $assessment->judul ?? 'Asesmen' }}</x-slot>

    <div class="max-w-2xl mx-auto my-6">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden text-center">
            
            @php
                $score = $progress->nilai ?? 0;
                $passed = $score >= 70;
            @endphp

            <div class="{{ $passed ? 'bg-gradient-to-br from-emerald-600 to-teal-700' : 'bg-gradient-to-br from-amber-500 to-orange-600' }} p-10 text-white relative">
                <div class="relative z-10">
                    <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur rounded-full text-[10px] font-black uppercase tracking-wider mb-3">
                        @if($assessment->jenis === 'pre_test')
                            Hasil Pre-Test Awal
                        @elseif($assessment->jenis === 'post_test')
                            Hasil Post-Test Akhir
                        @else
                            Tahap 4 • Transfer of Training Selesai
                        @endif
                    </span>
                    <h2 class="text-xs font-bold uppercase tracking-widest opacity-90 mb-1">Skor Asesmen Siswa</h2>
                    <div class="text-6xl sm:text-7xl font-black mb-3 drop-shadow-xs">
                        {{ number_format($score, 0) }}
                    </div>
                    <div class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-white/20 backdrop-blur text-xs font-extrabold shadow-2xs">
                        @if($passed)
                            <span class="material-symbols-outlined text-[16px]">verified</span>
                            <span>Pemahaman Sangat Baik</span>
                        @else
                            <span class="material-symbols-outlined text-[16px]">trending_up</span>
                            <span>Terus Tingkatkan Empati Anda</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-8">
                <h3 class="text-xl sm:text-2xl font-black text-slate-800 mb-1">{{ $assessment->judul ?? 'Lembar Kerja Peserta Didik (LKPD)' }}</h3>
                <p class="text-xs sm:text-sm font-bold text-slate-500 mb-6">Topik {{ $assessment->module->urutan ?? 1 }}: {{ $assessment->module->judul ?? 'Modul' }}</p>

                <div class="grid grid-cols-2 gap-4 mb-6 text-left">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70">
                        <span class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Waktu Selesai</span>
                        <span class="block text-xs font-extrabold text-slate-800">{{ \Carbon\Carbon::parse($progress->finished_at ?? $progress->updated_at ?? now())->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70">
                        <span class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Status Integrasi</span>
                        <span class="inline-flex items-center gap-1 text-xs font-black text-emerald-700">
                            <span class="material-symbols-outlined text-[14px]">sync_saved_locally</span>
                            Tersimpan ke Konselor
                        </span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('student.module', $assessment->module_id) }}" class="w-full inline-flex justify-center items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-extrabold rounded-xl transition shadow-xs text-xs sm:text-sm gap-1.5 cursor-pointer">
                        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                        Kembali ke Modul
                    </a>
                    <a href="{{ route('student.roadmap') }}" class="w-full inline-flex justify-center items-center px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold rounded-xl transition text-xs sm:text-sm gap-1.5 cursor-pointer">
                        <span class="material-symbols-outlined text-[16px]">map</span>
                        Roadmap Belajar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
