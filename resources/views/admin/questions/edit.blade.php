<x-app-layout>
    <x-slot name="title">Edit Soal</x-slot>

    <!-- Header Section with Breadcrumbs -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 bg-white p-6 rounded-2xl border border-slate-100 shadow-xs">
        <div>
            <nav class="text-xs text-slate-400 font-semibold mb-2">
                <ol class="list-reset flex items-center gap-1.5">
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition">Dashboard</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li><a href="{{ route('admin.assessments.show', $question->assessment_id) }}" class="hover:text-indigo-600 transition">Soal Asesmen</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li class="text-slate-600">Edit Soal</li>
                </ol>
            </nav>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-600 text-2xl">edit_note</span>
                Edit Soal Asesmen
            </h1>
        </div>
        <div>
            <a href="{{ route('admin.assessments.show', $question->assessment_id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider rounded-xl transition">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Kembali
            </a>
        </div>
    </div>

    <!-- Main Form Container -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 md:p-8 shadow-xs max-w-4xl mx-auto" x-data="questionForm()">
        <form action="{{ route('admin.questions.update', $question) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Metadata Grid (Nomor Soal & Bobot) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nomor Soal / Urutan -->
                <div>
                    <label for="urutan" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Urutan Soal</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                            <span class="material-symbols-outlined text-lg">tag</span>
                        </span>
                        <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $question->urutan) }}" required 
                            class="pl-11 w-full text-sm font-semibold px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('urutan') border-rose-400 bg-rose-50/20 @enderror">
                    </div>
                    @error('urutan')
                        <p class="text-rose-500 text-xs font-semibold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bobot / Score -->
                <div>
                    <label for="score" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Bobot Poin Soal</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                            <span class="material-symbols-outlined text-lg">star</span>
                        </span>
                        <input type="number" name="score" id="score" value="{{ old('score', $question->score) }}" required 
                            class="pl-11 w-full text-sm font-semibold px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('score') border-rose-400 bg-rose-50/20 @enderror">
                    </div>
                    @error('score')
                        <p class="text-rose-500 text-xs font-semibold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Pertanyaan Textarea -->
            <div>
                <label for="question" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Teks Pertanyaan Soal</label>
                <textarea name="question" id="question" rows="4" required placeholder="Tuliskan pertanyaan pilihan ganda Anda di sini..."
                    class="w-full text-sm font-semibold px-4 py-3.5 bg-slate-50/50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition @error('question') border-rose-400 bg-rose-50/20 @enderror">{{ old('question', $question->question) }}</textarea>
                @error('question')
                    <p class="text-rose-500 text-xs font-semibold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Gambar Soal (Optional) -->
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Gambar / Ilustrasi Pendukung (Opsional)</label>
                
                <!-- Gambar Saat Ini (Jika Ada) -->
                @if($question->image_path)
                    <div class="mb-4 bg-slate-50 border border-slate-200 rounded-2xl p-4 flex items-center gap-4 max-w-lg">
                        <div class="h-20 w-28 bg-white border rounded-xl overflow-hidden shadow-2xs shrink-0 flex items-center justify-center">
                            <img src="{{ asset('storage/' . $question->image_path) }}" class="max-h-full max-w-full object-contain">
                        </div>
                        <div>
                            <span class="px-2 py-0.5 bg-indigo-100 text-indigo-850 text-[9px] font-black rounded-md uppercase tracking-wider">Gambar Saat Ini</span>
                            <p class="text-[10px] text-slate-400 font-semibold mt-1">Mengunggah gambar baru akan menggantikan gambar yang sudah ada secara otomatis.</p>
                        </div>
                    </div>
                @endif

                <div class="relative flex flex-col items-center justify-center p-6 border-2 border-dashed border-slate-200 hover:border-indigo-400 bg-slate-50/30 rounded-2xl cursor-pointer transition duration-200 group">
                    <input type="file" name="image_upload" id="image_upload" accept="image/*" 
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                        @change="handleFileSelected">
                    <div class="text-center">
                        <span class="material-symbols-outlined text-slate-455 group-hover:text-indigo-500 text-3xl transition duration-200 mb-2">image</span>
                        <p class="text-xs font-extrabold text-slate-700" x-text="fileName ? fileName : 'Pilih atau Tarik Gambar Baru Ke Sini'"></p>
                        <p class="text-[10px] text-slate-400 font-semibold mt-1">Format: JPG, PNG. Ukuran maks: 2MB.</p>
                    </div>
                </div>
                @error('image_upload')
                    <p class="text-rose-500 text-xs font-semibold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <hr class="border-slate-100 my-8">

            <!-- Pilihan Jawaban Section -->
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-slate-50 pb-3">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800">Pilihan Jawaban</h3>
                        <p class="text-[11px] text-slate-400 font-semibold">Tentukan pilihan jawaban dan centang tombol Kunci Jawaban pada pilihan yang benar.</p>
                    </div>
                    <button type="button" @click="addOption" class="inline-flex items-center gap-1 text-xs font-black text-indigo-600 hover:text-indigo-800 transition uppercase tracking-wider">
                        <span class="material-symbols-outlined text-sm">add_circle</span>
                        Tambah Opsi
                    </button>
                </div>
                
                @error('options')
                    <p class="text-rose-600 text-xs font-semibold mt-1">{{ $message }}</p>
                @enderror
                @error('correct_option')
                    <p class="text-rose-600 text-xs font-semibold mt-1">{{ $message }}</p>
                @enderror

                <!-- Dynamic Options Rows -->
                <div class="space-y-4">
                    <template x-for="(option, index) in options" :key="index">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 border rounded-2xl transition-all duration-250 bg-slate-50/10" 
                            :class="option.isCorrect ? 'border-emerald-300 bg-emerald-50/10 ring-4 ring-emerald-500/5' : 'border-slate-200/80 hover:border-slate-300 bg-white'">
                            
                            <!-- Label / Badge -->
                            <div class="flex items-center gap-2 w-full sm:w-auto">
                                <span class="h-8 w-8 rounded-full flex items-center justify-center font-black text-sm shrink-0"
                                    :class="option.isCorrect ? 'bg-emerald-500 text-white' : 'bg-slate-100 text-slate-500'">
                                    <span x-text="option.label"></span>
                                </span>
                                <input type="hidden" :name="'options['+index+'][label]'" x-model="option.label">
                                <input type="hidden" :name="'options['+index+'][id]'" x-model="option.id">
                            </div>

                            <!-- Jawaban Text Input -->
                            <div class="flex-1 w-full">
                                <input type="text" :name="'options['+index+'][option]'" x-model="option.text" required placeholder="Tuliskan teks pilihan jawaban..."
                                    class="w-full text-xs sm:text-sm font-semibold px-3 py-2.5 bg-slate-50/20 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                            </div>

                            <!-- Actions (Kunci Jawaban Toggle & Hapus) -->
                            <div class="flex items-center justify-between sm:justify-end gap-3 w-full sm:w-auto shrink-0 border-t sm:border-0 pt-3 sm:pt-0">
                                <!-- Kunci Jawaban Label Button -->
                                <label class="flex items-center gap-1.5 cursor-pointer px-3.5 py-2 rounded-xl border text-[11px] font-black uppercase tracking-wider transition duration-200" 
                                    :class="option.isCorrect ? 'bg-emerald-500 border-emerald-500 text-white shadow-xs' : 'bg-white border-slate-200 text-slate-500 hover:bg-slate-50'">
                                    <input type="radio" name="correct_option" :value="index" x-model="correctIndex" @change="setCorrect(index)" class="sr-only">
                                    <span class="material-symbols-outlined text-[15px]" x-text="option.isCorrect ? 'check_circle' : 'circle'"></span>
                                    Kunci Jawaban
                                </label>

                                <!-- Hapus Button -->
                                <button type="button" @click="removeOption(index)" x-show="options.length > 2" 
                                    class="inline-flex items-center justify-center h-8.5 w-8.5 text-rose-500 hover:text-white border border-rose-100 hover:bg-rose-500 rounded-xl transition duration-200 shrink-0">
                                    <span class="material-symbols-outlined text-base">delete</span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between border-t border-slate-100 pt-6 mt-8">
                <a href="{{ route('admin.assessments.show', $question->assessment_id) }}" 
                    class="px-5 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-wider transition">
                    Batal
                </a>
                <button type="submit" 
                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
    
    @php
        $existingOptions = $question->options->map(function($opt, $index) {
            return [
                'id' => $opt->id,
                'label' => $opt->label,
                'text' => $opt->option, // Correct map using 'option' column!
                'isCorrect' => (bool)$opt->is_correct
            ];
        })->toArray();
        $correctIndex = $question->options->search(function($opt) { return $opt->is_correct; });
    @endphp

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('questionForm', () => ({
                correctIndex: '{{ $correctIndex !== false ? $correctIndex : 0 }}',
                fileName: '',
                options: @json($existingOptions),
                
                init() {
                    if (this.options.length === 0) {
                        this.options = [
                            { id: null, label: 'A', text: '', isCorrect: true },
                            { id: null, label: 'B', text: '', isCorrect: false },
                            { id: null, label: 'C', text: '', isCorrect: false },
                            { id: null, label: 'D', text: '', isCorrect: false }
                        ];
                    }
                },
                handleFileSelected(e) {
                    const file = e.target.files[0];
                    if (file) {
                        this.fileName = file.name;
                    } else {
                        this.fileName = '';
                    }
                },
                addOption() {
                    const labels = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                    const nextLabel = this.options.length < labels.length ? labels[this.options.length] : String.fromCharCode(65 + this.options.length);
                    this.options.push({ id: null, label: nextLabel, text: '', isCorrect: false });
                },
                removeOption(index) {
                    this.options.splice(index, 1);
                    // Re-calculate alphabetical labels
                    this.options.forEach((opt, i) => {
                        const labels = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                        opt.label = i < labels.length ? labels[i] : String.fromCharCode(65 + i);
                    });
                    
                    // Reset correct answer if deleted was correct
                    if (this.correctIndex == index) {
                        this.correctIndex = '0';
                        this.setCorrect(0);
                    } else if (this.correctIndex > index) {
                        this.correctIndex = String(parseInt(this.correctIndex) - 1);
                    }
                },
                setCorrect(index) {
                    this.options.forEach((opt, i) => {
                        opt.isCorrect = (i == index);
                    });
                }
            }))
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>
