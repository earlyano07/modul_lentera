<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $assessment->jenis === 'pre_test' ? 'Pre-Test' : ($assessment->jenis === 'post_test' ? 'Post-Test' : 'Tahap 4: Transfer of Training') }} - {{ $assessment->judul }}</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
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
                            Pre-Test Awal
                        @elseif($assessment->jenis === 'post_test')
                            Post-Test Akhir
                        @else
                            Tahap 4 • Transfer of Training
                        @endif
                    </span>
                </div>
            </div>
            
            <div>
                <a href="{{ route('student.module', $assessment->module_id) }}" class="inline-flex items-center px-4 py-2 border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-extrabold rounded-xl text-xs gap-1.5 transition">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    Kembali ke Modul
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 flex items-center justify-center p-6">
            <div class="max-w-2xl w-full">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
                    <!-- Banner -->
                    <div class="bg-gradient-to-br from-purple-700 via-indigo-700 to-blue-800 p-8 text-center text-white relative">
                        <div class="absolute inset-0 bg-white/5" style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
                        <div class="relative z-10">
                            <div class="w-14 h-14 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mx-auto mb-3 border border-white/30 shadow-xs">
                                <span class="material-symbols-outlined text-[28px] text-white" style="font-variation-settings: 'FILL' 1;">psychology</span>
                            </div>
                            <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur text-white text-[10px] font-black rounded-full mb-2 uppercase tracking-wider">
                                @if($assessment->jenis === 'pre_test')
                                    Pre-Test Pelatihan
                                @elseif($assessment->jenis === 'post_test')
                                    Post-Test Evaluasi Akhir
                                @else
                                    Tahap 4 • Transfer of Training (LKPD Online)
                                @endif
                            </span>
                            <h1 class="text-2xl sm:text-3xl font-black mb-1.5">{{ $assessment->judul ?? 'Lembar Kerja Peserta Didik (LKPD)' }}</h1>
                            <p class="text-indigo-100 text-xs sm:text-sm font-bold">
                                Topik {{ $assessment->module->urutan ?? 1 }}: {{ $assessment->module->judul ?? 'Modul' }}
                            </p>
                            @if($assessment->module->subtitle)
                                <p class="text-indigo-200 text-[11px] font-medium mt-1">{{ $assessment->module->subtitle }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Content Details -->
                    <div class="p-6 sm:p-8 space-y-6">
                        <!-- Info Chips -->
                        <div class="flex flex-wrap gap-3 justify-center">
                            <div class="flex items-center px-4 py-2 bg-purple-50 text-purple-700 rounded-xl font-extrabold text-xs">
                                <span class="material-symbols-outlined text-[18px] mr-1.5">checklist</span>
                                {{ count($assessment->questions ?? []) }} Butir Pertanyaan
                            </div>
                            <div class="flex items-center px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl font-extrabold text-xs">
                                <span class="material-symbols-outlined text-[18px] mr-1.5">sync_alt</span>
                                Terintegrasi dengan Evaluasi
                            </div>
                            <div class="flex items-center px-4 py-2 bg-amber-50 text-amber-700 rounded-xl font-extrabold text-xs">
                                <span class="material-symbols-outlined text-[18px] mr-1.5">timer</span>
                                Satu Sesi Pengerjaan
                            </div>
                        </div>

                        <!-- Guide Transfer from Counselor (If available) -->
                        @if($assessment->module->guide_transfer)
                            <div class="bg-indigo-50/60 border border-indigo-100 rounded-2xl p-4.5">
                                <div class="flex items-center gap-2 text-indigo-900 mb-1.5 font-extrabold text-xs uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-[18px]">campaign</span>
                                    Petunjuk Konselor (Tahap 4)
                                </div>
                                <p class="text-xs text-slate-700 font-semibold leading-relaxed">
                                    {{ $assessment->module->guide_transfer }}
                                </p>
                            </div>
                        @endif

                        <!-- Notice Box -->
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
                            <h3 class="text-slate-800 font-black text-xs sm:text-sm flex items-center mb-2">
                                <span class="material-symbols-outlined text-purple-600 text-lg mr-1.5">info</span>
                                PANDUAN PENGERJAAN
                            </h3>
                            <ul class="list-disc list-inside text-xs text-slate-600 space-y-1.5 font-semibold ml-1 leading-relaxed">
                                <li>Pilihlah jawaban yang paling tepat sesuai dengan pemahaman dan komitmen empati Anda.</li>
                                <li>Asesmen dikerjakan secara mandiri dan langsung tersimpan ke sistem setelah selesai.</li>
                                <li>Hasil pengerjaan akan otomatis terintegrasi ke dalam rekapan Evaluasi Konselor.</li>
                            </ul>
                        </div>

                        <!-- Start Button -->
                        <form action="{{ route('student.assessment.start', $assessment->id) }}" method="POST" class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
                            @csrf
                            <a href="{{ route('student.module', $assessment->module_id) }}" class="w-full sm:w-auto px-6 py-3 border border-slate-200 text-slate-700 hover:text-slate-900 hover:bg-slate-50 font-extrabold rounded-xl text-xs sm:text-sm text-center transition">
                                Kembali ke Modul
                            </a>
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white font-black rounded-xl transition shadow-md hover:shadow-lg gap-2 text-xs sm:text-sm cursor-pointer">
                                <span>Mulai Mengerjakan Asesmen</span>
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-4 border-t border-slate-200 bg-white text-center text-[10px] text-slate-400 font-bold uppercase tracking-wider">
            © 2026 LENTERA Educational Platform. Seluruh Hak Cipta Dilindungi.
        </footer>
    </body>
</html>
