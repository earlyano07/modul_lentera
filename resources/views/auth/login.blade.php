<x-guest-layout>
    <div class="min-h-screen w-full flex items-center justify-center p-4 sm:p-6 md:p-8 bg-[#eef3f8]">
        
        <!-- Main Card Wrapper -->
        <div class="bg-white rounded-[2rem] shadow-xl border border-gray-200/50 max-w-5xl w-full grid grid-cols-1 md:grid-cols-12 overflow-hidden min-h-[580px] relative">
            
            <!-- LEFT PANEL: BRANDING & GRAPHICS (5 Cols) -->
            <div class="md:col-span-5 bg-gradient-to-br from-[#0c254c] to-[#07152b] p-8 flex flex-col justify-between items-center relative text-white text-center select-none">
                
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

                <div class="my-auto space-y-6 w-full">
                    <!-- Logo Lentera -->
                    <div class="relative flex justify-center">
                        <div class="bg-white p-3.5 sm:p-4 rounded-3xl shadow-[0_12px_35px_rgba(0,0,0,0.35)] border border-white/20 max-w-[175px] sm:max-w-[200px] flex items-center justify-center transition-all duration-300 hover:scale-[1.03]">
                            <img src="{{ asset('images/logo-lentera.png') }}" alt="Logo Model LENTERA" class="w-full h-auto object-contain rounded-2xl drop-shadow-sm">
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm font-semibold text-[#adc7ff] tracking-wide text-center mt-3">
                        Learning <span class="text-amber-400">Empathy</span> through<br>Structured Learning Approach
                    </p>
                    
                    <div class="w-16 h-0.5 bg-amber-400/50 mx-auto my-4 relative">
                        <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2.5 h-2.5 bg-amber-400 rotate-45"></div>
                    </div>

                    <p class="text-[11px] sm:text-xs text-white/85 text-center leading-relaxed max-w-xs mx-auto font-medium">
                        Intervensi Empati untuk<br>Menciptakan Budaya<br>Anti-Perundungan di Sekolah
                    </p>

                    <div class="mt-6 flex justify-center">
                        <div class="inline-flex items-center gap-2 bg-[#061833]/80 border border-amber-400/40 px-4 py-2 rounded-full text-[10px] text-amber-400 font-bold uppercase tracking-wider shadow-sm">
                            <span class="material-symbols-outlined text-[15px]">gpp_good</span>
                            Platform khusus untuk Konselor SMP
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT PANEL: LOGIN FORM (7 Cols) -->
            <div class="md:col-span-7 p-8 sm:p-12 flex flex-col justify-center relative min-h-[500px]">
                
                <!-- Top-Right Actions -->
                <div class="absolute top-6 right-8 flex items-center gap-2">
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 border border-indigo-200 text-indigo-700 bg-indigo-50/60 hover:bg-indigo-100/60 text-[11px] font-bold rounded-full shadow-xs transition">
                        <span class="material-symbols-outlined text-sm">school</span>
                        Daftar Siswa
                    </a>
                </div>

                <!-- Decorative Leaf Vines (Bottom-Right Overlay) -->
                <div class="absolute bottom-0 right-0 w-28 h-28 pointer-events-none opacity-20 text-indigo-300">
                    <svg class="w-full h-full" viewBox="0 0 100 100" fill="currentColor">
                        <path d="M100 100 Q70 80 80 40" stroke="currentColor" stroke-width="2" fill="none"/>
                        <path d="M90 88 C95 97 100 90 90 88 Z"/>
                        <path d="M82 72 C90 80 95 72 82 72 Z"/>
                        <path d="M80 55 C85 65 92 58 80 55 Z"/>
                    </svg>
                </div>

                <div class="max-w-md w-full mx-auto space-y-6 z-10">
                    
                    <div class="text-center">
                        <h2 class="text-3xl font-black text-[#0d2a5c]">Selamat Datang!</h2>
                        <div class="w-12 h-0.5 bg-amber-400 mx-auto my-2.5 relative">
                            <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-amber-400 rotate-45"></div>
                        </div>
                        <p class="text-xs text-gray-500 font-semibold mt-1">Silakan masuk untuk melanjutkan ke platform Model LENTERA</p>
                    </div>

                    <!-- Session Status Alert -->
                    @if (session('status'))
                        <div class="p-3 bg-blue-50 border border-blue-200 text-blue-800 text-xs rounded-xl font-medium">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <!-- Nama Pengguna / Email -->
                        <div>
                            <label for="login" class="block text-gray-700 text-xs font-bold mb-2 uppercase tracking-wide">Nama Pengguna / Email</label>
                            <div class="flex rounded-xl shadow-md overflow-hidden bg-white border @if($errors->has('login') || $errors->has('email')) border-red-500 @else border-gray-100 @endif focus-within:ring-2 focus-within:ring-indigo-150 transition-all duration-300">
                                <div class="flex items-center justify-center px-4 bg-slate-50 border-r border-gray-200/50">
                                    <span class="material-symbols-outlined text-gray-500 text-lg">person</span>
                                </div>
                                <input type="text" name="login" id="login" value="{{ old('login', old('email')) }}" placeholder="Masukkan nama pengguna atau email Anda" class="w-full py-3 px-4 text-gray-750 leading-tight focus:outline-none placeholder-gray-400 border-0 text-sm" required autofocus autocomplete="username">
                            </div>
                            @if($errors->has('login') || $errors->has('email'))
                                <p class="text-red-500 text-[11px] italic mt-1.5 font-medium flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">error</span>
                                    {{ $errors->first('login') ?: $errors->first('email') }}
                                </p>
                            @endif
                        </div>

                        <!-- Kata Sandi -->
                        <div x-data="{ show: false }">
                            <label for="password" class="block text-gray-700 text-xs font-bold mb-2 uppercase tracking-wide">Kata Sandi</label>
                            <div class="flex rounded-xl shadow-md overflow-hidden bg-white border @error('password') border-red-500 @else border-gray-100 @enderror focus-within:ring-2 focus-within:ring-indigo-150 transition-all duration-300 relative">
                                <div class="flex items-center justify-center px-4 bg-slate-50 border-r border-gray-200/50">
                                    <span class="material-symbols-outlined text-gray-500 text-lg">lock</span>
                                </div>
                                <input :type="show ? 'text' : 'password'" name="password" id="password" placeholder="Masukkan kata sandi Anda" class="w-full py-3 px-4 text-gray-750 leading-tight focus:outline-none placeholder-gray-400 border-0 text-sm pr-12" required autocomplete="current-password">
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-450 hover:text-gray-600 transition-colors">
                                    <span class="material-symbols-outlined text-lg" x-text="show ? 'visibility' : 'visibility_off'">visibility_off</span>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-500 text-[11px] italic mt-1.5 font-medium flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">error</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between mt-2.5">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 w-4 h-4">
                                <span class="ms-2 text-xs text-gray-550 font-bold select-none">Ingat saya</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a class="text-xs font-bold text-[#1e3a8a] hover:underline" href="{{ route('password.request') }}">
                                    Lupa kata sandi?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6">
                            <button type="submit" class="w-full py-3.5 bg-[#0d2a5c] hover:bg-[#0a2046] active:scale-[0.98] text-white font-extrabold rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 tracking-wider text-xs">
                                <span class="material-symbols-outlined text-sm font-bold">login</span>
                                MASUK
                            </button>
                        </div>

                        <!-- Register Student Link -->
                        <div class="text-center pt-2">
                            <span class="text-xs text-gray-500">Siswa baru belum memiliki akun? </span>
                            <a href="{{ route('register') }}" class="text-xs font-bold text-[#0d2a5c] hover:underline">
                                Daftar di sini
                            </a>
                        </div>
                    </form>

                    <!-- OR Separator -->
                    <div class="my-6 flex items-center justify-between text-xs text-gray-400">
                        <div class="flex-1 h-px bg-gray-200"></div>
                        <span class="px-4 font-bold uppercase tracking-wider text-[10px]">atau</span>
                        <div class="flex-1 h-px bg-gray-200"></div>
                    </div>

                    <!-- Shortcut Demo Login Button -->
                    <div>
                        <button type="button" onclick="const f=document.getElementById('login')||document.getElementById('email'); if(f) f.value='admin@lentera.test'; document.getElementById('password').value='password';" class="w-full py-3.5 border-2 border-indigo-200 hover:bg-indigo-50/20 text-[#0d2a5c] font-black rounded-xl shadow-sm hover:shadow transition-all flex items-center justify-center gap-2 text-xs uppercase tracking-wide">
                            <span class="material-symbols-outlined text-[16px] font-bold">group</span>
                            Masuk sebagai Admin Sekolah
                        </button>
                    </div>

                    <!-- Safety Bottom Note -->
                    <div class="mt-8 flex items-start gap-2.5 p-3.5 bg-blue-50/20 border border-blue-100/50 rounded-2xl">
                        <span class="material-symbols-outlined text-[#0d2a5c] text-lg font-bold">gpp_good</span>
                        <p class="text-[10px] text-gray-500 leading-normal font-semibold">
                            Aman, terpercaya, dan dirancang khusus untuk mendukung layanan bimbingan dan konseling.
                        </p>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <!-- Centered copyright footer -->
    <div class="w-full text-center py-4 bg-[#eef3f8] border-t border-gray-200/40 select-none text-[10px] text-gray-450 font-bold uppercase tracking-wider">
        © 2026 Model LENTERA. All rights reserved.
    </div>
</x-guest-layout>
