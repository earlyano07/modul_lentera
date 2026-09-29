<x-app-layout>
    <x-slot name="title">Kelola Soal: {{ $assessment->judul }}</x-slot>

    <div x-data="questionManager()">
        <!-- Main Content Area with Dynamic Blur Filter -->
        <div :class="(showCreateModal || showEditModal) ? 'filter blur-[4px] pointer-events-none transition-all duration-300' : 'transition-all duration-300'">
            <!-- Header Section with Breadcrumbs -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
                <div>
                    <nav class="text-xs text-slate-400 font-semibold mb-2">
                        <ol class="list-reset flex items-center gap-1.5">
                            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition">Dashboard</a></li>
                            <li><span class="text-slate-300">/</span></li>
                            <li><a href="{{ route('admin.modules.show', $assessment->module_id) }}" class="hover:text-indigo-600 transition">Modul</a></li>
                            <li><span class="text-slate-300">/</span></li>
                            <li class="text-slate-600">Kelola Soal</li>
                        </ol>
                    </nav>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-600 text-2xl">fact_check</span>
                        Soal Asesmen: {{ $assessment->judul }}
                    </h1>
                </div>
                <div class="flex items-center gap-2.5">
                    <a href="{{ route('admin.assessments.edit', $assessment) }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow transition-all cursor-pointer">
                        <span class="material-symbols-outlined text-sm text-slate-500">edit_note</span>
                        Edit Asesmen & Situasi
                    </a>
                    <button type="button" @click="openCreateModal()" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-sm hover:shadow-md transition-all cursor-pointer">
                        <span class="material-symbols-outlined text-sm">add_circle</span>
                        Tambah Soal Baru
                    </button>
                </div>
            </div>

            <!-- Assessment Summary Card -->
            <div class="bg-gradient-to-r from-indigo-50/80 via-slate-50 to-indigo-50/30 border border-indigo-100/50 rounded-2xl p-6 mb-8 shadow-xs">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Jenis Asesmen -->
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-lg">category</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jenis Asesmen</p>
                            <div class="text-xs font-black text-indigo-900 mt-0.5">
                                @if($assessment->jenis == 'penilaian_diri')
                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 text-[10px] font-bold rounded-md">Penilaian Diri</span>
                                @elseif($assessment->jenis == 'refleksi_diri' || $assessment->jenis == 'lkpd')
                                    <span class="px-2 py-0.5 bg-indigo-100 text-indigo-800 text-[10px] font-bold rounded-md">Refleksi Diri</span>
                                @elseif($assessment->jenis == 'lembar_komitmen')
                                    <span class="px-2 py-0.5 bg-purple-100 text-purple-800 text-[10px] font-bold rounded-md">Lembar Komitmen</span>
                                @else
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-800 text-[10px] font-bold rounded-md">{{ \App\Models\Assessment::JENIS_OPTIONS[$assessment->jenis] ?? ucfirst($assessment->jenis) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Skor Maksimal -->
                    <div class="flex items-center gap-3 border-t md:border-t-0 md:border-x border-slate-200/60 pt-4 md:pt-0 md:px-6">
                        <div class="h-10 w-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-lg">assignment_turned_in</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Skor Maksimal</p>
                            <p class="text-sm font-black text-slate-800 mt-0.5">{{ $assessment->questions->sum('score') ?: $assessment->questions->count() ?: 0 }} Poin</p>
                        </div>
                    </div>

                    <!-- Total Soal -->
                    <div class="flex items-center gap-3 border-t md:border-t-0 pt-4 md:pt-0 md:pl-6">
                        <div class="h-10 w-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-lg">format_list_numbered</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Pertanyaan</p>
                            <p class="text-sm font-black text-slate-800 mt-0.5">{{ $assessment->questions->count() ?? 0 }} Butir Soal</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($assessment->deskripsi || $assessment->catatan)
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 mb-8 shadow-xs space-y-4">
                    @if($assessment->deskripsi)
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-[10px] font-black uppercase tracking-wider text-indigo-700 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm">menu_book</span>
                                    Bahan Bacaan / Situasi Kasus Asesmen
                                </span>
                                <a href="{{ route('admin.assessments.edit', $assessment) }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-bold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">edit</span>
                                    Edit Bacaan
                                </a>
                            </div>
                            <div class="text-xs sm:text-sm font-semibold text-slate-700 bg-indigo-50/50 p-4 rounded-xl border border-indigo-100/80 leading-relaxed whitespace-pre-line">
                                {{ $assessment->deskripsi }}
                            </div>
                        </div>
                    @endif
                    @if($assessment->catatan)
                        <div class="flex items-center justify-between p-3 bg-amber-50 rounded-xl border border-amber-200/70 text-amber-900 text-xs font-bold">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-amber-600 text-base shrink-0">info</span>
                                <span>{{ $assessment->catatan }}</span>
                            </div>
                            <a href="{{ route('admin.assessments.edit', $assessment) }}" class="text-xs text-amber-800 hover:text-amber-950 underline font-bold shrink-0 ml-2">
                                Edit Catatan
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="mb-8 p-4 bg-slate-50 border border-dashed border-slate-300 rounded-2xl flex items-center justify-between">
                    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                        <span class="material-symbols-outlined text-slate-400 text-base">info</span>
                        <span>Belum ada bahan bacaan situasi atau catatan khusus untuk asesmen ini.</span>
                    </div>
                    <a href="{{ route('admin.assessments.edit', $assessment) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs">add</span>
                        Tambah Bacaan Situasi
                    </a>
                </div>
            @endif

            <!-- List Questions Container -->
            <div class="space-y-6">
                @forelse($assessment->questions as $question)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all duration-200 overflow-hidden">
                    <!-- Question Top Panel -->
                    <div class="px-6 py-4.5 bg-slate-50/70 border-b border-slate-100 flex items-center justify-between gap-4 flex-wrap">
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <span class="inline-flex items-center justify-center h-7 px-3 rounded-full bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-black text-xs">
                                Soal #{{ $question->urutan }}
                            </span>
                            <span class="px-2.5 py-0.5 bg-amber-50 border border-amber-200/50 text-amber-800 text-[10px] font-bold rounded-lg uppercase tracking-wider">
                                {{ $question->score }} Poin
                            </span>
                            @if($question->type === 'checklist')
                                <span class="px-2.5 py-0.5 bg-emerald-50 border border-emerald-200/60 text-emerald-800 text-[10px] font-black rounded-lg uppercase tracking-wider flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px]">check_box</span>
                                    Checklist Komitmen
                                </span>
                            @elseif($question->type === 'essay')
                                <span class="px-2.5 py-0.5 bg-blue-50 border border-blue-200/60 text-blue-800 text-[10px] font-black rounded-lg uppercase tracking-wider flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px]">edit_note</span>
                                    Isian / Uraian
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 bg-purple-50 border border-purple-200/60 text-purple-800 text-[10px] font-black rounded-lg uppercase tracking-wider flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px]">radio_button_checked</span>
                                    Pilihan Ganda
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center gap-1">
                            <button type="button" 
                                @click="openEditModal({{ json_encode([
                                    'id' => $question->id,
                                    'urutan' => $question->urutan,
                                    'type' => $question->type ?: 'single_choice',
                                    'score' => $question->score,
                                    'question' => $question->question,
                                    'image_url' => $question->image_path ? asset('storage/' . $question->image_path) : null,
                                    'options' => $question->options->map(fn($opt) => ['label' => $opt->label, 'text' => $opt->option, 'score' => $opt->score ?? 0, 'isCorrect' => (bool)$opt->is_correct])->values()->toArray(),
                                    'correct_index' => (string)max(0, $question->options->search(fn($o) => $o->is_correct)),
                                    'update_url' => route('admin.questions.update', $question)
                                ]) }})" 
                                class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 text-xs font-extrabold px-3 py-1.5 rounded-lg hover:bg-indigo-50 transition uppercase tracking-wide cursor-pointer">
                                <span class="material-symbols-outlined text-sm">edit</span>
                                Edit
                            </button>
                            <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 text-rose-600 hover:text-rose-800 text-xs font-extrabold px-3 py-1.5 rounded-lg hover:bg-rose-50 transition uppercase tracking-wide cursor-pointer">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Question Body -->
                    <div class="p-6 space-y-4">
                        <div class="font-bold text-slate-800 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                            {{ $question->question }}
                        </div>

                        <!-- Soal Image (if exists) -->
                        @if($question->image_path)
                            <div class="rounded-2xl border border-slate-100 overflow-hidden max-w-md">
                                <img src="{{ asset('storage/' . $question->image_path) }}" alt="Gambar Soal" class="w-full h-auto object-cover">
                            </div>
                        @endif

                        @if($question->type === 'essay')
                            <!-- Essay / Uraian Preview Box -->
                            <div class="p-4 rounded-xl bg-blue-50/50 border border-blue-100 flex items-center gap-3 text-xs text-blue-900 font-semibold mt-4">
                                <span class="material-symbols-outlined text-blue-600 text-xl shrink-0">edit_note</span>
                                <div>
                                    <p class="font-extrabold">Soal Isian Singkat / Uraian Terbuka</p>
                                    <p class="text-[11px] text-blue-700/80 font-medium">Siswa akan mengetikkan respon jawaban tertulis pada kotak teks yang disediakan saat ujian.</p>
                                </div>
                            </div>
                        @else
                            <!-- Options Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                                @foreach($question->options ?? [] as $option)
                                    <div class="flex items-start p-4 rounded-xl border transition-all duration-200 {{ $option->is_correct ? 'bg-emerald-50/50 border-emerald-300 text-emerald-900 ring-2 ring-emerald-500/10' : 'bg-slate-50/30 border-slate-200/80 text-slate-700 hover:border-slate-350' }}">
                                        <div class="h-6 w-6 rounded-full flex items-center justify-center text-xs font-black mr-3 shrink-0 {{ $option->is_correct ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-600' }}">
                                            {{ $option->label ?? chr(64 + $loop->iteration) }}
                                        </div>
                                        <div class="flex-grow pt-0.5 text-xs sm:text-sm font-semibold">
                                            {{ $option->option ?? $option->option_text }}
                                        </div>
                                        @if($option->score > 0)
                                            <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-md text-[10px] font-black bg-indigo-50 text-indigo-700 border border-indigo-100 shrink-0 ml-2">
                                                Bobot: {{ $option->score }}
                                            </span>
                                        @endif
                                        @if($option->is_correct)
                                            <div class="ml-2 bg-emerald-100 text-emerald-800 rounded-full p-0.5 flex items-center justify-center shrink-0">
                                                <span class="material-symbols-outlined text-base">check</span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-2xl border border-slate-100 p-12 text-center shadow-xs">
                    <div class="h-16 w-16 bg-indigo-50 text-indigo-600 rounded-3xl flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl">quiz</span>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-800">Belum Ada Pertanyaan</h3>
                    <p class="text-xs text-slate-400 font-semibold max-w-sm mx-auto mt-1 mb-6">Mulai tambahkan butir pertanyaan untuk asesmen ini.</p>
                    <button type="button" @click="openCreateModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition cursor-pointer">
                        <span class="material-symbols-outlined text-sm">add_circle</span>
                        Tambah Soal Pertama
                    </button>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Create Question Modal -->
        <div x-show="showCreateModal" 
             class="fixed inset-0 z-[100] overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-250"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="fixed inset-0 transition-all duration-300" 
                 style="background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);" 
                 @click="showCreateModal = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
                <div x-show="showCreateModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-250"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-3xl p-6 md:p-8 flex flex-col max-h-[90vh] z-10 border border-slate-100">
                    
                    <button type="button" @click="showCreateModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition p-1 hover:bg-slate-100 rounded-lg cursor-pointer">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-600 text-2xl">add_box</span>
                            Tambah Soal Baru
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Lengkapi tipe pertanyaan, teks soal, dan opsi jawaban</p>
                    </div>

                    <div class="overflow-y-auto flex-1 px-1">
                        <form action="{{ route('admin.assessments.questions.store', $assessment) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            
                            <!-- Tipe Soal Selektor -->
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Soal *</label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                                    <label class="flex items-center gap-2 p-3 border rounded-xl cursor-pointer transition text-xs font-bold"
                                        :class="createType === 'single_choice' ? 'border-indigo-600 bg-indigo-50/70 text-indigo-900 ring-2 ring-indigo-500/20' : 'border-slate-200 text-slate-600 hover:bg-slate-50'">
                                        <input type="radio" name="type" value="single_choice" x-model="createType" class="sr-only">
                                        <span class="material-symbols-outlined text-base text-indigo-600">radio_button_checked</span>
                                        <span>Pilihan Ganda</span>
                                    </label>
                                    <label class="flex items-center gap-2 p-3 border rounded-xl cursor-pointer transition text-xs font-bold"
                                        :class="createType === 'checklist' ? 'border-emerald-600 bg-emerald-50/70 text-emerald-900 ring-2 ring-emerald-500/20' : 'border-slate-200 text-slate-600 hover:bg-slate-50'">
                                        <input type="radio" name="type" value="checklist" x-model="createType" class="sr-only">
                                        <span class="material-symbols-outlined text-base text-emerald-600">check_box</span>
                                        <span>Checklist Komitmen</span>
                                    </label>
                                    <label class="flex items-center gap-2 p-3 border rounded-xl cursor-pointer transition text-xs font-bold"
                                        :class="createType === 'essay' ? 'border-blue-600 bg-blue-50/70 text-blue-900 ring-2 ring-blue-500/20' : 'border-slate-200 text-slate-600 hover:bg-slate-50'">
                                        <input type="radio" name="type" value="essay" x-model="createType" class="sr-only">
                                        <span class="material-symbols-outlined text-base text-blue-600">edit_note</span>
                                        <span>Isian / Uraian</span>
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="create_urutan" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Urutan Soal *</label>
                                    <input type="number" name="urutan" id="create_urutan" x-ref="createUrutanInput" value="{{ $assessment->questions->max('urutan') + 1 }}" required 
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                                <div>
                                    <label for="create_score" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Bobot Poin Soal *</label>
                                    <input type="number" name="score" id="create_score" value="1" required min="1"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div>
                                <label for="create_question" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Teks Pertanyaan / Pernyataan *</label>
                                <textarea name="question" id="create_question" rows="3" required placeholder="Tuliskan pertanyaan, pernyataan komitmen, atau topik isian di sini..."
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition"></textarea>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Gambar / Ilustrasi Pendukung (Opsional)</label>
                                <div class="relative flex flex-col items-center justify-center p-4 border-2 border-dashed border-slate-200 hover:border-indigo-400 bg-slate-50/30 rounded-2xl cursor-pointer transition duration-200 group">
                                    <input type="file" name="image_upload" id="create_image_upload" accept="image/*" 
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        @change="const file = $event.target.files[0]; createFileName = file ? file.name : ''">
                                    <div class="text-center">
                                        <span class="material-symbols-outlined text-slate-400 group-hover:text-indigo-500 text-2xl transition duration-200 mb-1">image</span>
                                        <p class="text-[11px] font-extrabold text-slate-700" x-text="createFileName ? createFileName : 'Pilih Gambar'"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Pilihan Jawaban Section (Hanya untuk Single Choice & Checklist) -->
                            <div x-show="createType !== 'essay'" class="space-y-4">
                                <hr class="border-slate-100 my-4">
                                <div class="flex items-center justify-between border-b border-slate-50 pb-2">
                                    <div>
                                        <h3 class="text-xs font-extrabold text-slate-800" x-text="createType === 'checklist' ? 'Butir Pernyataan Komitmen' : 'Pilihan Jawaban'"></h3>
                                        <p class="text-[10px] text-slate-400 font-semibold" x-text="createType === 'checklist' ? 'Tentukan opsi dan centang kunci/komitmen yang diharapkan.' : 'Tentukan opsi dan tentukan bobot nilai (skor) tiap pilihan.'"></p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button type="button" @click="setCreateLikertPreset()" class="inline-flex items-center gap-1 text-[10px] font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 px-2.5 py-1 rounded-lg border border-indigo-200 transition cursor-pointer">
                                            <span class="material-symbols-outlined text-[13px]">format_list_bulleted</span>
                                            Preset Likert (SS=4, S=3, KS=2, TS=1)
                                        </button>
                                        <button type="button" @click="addCreateOption()" class="inline-flex items-center gap-1 text-[10px] font-black text-indigo-600 hover:text-indigo-800 transition uppercase tracking-wider cursor-pointer">
                                            <span class="material-symbols-outlined text-xs">add_circle</span>
                                            Tambah Opsi
                                        </button>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <template x-for="(option, index) in createOptions" :key="index">
                                        <div class="flex items-center gap-3 p-3 border rounded-xl transition-all duration-200 bg-white" 
                                            :class="option.isCorrect ? 'border-emerald-300 bg-emerald-50/5 ring-4 ring-emerald-500/5' : 'border-slate-200 hover:border-slate-350 bg-white'">
                                            
                                            <div class="flex items-center gap-2">
                                                <span class="h-7 w-7 rounded-full flex items-center justify-center font-black text-xs shrink-0"
                                                    :class="option.isCorrect ? 'bg-emerald-500 text-white' : 'bg-slate-100 text-slate-500'">
                                                    <span x-text="option.label"></span>
                                                </span>
                                                <input type="hidden" :name="'options['+index+'][label]'" x-model="option.label">
                                            </div>

                                            <div class="flex-1">
                                                <input type="text" :name="'options['+index+'][option]'" x-model="option.text" :required="createType !== 'essay'" :placeholder="createType === 'checklist' ? 'Contoh: Saya akan bersikap jujur dan sopan...' : 'Tuliskan teks pilihan jawaban...'"
                                                    class="w-full text-xs font-semibold px-2.5 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                            </div>

                                            <div class="w-20 shrink-0" title="Bobot Nilai Opsi (misal: 4, 3, 2, 1)">
                                                <div class="relative flex items-center">
                                                    <span class="absolute left-2 text-[9px] font-bold text-slate-400">Bobot</span>
                                                    <input type="number" :name="'options['+index+'][score]'" x-model="option.score" min="0" placeholder="0"
                                                        class="w-full text-xs font-bold pl-11 pr-1.5 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition text-right">
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2 shrink-0">
                                                <!-- Single Choice Kunci Radio -->
                                                <template x-if="createType === 'single_choice'">
                                                    <label class="flex items-center gap-1 cursor-pointer px-2.5 py-1.5 rounded-lg border text-[10px] font-black uppercase tracking-wider transition duration-200" 
                                                        :class="option.isCorrect ? 'bg-emerald-500 border-emerald-500 text-white shadow-xs' : 'bg-white border-slate-200 text-slate-500 hover:bg-slate-50'">
                                                        <input type="radio" name="correct_option" :value="index" x-model="createCorrectIndex" @change="setCreateCorrect(index)" class="sr-only">
                                                        <span class="material-symbols-outlined text-[12px]" x-text="option.isCorrect ? 'check_circle' : 'circle'"></span>
                                                        Kunci
                                                    </label>
                                                </template>

                                                <!-- Checklist Kunci Checkbox -->
                                                <template x-if="createType === 'checklist'">
                                                    <label class="flex items-center gap-1 cursor-pointer px-2.5 py-1.5 rounded-lg border text-[10px] font-black uppercase tracking-wider transition duration-200" 
                                                        :class="option.isCorrect ? 'bg-emerald-500 border-emerald-500 text-white shadow-xs' : 'bg-white border-slate-200 text-slate-500 hover:bg-slate-50'">
                                                        <input type="checkbox" name="correct_options[]" :value="index" :checked="option.isCorrect" @change="option.isCorrect = $event.target.checked" class="sr-only">
                                                        <span class="material-symbols-outlined text-[12px]" x-text="option.isCorrect ? 'check_box' : 'check_box_outline_blank'"></span>
                                                        Kunci/Poin
                                                    </label>
                                                </template>

                                                <button type="button" @click="removeCreateOption(index)" x-show="createOptions.length > 2" 
                                                    class="inline-flex items-center justify-center h-7 w-7 text-rose-500 hover:text-white border border-rose-100 hover:bg-rose-500 rounded-lg transition duration-200 shrink-0 cursor-pointer">
                                                    <span class="material-symbols-outlined text-sm">delete</span>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Essay Notice -->
                            <div x-show="createType === 'essay'" class="p-4 rounded-xl bg-blue-50/60 border border-blue-200/70 text-xs text-blue-900 flex items-start gap-3">
                                <span class="material-symbols-outlined text-blue-600 text-lg shrink-0">info</span>
                                <div>
                                    <p class="font-extrabold">Informasi Tipe Soal Isian / Uraian</p>
                                    <p class="text-[11px] text-blue-700/90 font-medium mt-0.5">Soal isian tidak memerlukan opsi pilihan. Siswa akan langsung mengisi jawaban teks pada halaman pengerjaan.</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4 mt-6">
                                <button type="button" @click="showCreateModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-wider transition cursor-pointer">
                                    Batal
                                </button>
                                <button type="submit" 
                                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition duration-200 flex items-center gap-1.5 cursor-pointer">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                    Simpan Pertanyaan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Question Modal -->
        <div x-show="showEditModal" 
             class="fixed inset-0 z-[100] overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-250"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="fixed inset-0 transition-all duration-300" 
                 style="background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);" 
                 @click="showEditModal = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
                <div x-show="showEditModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-250"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-3xl p-6 md:p-8 flex flex-col max-h-[90vh] z-10 border border-slate-100">
                    
                    <button type="button" @click="showEditModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition p-1 hover:bg-slate-100 rounded-lg cursor-pointer">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-600 text-2xl">edit_note</span>
                            Edit Butir Soal
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Perbarui tipe pertanyaan, bobot poin, dan pilihan jawaban</p>
                    </div>

                    <div class="overflow-y-auto flex-1 px-1">
                        <form :action="editForm.update_url" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')
                            
                            <!-- Tipe Soal Selektor -->
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Soal *</label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                                    <label class="flex items-center gap-2 p-3 border rounded-xl cursor-pointer transition text-xs font-bold"
                                        :class="editForm.type === 'single_choice' ? 'border-indigo-600 bg-indigo-50/70 text-indigo-900 ring-2 ring-indigo-500/20' : 'border-slate-200 text-slate-600 hover:bg-slate-50'">
                                        <input type="radio" name="type" value="single_choice" x-model="editForm.type" class="sr-only">
                                        <span class="material-symbols-outlined text-base text-indigo-600">radio_button_checked</span>
                                        <span>Pilihan Ganda</span>
                                    </label>
                                    <label class="flex items-center gap-2 p-3 border rounded-xl cursor-pointer transition text-xs font-bold"
                                        :class="editForm.type === 'checklist' ? 'border-emerald-600 bg-emerald-50/70 text-emerald-900 ring-2 ring-emerald-500/20' : 'border-slate-200 text-slate-600 hover:bg-slate-50'">
                                        <input type="radio" name="type" value="checklist" x-model="editForm.type" class="sr-only">
                                        <span class="material-symbols-outlined text-base text-emerald-600">check_box</span>
                                        <span>Checklist Komitmen</span>
                                    </label>
                                    <label class="flex items-center gap-2 p-3 border rounded-xl cursor-pointer transition text-xs font-bold"
                                        :class="editForm.type === 'essay' ? 'border-blue-600 bg-blue-50/70 text-blue-900 ring-2 ring-blue-500/20' : 'border-slate-200 text-slate-600 hover:bg-slate-50'">
                                        <input type="radio" name="type" value="essay" x-model="editForm.type" class="sr-only">
                                        <span class="material-symbols-outlined text-base text-blue-600">edit_note</span>
                                        <span>Isian / Uraian</span>
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="edit_urutan" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Urutan Soal *</label>
                                    <input type="number" name="urutan" id="edit_urutan" x-ref="editUrutanInput" x-model="editForm.urutan" required 
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                                <div>
                                    <label for="edit_score" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Bobot Poin Soal *</label>
                                    <input type="number" name="score" id="edit_score" x-model="editForm.score" required min="1"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div>
                                <label for="edit_question" class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Teks Pertanyaan / Pernyataan *</label>
                                <textarea name="question" id="edit_question" rows="3" x-model="editForm.question" required placeholder="Tuliskan pertanyaan pilihan ganda Anda di sini..."
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition"></textarea>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Gambar / Ilustrasi Pendukung</label>
                                <template x-if="editForm.image_url">
                                    <div class="mb-3 flex items-center gap-3 p-2 bg-slate-50 border border-slate-200 rounded-xl w-fit">
                                        <img :src="editForm.image_url" alt="Gambar Soal" class="w-14 h-14 object-contain rounded-lg bg-white border border-slate-100 p-1">
                                        <div class="text-xs">
                                            <p class="font-bold text-slate-700">Gambar Saat Ini</p>
                                            <p class="text-[10px] text-slate-400">Pilih file baru jika ingin mengganti</p>
                                        </div>
                                    </div>
                                </template>
                                <div class="relative flex flex-col items-center justify-center p-4 border-2 border-dashed border-slate-200 hover:border-indigo-400 bg-slate-50/30 rounded-2xl cursor-pointer transition duration-200 group">
                                    <input type="file" name="image_upload" id="edit_image_upload" accept="image/*" 
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        @change="const file = $event.target.files[0]; editFileName = file ? file.name : ''">
                                    <div class="text-center">
                                        <span class="material-symbols-outlined text-slate-400 group-hover:text-indigo-500 text-2xl transition duration-200 mb-1">image</span>
                                        <p class="text-[11px] font-extrabold text-slate-700" x-text="editFileName ? editFileName : 'Pilih File Gambar Baru'"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Pilihan Jawaban Section (Hanya untuk Single Choice & Checklist) -->
                            <div x-show="editForm.type !== 'essay'" class="space-y-4">
                                <hr class="border-slate-100 my-4">
                                <div class="flex items-center justify-between border-b border-slate-50 pb-2">
                                    <div>
                                        <h3 class="text-xs font-extrabold text-slate-800" x-text="editForm.type === 'checklist' ? 'Butir Pernyataan Komitmen' : 'Pilihan Jawaban'"></h3>
                                        <p class="text-[10px] text-slate-400 font-semibold" x-text="editForm.type === 'checklist' ? 'Tentukan opsi dan centang kunci/komitmen yang diharapkan.' : 'Tentukan opsi dan tentukan bobot nilai (skor) tiap pilihan.'"></p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button type="button" @click="setEditLikertPreset()" class="inline-flex items-center gap-1 text-[10px] font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 px-2.5 py-1 rounded-lg border border-indigo-200 transition cursor-pointer">
                                            <span class="material-symbols-outlined text-[13px]">format_list_bulleted</span>
                                            Preset Likert (SS=4, S=3, KS=2, TS=1)
                                        </button>
                                        <button type="button" @click="addEditOption()" class="inline-flex items-center gap-1 text-[10px] font-black text-indigo-600 hover:text-indigo-800 transition uppercase tracking-wider cursor-pointer">
                                            <span class="material-symbols-outlined text-xs">add_circle</span>
                                            Tambah Opsi
                                        </button>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <template x-for="(option, index) in editForm.options" :key="index">
                                        <div class="flex items-center gap-3 p-3 border rounded-xl transition-all duration-200 bg-white" 
                                            :class="option.isCorrect ? 'border-emerald-300 bg-emerald-50/5 ring-4 ring-emerald-500/5' : 'border-slate-200 hover:border-slate-350 bg-white'">
                                            
                                            <div class="flex items-center gap-2">
                                                <span class="h-7 w-7 rounded-full flex items-center justify-center font-black text-xs shrink-0"
                                                    :class="option.isCorrect ? 'bg-emerald-500 text-white' : 'bg-slate-100 text-slate-500'">
                                                    <span x-text="option.label"></span>
                                                </span>
                                                <input type="hidden" :name="'options['+index+'][label]'" x-model="option.label">
                                            </div>

                                            <div class="flex-1">
                                                <input type="text" :name="'options['+index+'][option]'" x-model="option.text" :required="editForm.type !== 'essay'" placeholder="Tuliskan teks pilihan jawaban..."
                                                    class="w-full text-xs font-semibold px-2.5 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                            </div>

                                            <div class="w-20 shrink-0" title="Bobot Nilai Opsi (misal: 4, 3, 2, 1)">
                                                <div class="relative flex items-center">
                                                    <span class="absolute left-2 text-[9px] font-bold text-slate-400">Bobot</span>
                                                    <input type="number" :name="'options['+index+'][score]'" x-model="option.score" min="0" placeholder="0"
                                                        class="w-full text-xs font-bold pl-11 pr-1.5 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition text-right">
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2 shrink-0">
                                                <!-- Single Choice Kunci Radio -->
                                                <template x-if="editForm.type === 'single_choice'">
                                                    <label class="flex items-center gap-1 cursor-pointer px-2.5 py-1.5 rounded-lg border text-[10px] font-black uppercase tracking-wider transition duration-200" 
                                                        :class="option.isCorrect ? 'bg-emerald-500 border-emerald-500 text-white shadow-xs' : 'bg-white border-slate-200 text-slate-500 hover:bg-slate-50'">
                                                        <input type="radio" name="correct_option" :value="index" x-model="editForm.correct_index" @change="setEditCorrect(index)" class="sr-only">
                                                        <span class="material-symbols-outlined text-[12px]" x-text="option.isCorrect ? 'check_circle' : 'circle'"></span>
                                                        Kunci
                                                    </label>
                                                </template>

                                                <!-- Checklist Kunci Checkbox -->
                                                <template x-if="editForm.type === 'checklist'">
                                                    <label class="flex items-center gap-1 cursor-pointer px-2.5 py-1.5 rounded-lg border text-[10px] font-black uppercase tracking-wider transition duration-200" 
                                                        :class="option.isCorrect ? 'bg-emerald-500 border-emerald-500 text-white shadow-xs' : 'bg-white border-slate-200 text-slate-500 hover:bg-slate-50'">
                                                        <input type="checkbox" name="correct_options[]" :value="index" :checked="option.isCorrect" @change="option.isCorrect = $event.target.checked" class="sr-only">
                                                        <span class="material-symbols-outlined text-[12px]" x-text="option.isCorrect ? 'check_box' : 'check_box_outline_blank'"></span>
                                                        Kunci/Poin
                                                    </label>
                                                </template>

                                                <button type="button" @click="removeEditOption(index)" x-show="editForm.options.length > 2" 
                                                    class="inline-flex items-center justify-center h-7 w-7 text-rose-500 hover:text-white border border-rose-100 hover:bg-rose-500 rounded-lg transition duration-200 shrink-0 cursor-pointer">
                                                    <span class="material-symbols-outlined text-sm">delete</span>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Essay Notice -->
                            <div x-show="editForm.type === 'essay'" class="p-4 rounded-xl bg-blue-50/60 border border-blue-200/70 text-xs text-blue-900 flex items-start gap-3">
                                <span class="material-symbols-outlined text-blue-600 text-lg shrink-0">info</span>
                                <div>
                                    <p class="font-extrabold">Informasi Tipe Soal Isian / Uraian</p>
                                    <p class="text-[11px] text-blue-700/90 font-medium mt-0.5">Soal isian tidak memerlukan opsi pilihan. Siswa akan langsung mengisi jawaban teks pada halaman pengerjaan.</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4 mt-6">
                                <button type="button" @click="showEditModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-wider transition cursor-pointer">
                                    Batal
                                </button>
                                <button type="submit" 
                                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition duration-200 flex items-center gap-1.5 cursor-pointer">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('questionManager', () => ({
                showCreateModal: false,
                showEditModal: false,
                createFileName: '',
                editFileName: '',
                createType: '{{ ($assessment->jenis === "lembar_komitmen" || str_contains(strtolower($assessment->judul), "komitmen")) ? "checklist" : "single_choice" }}',
                createCorrectIndex: '0',
                createOptions: [
                    { label: 'A', text: '', score: 0, isCorrect: true },
                    { label: 'B', text: '', score: 0, isCorrect: false },
                    { label: 'C', text: '', score: 0, isCorrect: false },
                    { label: 'D', text: '', score: 0, isCorrect: false }
                ],
                editForm: {
                    id: '',
                    urutan: '',
                    type: 'single_choice',
                    score: '',
                    question: '',
                    image_url: null,
                    options: [],
                    correct_index: '0',
                    update_url: ''
                },
                setCreateLikertPreset() {
                    this.createType = 'single_choice';
                    this.createOptions = [
                        { label: 'SS', text: 'Sangat Sesuai', score: 4, isCorrect: false },
                        { label: 'S', text: 'Sesuai', score: 3, isCorrect: false },
                        { label: 'KS', text: 'Kurang Sesuai', score: 2, isCorrect: false },
                        { label: 'TS', text: 'Tidak Sesuai', score: 1, isCorrect: false }
                    ];
                    this.createCorrectIndex = '0';
                },
                setEditLikertPreset() {
                    this.editForm.type = 'single_choice';
                    this.editForm.options = [
                        { label: 'SS', text: 'Sangat Sesuai', score: 4, isCorrect: false },
                        { label: 'S', text: 'Sesuai', score: 3, isCorrect: false },
                        { label: 'KS', text: 'Kurang Sesuai', score: 2, isCorrect: false },
                        { label: 'TS', text: 'Tidak Sesuai', score: 1, isCorrect: false }
                    ];
                    this.editForm.correct_index = '0';
                },
                openCreateModal() {
                    this.createFileName = '';
                    this.createType = '{{ ($assessment->jenis === "lembar_komitmen" || str_contains(strtolower($assessment->judul), "komitmen")) ? "checklist" : "single_choice" }}';
                    if (this.createType === 'checklist') {
                        this.createOptions.forEach(opt => opt.isCorrect = true);
                    } else {
                        this.setCreateCorrect(0);
                    }
                    this.showCreateModal = true;
                    this.$nextTick(() => {
                        this.$refs.createUrutanInput?.focus();
                    });
                },
                addCreateOption() {
                    const labels = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                    const nextLabel = this.createOptions.length < labels.length ? labels[this.createOptions.length] : String.fromCharCode(65 + this.createOptions.length);
                    this.createOptions.push({ label: nextLabel, text: '', score: 0, isCorrect: this.createType === 'checklist' });
                },
                removeCreateOption(index) {
                    this.createOptions.splice(index, 1);
                    this.createOptions.forEach((opt, i) => {
                        const labels = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                        opt.label = i < labels.length ? labels[i] : String.fromCharCode(65 + i);
                    });
                    if (this.createCorrectIndex == index) {
                        this.createCorrectIndex = '0';
                        this.setCreateCorrect(0);
                    } else if (this.createCorrectIndex > index) {
                        this.createCorrectIndex = String(parseInt(this.createCorrectIndex) - 1);
                    }
                },
                setCreateCorrect(index) {
                    this.createOptions.forEach((opt, i) => {
                        opt.isCorrect = (i == index);
                    });
                },
                openEditModal(data) {
                    this.editForm = { ...data };
                    if (!this.editForm.type) {
                        this.editForm.type = 'single_choice';
                    }
                    if (!this.editForm.options || this.editForm.options.length === 0) {
                        this.editForm.options = [
                            { label: 'A', text: '', score: 0, isCorrect: true },
                            { label: 'B', text: '', score: 0, isCorrect: false }
                        ];
                    }
                    this.editFileName = '';
                    this.showEditModal = true;
                    this.$nextTick(() => {
                        this.$refs.editUrutanInput?.focus();
                        this.$refs.editUrutanInput?.select();
                    });
                },
                addEditOption() {
                    const labels = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                    const nextLabel = this.editForm.options.length < labels.length ? labels[this.editForm.options.length] : String.fromCharCode(65 + this.editForm.options.length);
                    this.editForm.options.push({ label: nextLabel, text: '', score: 0, isCorrect: this.editForm.type === 'checklist' });
                },
                removeEditOption(index) {
                    this.editForm.options.splice(index, 1);
                    this.editForm.options.forEach((opt, i) => {
                        const labels = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                        opt.label = i < labels.length ? labels[i] : String.fromCharCode(65 + i);
                    });
                    if (this.editForm.correct_index == index) {
                        this.editForm.correct_index = '0';
                        this.setEditCorrect(0);
                    } else if (this.editForm.correct_index > index) {
                        this.editForm.correct_index = String(parseInt(this.editForm.correct_index) - 1);
                    }
                },
                setEditCorrect(index) {
                    this.editForm.options.forEach((opt, i) => {
                        opt.isCorrect = (i == index);
                    });
                }
            }));
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @endpush
</x-app-layout>
