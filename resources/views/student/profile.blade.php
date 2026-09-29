<x-app-layout>
    <x-slot name="title">Pengaturan Profil Siswa</x-slot>

    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pengaturan Profil Siswa</h1>
        <p class="mt-2 text-sm text-slate-600 font-medium">Kelola informasi nama pengguna (username) dan kata sandi akun LENTERA Anda secara mandiri.</p>
    </div>

    <!-- 2-Column Responsive Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- LEFT COLUMN: Identitas Siswa (4 Cols) -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 p-6 overflow-hidden relative">
                <div class="absolute top-0 left-0 right-0 h-24 bg-gradient-to-r from-[#0c254c] to-[#1a73e8]"></div>
                
                <div class="relative pt-6 flex flex-col items-center text-center">
                    <!-- Avatar -->
                    <div class="w-20 h-20 rounded-2xl bg-white p-1 shadow-md mb-3 border border-slate-100 flex items-center justify-center">
                        <div class="w-full h-full rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-700 font-black text-2xl">
                            {{ substr($user->nama ?? 'S', 0, 1) }}
                        </div>
                    </div>

                    <h2 class="text-lg font-black text-slate-900 leading-tight">{{ $user->nama ?? 'Siswa' }}</h2>
                    <span class="inline-flex items-center gap-1 mt-1.5 px-3 py-1 bg-indigo-50 text-indigo-700 font-bold text-xs rounded-full border border-indigo-100">
                        <span class="material-symbols-outlined text-[14px]">school</span>
                        Peserta Didik (Siswa)
                    </span>
                </div>

                <!-- Academic Info List -->
                <div class="mt-6 pt-6 border-t border-slate-100 space-y-3.5 text-xs">
                    <div class="flex items-center justify-between py-1">
                        <span class="text-slate-500 font-medium flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-slate-400">badge</span>
                            NIS
                        </span>
                        <span class="font-bold text-slate-800 font-mono">{{ $student->nis ?? '-' }}</span>
                    </div>

                    <div class="flex items-center justify-between py-1">
                        <span class="text-slate-500 font-medium flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-slate-400">domain</span>
                            Sekolah
                        </span>
                        <span class="font-bold text-slate-800 text-right max-w-[160px] truncate" title="{{ $student->kelas->school->nama ?? '-' }}">
                            {{ $student->kelas->school->nama ?? '-' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-1">
                        <span class="text-slate-500 font-medium flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-slate-400">meeting_room</span>
                            Kelas
                        </span>
                        <span class="font-bold text-slate-800">
                            Kelas {{ $student->kelas->nama_kelas ?? '-' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-1">
                        <span class="text-slate-500 font-medium flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-slate-400">wc</span>
                            Jenis Kelamin
                        </span>
                        <span class="font-bold text-slate-800">
                            {{ ($student->jenis_kelamin ?? '') === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-1">
                        <span class="text-slate-500 font-medium flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-slate-400">calendar_today</span>
                            Tanggal Lahir
                        </span>
                        <span class="font-bold text-slate-800">
                            {{ $student->tanggal_lahir ? $student->tanggal_lahir->format('d/m/Y') : '-' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-1">
                        <span class="text-slate-500 font-medium flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-slate-400">verified</span>
                            Status Akun
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-emerald-100 text-emerald-800">
                            Aktif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Help Notice -->
            <div class="p-5 bg-blue-50/60 border border-blue-100 rounded-3xl flex items-start gap-3 text-xs text-blue-900 leading-relaxed font-medium">
                <span class="material-symbols-outlined text-blue-600 text-xl shrink-0 mt-0.5">info</span>
                <div>
                    <strong>Catatan:</strong> Jika terdapat ketidaksesuaian pada data nama, NIS, atau kelas, silakan hubungi Guru BK / Konselor sekolah Anda.
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Ubah Username & Ubah Password (8 Cols) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- CARD 1: Ubah Nama Pengguna (Username) -->
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-5 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <span class="material-symbols-outlined text-xl">person</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Ubah Nama Pengguna (Username)</h3>
                        <p class="text-xs text-slate-500 font-semibold">Gunakan nama pengguna yang mudah Anda ingat saat masuk ke platform LENTERA.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('student.profile.update-username') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="username" class="block text-slate-700 text-xs font-bold mb-1.5 uppercase tracking-wide">
                            Nama Pengguna Baru <span class="text-red-500">*</span>
                        </label>
                        <div class="flex rounded-xl shadow-xs overflow-hidden bg-white border @error('username') border-red-500 @else border-slate-200 @enderror focus-within:ring-2 focus-within:ring-indigo-200 transition-all max-w-lg">
                            <div class="flex items-center justify-center px-4 bg-slate-50 border-r border-slate-200 text-slate-500 text-sm font-mono">
                                @
                            </div>
                            <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" placeholder="Contoh: budi_pratama" required class="w-full py-2.5 px-3.5 text-slate-800 leading-tight focus:outline-none placeholder-slate-400 border-0 text-sm font-semibold">
                        </div>
                        
                        @error('username')
                            <p class="text-red-500 text-xs italic mt-1.5 font-medium flex items-center gap-1">
                                <span class="material-symbols-outlined text-[15px]">error</span>
                                {{ $message }}
                            </p>
                        @enderror

                        <p class="text-[11px] text-slate-400 mt-1.5 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">lock_reset</span>
                            Nama pengguna bersifat unik (tidak boleh sama dengan siswa lain).
                        </p>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#0d2a5c] hover:bg-[#0a2046] active:scale-[0.98] text-white font-extrabold rounded-xl shadow-xs hover:shadow-md transition-all text-xs tracking-wider uppercase cursor-pointer">
                            <span class="material-symbols-outlined text-sm">save</span>
                            Simpan Nama Pengguna
                        </button>
                    </div>
                </form>
            </div>

            <!-- CARD 2: Ubah Kata Sandi (Password) -->
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 p-6 sm:p-8" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
                <div class="flex items-center gap-3 mb-5 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                        <span class="material-symbols-outlined text-xl">key</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Ubah Kata Sandi (Password)</h3>
                        <p class="text-xs text-slate-500 font-semibold">Ganti kata sandi default Anda dengan kata sandi baru yang aman dan mudah diingat.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('student.profile.update-password') }}" class="space-y-4 max-w-lg">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-slate-700 text-xs font-bold mb-1.5 uppercase tracking-wide">
                            Kata Sandi Saat Ini <span class="text-red-500">*</span>
                        </label>
                        <div class="flex rounded-xl shadow-xs overflow-hidden bg-white border @error('current_password') border-red-500 @else border-slate-200 @enderror focus-within:ring-2 focus-within:ring-indigo-200 transition-all relative">
                            <div class="flex items-center justify-center px-3.5 bg-slate-50 border-r border-slate-200">
                                <span class="material-symbols-outlined text-slate-500 text-lg">lock</span>
                            </div>
                            <input :type="showCurrent ? 'text' : 'password'" name="current_password" id="current_password" placeholder="Masukkan kata sandi saat ini" required class="w-full py-2.5 px-3.5 text-slate-800 leading-tight focus:outline-none placeholder-slate-400 border-0 text-sm pr-10">
                            <button type="button" @click="showCurrent = !showCurrent" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                <span class="material-symbols-outlined text-base" x-text="showCurrent ? 'visibility' : 'visibility_off'">visibility_off</span>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="text-red-500 text-xs italic mt-1.5 font-medium flex items-center gap-1">
                                <span class="material-symbols-outlined text-[15px]">error</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-slate-700 text-xs font-bold mb-1.5 uppercase tracking-wide">
                            Kata Sandi Baru <span class="text-red-500">*</span>
                        </label>
                        <div class="flex rounded-xl shadow-xs overflow-hidden bg-white border @error('password') border-red-500 @else border-slate-200 @enderror focus-within:ring-2 focus-within:ring-indigo-200 transition-all relative">
                            <div class="flex items-center justify-center px-3.5 bg-slate-50 border-r border-slate-200">
                                <span class="material-symbols-outlined text-slate-500 text-lg">lock_reset</span>
                            </div>
                            <input :type="showNew ? 'text' : 'password'" name="password" id="password" placeholder="Minimal 8 karakter" required class="w-full py-2.5 px-3.5 text-slate-800 leading-tight focus:outline-none placeholder-slate-400 border-0 text-sm pr-10">
                            <button type="button" @click="showNew = !showNew" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                <span class="material-symbols-outlined text-base" x-text="showNew ? 'visibility' : 'visibility_off'">visibility_off</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs italic mt-1.5 font-medium flex items-center gap-1">
                                <span class="material-symbols-outlined text-[15px]">error</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-slate-700 text-xs font-bold mb-1.5 uppercase tracking-wide">
                            Konfirmasi Kata Sandi Baru <span class="text-red-500">*</span>
                        </label>
                        <div class="flex rounded-xl shadow-xs overflow-hidden bg-white border @error('password_confirmation') border-red-500 @else border-slate-200 @enderror focus-within:ring-2 focus-within:ring-indigo-200 transition-all relative">
                            <div class="flex items-center justify-center px-3.5 bg-slate-50 border-r border-slate-200">
                                <span class="material-symbols-outlined text-slate-500 text-lg">check_circle</span>
                            </div>
                            <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" placeholder="Ulangi kata sandi baru" required class="w-full py-2.5 px-3.5 text-slate-800 leading-tight focus:outline-none placeholder-slate-400 border-0 text-sm pr-10">
                            <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                <span class="material-symbols-outlined text-base" x-text="showConfirm ? 'visibility' : 'visibility_off'">visibility_off</span>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs italic mt-1.5 font-medium flex items-center gap-1">
                                <span class="material-symbols-outlined text-[15px]">error</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#0d2a5c] hover:bg-[#0a2046] active:scale-[0.98] text-white font-extrabold rounded-xl shadow-xs hover:shadow-md transition-all text-xs tracking-wider uppercase cursor-pointer">
                            <span class="material-symbols-outlined text-sm">enhanced_encryption</span>
                            Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</x-app-layout>