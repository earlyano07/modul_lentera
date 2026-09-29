<x-guest-layout>
    <div class="min-h-screen w-full flex items-center justify-center p-4 sm:p-6 md:p-8 bg-[#eef3f8]">
        
        <!-- Main Card Wrapper -->
        <div class="bg-white rounded-[2rem] shadow-xl border border-gray-200/50 max-w-5xl w-full grid grid-cols-1 lg:grid-cols-12 overflow-hidden my-6 relative">
            
            <!-- LEFT PANEL: BRANDING & GRAPHICS (5 Cols) -->
            <div class="lg:col-span-5 bg-gradient-to-br from-[#0c254c] to-[#07152b] p-8 flex flex-col justify-between items-center relative text-white text-center select-none">
                
                <!-- Decorative Vine (Top-Left) -->
                <svg class="absolute top-0 left-0 w-24 h-24 text-white/5 pointer-events-none -translate-x-2 -translate-y-2" viewBox="0 0 100 100" fill="currentColor">
                    <path d="M0 0 Q30 20 20 60" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path d="M10 12 C5 3 0 10 10 12 Z"/>
                    <path d="M18 28 C10 20 5 28 18 28 Z"/>
                    <path d="M20 45 C15 35 8 42 20 45 Z"/>
                </svg>

                <!-- Decorative Vine (Bottom-Left) -->
                <svg class="absolute bottom-0 left-0 w-24 h-24 text-white/5 pointer-events-none -translate-x-2 translate-y-2 rotate-90" viewBox="0 0 100 100" fill="currentColor">
                    <path d="M0 0 Q30 20 20 60" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path d="M10 12 C5 3 0 10 10 12 Z"/>
                    <path d="M18 28 C10 20 5 28 18 28 Z"/>
                    <path d="M20 45 C15 35 8 42 20 45 Z"/>
                </svg>

                <div class="my-auto space-y-5 w-full py-4">
                    <!-- Logo Lentera -->
                    <div class="relative flex justify-center">
                        <div class="bg-white p-3.5 sm:p-4 rounded-3xl shadow-[0_12px_35px_rgba(0,0,0,0.35)] border border-white/20 max-w-[175px] sm:max-w-[200px] flex items-center justify-center transition-all duration-300 hover:scale-[1.03]">
                            <img src="{{ asset('images/logo-lentera.png') }}" alt="Logo Model LENTERA" class="w-full h-auto object-contain rounded-2xl drop-shadow-sm">
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm font-semibold text-[#adc7ff] tracking-wide text-center">
                        Learning <span class="text-amber-400">Empathy</span> through<br>Structured Learning Approach
                    </p>
                    
                    <div class="w-16 h-0.5 bg-amber-400/50 mx-auto my-3 relative">
                        <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2.5 h-2.5 bg-amber-400 rotate-45"></div>
                    </div>

                    <p class="text-[11px] sm:text-xs text-white/85 text-center leading-relaxed max-w-xs mx-auto font-medium">
                        Mari bersama membangun budaya empati dan kepedulian sosial untuk sekolah yang ramah dan bebas dari perundungan.
                    </p>

                    <div class="pt-2 flex justify-center">
                        <div class="inline-flex items-center gap-2 bg-[#061833]/90 border border-amber-400/50 px-4 py-2 rounded-full text-[10px] text-amber-300 font-bold uppercase tracking-wider shadow-sm">
                            <span class="material-symbols-outlined text-[16px]">school</span>
                            Pendaftaran Khusus Siswa
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT PANEL: REGISTER FORM (7 Cols) -->
            <div class="lg:col-span-7 p-6 sm:p-10 flex flex-col justify-center relative">
                
                <!-- Help / Login Link (Top-Right) -->
                <div class="flex justify-end mb-4 sm:mb-2">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 border border-slate-200 text-slate-600 hover:bg-slate-50 text-[11px] font-bold rounded-full shadow-xs transition">
                        <span class="material-symbols-outlined text-sm">login</span>
                        Sudah punya akun? Masuk
                    </a>
                </div>

                <div class="w-full mx-auto space-y-5">
                    
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-black text-[#0d2a5c]">Daftar Akun Siswa</h2>
                        <div class="w-12 h-0.5 bg-amber-400 my-2 relative">
                            <div class="absolute -top-1 left-0 w-2 h-2 bg-amber-400 rotate-45"></div>
                        </div>
                        <p class="text-xs text-gray-500 font-semibold">Lengkapi data diri Anda di bawah ini untuk memulai aktivitas pembelajaran.</p>
                    </div>

                    <!-- Informational Notice (Student-Only Badge) -->
                    <div class="flex items-start gap-2.5 p-3 bg-blue-50/80 border border-blue-200 rounded-xl text-[11px] text-blue-900 leading-relaxed font-medium">
                        <span class="material-symbols-outlined text-blue-600 text-base shrink-0 mt-0.5">verified_user</span>
                        <div>
                            <strong>Pendaftaran Mandiri Khusus Siswa:</strong> Akun Guru Bimbingan & Konseling (Konselor) dan Admin disediakan oleh pihak sekolah.
                        </div>
                    </div>

                    @php
                        $oldKelas = old('kelas_id') ? $kelasList->firstWhere('id', old('kelas_id')) : null;
                        $initialSchool = old('school_id', $oldKelas?->school_id ?? '');
                        $initialKelas = old('kelas_id', '');
                    @endphp

                    <form method="POST" action="{{ route('register') }}" class="space-y-4" x-data="{
                        selectedSchool: '{{ $initialSchool }}',
                        selectedKelas: '{{ $initialKelas }}',
                        kelasList: {{ Js::from($kelasList->map(fn($k) => ['id' => (string)$k->id, 'school_id' => (string)$k->school_id, 'nama_kelas' => $k->nama_kelas, 'tingkat' => $k->tingkat])) }},
                        get availableKelas() {
                            if (!this.selectedSchool) return [];
                            return this.kelasList.filter(k => k.school_id === String(this.selectedSchool));
                        },
                        onSchoolChange() {
                            this.selectedKelas = '';
                        }
                    }">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div>
                            <label for="nama" class="block text-gray-700 text-xs font-bold mb-1.5 uppercase tracking-wide">
                                Nama Lengkap Siswa <span class="text-red-500">*</span>
                            </label>
                            <div class="flex rounded-xl shadow-xs overflow-hidden bg-white border @error('nama') border-red-500 @else border-gray-200 @enderror focus-within:ring-2 focus-within:ring-indigo-200 transition-all">
                                <div class="flex items-center justify-center px-3.5 bg-slate-50 border-r border-gray-200">
                                    <span class="material-symbols-outlined text-gray-500 text-lg">person</span>
                                </div>
                                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" placeholder="Contoh: Budi Pratama" class="w-full py-2.5 px-3.5 text-gray-800 leading-tight focus:outline-none placeholder-gray-400 border-0 text-xs sm:text-sm" required autofocus autocomplete="name">
                            </div>
                            @error('nama')
                                <p class="text-red-500 text-[11px] italic mt-1 font-medium flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">error</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- 2-Column Grid: NIS & Jenis Kelamin -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- NIS -->
                            <div>
                                <label for="nis" class="block text-gray-700 text-xs font-bold mb-1.5 uppercase tracking-wide">
                                    Nomor Induk Siswa (NIS) <span class="text-red-500">*</span>
                                </label>
                                <div class="flex rounded-xl shadow-xs overflow-hidden bg-white border @error('nis') border-red-500 @else border-gray-200 @enderror focus-within:ring-2 focus-within:ring-indigo-200 transition-all">
                                    <div class="flex items-center justify-center px-3.5 bg-slate-50 border-r border-gray-200">
                                        <span class="material-symbols-outlined text-gray-500 text-lg">badge</span>
                                    </div>
                                    <input type="text" name="nis" id="nis" value="{{ old('nis') }}" placeholder="Contoh: 10025" class="w-full py-2.5 px-3.5 text-gray-800 leading-tight focus:outline-none placeholder-gray-400 border-0 text-xs sm:text-sm" required>
                                </div>
                                @error('nis')
                                    <p class="text-red-500 text-[11px] italic mt-1 font-medium flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">error</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <label class="block text-gray-700 text-xs font-bold mb-1.5 uppercase tracking-wide">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-2 gap-2 h-[42px]">
                                    <label class="flex items-center justify-center gap-1.5 px-3 border @error('jenis_kelamin') border-red-500 @else border-gray-200 @enderror rounded-xl cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50 has-[:checked]:text-indigo-900">
                                        <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin') === 'L' ? 'checked' : '' }} required class="text-indigo-600 focus:ring-indigo-500 h-3.5 w-3.5">
                                        <span class="text-xs font-semibold">Laki-laki</span>
                                    </label>
                                    <label class="flex items-center justify-center gap-1.5 px-3 border @error('jenis_kelamin') border-red-500 @else border-gray-200 @enderror rounded-xl cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50 has-[:checked]:text-indigo-900">
                                        <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin') === 'P' ? 'checked' : '' }} required class="text-indigo-600 focus:ring-indigo-500 h-3.5 w-3.5">
                                        <span class="text-xs font-semibold">Perempuan</span>
                                    </label>
                                </div>
                                @error('jenis_kelamin')
                                    <p class="text-red-500 text-[11px] italic mt-1 font-medium flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">error</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- 2-Column Grid: Sekolah & Kelas -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Sekolah -->
                            <div>
                                <label for="school_id" class="block text-gray-700 text-xs font-bold mb-1.5 uppercase tracking-wide">
                                    Sekolah <span class="text-red-500">*</span>
                                </label>
                                <div class="flex rounded-xl shadow-xs overflow-hidden bg-white border @error('school_id') border-red-500 @else border-gray-200 @enderror focus-within:ring-2 focus-within:ring-indigo-200 transition-all">
                                    <div class="flex items-center justify-center px-3.5 bg-slate-50 border-r border-gray-200">
                                        <span class="material-symbols-outlined text-gray-500 text-lg">domain</span>
                                    </div>
                                    <select id="school_id" name="school_id" x-model="selectedSchool" @change="onSchoolChange()" required class="w-full py-2.5 px-3 text-gray-800 leading-tight focus:outline-none border-0 text-xs sm:text-sm bg-white">
                                        <option value="">-- Pilih Sekolah --</option>
                                        @foreach($schools as $school)
                                            <option value="{{ $school->id }}" {{ $initialSchool == $school->id ? 'selected' : '' }}>
                                                {{ $school->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('school_id')
                                    <p class="text-red-500 text-[11px] italic mt-1 font-medium flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">error</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Kelas (Hanya muncul kelas dari sekolah yang dipilih) -->
                            <div>
                                <label for="kelas_id" class="block text-gray-700 text-xs font-bold mb-1.5 uppercase tracking-wide">
                                    Kelas <span class="text-red-500">*</span>
                                </label>
                                <div class="flex rounded-xl shadow-xs overflow-hidden bg-white border @error('kelas_id') border-red-500 @else border-gray-200 @enderror focus-within:ring-2 focus-within:ring-indigo-200 transition-all">
                                    <div class="flex items-center justify-center px-3.5 bg-slate-50 border-r border-gray-200">
                                        <span class="material-symbols-outlined text-gray-500 text-lg">school</span>
                                    </div>
                                    <select name="kelas_id" id="kelas_id" x-model="selectedKelas" :disabled="!selectedSchool" required class="w-full py-2.5 px-3 text-gray-800 leading-tight focus:outline-none border-0 text-xs sm:text-sm bg-white disabled:bg-slate-50 disabled:text-slate-400 disabled:cursor-not-allowed">
                                        <option value="" x-text="!selectedSchool ? '-- Pilih Sekolah Terlebih Dahulu --' : (availableKelas.length === 0 ? '-- Tidak ada kelas di sekolah ini --' : '-- Pilih Kelas --')"></option>
                                        <template x-for="k in availableKelas" :key="k.id">
                                            <option :value="k.id" x-text="'Kelas ' + k.nama_kelas + (k.tingkat ? ' (Tingkat ' + k.tingkat + ')' : '')" :selected="k.id == selectedKelas"></option>
                                        </template>
                                    </select>
                                </div>
                                @error('kelas_id')
                                    <p class="text-red-500 text-[11px] italic mt-1 font-medium flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">error</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="tanggal_lahir" class="block text-gray-700 text-xs font-bold mb-1.5 uppercase tracking-wide">
                                Tanggal Lahir <span class="text-red-500">*</span>
                            </label>
                            <div class="flex rounded-xl shadow-xs overflow-hidden bg-white border @error('tanggal_lahir') border-red-500 @else border-gray-200 @enderror focus-within:ring-2 focus-within:ring-indigo-200 transition-all">
                                <div class="flex items-center justify-center px-3.5 bg-slate-50 border-r border-gray-200">
                                    <span class="material-symbols-outlined text-gray-500 text-lg">calendar_today</span>
                                </div>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full py-2.5 px-3 text-gray-800 leading-tight focus:outline-none border-0 text-xs sm:text-sm bg-white">
                            </div>
                            @error('tanggal_lahir')
                                <p class="text-red-500 text-[11px] italic mt-1 font-medium flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">error</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Info Pembuatan Username & Password Otomatis -->
                        <div class="p-4 bg-amber-50/70 border border-amber-200/80 rounded-2xl flex items-start gap-3 mt-1">
                            <div class="h-8 w-8 rounded-xl bg-amber-100 flex items-center justify-center text-amber-700 shrink-0 shadow-xs mt-0.5">
                                <span class="material-symbols-outlined text-lg">auto_mode</span>
                            </div>
                            <div class="text-xs text-slate-700 space-y-1">
                                <p class="font-bold text-slate-900">Nama Pengguna & Kata Sandi Dibuat Otomatis</p>
                                <p class="text-[11px] text-slate-600 leading-relaxed">
                                    Anda tidak perlu mengisikan email dan kata sandi. Sistem LENTERA akan otomatis membuatkan akun Anda:
                                </p>
                                <ul class="list-disc list-inside text-[11px] text-slate-600 space-y-0.5 pt-0.5">
                                    <li><strong>Nama Pengguna:</strong> Kombinasi 3 huruf nama depan + NIS + tanggal pendaftaran</li>
                                    <li><strong>Kata Sandi Default:</strong> Kombinasi 6 abjad besar-kecil + karakter spesial</li>
                                </ul>
                                <p class="text-[10px] text-amber-900 font-semibold pt-0.5 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px]">info</span>
                                    Nama pengguna dan kata sandi akan langsung diberikan setelah Anda menekan tombol di bawah.
                                </p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" class="w-full py-3.5 bg-[#0d2a5c] hover:bg-[#0a2046] active:scale-[0.99] text-white font-extrabold rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 tracking-wider text-xs uppercase cursor-pointer">
                                <span class="material-symbols-outlined text-base font-bold">how_to_reg</span>
                                DAFTAR & DAPATKAN AKUN SISWA
                            </button>
                        </div>

                        <!-- Back to Login -->
                        <div class="text-center pt-2">
                            <span class="text-xs text-gray-500">Sudah memiliki akun siswa? </span>
                            <a href="{{ route('login') }}" class="text-xs font-bold text-[#0d2a5c] hover:underline">
                                Masuk di sini
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>

    <!-- Centered copyright footer -->
    <div class="w-full text-center py-4 bg-[#eef3f8] border-t border-gray-200/40 select-none text-[10px] text-gray-450 font-bold uppercase tracking-wider">
        © 2026 Model LENTERA. All rights reserved.
    </div>
</x-guest-layout>
