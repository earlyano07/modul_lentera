<x-app-layout>
    <x-slot name="title">Pengaturan Profil Konselor</x-slot>

    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                    <span class="p-2.5 rounded-2xl bg-indigo-50 text-indigo-700 border border-indigo-100 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[28px]">manage_accounts</span>
                    </span>
                    Pengaturan Profil Konselor
                </h1>
                <p class="mt-2 text-sm text-slate-600 font-medium">
                    Kelola data identitas, kontak, nama pengguna (username), dan keamanan akun konselor Anda secara mandiri.
                </p>
            </div>
            
            <a href="{{ route('counselor.dashboard') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition shadow-2xs self-start sm:self-auto">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- 2-Column Responsive Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- LEFT COLUMN: Identitas Konselor & Sekolah Binaan (4 Cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Card 1: Identitas Konselor -->
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 p-6 overflow-hidden relative">
                <div class="absolute top-0 left-0 right-0 h-24 bg-gradient-to-r from-[#0c254c] via-[#154687] to-[#1a73e8]"></div>
                
                <div class="relative pt-6 flex flex-col items-center text-center">
                    <!-- Avatar -->
                    <div class="w-20 h-20 rounded-2xl bg-white p-1 shadow-md mb-3 border border-slate-100 flex items-center justify-center">
                        <div class="w-full h-full rounded-xl bg-gradient-to-br from-indigo-500 to-[#1a73e8] text-white flex items-center justify-center font-black text-2xl shadow-inner">
                            {{ strtoupper(substr($user->nama ?? 'K', 0, 1)) }}
                        </div>
                    </div>

                    <h2 class="text-lg font-black text-slate-900 leading-tight">{{ $user->nama ?? 'Konselor' }}</h2>
                    <span class="inline-flex items-center gap-1.5 mt-2 px-3 py-1 bg-indigo-50 text-indigo-700 font-bold text-xs rounded-full border border-indigo-100">
                        <span class="material-symbols-outlined text-[14px]">psychology</span>
                        Guru BK / Konselor
                    </span>
                </div>

                <!-- Info List -->
                <div class="mt-6 pt-6 border-t border-slate-100 space-y-3.5 text-xs">
                    <div class="flex items-center justify-between py-1">
                        <span class="text-slate-500 font-medium flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-slate-400">badge</span>
                            NIP
                        </span>
                        <span class="font-bold text-slate-800 font-mono">{{ $konselor->nip ?: '-' }}</span>
                    </div>

                    <div class="flex items-center justify-between py-1">
                        <span class="text-slate-500 font-medium flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-slate-400">mail</span>
                            Email
                        </span>
                        <span class="font-bold text-slate-800 max-w-[170px] truncate" title="{{ $user->email }}">
                            {{ $user->email }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-1">
                        <span class="text-slate-500 font-medium flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-slate-400">call</span>
                            No. HP / WA
                        </span>
                        <span class="font-bold text-slate-800 font-mono">{{ $konselor->no_hp ?: '-' }}</span>
                    </div>

                    <div class="flex items-center justify-between py-1">
                        <span class="text-slate-500 font-medium flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-slate-400">alternate_email</span>
                            Username
                        </span>
                        <span class="font-bold text-indigo-600 font-mono bg-indigo-50/70 px-2 py-0.5 rounded border border-indigo-100">
                            {{ $user->username }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-1">
                        <span class="text-slate-500 font-medium flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-slate-400">verified</span>
                            Status Akun
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            {{ $user->status ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-1">
                        <span class="text-slate-500 font-medium flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-slate-400">schedule</span>
                            Login Terakhir
                        </span>
                        <span class="font-semibold text-slate-600">
                            {{ $user->last_login ? $user->last_login->diffForHumans() : '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Penugasan Sekolah -->
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-lg">domain</span>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900">Sekolah Binaan</h3>
                            <p class="text-[11px] text-slate-500 font-medium">Penugasan resmi oleh Administrator</p>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 text-xs font-black">
                        {{ $konselor->schools->count() }}
                    </span>
                </div>

                @if($konselor->schools->isNotEmpty())
                    <div class="space-y-2">
                        @foreach($konselor->schools as $school)
                            <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[16px]">school</span>
                                    </div>
                                    <span class="text-xs font-bold text-slate-800 truncate" title="{{ $school->nama }}">
                                        {{ $school->nama }}
                                    </span>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200 shrink-0">
                                    Ditugaskan
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200/70 text-xs text-amber-800">
                        <p class="font-bold flex items-center gap-1.5 mb-1">
                            <span class="material-symbols-outlined text-base text-amber-600">warning</span>
                            Belum Ada Penugasan
                        </p>
                        <p class="text-slate-600">
                            Akun Anda belum ditautkan ke sekolah binaan. Silakan hubungi Administrator sistem untuk mengatur penugasan sekolah Anda.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Card 3: Catatan Keamanan -->
            <div class="p-5 bg-blue-50/60 border border-blue-100 rounded-3xl flex items-start gap-3 text-xs text-blue-950 leading-relaxed font-medium">
                <span class="material-symbols-outlined text-blue-600 text-xl shrink-0 mt-0.5">security</span>
                <div>
                    <strong>Tips Keamanan:</strong> Jangan bagikan nama pengguna dan kata sandi Anda kepada orang lain. Lakukan penggantian kata sandi secara berkala untuk menjaga kerahasiaan data siswa.
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Forms (8 Cols) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- CARD 1: Informasi Profil & Kontak -->
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <span class="material-symbols-outlined text-xl">person</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Informasi Pribadi & Kontak</h3>
                        <p class="text-xs text-slate-500 font-semibold">Perbarui data nama lengkap, NIP, email, dan nomor handphone aktif Anda.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('counselor.profile.update') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Nama Lengkap -->
                        <div class="sm:col-span-2">
                            <label for="nama" class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">
                                Nama Lengkap & Gelar <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">badge</span>
                                <input type="text" name="nama" id="nama" 
                                       value="{{ old('nama', $user->nama) }}" 
                                       required
                                       class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-900 font-bold focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-2xs @error('nama') border-red-500 bg-red-50/30 @enderror"
                                       placeholder="Contoh: Dra. Novia Hendratno, M.Pd.">
                            </div>
                            @error('nama')
                                <p class="text-red-600 text-xs mt-1.5 font-bold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">error</span> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- NIP -->
                        <div>
                            <label for="nip" class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">
                                NIP (Nomor Induk Pegawai)
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">pin</span>
                                <input type="text" name="nip" id="nip" 
                                       value="{{ old('nip', $konselor->nip !== '-' ? $konselor->nip : '') }}" 
                                       class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-900 font-bold font-mono focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-2xs @error('nip') border-red-500 bg-red-50/30 @enderror"
                                       placeholder="19850315 201001 2 021">
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1">Kosongkan jika bukan ASN atau tidak memiliki NIP.</p>
                            @error('nip')
                                <p class="text-red-600 text-xs mt-1.5 font-bold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">error</span> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- No HP / WhatsApp -->
                        <div>
                            <label for="no_hp" class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">
                                No. Handphone / WhatsApp
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">call</span>
                                <input type="text" name="no_hp" id="no_hp" 
                                       value="{{ old('no_hp', $konselor->no_hp !== '-' ? $konselor->no_hp : '') }}" 
                                       class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-900 font-bold font-mono focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-2xs @error('no_hp') border-red-500 bg-red-50/30 @enderror"
                                       placeholder="Contoh: 081234567890">
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1">Nomor aktif untuk keperluan komunikasi konseling.</p>
                            @error('no_hp')
                                <p class="text-red-600 text-xs mt-1.5 font-bold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">error</span> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Alamat Email -->
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">
                                Alamat Email <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">mail</span>
                                <input type="email" name="email" id="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required
                                       class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-900 font-bold focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-2xs @error('email') border-red-500 bg-red-50/30 @enderror"
                                       placeholder="konselor@sekolah.sch.id">
                            </div>
                            @error('email')
                                <p class="text-red-600 text-xs mt-1.5 font-bold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">error</span> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl transition shadow-xs cursor-pointer active:scale-95">
                            <span class="material-symbols-outlined text-sm">save</span>
                            Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>

            <!-- CARD 2: Ubah Nama Pengguna (Username) -->
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                        <span class="material-symbols-outlined text-xl">alternate_email</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Ubah Nama Pengguna (Username)</h3>
                        <p class="text-xs text-slate-500 font-semibold">Username digunakan saat Anda masuk ke akun LENTERA.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('counselor.profile.update-username') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-end">
                        <!-- Username Saat Ini -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">
                                Nama Pengguna Saat Ini
                            </label>
                            <input type="text" disabled 
                                   value="{{ $user->username }}" 
                                   class="w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-2xl text-sm text-slate-500 font-mono font-bold cursor-not-allowed">
                        </div>

                        <!-- Username Baru -->
                        <div>
                            <label for="username" class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">
                                Nama Pengguna Baru <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="username" id="username" 
                                   value="{{ old('username') }}" 
                                   required minlength="3" maxlength="50"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-900 font-mono font-bold focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition shadow-2xs @error('username') border-red-500 bg-red-50/30 @enderror"
                                   placeholder="Ketik username baru">
                        </div>
                    </div>

                    @error('username')
                        <p class="text-red-600 text-xs mt-1.5 font-bold flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">error</span> {{ $message }}
                        </p>
                    @enderror

                    <p class="text-[11px] text-slate-400">
                        * Minimal 3 karakter, maksimal 50 karakter. Hanya boleh huruf, angka, tanda hubung (-), dan garis bawah (_).
                    </p>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl transition shadow-xs cursor-pointer active:scale-95">
                            <span class="material-symbols-outlined text-sm">check_circle</span>
                            Perbarui Nama Pengguna
                        </button>
                    </div>
                </form>
            </div>

            <!-- CARD 3: Ubah Kata Sandi (Password) -->
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600">
                        <span class="material-symbols-outlined text-xl">lock_reset</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Ubah Kata Sandi (Password)</h3>
                        <p class="text-xs text-slate-500 font-semibold">Tingkatkan keamanan akun dengan menggunakan kombinasi kata sandi yang kuat.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('counselor.profile.update-password') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <!-- Kata Sandi Saat Ini -->
                    <div>
                        <label for="current_password" class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">
                            Kata Sandi Saat Ini <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">lock</span>
                            <input type="password" name="current_password" id="current_password" 
                                   required
                                   class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-900 font-medium focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition shadow-2xs @error('current_password') border-red-500 bg-red-50/30 @enderror"
                                   placeholder="Masukkan kata sandi akun Anda saat ini">
                        </div>
                        @error('current_password')
                            <p class="text-red-600 text-xs mt-1.5 font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">error</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Kata Sandi Baru -->
                        <div>
                            <label for="password" class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">
                                Kata Sandi Baru <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">key</span>
                                <input type="password" name="password" id="password" 
                                       required minlength="8"
                                       class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-900 font-medium focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition shadow-2xs @error('password') border-red-500 bg-red-50/30 @enderror"
                                       placeholder="Minimal 8 karakter">
                            </div>
                            @error('password')
                                <p class="text-red-600 text-xs mt-1.5 font-bold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">error</span> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Konfirmasi Kata Sandi Baru -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">
                                Konfirmasi Kata Sandi Baru <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">check</span>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       required minlength="8"
                                       class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-900 font-medium focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition shadow-2xs"
                                       placeholder="Ketik ulang kata sandi baru">
                            </div>
                        </div>
                    </div>

                    <p class="text-[11px] text-slate-400">
                        * Gunakan kombinasi huruf besar, huruf kecil, angka, atau simbol untuk keamanan yang lebih baik.
                    </p>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl transition shadow-xs cursor-pointer active:scale-95">
                            <span class="material-symbols-outlined text-sm">lock_reset</span>
                            Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
