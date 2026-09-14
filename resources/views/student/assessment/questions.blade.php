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
                        @if($assessment->jenis === 'pre_test')
                            Pre-Test
                        @elseif($assessment->jenis === 'post_test')
                            Post-Test
                        @else
                            Tahap 4 • Transfer of Training (LKPD)
                        @endif
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
        <main class="flex-1 p-6 flex justify-center items-center">
            <div class="max-w-3xl w-full" x-data="{ currentIdx: 0, total: {{ count($assessment->questions ?? []) }} }">
                <!-- Sticky Header with Stepper Progress -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="inline-block px-2.5 py-0.5 rounded-md text-[9px] font-black uppercase tracking-wider bg-purple-100 text-purple-800 mb-1">
                                @if($assessment->jenis === 'pre_test')
                                    Pre-Test Awal
                                @elseif($assessment->jenis === 'post_test')
                                    Post-Test Akhir
                                @else
                                    Tahap 4 • Transfer of Training
                                @endif
                            </span>
                            <h2 class="text-base sm:text-lg font-black text-slate-900 leading-tight">{{ $assessment->judul ?? 'Lembar Kerja Peserta Didik (LKPD)' }}</h2>
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
                                
                                <!-- Options List -->
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
                                                <span class="font-extrabold mr-2 text-slate-500 group-hover:text-indigo-600">{{ $labels[$optIndex] ?? '' }}.</span>
                                                <span class="text-slate-800 leading-normal">{{ $option->option }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
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
                                    class="inline-flex items-center justify-center px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs sm:text-sm transition gap-1.5">
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
                                    class="inline-flex items-center justify-center px-5 py-2.5 bg-[#005bbf] hover:bg-[#004493] text-white font-bold rounded-xl text-xs sm:text-sm transition gap-1.5 group">
                                Selanjutnya
                                <span class="material-symbols-outlined group-hover:translate-x-0.5 transition-transform text-sm sm:text-base">arrow_forward</span>
                            </button>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    x-show="currentIdx === total - 1" 
                                    class="inline-flex items-center justify-center px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs sm:text-sm transition gap-1.5 shadow-md">
                                Kumpulkan Jawaban
                                <span class="material-symbols-outlined text-sm sm:text-base">check_circle</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-4 border-t border-slate-200 bg-white text-center text-[10px] text-slate-400 font-bold uppercase tracking-wider">
            © 2026 LENTERA Educational Platform. Seluruh Hak Cipta Dilindungi.
        </footer>

    </body>
</html>
