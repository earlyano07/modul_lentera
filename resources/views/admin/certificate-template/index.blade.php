<x-app-layout>
    <x-slot name="title">Template Sertifikat Word</x-slot>

    <!-- Header Section -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-600 text-3xl">description</span>
                Template Sertifikat (Microsoft Word)
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Kelola file template sertifikat Microsoft Word (.docx). Desain sertifikat secara bebas di Word, lalu unggah ke sini.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.certificate-template.preview-docx') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow-sm transition-all">
                <span class="material-symbols-outlined text-[18px]">play_circle</span>
                Uji Isi Data Contoh (.docx)
            </a>
            
            @if($template->docx_template_path)
                <form action="{{ route('admin.certificate-template.reset') }}" method="POST"
                    onsubmit="return confirm('Kembalikan template sertifikat ke template standar bawaan LENTERA?');">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-red-50 border border-red-200 text-red-600 rounded-lg text-sm font-semibold shadow-sm transition-all">
                        <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                        Reset ke Template Standar
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3">
            <span class="material-symbols-outlined text-emerald-600">check_circle</span>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl">
            <div class="flex items-center gap-2 font-semibold text-sm">
                <span class="material-symbols-outlined text-red-600">error</span>
                Mohon periksa kembali file yang diunggah:
            </div>
            <ul class="list-disc list-inside mt-2 text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main Container Grid -->
    <div class="space-y-6">

        <!-- Status & Upload Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                        <span class="material-symbols-outlined text-xl">file_present</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="font-bold text-gray-900 text-base">Status Template Aktif:</h2>
                            @if($template->docx_template_path)
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold bg-emerald-100 text-emerald-800 px-3 py-0.5 rounded-full">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Template Kustom (Diunggah Admin)
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold bg-blue-100 text-blue-800 px-3 py-0.5 rounded-full">
                                    <span class="w-2 h-2 rounded-full bg-blue-500"></span> Template Standar Bawaan LENTERA
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Template ini yang otomatis digunakan sistem saat Siswa atau Guru BK mengunduh sertifikat (.docx).
                        </p>
                    </div>
                </div>

                <!-- Template Download Actions -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.certificate-template.download-docx-template') }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white border border-blue-200 hover:bg-blue-50 text-blue-700 font-bold text-xs rounded-xl transition shadow-2xs">
                        <span class="material-symbols-outlined text-[18px]">download</span>
                        Unduh Template Aktif
                    </a>
                    <a href="{{ route('admin.certificate-template.download-default-docx-template') }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition shadow-2xs">
                        <span class="material-symbols-outlined text-[18px]">file_download</span>
                        Unduh Template Standar
                    </a>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- Left Column: Upload New Template -->
                <div class="lg:col-span-5 bg-slate-50 p-6 rounded-2xl border border-slate-200/80">
                    <h3 class="text-sm font-bold text-slate-900 mb-1 flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-600 text-xl">upload_file</span>
                        Unggah Template Word (.docx)
                    </h3>
                    <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                        Pilih file Word hasil desain Anda yang sudah berisi variabel penanda (seperti <code>${nama}</code>).
                    </p>

                    <form action="{{ route('admin.certificate-template.upload-docx') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih File .docx</label>
                            <input type="file" name="docx_template" accept=".docx" required
                                class="block w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer cursor-pointer border border-slate-300 rounded-xl bg-white focus:outline-none">
                        </div>

                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
                            <span class="material-symbols-outlined text-[18px]">cloud_upload</span>
                            Simpan & Terapkan Template
                        </button>
                    </form>

                    <!-- Instructions -->
                    <div class="mt-5 pt-4 border-t border-slate-200 text-xs text-slate-500 space-y-2">
                        <div class="font-bold text-slate-700">Panduan Praktis:</div>
                        <ol class="list-decimal list-inside space-y-1 text-[11px] leading-relaxed">
                            <li>Unduh <strong>Template Standar</strong> di atas sebagai dasar.</li>
                            <li>Buka & atur desain, logo, border, atau jenis huruf di Word.</li>
                            <li>Pastikan variabel seperti <code class="bg-slate-200 px-1 rounded">${nama}</code> tidak terhapus.</li>
                            <li>Simpan file Word (.docx) lalu unggah kembali melalui form di atas.</li>
                        </ol>
                    </div>
                </div>

                <!-- Right Column: Cheatsheet Table of Placeholders -->
                <div class="lg:col-span-7" x-data="{ copiedTag: null }">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                                <span class="material-symbols-outlined text-indigo-600 text-xl">code</span>
                                Daftar Variabel Penanda
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Klik tombol <strong>Salin</strong> untuk menyalin variabel, lalu tempel (*paste*) ke dalam template Word.
                            </p>
                        </div>
                    </div>

                    <div class="border border-slate-200 rounded-xl overflow-hidden shadow-2xs">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-100 text-slate-700 font-bold border-b border-slate-200">
                                <tr>
                                    <th class="px-3.5 py-2.5">Variabel di Word</th>
                                    <th class="px-3.5 py-2.5">Keterangan Data</th>
                                    <th class="px-3.5 py-2.5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @php
                                    $placeholders = [
                                        ['tag' => '${nama}', 'desc' => 'Nama Lengkap Siswa'],
                                        ['tag' => '${nis}', 'desc' => 'NIS / NISN Siswa'],
                                        ['tag' => '${kelas}', 'desc' => 'Nama Kelas Siswa (contoh: Kelas VIII A)'],
                                        ['tag' => '${sekolah}', 'desc' => 'Nama Sekolah'],
                                        ['tag' => '${no_sertifikat}', 'desc' => 'Nomor Registrasi Sertifikat Otomatis'],
                                        ['tag' => '${tanggal}', 'desc' => 'Tanggal Penyelesaian / Terbit Sertifikat'],
                                        ['tag' => '${guru_bk}', 'desc' => 'Nama Guru BK / Konselor Penandatangan'],
                                        ['tag' => '${nip_guru_bk}', 'desc' => 'NIP Guru BK'],
                                        ['tag' => '${nilai_topik_1}', 'desc' => 'Nilai Topik 1 (Menyadari Masalah, contoh: 82%)'],
                                        ['tag' => '${predikat_topik_1}', 'desc' => 'Predikat Topik 1 (contoh: Baik)'],
                                        ['tag' => '${nilai_topik_2}', 'desc' => 'Nilai Topik 2 (Memahami Emosi)'],
                                        ['tag' => '${predikat_topik_2}', 'desc' => 'Predikat Topik 2'],
                                        ['tag' => '${nilai_topik_3}', 'desc' => 'Nilai Topik 3 (Mengambil Perspektif)'],
                                        ['tag' => '${predikat_topik_3}', 'desc' => 'Predikat Topik 3'],
                                        ['tag' => '${nilai_topik_4}', 'desc' => 'Nilai Topik 4 (Bertindak Empatik)'],
                                        ['tag' => '${predikat_topik_4}', 'desc' => 'Predikat Topik 4'],
                                        ['tag' => '${nilai_topik_5}', 'desc' => 'Nilai Topik 5 (Membudayakan Anti-Perundungan)'],
                                        ['tag' => '${predikat_topik_5}', 'desc' => 'Predikat Topik 5'],
                                        ['tag' => '${nilai_akhir}', 'desc' => 'Rata-rata Capaian Keseluruhan (contoh: 84,6%)'],
                                        ['tag' => '${predikat_akhir}', 'desc' => 'Kategori Predikat Akhir (contoh: Baik)'],
                                    ];
                                @endphp
                                @foreach($placeholders as $p)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-3.5 py-2 font-mono font-bold text-indigo-600 select-all">{{ $p['tag'] }}</td>
                                        <td class="px-3.5 py-2 text-slate-600">{{ $p['desc'] }}</td>
                                        <td class="px-3.5 py-2 text-right">
                                            <button type="button"
                                                @click="navigator.clipboard.writeText('{{ $p['tag'] }}'); copiedTag = '{{ $p['tag'] }}'; setTimeout(() => copiedTag = null, 1500)"
                                                class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold rounded-lg bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 text-slate-600 transition">
                                                <span x-text="copiedTag === '{{ $p['tag'] }}' ? 'Disalin! ✓' : 'Salin'">Salin</span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <!-- Certificate Metadata Management Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden"
            x-data="{
                signerMode: '{{ old('signer_mode', $template->signer_mode ?? 'school_counselor') }}',
                certPrefix: '{{ old('cert_number_prefix', $template->cert_number_prefix ?? 'LTR') }}',
                certFormat: '{{ old('cert_number_format', $template->cert_number_format ?? 'No: {PREFIX}/{YEAR}/{CLASS}/{ID}') }}',
                dateType: '{{ old('date_type', $template->date_type ?? 'completion_date') }}',
                get sampleCertNumber() {
                    let p = this.certFormat || 'No: {PREFIX}/{YEAR}/{CLASS}/{ID}';
                    let yr = new Date().getFullYear();
                    let mo = String(new Date().getMonth() + 1).padStart(2, '0');
                    let romans = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
                    let romanMo = romans[new Date().getMonth()] || 'IX';
                    return p.replaceAll('{PREFIX}', this.certPrefix || 'LTR')
                            .replaceAll('{YEAR}', yr)
                            .replaceAll('{MONTH}', mo)
                            .replaceAll('{MONTH_ROMAN}', romanMo)
                            .replaceAll('{CLASS}', 'VIIIA')
                            .replaceAll('{ID}', '0005')
                            .replaceAll('{STUDENT_ID}', '0005');
                }
            }">
            
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 via-slate-50 to-emerald-50 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                        <span class="material-symbols-outlined text-xl">tune</span>
                    </div>
                    <div>
                        <h2 class="font-bold text-gray-900 text-base">Manajemen Data & Variabel Sertifikat</h2>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Atur aturan identitas Guru BK/Penandatangan, format penomoran sertifikat, dan penentuan tanggal cetak.
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.certificate-template.update-metadata') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                    
                    <!-- 1. Signer Settings (Guru BK) -->
                    <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-200 flex flex-col justify-between h-full space-y-4">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="material-symbols-outlined text-blue-600 text-xl">badge</span>
                                <h3 class="text-sm font-bold text-slate-900">1. Data Guru BK / Penandatangan</h3>
                            </div>
                            <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                                Pengaturan sumber data untuk variabel <code class="bg-blue-100/70 text-blue-800 px-1 rounded">${guru_bk}</code> dan <code class="bg-blue-100/70 text-blue-800 px-1 rounded">${nip_guru_bk}</code>.
                            </p>

                            <!-- Mode Selector -->
                            <div class="space-y-2 mb-4">
                                <label class="flex items-start gap-2.5 p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-blue-400 transition"
                                    :class="{ 'border-blue-500 ring-2 ring-blue-50': signerMode === 'school_counselor' }">
                                    <input type="radio" name="signer_mode" value="school_counselor" x-model="signerMode" class="mt-0.5 text-blue-600 focus:ring-blue-500">
                                    <div>
                                        <div class="text-xs font-bold text-slate-800">Otomatis Konselor Sekolah (Rekomendasi)</div>
                                        <div class="text-[11px] text-slate-500 leading-tight mt-0.5">Mengambil akun Guru BK yang ditugaskan pada sekolah siswa masing-masing.</div>
                                    </div>
                                </label>

                                <label class="flex items-start gap-2.5 p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-blue-400 transition"
                                    :class="{ 'border-blue-500 ring-2 ring-blue-50': signerMode === 'custom' }">
                                    <input type="radio" name="signer_mode" value="custom" x-model="signerMode" class="mt-0.5 text-blue-600 focus:ring-blue-500">
                                    <div>
                                        <div class="text-xs font-bold text-slate-800">Gunakan Penandatangan Khusus</div>
                                        <div class="text-[11px] text-slate-500 leading-tight mt-0.5">Selalu gunakan nama & NIP di bawah untuk semua sertifikat.</div>
                                    </div>
                                </label>
                            </div>

                            <!-- Input fields -->
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                        Nama Guru BK / Penandatangan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="default_signer_name"
                                        value="{{ old('default_signer_name', $template->default_signer_name) }}"
                                        placeholder="Contoh: Dra. Hj. Siti Nurjanah, M.Pd."
                                        class="w-full text-xs px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <p class="text-[10px] text-slate-400 mt-1" x-show="signerMode === 'school_counselor'">
                                        *Digunakan sebagai cadangan jika sekolah siswa belum menugaskan Guru BK.
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                        NIP Guru BK (Opsional)
                                    </label>
                                    <input type="text" name="default_signer_nip"
                                        value="{{ old('default_signer_nip', $template->default_signer_nip) }}"
                                        placeholder="Contoh: 19850315 201001 2 021 (atau kosongkan jika -)"
                                        class="w-full text-xs px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                        Jabatan Penandatangan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="signer_title" required
                                        value="{{ old('signer_title', $template->signer_title ?? 'Guru Bimbingan dan Konseling') }}"
                                        placeholder="Guru Bimbingan dan Konseling"
                                        class="w-full text-xs px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Certificate Number Settings -->
                    <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-200 flex flex-col justify-between h-full space-y-4">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="material-symbols-outlined text-indigo-600 text-xl">tag</span>
                                <h3 class="text-sm font-bold text-slate-900">2. Format Nomor Sertifikat</h3>
                            </div>
                            <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                                Pengaturan otomatisasi nomor registrasi untuk variabel <code class="bg-indigo-100/70 text-indigo-800 px-1 rounded">${no_sertifikat}</code>.
                            </p>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                        Awalan / Kode Prefix <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="cert_number_prefix" x-model="certPrefix" required
                                        placeholder="LTR"
                                        class="w-full text-xs px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-mono">
                                </div>

                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                        Pola Format Nomor Sertifikat <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="cert_number_format" x-model="certFormat" required
                                        placeholder="No: {PREFIX}/{YEAR}/{CLASS}/{ID}"
                                        class="w-full text-xs px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-mono">
                                </div>

                                <!-- Preset Format Buttons -->
                                <div>
                                    <span class="text-[11px] text-slate-500 font-semibold block mb-1.5">Pilihan Pola Cepat:</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        <button type="button" @click="certFormat = 'No: {PREFIX}/{YEAR}/{CLASS}/{ID}'"
                                            class="px-2 py-1 bg-white hover:bg-indigo-50 border border-slate-200 text-[10px] font-mono text-slate-700 rounded-lg transition">
                                            {PREFIX}/{YEAR}/{CLASS}/{ID}
                                        </button>
                                        <button type="button" @click="certFormat = 'No: {PREFIX}/{MONTH_ROMAN}/{YEAR}/{ID}'"
                                            class="px-2 py-1 bg-white hover:bg-indigo-50 border border-slate-200 text-[10px] font-mono text-slate-700 rounded-lg transition">
                                            {PREFIX}/{MONTH_ROMAN}/{YEAR}/{ID}
                                        </button>
                                        <button type="button" @click="certFormat = 'No: {ID}/{PREFIX}-BK/{YEAR}'"
                                            class="px-2 py-1 bg-white hover:bg-indigo-50 border border-slate-200 text-[10px] font-mono text-slate-700 rounded-lg transition">
                                            {ID}/{PREFIX}-BK/{YEAR}
                                        </button>
                                    </div>
                                </div>

                                <!-- Live Preview Box -->
                                <div class="mt-4 p-3.5 bg-indigo-50/80 border border-indigo-200/80 rounded-xl">
                                    <div class="text-[10px] font-bold text-indigo-700 uppercase tracking-wider mb-1 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">visibility</span>
                                        Pratinjau Hasil Nomor:
                                    </div>
                                    <div class="font-mono font-bold text-xs text-indigo-900 break-all select-all" x-text="sampleCertNumber"></div>
                                </div>

                                <div class="text-[10px] text-slate-400 space-y-0.5 pt-1">
                                    <div>Variabel tersedia: <code class="text-slate-600">{PREFIX}</code>, <code class="text-slate-600">{YEAR}</code>, <code class="text-slate-600">{MONTH}</code>, <code class="text-slate-600">{MONTH_ROMAN}</code>, <code class="text-slate-600">{CLASS}</code>, <code class="text-slate-600">{ID}</code></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Date Settings -->
                    <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-200 flex flex-col justify-between h-full space-y-4">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="material-symbols-outlined text-emerald-600 text-xl">calendar_today</span>
                                <h3 class="text-sm font-bold text-slate-900">3. Tanggal Sertifikat</h3>
                            </div>
                            <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                                Pengaturan penentuan tanggal terbit untuk variabel <code class="bg-emerald-100/70 text-emerald-800 px-1 rounded">${tanggal}</code>.
                            </p>

                            <div class="space-y-2.5 mb-4">
                                <label class="flex items-start gap-2.5 p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-emerald-400 transition"
                                    :class="{ 'border-emerald-500 ring-2 ring-emerald-50': dateType === 'completion_date' }">
                                    <input type="radio" name="date_type" value="completion_date" x-model="dateType" class="mt-0.5 text-emerald-600 focus:ring-emerald-500">
                                    <div>
                                        <div class="text-xs font-bold text-slate-800">Tanggal Selesai Bimbingan (Dinamis)</div>
                                        <div class="text-[11px] text-slate-500 leading-tight mt-0.5">Sesuai tanggal siswa menyelesaikan modul topik terakhir (rekomendasi).</div>
                                    </div>
                                </label>

                                <label class="flex items-start gap-2.5 p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-emerald-400 transition"
                                    :class="{ 'border-emerald-500 ring-2 ring-emerald-50': dateType === 'current_date' }">
                                    <input type="radio" name="date_type" value="current_date" x-model="dateType" class="mt-0.5 text-emerald-600 focus:ring-emerald-500">
                                    <div>
                                        <div class="text-xs font-bold text-slate-800">Tanggal Hari Ini (Waktu Cetak/Unduh)</div>
                                        <div class="text-[11px] text-slate-500 leading-tight mt-0.5">Selalu menggunakan tanggal saat file sertifikat di-generate/diunduh.</div>
                                    </div>
                                </label>

                                <label class="flex items-start gap-2.5 p-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-emerald-400 transition"
                                    :class="{ 'border-emerald-500 ring-2 ring-emerald-50': dateType === 'fixed_date' }">
                                    <input type="radio" name="date_type" value="fixed_date" x-model="dateType" class="mt-0.5 text-emerald-600 focus:ring-emerald-500">
                                    <div>
                                        <div class="text-xs font-bold text-slate-800">Tanggal Tetap Tertentu</div>
                                        <div class="text-[11px] text-slate-500 leading-tight mt-0.5">Menetapkan tanggal terbit serentak yang sama untuk seluruh siswa.</div>
                                    </div>
                                </label>
                            </div>

                            <!-- Fixed Date Input -->
                            <div x-show="dateType === 'fixed_date'" x-transition class="pt-2">
                                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                    Tentukan Tanggal Terbit Sertifikat <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="fixed_date"
                                    value="{{ old('fixed_date', $template->fixed_date ? \Carbon\Carbon::parse($template->fixed_date)->format('Y-m-d') : '') }}"
                                    class="w-full text-xs px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Action Submit Button -->
                <div class="mt-6 pt-5 border-t border-slate-200 flex items-center justify-end gap-3">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm transition-all hover:shadow">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        Simpan Pengaturan Data Sertifikat
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>