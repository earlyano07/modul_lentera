<x-guest-layout>
    <div class="min-h-screen w-full flex items-center justify-center p-4 sm:p-6 md:p-8 bg-[#eef3f8]" x-data="{ 
        copiedUser: false, 
        copiedPass: false,
        showPass: true,
        copyText(text, type) {
            navigator.clipboard.writeText(text).then(() => {
                if(type === 'user') {
                    this.copiedUser = true;
                    setTimeout(() => this.copiedUser = false, 2500);
                } else {
                    this.copiedPass = true;
                    setTimeout(() => this.copiedPass = false, 2500);
                }
            });
        }
    }">
        <!-- Main Card Wrapper -->
        <div class="bg-white rounded-[2rem] shadow-xl border border-gray-200/50 max-w-4xl w-full grid grid-cols-1 lg:grid-cols-12 overflow-hidden my-6 relative">
            
            <!-- LEFT PANEL: SUCCESS GRAPHICS (5 Cols) -->
            <div class="lg:col-span-5 bg-gradient-to-br from-[#0c254c] to-[#07152b] p-8 flex flex-col justify-between items-center relative text-white text-center select-none">
                
                <!-- Decorative Vine (Top-Left) -->
                <svg class="absolute top-0 left-0 w-24 h-24 text-white/5 pointer-events-none -translate-x-2 -translate-y-2" viewBox="0 0 100 100" fill="currentColor">
                    <path d="M0 0 Q30 20 20 60" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path d="M10 12 C5 3 0 10 10 12 Z"/>
                    <path d="M18 28 C10 20 5 28 18 28 Z"/>
                    <path d="M20 45 C15 35 8 42 20 45 Z"/>
                </svg>

                <div class="my-auto space-y-5 w-full py-6">
                    <!-- Success Icon Glow -->
                    <div class="relative flex justify-center">
                        <div class="w-24 h-24 rounded-full bg-emerald-500/20 border-2 border-emerald-400 flex items-center justify-center text-emerald-400 shadow-[0_0_25px_rgba(52,211,153,0.3)]">
                            <span class="material-symbols-outlined text-5xl font-bold">check_circle</span>
                        </div>
                    </div>

                    <h1 class="text-white text-2xl sm:text-3xl font-extrabold tracking-wide text-center">
                        Pendaftaran Berhasil!
                    </h1>
                    
                    <div class="w-16 h-0.5 bg-amber-400/50 mx-auto my-2 relative">
                        <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2.5 h-2.5 bg-amber-400 rotate-45"></div>
                    </div>

                    <p class="text-xs sm:text-sm text-slate-200 text-center leading-relaxed max-w-xs mx-auto font-medium">
                        Akun Anda telah aktif di platform Model LENTERA. Harap simpan nama pengguna dan kata sandi di samping untuk masuk kembali.
                    </p>

                    <div class="pt-4 flex justify-center">
                        <div class="inline-flex items-center gap-2 bg-[#061833]/90 border border-emerald-400/50 px-4 py-2 rounded-full text-[11px] text-emerald-300 font-bold uppercase tracking-wider shadow-sm">
                            <span class="material-symbols-outlined text-[16px]">verified</span>
                            Akun Siswa Resmi Aktif
                        </div>
                    </div>
                </div>

                <!-- Footer text -->
                <div class="text-[10px] text-white/50 pb-2">
                    Learning Empathy through Structured Learning Approach
                </div>
            </div>

            <!-- RIGHT PANEL: CREDENTIALS (7 Cols) -->
            <div class="lg:col-span-7 p-6 sm:p-10 flex flex-col justify-center relative space-y-6">
                
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full mb-2">
                        <span class="material-symbols-outlined text-sm">badge</span>
                        Kredensial Akun Siswa Baru
                    </div>
                    <h2 class="text-2xl font-black text-[#0d2a5c]">Detail Akun Anda</h2>
                    <p class="text-xs text-slate-500 font-semibold mt-1">
                        Halo <strong class="text-slate-800">{{ $credentials['nama'] ?? 'Siswa' }}</strong>, berikut adalah data akun yang dapat Anda gunakan untuk masuk:
                    </p>
                </div>

                <!-- Identity Summary -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 grid grid-cols-2 gap-3 text-xs">
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">Nama Siswa</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $credentials['nama'] ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">NIS</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $credentials['nis'] ?? '-' }}</span>
                    </div>
                    <div class="col-span-2 pt-1 border-t border-slate-200/50">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">Sekolah & Kelas</span>
                        <span class="font-bold text-slate-800 text-xs">{{ $credentials['kelas'] ?? '-' }}</span>
                    </div>
                </div>

                <!-- Credentials Cards -->
                <div class="space-y-4">
                    
                    <!-- Username Card -->
                    <div class="bg-gradient-to-r from-blue-50/70 to-indigo-50/70 border-2 border-indigo-200 rounded-2xl p-4 relative">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-indigo-900 uppercase tracking-wide flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">person</span>
                                Nama Pengguna (Username)
                            </span>
                            <span class="text-[10px] text-indigo-700 font-semibold bg-indigo-100/70 px-2 py-0.5 rounded-md">
                                3 Huruf Nama + NIS + Tgl Daftar
                            </span>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-xl sm:text-2xl font-mono font-black text-[#0d2a5c] tracking-wider select-all">
                                {{ $credentials['username'] ?? '-' }}
                            </span>
                            <button type="button" @click="copyText('{{ $credentials['username'] ?? '' }}', 'user')" class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-indigo-300 hover:bg-indigo-50 text-indigo-700 font-bold text-xs rounded-xl shadow-2xs transition active:scale-95 cursor-pointer">
                                <span class="material-symbols-outlined text-sm" x-text="copiedUser ? 'check' : 'content_copy'">content_copy</span>
                                <span x-text="copiedUser ? 'Tersalin!' : 'Salin'">Salin</span>
                            </button>
                        </div>
                    </div>

                    <!-- Password Card -->
                    <div class="bg-gradient-to-r from-amber-50/70 to-orange-50/70 border-2 border-amber-300/80 rounded-2xl p-4 relative">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-amber-900 uppercase tracking-wide flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">lock</span>
                                Kata Sandi Default (Password)
                            </span>
                            <span class="text-[10px] text-amber-800 font-semibold bg-amber-100 px-2 py-0.5 rounded-md">
                                6 Abjad Besar-Kecil + Simbol
                            </span>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-xl sm:text-2xl font-mono font-black text-amber-950 tracking-wider select-all" x-text="showPass ? '{{ $credentials['password'] ?? '' }}' : '••••••••'">
                                {{ $credentials['password'] ?? '-' }}
                            </span>
                            <div class="flex items-center gap-1.5">
                                <button type="button" @click="showPass = !showPass" class="p-1.5 text-amber-800 hover:text-amber-950 transition cursor-pointer" title="Tampilkan/Sembunyikan">
                                    <span class="material-symbols-outlined text-lg" x-text="showPass ? 'visibility' : 'visibility_off'">visibility</span>
                                </button>
                                <button type="button" @click="copyText('{{ $credentials['password'] ?? '' }}', 'pass')" class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-amber-300 hover:bg-amber-50 text-amber-800 font-bold text-xs rounded-xl shadow-2xs transition active:scale-95 cursor-pointer">
                                    <span class="material-symbols-outlined text-sm" x-text="copiedPass ? 'check' : 'content_copy'">content_copy</span>
                                    <span x-text="copiedPass ? 'Tersalin!' : 'Salin'">Salin</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Warning Reminder Box -->
                <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-xl flex items-start gap-2.5 text-rose-900 text-xs leading-relaxed font-medium">
                    <span class="material-symbols-outlined text-rose-600 text-base shrink-0 mt-0.5">warning</span>
                    <div>
                        <strong>PENTING:</strong> Catat atau simpan Nama Pengguna dan Kata Sandi di atas sekarang! Informasi ini hanya ditampilkan saat ini demi keamanan akun Anda.
                    </div>
                </div>

                <!-- Actions -->
                <div class="space-y-2 pt-2">
                    <a href="{{ route('student.dashboard') }}" class="w-full py-3.5 bg-[#0d2a5c] hover:bg-[#0a2046] active:scale-[0.99] text-white font-extrabold rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 tracking-wider text-xs uppercase cursor-pointer">
                        <span class="material-symbols-outlined text-base">dashboard</span>
                        LANJUT MASUK KE DASHBOARD SISWA
                    </a>
                    
                    <a href="{{ route('login') }}" class="w-full py-2.5 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold rounded-xl transition text-center block text-xs">
                        Halaman Masuk (Login)
                    </a>
                </div>

            </div>

        </div>

    </div>

    <!-- Centered copyright footer -->
    <div class="w-full text-center py-4 bg-[#eef3f8] border-t border-gray-200/40 select-none text-[10px] text-gray-450 font-bold uppercase tracking-wider">
        © 2026 Model LENTERA. All rights reserved.
    </div>
</x-guest-layout>