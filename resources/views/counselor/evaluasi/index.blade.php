<x-app-layout>
    <x-slot name="title">Evaluasi Peserta Didik - LENTERA</x-slot>

    <div x-data="evaluasiHandler()" class="w-full max-w-7xl mx-auto space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                        Meja Kerja Evaluasi Kelas
                    </span>
                    <span class="text-xs text-slate-500 font-medium">
                        Topik {{ $selectedModule->urutan ?? 1 }}
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Evaluasi Peserta Didik</h1>
                <p class="text-xs sm:text-sm text-slate-600 mt-1">
                    Kelola penilaian instrumen (Penilaian Diri, Refleksi Diri, dan Lembar Komitmen) peserta didik per kelas.
                </p>
            </div>

            <!-- Quick School & Class Badge -->
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 shadow-2xs">
                    <span class="material-symbols-outlined text-sm text-indigo-600">apartment</span>
                    {{ $selectedSchool->nama ?? 'Semua Sekolah' }}
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-50 border border-indigo-200 text-xs font-bold text-indigo-700 shadow-2xs">
                    <span class="material-symbols-outlined text-sm">class</span>
                    {{ $selectedKelas->nama_kelas ?? '-' }}
                </span>
            </div>
        </div>

        <!-- Notification Banner -->
        @if(session('success'))
        <div class="flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl shadow-xs" role="alert">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <p class="text-xs sm:text-sm font-semibold">{{ session('success') }}</p>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 cursor-pointer">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
        @endif

        <!-- Filter Bar Card -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                
                <!-- 1. Filter Sekolah -->
                <div>
                    <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-1.5">
                        Sekolah Binaan
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">apartment</span>
                        <select onchange="window.location.href = '?school_id=' + this.value + '&module_id={{ $selectedModule->id ?? 1 }}'"
                                class="w-full pl-9 pr-9 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-xs font-bold text-slate-800 appearance-none shadow-2xs transition cursor-pointer">
                            @foreach($schools as $sc)
                                <option value="{{ $sc->id }}" {{ ($selectedSchool?->id == $sc->id) ? 'selected' : '' }}>
                                    {{ $sc->nama }} ({{ $sc->kelas_count }} Kelas)
                                </option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-base">expand_more</span>
                    </div>
                </div>

                <!-- 2. Filter Kelas -->
                <div>
                    <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-1.5">
                        Kelas
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">groups</span>
                        <select onchange="window.location.href = '?school_id={{ $selectedSchool?->id }}&kelas_id=' + this.value + '&module_id={{ $selectedModule->id ?? 1 }}'"
                                class="w-full pl-9 pr-9 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-xs font-bold text-slate-800 appearance-none shadow-2xs transition cursor-pointer">
                            @forelse($kelasList as $kls)
                                <option value="{{ $kls->id }}" {{ ($selectedKelas?->id == $kls->id) ? 'selected' : '' }}>
                                    Kelas {{ $kls->nama_kelas }} ({{ $kls->students_count }} Siswa)
                                </option>
                            @empty
                                <option value="">-- Belum ada kelas --</option>
                            @endforelse
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-base">expand_more</span>
                    </div>
                </div>

                <!-- 3. Filter Topik -->
                <div>
                    <label class="block text-[11px] font-black uppercase tracking-wider text-slate-400 mb-1.5">
                        Topik Pelatihan Empati
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">auto_stories</span>
                        <select onchange="window.location.href = '?school_id={{ $selectedSchool?->id }}&kelas_id={{ $selectedKelas?->id }}&module_id=' + this.value"
                                class="w-full pl-9 pr-9 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-xs font-bold text-slate-800 appearance-none shadow-2xs transition cursor-pointer">
                            @foreach($modules as $m)
                                <option value="{{ $m->id }}" {{ ($selectedModule?->id == $m->id) ? 'selected' : '' }}>
                                    Topik {{ $m->urutan }}: {{ $m->judul }}
                                </option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-base">expand_more</span>
                    </div>
                </div>

            </div>

            <!-- Topik Tab Selector (Quick Access) -->
            <div class="pt-2 border-t border-slate-100 flex items-center gap-2 overflow-x-auto pb-1">
                @foreach($modules as $modItem)
                    @php $isCurrentMod = $selectedModule?->id == $modItem->id; @endphp
                    <a href="?school_id={{ $selectedSchool?->id }}&kelas_id={{ $selectedKelas?->id }}&module_id={{ $modItem->id }}"
                       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-extrabold transition-all shrink-0 select-none {{ $isCurrentMod ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200/60' }}">
                        <span class="w-5 h-5 rounded-md flex items-center justify-center text-[10px] font-black {{ $isCurrentMod ? 'bg-white/20 text-white' : 'bg-indigo-100 text-indigo-700' }}">
                            {{ $modItem->urutan }}
                        </span>
                        <span>{{ $modItem->judul }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Progress Overview Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-black uppercase tracking-wider text-slate-400">Total Siswa di Kelas</p>
                    <p class="text-2xl font-black text-slate-900 mt-0.5">{{ $totalStudents }} <span class="text-xs font-semibold text-slate-500">Siswa</span></p>
                </div>
                <div class="w-12 h-12 bg-slate-100 text-slate-600 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">groups</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-black uppercase tracking-wider text-emerald-600">Sudah Dievaluasi</p>
                    <p class="text-2xl font-black text-emerald-700 mt-0.5">
                        {{ $evaluatedCount }} 
                        <span class="text-xs font-semibold text-emerald-600">
                            ({{ $totalStudents > 0 ? round(($evaluatedCount / $totalStudents) * 100) : 0 }}%)
                        </span>
                    </p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">task_alt</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-2xs flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-black uppercase tracking-wider text-amber-600">Perlu Dievaluasi</p>
                    <p class="text-2xl font-black text-amber-700 mt-0.5">{{ $pendingCount }} <span class="text-xs font-semibold text-amber-600">Siswa</span></p>
                </div>
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">pending_actions</span>
                </div>
            </div>
        </div>

        <!-- Pedoman Standar Kategori Penilaian Capaian Topik -->
        <div x-data="{ openGuide: false }" class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
            <button type="button" 
                    @click="openGuide = !openGuide" 
                    class="w-full px-5 py-3.5 flex items-center justify-between text-left hover:bg-slate-50 transition cursor-pointer">
                <div class="flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-indigo-600 text-lg">menu_book</span>
                    <span class="text-xs font-black text-slate-800 uppercase tracking-wider">
                        Pedoman Acuan Kategori Capaian Topik (Akumulasi Seluruh Jenis Asesmen)
                    </span>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700">5 Kategori</span>
                </div>
                <div class="flex items-center gap-1.5 text-xs text-slate-400 font-bold">
                    <span x-text="openGuide ? 'Tutup Tabel Acuan' : 'Lihat Tabel Acuan'"></span>
                    <span class="material-symbols-outlined text-sm transition-transform" :class="openGuide ? 'rotate-180' : ''">expand_more</span>
                </div>
            </button>
            <div x-show="openGuide" class="border-t border-slate-100 p-5 bg-slate-50/50 space-y-4">
                <div class="p-3.5 bg-indigo-50/70 border border-indigo-100 rounded-2xl text-xs text-indigo-950 flex items-start gap-3">
                    <span class="material-symbols-outlined text-indigo-600 text-lg shrink-0 mt-0.5">info</span>
                    <div>
                        <p class="font-extrabold text-indigo-900 mb-0.5">Prinsip Bimbingan Konseling:</p>
                        <p class="leading-relaxed text-indigo-800/90 font-medium">
                            Hasil evaluasi menjadi dasar bagi konselor untuk menentukan bentuk tindak lanjut yang sesuai dengan kebutuhan peserta didik. 
                            <strong>Tindak lanjut dilakukan secara bertahap dan tidak dimaksudkan untuk memberikan hukuman kepada peserta didik.</strong>
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white">
                    <table class="min-w-full text-xs divide-y divide-slate-100">
                        <thead class="bg-slate-50 text-[10px] font-black uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-3 py-2.5 text-center w-28">Persentase</th>
                                <th class="px-3 py-2.5 text-center w-36">Kategori</th>
                                <th class="px-4 py-2.5 text-left w-1/3">Karakteristik Capaian</th>
                                <th class="px-4 py-2.5 text-left">Rekomendasi Tindak Lanjut Konselor</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($tindakLanjutGuidelines as $g)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-3 py-3 text-center font-bold text-slate-700 whitespace-nowrap">{{ $g['range'] }}</td>
                                <td class="px-3 py-3 text-center whitespace-nowrap">
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-black border {{ $g['badge'] }}">
                                        {{ $g['category'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-slate-700 leading-relaxed font-medium">
                                    <p class="font-bold text-slate-900 mb-0.5">{{ $g['meaning'] }}</p>
                                    <p class="text-[11px] text-slate-500">{{ $g['deskripsi'] }}</p>
                                </td>
                                <td class="px-4 py-3 text-slate-700">
                                    <ul class="space-y-1 text-[11px] text-slate-600">
                                        @foreach($g['tindak_lanjut'] as $tl)
                                            <li class="flex items-start gap-1.5">
                                                <span class="text-indigo-600 font-bold">•</span>
                                                <span>{{ $tl }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @if($g['catatan_penting'])
                                        <div class="mt-2 p-2 rounded-lg bg-amber-50 border border-amber-200 text-[10px] text-amber-800 font-medium">
                                            <strong>Catatan:</strong> {{ $g['catatan_penting'] }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Gradebook Table Card -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
                <div>
                    <h2 class="text-base font-black text-slate-900">
                        Rekapitulasi Evaluasi: Kelas {{ $selectedKelas->nama_kelas ?? '-' }}
                    </h2>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">
                        Menilai 3 instrumen asesmen dan penetapan kategori capaian topik.
                    </p>
                </div>
                <span class="text-xs font-bold text-slate-500">
                    Menampilkan {{ $totalStudents }} Siswa
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50 text-[10px] font-black uppercase tracking-wider text-slate-400">
                        <tr>
                            <th scope="col" class="px-3 py-3.5 text-left w-10">No</th>
                            <th scope="col" class="px-4 py-3.5 text-left min-w-[160px]">Nama Peserta Didik</th>
                            <th scope="col" class="px-3 py-3.5 text-center">1. Penilaian Diri</th>
                            <th scope="col" class="px-3 py-3.5 text-center">2. Refleksi Diri</th>
                            <th scope="col" class="px-3 py-3.5 text-center">3. Lembar Komitmen</th>
                            <th scope="col" class="px-4 py-3.5 text-center bg-indigo-50/70 text-indigo-900 border-x border-indigo-100 font-black">Capaian Topik (Total)</th>
                            <th scope="col" class="px-3 py-3.5 text-center">Status</th>
                            <th scope="col" class="px-4 py-3.5 text-right w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($studentsData as $idx => $st)
                        <tr class="hover:bg-slate-50/80 transition-colors {{ $st['is_evaluated'] ? 'bg-emerald-50/20' : '' }}">
                            <td class="px-3 py-4 font-bold text-slate-400">
                                {{ $idx + 1 }}
                            </td>
                            <td class="px-4 py-4">
                                <p class="font-black text-slate-900 text-sm">{{ $st['name'] }}</p>
                                <p class="text-[11px] text-slate-500 font-semibold mt-0.5">NIS: {{ $st['nis'] }}</p>
                            </td>

                            <!-- 1. Penilaian Diri -->
                            <td class="px-3 py-4 text-center">
                                @if(($st['self_evaluated'] ?? false))
                                    <div class="inline-flex flex-col items-center">
                                        <span class="font-extrabold text-slate-800 text-xs">
                                            {{ $st['current_self_score'] }} / {{ $maxSelfScore }}
                                        </span>
                                        <span class="text-[10px] text-emerald-700 font-bold mt-0.5">
                                            ({{ $st['self_details']['percentage'] ?? 0 }}%)
                                        </span>
                                    </div>
                                @elseif($st['self_done'])
                                    <div class="inline-flex flex-col items-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Siswa: {{ number_format($st['self_nilai'], 0) }}%
                                        </span>
                                        <span class="text-[9px] text-slate-400 font-medium mt-0.5">
                                            (Skor: {{ $st['rec_self'] ?? 0 }} / {{ $maxSelfScore }})
                                        </span>
                                    </div>
                                @else
                                    <span class="text-slate-300 text-xs font-semibold">-</span>
                                @endif
                            </td>

                            <!-- 2. Refleksi Diri -->
                            <td class="px-3 py-4 text-center">
                                @if(($st['refleksi_evaluated'] ?? false))
                                    <div class="inline-flex flex-col items-center">
                                        <span class="font-extrabold text-slate-800 text-xs">
                                            {{ $st['current_refleksi_score'] }} / {{ $maxRefleksiScore }}
                                        </span>
                                        <span class="text-[10px] text-blue-700 font-bold mt-0.5">
                                            ({{ $st['refleksi_details']['percentage'] ?? 0 }}%)
                                        </span>
                                    </div>
                                @elseif($st['refleksi_done'])
                                    <div class="inline-flex flex-col items-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                            Siswa: {{ number_format($st['refleksi_nilai'], 0) }}%
                                        </span>
                                        <span class="text-[9px] text-slate-400 font-medium mt-0.5">
                                            (Skor: {{ $st['rec_refleksi'] ?? 0 }} / {{ $maxRefleksiScore }})
                                        </span>
                                    </div>
                                @else
                                    <span class="text-slate-300 text-xs font-semibold">-</span>
                                @endif
                            </td>

                            <!-- 3. Lembar Komitmen -->
                            <td class="px-3 py-4 text-center">
                                @if(($st['commit_evaluated'] ?? false))
                                    <div class="inline-flex flex-col items-center">
                                        <span class="font-extrabold text-slate-800 text-xs">
                                            {{ $st['current_commit_score'] }} / {{ $maxCommitmentScore }}
                                        </span>
                                        <span class="text-[10px] text-purple-700 font-bold mt-0.5">
                                            ({{ $st['commit_details']['percentage'] ?? 0 }}%)
                                        </span>
                                    </div>
                                @elseif($st['commit_done'])
                                    <div class="inline-flex flex-col items-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                            Siswa: {{ number_format($st['commit_nilai'], 0) }}%
                                        </span>
                                        <span class="text-[9px] text-slate-400 font-medium mt-0.5">
                                            (Skor: {{ $st['rec_commit'] ?? 0 }} / {{ $maxCommitmentScore }})
                                        </span>
                                    </div>
                                @else
                                    <span class="text-slate-300 text-xs font-semibold">-</span>
                                @endif
                            </td>

                            <!-- Capaian Topik (Total) -->
                            <td class="px-4 py-4 text-center bg-indigo-50/20 border-x border-indigo-100/50">
                                @if($st['is_fully_evaluated'])
                                    <div class="inline-flex flex-col items-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black border {{ $st['overall_badge'] }}">
                                            {{ $st['overall_category'] }} ({{ $st['overall_percentage'] }}%)
                                        </span>
                                        <span class="text-[10px] text-slate-600 font-bold mt-0.5" title="{{ $st['overall_meaning'] }}">
                                            Total: {{ $st['total_score'] }} / {{ $maxTotalScore }}
                                        </span>
                                        <span class="text-[9px] text-slate-400 font-medium max-w-[150px] truncate block" title="{{ $st['overall_meaning'] }}">
                                            {{ $st['overall_meaning'] }}
                                        </span>
                                    </div>
                                @elseif($st['is_fully_done'])
                                    <div class="inline-flex flex-col items-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black border {{ $st['overall_badge'] }}">
                                            {{ $st['overall_category'] }} ({{ $st['overall_percentage'] }}%)
                                        </span>
                                        <span class="text-[9px] text-indigo-600 font-bold mt-0.5">
                                            Pengerjaan Siswa
                                        </span>
                                        <span class="text-[9px] text-slate-400 font-medium max-w-[150px] truncate block" title="{{ $st['overall_meaning'] }}">
                                            {{ $st['overall_meaning'] }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-slate-300 text-xs font-semibold" title="Menunggu seluruh asesmen selesai">-</span>
                                @endif
                            </td>

                            <!-- Status Badge -->
                            <td class="px-3 py-4 text-center">
                                @if($st['is_evaluated'])
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[10px] font-black bg-emerald-100 text-emerald-800">
                                        <span class="material-symbols-outlined text-[12px]">check</span>
                                        Sudah Dievaluasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-800">
                                        <span class="material-symbols-outlined text-[12px]">schedule</span>
                                        Perlu Dinilai
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="px-4 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button"
                                            @click="openEvaluationModal({{ $st['id'] }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-black transition-all cursor-pointer shadow-2xs
                                                {{ $st['is_evaluated'] ? 'bg-white border border-slate-200 hover:bg-slate-50 text-indigo-600' : 'bg-indigo-600 hover:bg-indigo-700 text-white' }}">
                                        <span class="material-symbols-outlined text-sm">{{ $st['is_evaluated'] ? 'edit' : 'add_task' }}</span>
                                        <span>{{ $st['is_evaluated'] ? 'Ubah Nilai' : 'Beri Nilai' }}</span>
                                    </button>

                                    <a href="{{ route('counselor.monitoring.student.detail', $st['id']) }}"
                                       title="Lihat Portofolio Lengkap Siswa"
                                       class="w-8 h-8 rounded-xl flex items-center justify-center bg-slate-50 hover:bg-slate-100 text-slate-500 hover:text-slate-800 border border-slate-200/80 transition-colors">
                                        <span class="material-symbols-outlined text-base">visibility</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <span class="material-symbols-outlined text-3xl mb-2">person_off</span>
                                <p class="text-sm font-semibold">Tidak ada peserta didik di kelas ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MODAL EVALUASI SISWA (Alpine.js) -->
        <div x-show="showModal"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             aria-labelledby="modal-title"
             role="dialog"
             aria-modal="true">

            <!-- Backdrop -->
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showModal = false"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="showModal"
                     x-transition:enter="ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-slate-200">

                    <form action="{{ route('counselor.evaluasi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="student_id" :value="activeStudent?.id">
                        <input type="hidden" name="module_id" value="{{ $selectedModule->id ?? 1 }}">
                        <input type="hidden" name="school_id" value="{{ $selectedSchool?->id }}">
                        <input type="hidden" name="kelas_id" value="{{ $selectedKelas?->id }}">

                        <!-- Header Modal -->
                        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                            <div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-indigo-100 text-indigo-800 mb-1">
                                    Evaluasi: Topik {{ $selectedModule->urutan }}
                                </span>
                                <h3 class="text-xl font-black text-slate-900 leading-tight" x-text="activeStudent?.name">
                                    Nama Siswa
                                </h3>
                                <p class="text-xs text-slate-500 font-semibold mt-0.5">
                                    Kelas <span x-text="activeStudent?.kelas_nama"></span> • NIS: <span x-text="activeStudent?.nis"></span>
                                </p>
                            </div>
                            <button type="button"
                                    @click="showModal = false"
                                    class="text-slate-400 hover:text-slate-600 rounded-xl p-2 hover:bg-slate-100 transition-colors cursor-pointer">
                                <span class="material-symbols-outlined text-lg">close</span>
                            </button>
                        </div>

                        <!-- Body Modal -->
                        <div class="p-6 space-y-5">
                            
                            <!-- Live Topic Capaian Card (Akumulasi Seluruh Jenis Asesmen) -->
                            <div class="p-4 rounded-2xl border transition-all"
                                 :class="overallCategory().badgeColor">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black uppercase tracking-wider opacity-75">
                                        Kategori Capaian Topik {{ $selectedModule->urutan }} (Total Seluruh Asesmen):
                                    </span>
                                    <span class="text-xs font-black" x-text="'Total Skor: ' + overallScore() + ' / ' + maxTotal"></span>
                                </div>
                                <div class="flex items-center gap-2 mt-1.5">
                                    <span class="text-base font-black" x-text="overallCategory().cat"></span>
                                    <span class="text-xs font-bold opacity-85" x-text="'(' + overallPct() + '%)'"></span>
                                </div>
                                <p class="text-[11px] font-semibold mt-1 leading-snug" x-text="'Makna: ' + overallCategory().makna"></p>
                                
                                <!-- Live Tindak Lanjut Panduan -->
                                <div class="mt-3 pt-3 border-t border-current/15 text-left space-y-2">
                                    <p class="text-[11px] font-medium leading-relaxed opacity-95" x-text="overallCategory().deskripsi"></p>
                                    <div>
                                        <span class="text-[10px] font-black uppercase tracking-wider opacity-80 block mb-1">
                                            Rekomendasi Tindak Lanjut:
                                        </span>
                                        <ul class="list-disc list-inside text-[11px] space-y-0.5 opacity-90 pl-0.5 font-medium leading-relaxed">
                                            <template x-for="(tl, idx) in (overallCategory().tindakLanjut || [])" :key="idx">
                                                <li x-text="tl"></li>
                                            </template>
                                        </ul>
                                    </div>
                                    <template x-if="overallCategory().catatanPenting">
                                        <div class="p-2.5 rounded-xl bg-white/70 border border-current/20 text-[10px] leading-relaxed">
                                            <span class="font-black">Catatan Penting:</span> <span x-text="overallCategory().catatanPenting"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- 3 Instruments Scoring Grid: Penilaian Diri, Refleksi Diri, Lembar Komitmen -->
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-indigo-600 text-base">fact_check</span>
                                        Input Skor Tiap Asesmen (Topik {{ $selectedModule->urutan }})
                                    </h4>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase">Skala Likert Berbobot</span>
                                </div>

                                <!-- 1. Penilaian Diri -->
                                <div class="p-4 rounded-2xl border border-slate-200 bg-emerald-50/20 space-y-3">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-extrabold text-slate-800 flex items-center gap-1.5">
                                            <span class="w-5 h-5 rounded bg-emerald-600 text-white flex items-center justify-center text-[10px] font-black">1</span>
                                            1. Penilaian Diri
                                        </label>
                                        <span class="text-xs font-black text-emerald-700" x-text="selfScore + ' / ' + maxSelf + ' (' + selfDetails().pct + '%)'"></span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <input type="range"
                                               min="0"
                                               :max="maxSelf"
                                               x-model.number="selfScore"
                                               class="flex-1 accent-emerald-600 cursor-pointer">
                                        <input type="number"
                                               name="self_score"
                                               min="0"
                                               :max="maxSelf"
                                               x-model.number="selfScore"
                                               class="w-16 px-2.5 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-black text-center focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                                    </div>
                                    <p class="text-[11px] text-slate-500 font-medium flex items-center justify-between">
                                        <span>Rekomendasi pengerjaan siswa:</span>
                                        <strong class="text-emerald-700" x-text="activeStudent?.rec_self !== null ? activeStudent?.rec_self + ' / ' + maxSelf : 'Belum mengerjakan'"></strong>
                                    </p>
                                </div>

                                <!-- 2. Refleksi Diri -->
                                <div class="p-4 rounded-2xl border border-slate-200 bg-blue-50/20 space-y-3">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-extrabold text-slate-800 flex items-center gap-1.5">
                                            <span class="w-5 h-5 rounded bg-blue-600 text-white flex items-center justify-center text-[10px] font-black">2</span>
                                            2. Refleksi Diri
                                        </label>
                                        <span class="text-xs font-black text-blue-700" x-text="refleksiScore + ' / ' + maxRefleksi + ' (' + refleksiDetails().pct + '%)'"></span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <input type="range"
                                               min="0"
                                               :max="maxRefleksi"
                                               x-model.number="refleksiScore"
                                               class="flex-1 accent-blue-600 cursor-pointer">
                                        <input type="number"
                                               name="refleksi_score"
                                               min="0"
                                               :max="maxRefleksi"
                                               x-model.number="refleksiScore"
                                               class="w-16 px-2.5 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-black text-center focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    </div>
                                    <p class="text-[11px] text-slate-500 font-medium flex items-center justify-between">
                                        <span>Rekomendasi pengerjaan siswa:</span>
                                        <strong class="text-blue-700" x-text="activeStudent?.rec_refleksi !== null ? activeStudent?.rec_refleksi + ' / ' + maxRefleksi : 'Belum mengerjakan'"></strong>
                                    </p>
                                </div>

                                <!-- 3. Lembar Komitmen -->
                                <div class="p-4 rounded-2xl border border-slate-200 bg-purple-50/20 space-y-3">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-extrabold text-slate-800 flex items-center gap-1.5">
                                            <span class="w-5 h-5 rounded bg-purple-600 text-white flex items-center justify-center text-[10px] font-black">3</span>
                                            3. Lembar Komitmen
                                        </label>
                                        <span class="text-xs font-black text-purple-700" x-text="commitScore + ' / ' + maxCommit + ' (' + commitDetails().pct + '%)'"></span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <input type="range"
                                               min="0"
                                               :max="maxCommit"
                                               x-model.number="commitScore"
                                               class="flex-1 accent-purple-600 cursor-pointer">
                                        <input type="number"
                                               name="commitment_score"
                                               min="0"
                                               :max="maxCommit"
                                               x-model.number="commitScore"
                                               class="w-16 px-2.5 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-black text-center focus:ring-2 focus:ring-purple-500 focus:outline-none">
                                    </div>
                                    <p class="text-[11px] text-slate-500 font-medium flex items-center justify-between">
                                        <span>Rekomendasi pengerjaan siswa:</span>
                                        <strong class="text-purple-700" x-text="activeStudent?.rec_commit !== null ? activeStudent?.rec_commit + ' / ' + maxCommit : 'Belum mengerjakan'"></strong>
                                    </p>
                                </div>

                            </div>

                            <!-- Catatan Observasi & Rekomendasi Konselor -->
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">
                                        Catatan Observasi & Rencana Tindak Lanjut
                                    </label>
                                    <button type="button"
                                            @click="copyTindakLanjutToNotes()"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-black bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition cursor-pointer">
                                        <span class="material-symbols-outlined text-[14px]">content_copy</span>
                                        Salin Rekomendasi ke Catatan
                                    </button>
                                </div>
                                <textarea name="notes"
                                          x-model="notes"
                                          rows="3"
                                          placeholder="Tuliskan catatan analisis perilaku, refleksi, atau rencana tindak lanjut bimbingan empati untuk siswa ini..."
                                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"></textarea>
                            </div>

                        </div>

                        <!-- Footer Modal -->
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 rounded-b-3xl">
                            <button type="button"
                                    @click="showModal = false"
                                    class="px-4 py-2 text-xs font-bold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                                Batal
                            </button>
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-xs font-black rounded-xl shadow-xs transition cursor-pointer">
                                <span class="material-symbols-outlined text-sm">save</span>
                                <span>Simpan Evaluasi</span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

    <script>
        function evaluasiHandler() {
            return {
                showModal: false,
                activeStudent: null,
                selfScore: 0,
                refleksiScore: 0,
                commitScore: 0,
                notes: '',
                maxSelf: {{ $maxSelfScore }},
                maxRefleksi: {{ $maxRefleksiScore }},
                maxCommit: {{ $maxCommitmentScore }},
                maxTotal: {{ $maxTotalScore }},
                studentsData: @json($studentsData),
                
                openEvaluationModal(studentId) {
                    const st = this.studentsData.find(s => s.id === studentId);
                    if (!st) return;
                    this.activeStudent = st;
                    this.selfScore = st.current_self_score;
                    this.refleksiScore = st.current_refleksi_score;
                    this.commitScore = st.current_commit_score;
                    this.notes = st.current_notes || '';
                    this.showModal = true;
                },

                getCategoryForPct(pct) {
                    if (pct >= 85) {
                        return {
                            cat: 'Sangat Baik',
                            makna: 'Capaian sangat baik dan dapat dipertahankan',
                            deskripsi: 'Peserta didik yang memperoleh hasil dalam kategori Sangat Baik menunjukkan capaian yang baik dalam memahami materi, melakukan refleksi, dan membangun komitmen perilaku positif.',
                            tindakLanjut: [
                                'Memberikan penguatan positif',
                                'Mempertahankan perilaku yang sudah berkembang',
                                'Memberikan kesempatan untuk menjadi contoh perilaku positif bagi teman',
                                'Mendorong peserta didik untuk menerapkan nilai empati dalam kehidupan sehari-hari'
                            ],
                            catatanPenting: null,
                            color: 'emerald',
                            badgeColor: 'bg-emerald-100 text-emerald-800 border-emerald-200'
                        };
                    }
                    if (pct >= 75) {
                        return {
                            cat: 'Baik',
                            makna: 'Capaian baik, dengan penguatan pada aspek tertentu',
                            deskripsi: 'Peserta didik dalam kategori Baik telah menunjukkan capaian yang memadai, tetapi masih terdapat aspek yang dapat dikembangkan.',
                            tindakLanjut: [
                                'Memberikan penguatan pada aspek yang belum optimal',
                                'Mendorong penerapan keterampilan empati dalam situasi nyata',
                                'Melakukan pemantauan perkembangan pada kegiatan berikutnya',
                                'Memberikan umpan balik secara positif dan konstruktif'
                            ],
                            catatanPenting: null,
                            color: 'blue',
                            badgeColor: 'bg-blue-100 text-blue-800 border-blue-200'
                        };
                    }
                    if (pct >= 65) {
                        return {
                            cat: 'Cukup',
                            makna: 'Memerlukan penguatan dan pendampingan',
                            deskripsi: 'Peserta didik dalam kategori Cukup memerlukan penguatan agar pemahaman dan keterampilan yang diperoleh dapat diterapkan secara lebih konsisten.',
                            tindakLanjut: [
                                'Memberikan penguatan atau pengulangan materi tertentu',
                                'Mengajak peserta didik melakukan refleksi kembali',
                                'Memberikan contoh situasi yang lebih dekat dengan kehidupan peserta didik',
                                'Melakukan pendampingan secara individual atau kelompok kecil apabila diperlukan',
                                'Memantau perkembangan peserta didik pada kegiatan berikutnya'
                            ],
                            catatanPenting: null,
                            color: 'amber',
                            badgeColor: 'bg-amber-100 text-amber-800 border-amber-200'
                        };
                    }
                    if (pct >= 55) {
                        return {
                            cat: 'Kurang',
                            makna: 'Memerlukan pembinaan lebih lanjut',
                            deskripsi: 'Peserta didik dalam kategori Kurang memerlukan pembinaan lebih lanjut. Konselor perlu mengidentifikasi aspek yang menyebabkan capaian peserta didik belum optimal.',
                            tindakLanjut: [
                                'Melakukan pembinaan secara terarah',
                                'Memberikan pengulangan atau penguatan pada materi yang belum dipahami',
                                'Melakukan refleksi dan diskusi individual',
                                'Memberikan latihan tambahan yang sesuai dengan kebutuhan peserta didik',
                                'Melakukan pemantauan secara berkala',
                                'Memberikan layanan konseling individual atau kelompok apabila hasil asesmen menunjukkan kebutuhan tersebut'
                            ],
                            catatanPenting: 'Hasil kategori "Kurang" bukan berarti peserta didik adalah pelaku atau korban perundungan. Hasil tersebut menunjukkan bahwa peserta didik membutuhkan penguatan atau pendampingan dalam proses layanan LENTERA.',
                            color: 'orange',
                            badgeColor: 'bg-orange-100 text-orange-800 border-orange-200'
                        };
                    }
                    return {
                        cat: 'Sangat Kurang',
                        makna: 'Memerlukan pembinaan dan pendampingan lebih intensif',
                        deskripsi: 'Peserta didik dalam kategori Sangat Kurang memerlukan pendampingan lebih intensif. Konselor tidak langsung menyimpulkan bahwa peserta didik memiliki masalah perilaku, tetapi perlu melakukan identifikasi lebih lanjut terhadap kondisi dan kebutuhan peserta didik.',
                        tindakLanjut: [
                            'Melakukan pembinaan dan pendampingan secara lebih intensif',
                            'Melakukan asesmen atau identifikasi kebutuhan lebih lanjut',
                            'Memberikan layanan konseling individual/kelompok sesuai kebutuhan',
                            'Melakukan koordinasi dengan pihak terkait sesuai prinsip kerahasiaan dan kebutuhan peserta didik',
                            'Melakukan monitoring perkembangan secara berkala'
                        ],
                        catatanPenting: 'Hasil kategori "Sangat Kurang" bukan berarti peserta didik adalah pelaku atau korban perundungan. Hasil tersebut menunjukkan bahwa peserta didik membutuhkan penguatan atau pendampingan dalam proses layanan LENTERA.',
                        color: 'rose',
                        badgeColor: 'bg-rose-100 text-rose-800 border-rose-200'
                    };
                },

                copyTindakLanjutToNotes() {
                    const tl = this.overallCategory().tindakLanjut || [];
                    if (tl.length === 0) return;
                    const textToInsert = 'Rekomendasi Tindak Lanjut:\n• ' + tl.join('\n• ');
                    if (!this.notes || this.notes.trim() === '') {
                        this.notes = textToInsert;
                    } else if (!this.notes.includes('Rekomendasi Tindak Lanjut:')) {
                        this.notes = this.notes + '\n\n' + textToInsert;
                    }
                },

                selfDetails() {
                    const pct = this.maxSelf > 0 ? Math.min(100, Math.max(0, Math.round((this.selfScore / this.maxSelf) * 100))) : 0;
                    const res = this.getCategoryForPct(pct);
                    return { pct, ...res };
                },

                refleksiDetails() {
                    const pct = this.maxRefleksi > 0 ? Math.min(100, Math.max(0, Math.round((this.refleksiScore / this.maxRefleksi) * 100))) : 0;
                    const res = this.getCategoryForPct(pct);
                    return { pct, ...res };
                },

                commitDetails() {
                    const pct = this.maxCommit > 0 ? Math.min(100, Math.max(0, Math.round((this.commitScore / this.maxCommit) * 100))) : 0;
                    const res = this.getCategoryForPct(pct);
                    return { pct, ...res };
                },

                overallScore() {
                    return (Number(this.selfScore) || 0) + (Number(this.refleksiScore) || 0) + (Number(this.commitScore) || 0);
                },

                overallPct() {
                    const pctSelf = this.maxSelf > 0 ? (this.selfScore / this.maxSelf) * 100 : 0;
                    const pctRefleksi = this.maxRefleksi > 0 ? (this.refleksiScore / this.maxRefleksi) * 100 : 0;
                    const pctCommit = this.maxCommit > 0 ? (this.commitScore / this.maxCommit) * 100 : 0;
                    return Math.min(100, Math.max(0, Math.round((pctSelf + pctRefleksi + pctCommit) / 3)));
                },

                overallCategory() {
                    const pct = this.overallPct();
                    const res = this.getCategoryForPct(pct);
                    return { pct, ...res };
                },

                init() {
                    @if($autoOpenStudentId)
                        this.openEvaluationModal({{ $autoOpenStudentId }});
                    @endif
                }
            };
        }
    </script>
</x-app-layout>
