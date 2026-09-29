<x-app-layout>
    <x-slot name="title">Hasil Asesmen - {{ $assessment->judul ?? 'Asesmen' }}</x-slot>

    <div class="max-w-2xl mx-auto my-6">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden text-center">

            @php
                $score = (float) ($progress->nilai ?? 0);
                $catInfo = \App\Models\StudentEvaluation::getCategoryFromPercentage($score);
                $gradientClass = match ($catInfo['color']) {
                    'emerald' => 'bg-gradient-to-br from-emerald-600 to-teal-700',
                    'blue' => 'bg-gradient-to-br from-blue-600 to-indigo-700',
                    'amber' => 'bg-gradient-to-br from-amber-500 to-amber-700',
                    'orange' => 'bg-gradient-to-br from-orange-500 to-orange-700',
                    default => 'bg-gradient-to-br from-rose-500 to-rose-700',
                };
            @endphp

            <div class="{{ $gradientClass }} p-10 text-white relative">
                <div class="relative z-10">
                    <span
                        class="inline-block px-3 py-1 bg-white/20 backdrop-blur rounded-full text-[10px] font-black uppercase tracking-wider mb-3">
                        @if ($assessment->jenis === 'penilaian_diri')
                            Penilaian Diri Siswa
                        @elseif($assessment->jenis === 'refleksi_diri')
                            Refleksi Diri Siswa
                        @elseif($assessment->jenis === 'lembar_komitmen')
                            Lembar Komitmen Siswa
                        @else
                            Tahap 4 • Transfer of Training Selesai
                        @endif
                    </span>
                    <h2 class="text-xs font-bold uppercase tracking-widest opacity-90 mb-1">Capaian Asesmen Siswa</h2>
                    <div class="text-6xl sm:text-7xl font-black mb-1 drop-shadow-xs">
                        {{ number_format($score, 0) }}<span class="text-3xl font-bold opacity-80">%</span>
                    </div>
                    <p class="text-xs font-extrabold uppercase tracking-wider opacity-90 mb-3">
                        Kategori: <span class="underline font-black">{{ $catInfo['category'] }}</span>
                    </p>
                    <div
                        class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-white/20 backdrop-blur text-xs font-extrabold shadow-2xs max-w-md mx-auto">
                        <span class="material-symbols-outlined text-[16px] shrink-0">info</span>
                        <span class="leading-snug">{{ $catInfo['meaning'] }}</span>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-8">
                <h3 class="text-xl sm:text-2xl font-black text-slate-800 mb-1">
                    {{ $assessment->judul ?? 'Asesmen Siswa' }}</h3>
                <p class="text-xs sm:text-sm font-bold text-slate-500 mb-6">Topik
                    {{ $assessment->module->urutan ?? 1 }}: {{ $assessment->module->judul ?? 'Modul' }}</p>

                <div class="grid grid-cols-2 gap-4 mb-6 text-left">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70">
                        <span class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Waktu
                            Selesai</span>
                        <span
                            class="block text-xs font-extrabold text-slate-800">{{ \Carbon\Carbon::parse($progress->finished_at ?? ($progress->updated_at ?? now()))->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/70">
                        <span class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Status
                            Integrasi</span>
                        <span class="inline-flex items-center gap-1 text-xs font-black text-emerald-700">
                            <span class="material-symbols-outlined text-[14px]">sync_saved_locally</span>
                            Tersimpan ke Konselor
                        </span>
                    </div>
                </div>

                <!-- Hasil Pilihan dan Catatan Komitmen Siswa -->
                @if (!empty($progress->answers) && $assessment->questions->isNotEmpty())
                    <div class="mb-6 text-left bg-amber-50/60 border border-amber-200/80 rounded-2xl p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="material-symbols-outlined text-amber-600 text-lg">fact_check</span>
                            <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider">
                                {{ $assessment->jenis === 'lembar_komitmen' || str_contains(strtolower($assessment->judul), 'komitmen') ? 'Pilihan Komitmen & Catatan Anda' : 'Ringkasan Jawaban Anda' }}
                            </h4>
                        </div>

                        <div class="space-y-3 text-xs">
                            @foreach ($assessment->questions as $q)
                                @php
                                    $ans = $progress->answers[$q->id] ?? null;
                                @endphp
                                <div class="bg-white p-3.5 rounded-xl border border-amber-100 shadow-2xs space-y-1.5">
                                    <p class="font-extrabold text-slate-800 text-xs leading-snug">
                                        {{ $loop->iteration }}. {{ $q->question }}
                                    </p>

                                    @if ($q->type === 'checklist')
                                        <div class="space-y-1 pl-1 pt-1">
                                            @foreach ($q->options as $opt)
                                                @php
                                                    $isSelected = is_array($ans)
                                                        ? in_array((string) $opt->id, array_map('strval', $ans))
                                                        : $ans == $opt->id;
                                                @endphp
                                                <div
                                                    class="flex items-start gap-2 text-xs {{ $isSelected ? 'text-emerald-900 font-bold' : 'text-slate-400 font-medium' }}">
                                                    <span
                                                        class="inline-flex items-center justify-center w-4 h-4 rounded shrink-0 mt-0.5 text-[10px] font-black {{ $isSelected ? 'bg-emerald-600 text-white shadow-2xs' : 'bg-slate-100 text-slate-300' }}">
                                                        {{ $isSelected ? '✓' : '' }}
                                                    </span>
                                                    <span
                                                        class="{{ $isSelected ? 'text-slate-800' : 'text-slate-400 line-through decoration-slate-300' }}">
                                                        {{ $opt->option }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($q->type === 'essay')
                                        <div
                                            class="p-3 bg-amber-50/90 rounded-lg border border-amber-200 text-xs text-slate-800 font-medium leading-relaxed">
                                            <span
                                                class="font-bold text-amber-900 text-[10px] block mb-0.5 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[13px]">edit_note</span>
                                                Catatan Komitmen Anda:
                                            </span>
                                            <span
                                                class="italic font-semibold text-slate-900">"{{ $ans ?: 'Tidak ada catatan tertulis.' }}"</span>
                                        </div>
                                    @else
                                        <div class="text-xs text-slate-700 font-semibold pl-1">
                                            @php
                                                $selectedOpt = $q->options->firstWhere(
                                                    'id',
                                                    is_array($ans) ? $ans[0] ?? null : $ans,
                                                );
                                            @endphp
                                            Pilihan Anda:
                                            <span class="text-indigo-600 font-bold">
                                                {{ $selectedOpt ? ($selectedOpt->label ? "({$selectedOpt->label}) " : '') . $selectedOpt->option : ($ans ?: '-') }}
                                            </span>
                                            @if ($selectedOpt && $selectedOpt->score > 0)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 ml-1.5 rounded-md text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                                    Bobot: {{ $selectedOpt->score }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('student.module', $assessment->module_id) }}"
                        class="w-full inline-flex justify-center items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-extrabold rounded-xl transition shadow-xs text-xs sm:text-sm gap-1.5 cursor-pointer">
                        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                        Oke
                    </a>
                    <a href="{{ route('student.roadmap') }}"
                        class="w-full inline-flex justify-center items-center px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold rounded-xl transition text-xs sm:text-sm gap-1.5 cursor-pointer">
                        <span class="material-symbols-outlined text-[16px]">map</span>
                        Roadmap Belajar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
