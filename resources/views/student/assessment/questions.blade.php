<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Mengerjakan: {{ $assessment->judul ?? 'Asesmen' }}</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <!-- Material Symbols -->
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
                display: inline-block;
                vertical-align: middle;
            }
        </style>
        <script>
            function confirmClose() {
                if (confirm("Apakah Anda yakin ingin keluar dari ujian? Jawaban Anda saat ini belum disimpan.")) {
                    window.close();
                }
            }
        </script>
    </head>
    <body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex flex-col justify-between">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex justify-between items-center px-6 sticky top-0 z-50 shadow-2xs">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-purple-600 rounded-xl flex items-center justify-center shadow-xs text-white">
                    <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">assignment</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-black text-slate-800 leading-none">LENTERA ASESMEN</span>
                    <span class="text-[9px] text-purple-600 uppercase tracking-widest font-black mt-0.5">
                        Instrumen Asesmen
                    </span>
                </div>
            </div>
            
            <div>
                <a href="{{ route('student.module', $assessment->module_id) }}" onclick="return confirm('Apakah Anda yakin ingin keluar? Jawaban Anda belum disimpan.');" class="inline-flex items-center px-4 py-2 border border-rose-200 text-rose-600 hover:text-rose-800 hover:bg-rose-50 font-extrabold rounded-xl text-xs gap-1.5 transition">
                    <span class="material-symbols-outlined text-[16px]">logout</span>
                    Keluar Ujian
                </a>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 p-4 sm:p-6 flex justify-center items-start">
            @php
                $hasQuestions = $assessment->questions->count() > 0;
                
                // Separate scale (Likert) questions, essay questions, and checklist questions
                $scaleQuestions = $assessment->questions->filter(fn($q) => in_array($q->type, ['single_choice', 'multiple_choice', '']) && $q->options->count() >= 2)->values();
                $essayQuestions = $assessment->questions->filter(fn($q) => $q->type === 'essay')->values();
                $checklistQuestions = $assessment->questions->filter(fn($q) => $q->type === 'checklist')->values();
                
                $firstScale = $scaleQuestions->first();
                $firstLabels = $firstScale?->options->pluck('label')->toArray() ?? [];
                
                // Uniform scale if at least 2 scale questions exist, all have matching labels, and no checklist questions
                $isUniformScale = $scaleQuestions->count() >= 2 
                    && $checklistQuestions->isEmpty()
                    && ($scaleQuestions->count() + $essayQuestions->count() === $assessment->questions->count())
                    && $scaleQuestions->every(fn($q) => $q->options->pluck('label')->toArray() === $firstLabels);
            @endphp

            @if($isUniformScale)
                <!-- LIKERT MATRIX TABLE VIEW (Sesuai Format Gambar Instrumen) -->
                <div class="max-w-4xl w-full">
                    <!-- Header Info -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 sm:p-6 mb-5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4 mb-4">
                            <div>
                                <span class="inline-block px-2.5 py-0.5 rounded-md text-[9px] font-black uppercase tracking-wider bg-purple-100 text-purple-800 mb-1">
                                    {{ \App\Models\Assessment::JENIS_OPTIONS[$assessment->jenis] ?? 'Instrumen Asesmen' }}
                                </span>
                                <h1 class="text-lg sm:text-xl font-black text-slate-900 leading-tight">{{ $assessment->judul ?? 'Asesmen Siswa' }}</h1>
                                <p class="text-xs text-slate-500 font-bold mt-0.5">Topik {{ $assessment->module->urutan ?? 1 }}: {{ $assessment->module->judul ?? 'Modul' }}</p>
                            </div>
                            <div class="text-left sm:text-right">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-indigo-50 text-indigo-700 text-xs font-black border border-indigo-100">
                                    <span class="material-symbols-outlined text-[15px]">quiz</span>
                                    {{ $assessment->questions->count() }} Butir Pernyataan
                                </span>
                            </div>
                        </div>

                        <!-- Narasi Kasus / Situasi Refleksi (Jika Ada) -->
                        @if($assessment->deskripsi)
                            <div class="p-4 sm:p-5 rounded-2xl bg-indigo-50/50 border border-indigo-100/80 text-slate-800 space-y-2 mb-3">
                                <div class="flex items-center gap-2 text-indigo-900 font-black text-xs uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-base">auto_stories</span>
                                    Situasi / Bahan Refleksi
                                </div>
                                <div class="text-xs sm:text-sm font-semibold leading-relaxed whitespace-pre-line text-slate-700">
                                    {{ $assessment->deskripsi }}
                                </div>
                            </div>
                        @endif

                        <!-- Petunjuk Pengerjaan (Sesuai Gambar) -->
                        <div class="flex items-start gap-2.5 text-slate-800 font-bold text-xs sm:text-sm bg-slate-50/80 p-3.5 rounded-xl border border-slate-200/60">
                            <span class="material-symbols-outlined text-indigo-600 text-lg shrink-0 mt-0.5">info</span>
                            <span><strong>Petunjuk:</strong> Pilih satu jawaban yang paling sesuai dengan dirimu pada setiap pernyataan di bawah ini.</span>
                        </div>
                    </div>

                    <!-- Form Pengerjaan Tabel -->
                    <form action="{{ route('student.assessment.submit', $assessment->id) }}" method="POST" id="assessment-form">
                        @csrf

                        <!-- Tabel Matriks Soal -->
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-300 overflow-hidden mb-5">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse min-w-[620px]">
                                    <thead>
                                        <tr class="bg-slate-100 border-b-2 border-slate-300 text-slate-800 text-xs font-black uppercase">
                                            <th class="py-3.5 px-3 text-center w-12 border-r border-slate-300">No</th>
                                            <th class="py-3.5 px-5 border-r border-slate-300">Pernyataan</th>
                                            @foreach($firstScale->options as $opt)
                                                <th class="py-3.5 px-2 text-center w-16 sm:w-20 border-r border-slate-300 last:border-r-0" title="{{ $opt->option }}">
                                                    <span class="text-sm font-black">{{ $opt->label }}</span>
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-300 text-xs sm:text-sm">
                                        @foreach($scaleQuestions as $index => $question)
                                            <tr class="hover:bg-indigo-50/20 transition-colors {{ $loop->odd ? 'bg-white' : 'bg-slate-50/40' }}">
                                                <td class="py-4 px-3 text-center font-black text-slate-600 border-r border-slate-300 align-middle">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="py-4 px-5 font-semibold text-slate-800 leading-relaxed border-r border-slate-300 align-middle">
                                                    {{ $question->question }}
                                                    @if($question->image_path)
                                                        <div class="mt-2 max-w-xs rounded-xl overflow-hidden border border-slate-200">
                                                            <img src="{{ asset('storage/' . $question->image_path) }}" class="w-full h-auto">
                                                        </div>
                                                    @endif
                                                </td>
                                                @foreach($question->options as $option)
                                                    <td class="p-0 text-center border-r border-slate-300 last:border-r-0 align-middle hover:bg-indigo-100/50 transition">
                                                        <label class="w-full h-full min-h-[52px] flex items-center justify-center cursor-pointer p-3">
                                                            <input type="radio" 
                                                                   name="answers[{{ $question->id }}]" 
                                                                   value="{{ $option->id }}" 
                                                                   required 
                                                                   class="w-5 h-5 text-indigo-600 border-slate-400 focus:ring-indigo-500 focus:ring-offset-0 cursor-pointer transition">
                                                        </label>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Keterangan Singkatan Legend (Sesuai Gambar: SS = Sangat Sesuai | S = Sesuai | KS = Kurang Sesuai | TS = Tidak Sesuai) -->
                            <div class="p-4 bg-slate-50 border-t border-slate-300 text-xs font-bold text-slate-700">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-slate-500 font-extrabold text-[11px]">Keterangan:</span>
                                    @foreach($firstScale->options as $opt)
                                        <span class="inline-flex items-center gap-1 bg-white px-2.5 py-1 rounded-md border border-slate-200 shadow-2xs">
                                            <strong class="text-slate-900 font-black">{{ $opt->label }}</strong> = {{ $opt->option }}
                                        </span>
                                        @if(!$loop->last)
                                            <span class="text-slate-300">|</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Catatan Penilaian Tambahan (Sesuai Gambar Dokumen) -->
                            @if($assessment->catatan)
                                <div class="p-3.5 bg-amber-50/80 border-t border-slate-300 text-xs text-amber-950 font-bold flex items-center gap-2">
                                    <span class="material-symbols-outlined text-amber-600 text-base shrink-0">info</span>
                                    <span>{{ $assessment->catatan }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Soal Esai / Komitmen Tambahan (Jika Ada) -->
                        @if($essayQuestions->isNotEmpty())
                            <div class="space-y-4 mb-5">
                                @foreach($essayQuestions as $eIndex => $eQuestion)
                                    <div class="bg-white rounded-2xl shadow-sm border border-slate-300 p-5 sm:p-6">
                                        <div class="flex items-start gap-3 mb-3">
                                            <div class="shrink-0 w-8 h-8 bg-indigo-50 text-indigo-700 rounded-lg flex items-center justify-center font-black text-sm border border-indigo-100">
                                                {{ $scaleQuestions->count() + $eIndex + 1 }}
                                            </div>
                                            <div class="flex-1 pt-1">
                                                <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">
                                                    {{ $eQuestion->question }}
                                                </h3>
                                            </div>
                                        </div>

                                        <div class="p-3 bg-indigo-50/70 border border-indigo-100 rounded-xl flex items-center gap-2 text-xs text-indigo-800 font-semibold mb-3">
                                            <span class="material-symbols-outlined text-indigo-600 text-base shrink-0">edit_note</span>
                                            <span>Tuliskan komitmen atau uraian Anda secara lengkap pada kolom di bawah:</span>
                                        </div>

                                        <div>
                                            <textarea name="answers[{{ $eQuestion->id }}]" 
                                                      rows="4" 
                                                      required 
                                                      placeholder="Tuliskan komitmen Anda di sini..." 
                                                      class="w-full text-xs sm:text-sm font-medium p-4 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 focus:bg-white transition leading-relaxed"></textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Footer Submit Button -->
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <p class="text-xs text-slate-500 font-medium text-center sm:text-left">
                                Periksa kembali seluruh jawaban Anda sebelum mengumpulkan.
                            </p>
                            <button type="submit" 
                                    onclick="return confirm('Apakah Anda yakin telah mengisi semua butir pernyataan dan ingin mengumpulkan jawaban?');"
                                    class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-xl text-xs sm:text-sm transition gap-2 shadow-md hover:shadow-lg cursor-pointer">
                                <span class="material-symbols-outlined text-base">check_circle</span>
                                Kumpulkan Jawaban
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <!-- STEPPER / CARD VIEW (Untuk Checklist & Essay / Pilihan Ganda Standard) -->
                <div class="max-w-3xl w-full" x-data="{ currentIdx: 0, total: {{ count($assessment->questions ?? []) }} }">
                    <!-- Sticky Header with Stepper Progress -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="inline-block px-2.5 py-0.5 rounded-md text-[9px] font-black uppercase tracking-wider bg-purple-100 text-purple-800 mb-1">
                                    {{ \App\Models\Assessment::JENIS_OPTIONS[$assessment->jenis] ?? 'Instrumen Asesmen Online' }}
                                </span>
                                <h2 class="text-base sm:text-lg font-black text-slate-900 leading-tight">{{ $assessment->judul ?? 'Asesmen Siswa' }}</h2>
                                <p class="text-xs text-slate-500 font-bold mt-0.5">Topik {{ $assessment->module->urutan ?? 1 }}: {{ $assessment->module->judul ?? 'Modul' }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-lg sm:text-xl font-black text-purple-700">
                                    Soal <span x-text="currentIdx + 1"></span> dari <span x-text="total"></span>
                                </div>
                                <div class="text-[10px] text-slate-400 uppercase tracking-widest font-extrabold">Progres Pengerjaan</div>
                            </div>
                        </div>
                        <!-- Progress Bar -->
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden mt-4">
                            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 h-full transition-all duration-300 rounded-full" 
                                 :style="'width: ' + (((currentIdx + 1) / total) * 100) + '%'"></div>
                        </div>
                    </div>

                    <!-- Situasi / Catatan (Jika Ada) -->
                    @if($assessment->deskripsi)
                        <div class="p-4 sm:p-5 rounded-2xl bg-indigo-50/50 border border-indigo-100/80 text-slate-800 space-y-2 mb-6">
                            <div class="flex items-center gap-2 text-indigo-900 font-black text-xs uppercase tracking-wider">
                                <span class="material-symbols-outlined text-base">auto_stories</span>
                                Situasi / Bahan Refleksi
                            </div>
                            <div class="text-xs sm:text-sm font-semibold leading-relaxed whitespace-pre-line text-slate-700">
                                {{ $assessment->deskripsi }}
                            </div>
                        </div>
                    @endif

                    @if($assessment->catatan)
                        <div class="p-3.5 bg-amber-50/80 border border-amber-200/80 rounded-2xl text-xs text-amber-950 font-bold flex items-center gap-2 mb-6">
                            <span class="material-symbols-outlined text-amber-600 text-base shrink-0">info</span>
                            <span>{{ $assessment->catatan }}</span>
                        </div>
                    @endif

                    <!-- Form questions -->
                    <form action="{{ route('student.assessment.submit', $assessment->id) }}" method="POST" id="assessment-form">
                        @csrf
                        
                        <div class="mb-8">
                            @forelse($assessment->questions ?? [] as $index => $question)
                                <!-- Each Question Container -->
                                <div x-show="currentIdx === {{ $index }}" 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 transform translate-x-4"
                                     x-transition:enter-end="opacity-100 transform translate-x-0"
                                     class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8 space-y-6">
                                    
                                    <!-- Question Header with Number and Image -->
                                    <div class="space-y-4">
                                        <div class="flex items-start gap-4">
                                            <div class="shrink-0 w-9 h-9 bg-indigo-50 text-indigo-700 rounded-lg flex items-center justify-center font-bold text-base border border-indigo-100/50">
                                                {{ $index + 1 }}
                                            </div>
                                            <div class="pt-1.5 flex-1">
                                                <p class="text-base sm:text-lg font-bold text-slate-900 leading-relaxed">
                                                    {{ $question->question }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Question Image (If Available) -->
                                        @if($question->image_path)
                                            <div class="overflow-hidden rounded-2xl border border-slate-100 shadow-sm max-w-xl mx-auto my-4 aspect-[16/9] bg-slate-50">
                                                <img src="{{ asset('storage/' . $question->image_path) }}" class="w-full h-full object-cover">
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Question Type Specific Content -->
                                    @if($question->type === 'checklist')
                                        <!-- Checklist Hint -->
                                        <div class="p-3 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center gap-2 text-xs text-emerald-800 font-semibold">
                                            <span class="material-symbols-outlined text-emerald-600 text-base shrink-0">checklist</span>
                                            <span>Pilihlah / centang butir komitmen di bawah ini yang kamu sepakati:</span>
                                        </div>

                                        <!-- Checklist Options -->
                                        <div class="space-y-3 pt-1">
                                            @foreach($question->options ?? [] as $optIndex => $option)
                                                <label class="flex items-start p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50/50 hover:border-slate-300 transition-all has-[:checked]:bg-emerald-50/50 has-[:checked]:border-emerald-500 has-[:checked]:ring-1 has-[:checked]:ring-emerald-500 group">
                                                    <div class="flex items-center h-5 mt-0.5">
                                                        <input type="checkbox" 
                                                               name="answers[{{ $question->id }}][]" 
                                                               value="{{ $option->id }}" 
                                                               class="w-5 h-5 text-emerald-600 rounded-md bg-slate-100 border-slate-300 focus:ring-emerald-500 focus:ring-offset-0 transition">
                                                    </div>
                                                    <div class="ml-3.5 flex text-xs sm:text-sm font-semibold text-slate-800 leading-normal">
                                                        {{ $option->option }}
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    @elseif($question->type === 'essay')
                                        <!-- Essay Hint -->
                                        <div class="p-3 bg-blue-50 border border-blue-100 rounded-xl flex items-center gap-2 text-xs text-blue-800 font-semibold">
                                            <span class="material-symbols-outlined text-blue-600 text-base shrink-0">edit_note</span>
                                            <span>Tuliskan uraian atau respon refleksi kamu pada kotak di bawah ini:</span>
                                        </div>

                                        <!-- Essay Textarea -->
                                        <div class="pt-1">
                                            <textarea name="answers[{{ $question->id }}]" 
                                                      rows="5" 
                                                      required 
                                                      placeholder="Tuliskan jawaban atau refleksi Anda secara lengkap di sini..." 
                                                      class="w-full text-xs sm:text-sm font-medium p-4 bg-slate-50/70 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 focus:bg-white transition leading-relaxed"></textarea>
                                        </div>
                                    @else
                                        <!-- Single Choice Options List -->
                                        <div class="space-y-3 pt-2">
                                            @foreach($question->options ?? [] as $optIndex => $option)
                                                @php $labels = ['A', 'B', 'C', 'D', 'E']; @endphp
                                                <label class="flex items-start p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50/50 hover:border-slate-300 transition-all has-[:checked]:bg-indigo-50/50 has-[:checked]:border-indigo-500 has-[:checked]:ring-1 has-[:checked]:ring-indigo-500 group">
                                                    <div class="flex items-center h-5 mt-0.5">
                                                        <input type="radio" 
                                                               name="answers[{{ $question->id }}]" 
                                                               value="{{ $option->id }}" 
                                                               class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 focus:ring-indigo-500 focus:ring-offset-0" 
                                                               required>
                                                    </div>
                                                    <div class="ml-3 flex text-xs sm:text-sm font-semibold text-slate-700">
                                                        <span class="font-extrabold mr-2 text-slate-500 group-hover:text-indigo-600">{{ $option->label ?? ($labels[$optIndex] ?? '') }}.</span>
                                                        <span class="text-slate-800 leading-normal">{{ $option->option }}</span>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="bg-white p-8 rounded-2xl text-center text-slate-500 font-semibold border border-slate-200">
                                    Tidak ada pertanyaan dalam asesmen ini.
                                </div>
                            @endforelse
                        </div>

                        <!-- Navigation Buttons Footer -->
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 flex items-center justify-between gap-4">
                            <!-- Previous Button -->
                            <div>
                                <button type="button" 
                                        @click="currentIdx--" 
                                        x-show="currentIdx > 0" 
                                        class="inline-flex items-center justify-center px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs sm:text-sm transition gap-1.5 cursor-pointer">
                                    <span class="material-symbols-outlined text-sm sm:text-base">arrow_back</span>
                                    Sebelumnya
                                </button>
                            </div>

                            <!-- Next or Submit Button -->
                            <div>
                                <!-- Next Button -->
                                <button type="button" 
                                        @click="currentIdx++" 
                                        x-show="currentIdx < total - 1" 
                                        class="inline-flex items-center justify-center px-5 py-2.5 bg-[#005bbf] hover:bg-[#004493] text-white font-bold rounded-xl text-xs sm:text-sm transition gap-1.5 group cursor-pointer">
                                    Selanjutnya
                                    <span class="material-symbols-outlined group-hover:translate-x-0.5 transition-transform text-sm sm:text-base">arrow_forward</span>
                                </button>

                                <!-- Submit Button -->
                                <button type="submit" 
                                        x-show="currentIdx === total - 1" 
                                        class="inline-flex items-center justify-center px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs sm:text-sm transition gap-1.5 shadow-md cursor-pointer">
                                    Kumpulkan Jawaban
                                    <span class="material-symbols-outlined text-sm sm:text-base">check_circle</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </main>

        <!-- Footer -->
        <footer class="py-4 border-t border-slate-200 bg-white text-center text-[10px] text-slate-400 font-bold uppercase tracking-wider">
            © 2026 LENTERA Educational Platform. Seluruh Hak Cipta Dilindungi.
        </footer>

    </body>
</html>
