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
                    <!-- Lantern Logo SVG (High Quality Render) -->
                    <div class="relative flex justify-center">
                        <svg viewBox="0 0 300 350" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-44 h-48 sm:w-48 sm:h-52 drop-shadow-[0_0_15px_rgba(253,224,71,0.3)]">
                            <defs>
                                <radialGradient id="glow" cx="50%" cy="45%" r="50%" fx="50%" fy="45%">
                                    <stop offset="0%" stop-color="#fff5cc" stop-opacity="1" />
                                    <stop offset="35%" stop-color="#ffd24d" stop-opacity="0.85" />
                                    <stop offset="75%" stop-color="#ff9900" stop-opacity="0.25" />
                                    <stop offset="100%" stop-color="#ff9900" stop-opacity="0" />
                                </radialGradient>
                                <linearGradient id="metal" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#0a2540" />
                                    <stop offset="30%" stop-color="#1e4e8c" />
                                    <stop offset="50%" stop-color="#3b82f6" />
                                    <stop offset="70%" stop-color="#1e4e8c" />
                                    <stop offset="100%" stop-color="#0a2540" />
                                </linearGradient>
                                <linearGradient id="gold" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#b8860b" />
                                    <stop offset="50%" stop-color="#ffd700" />
                                    <stop offset="100%" stop-color="#b8860b" />
                                </linearGradient>
                            </defs>
                            
                            <!-- Glowing background -->
                            <circle cx="150" cy="140" r="90" fill="url(#glow)" />
                            
                            <!-- Rays -->
                            <path d="M150 40 L150 15 M250 140 L275 140 M50 140 L25 140 M80 70 L62 52 M220 70 L238 52" stroke="#ffd700" stroke-width="3" stroke-linecap="round" opacity="0.7" />
                            
                            <!-- Sparkles -->
                            <path d="M75 95 L80 100 L75 105 L70 100 Z" fill="#ffd700" />
                            <path d="M225 95 L230 100 L225 105 L220 100 Z" fill="#ffd700" />
                            <path d="M110 45 L113 48 L110 51 L107 48 Z" fill="#ffd700" />
                            <path d="M190 45 L193 48 L190 51 L187 48 Z" fill="#ffd700" />
                            
                            <!-- Lantern loop -->
                            <circle cx="150" cy="40" r="16" stroke="url(#gold)" stroke-width="6" fill="none" />
                            
                            <!-- Cap / Hood -->
                            <path d="M120 70 L180 70 L170 56 L130 56 Z" fill="url(#metal)" stroke="url(#gold)" stroke-width="2" />
                            <rect x="110" y="70" width="80" height="8" rx="4" fill="url(#gold)" />
                            <path d="M115 78 C115 78 120 98 150 98 C180 98 185 78 185 78 Z" fill="url(#metal)" />
                            
                            <!-- Protective cage wire guards -->
                            <path d="M110 98 C80 140 80 200 110 242" stroke="url(#metal)" stroke-width="8" stroke-linecap="round" fill="none" />
                            <path d="M190 98 C220 140 220 200 190 242" stroke="url(#metal)" stroke-width="8" stroke-linecap="round" fill="none" />
                            
                            <!-- Glass globe -->
                            <path d="M120 98 L180 98 L190 220 L110 220 Z" fill="#ffea9f" fill-opacity="0.25" stroke="url(#gold)" stroke-width="2" />
                            <path d="M115 150 C115 150 135 130 150 130 C165 130 185 150 185 150" stroke="#fff" stroke-width="3" stroke-linecap="round" opacity="0.4" />
                            
                            <!-- Flame -->
                            <path d="M150 195 C135 195 130 170 150 135 C170 170 165 195 150 195 Z" fill="#ff6600" />
                            <path d="M150 195 C140 195 137 180 150 155 C163 180 160 195 150 195 Z" fill="#ffcc00" />
                            <path d="M150 195 C145 195 143 188 150 170 C157 188 155 195 150 195 Z" fill="#ffffff" />
                            
                            <!-- Tank base -->
                            <path d="M100 242 L200 242 L210 290 L90 290 Z" fill="url(#metal)" stroke="url(#gold)" stroke-width="2" />
                            <rect x="95" y="242" width="110" height="12" rx="4" fill="url(#gold)" />
                            
                            <!-- Golden heart/figures emblem inside base -->
                            <path d="M150 282 C142 272 132 274 132 264 C132 258 138 258 142 264 C144 266 148 266 150 262 C152 266 156 266 158 264 C162 258 168 258 168 264 C168 274 158 272 150 282 Z" fill="#ffd700" />
                            <circle cx="142" cy="254" r="3.5" fill="#ffd700" />
                            <circle cx="158" cy="254" r="3.5" fill="#ffd700" />
                            
                            <rect x="80" y="290" width="140" height="10" rx="3" fill="url(#gold)" />
                            
                            <!-- Wreath leaves under the lantern -->
                            <path d="M80 250 Q60 210 80 180 M220 250 Q240 210 220 180" stroke="#85af5d" stroke-width="6" stroke-linecap="round" fill="none" opacity="0.8" />
                            <path d="M74 230 C64 228 64 220 74 222 Z" fill="#85af5d" />
                            <path d="M68 208 C58 206 58 198 68 200 Z" fill="#85af5d" />
                            <path d="M226 230 C236 228 236 220 226 222 Z" fill="#85af5d" />
                            <path d="M232 208 C242 206 242 198 232 200 Z" fill="#85af5d" />
                        </svg>
                    </div>

                    <h1 class="text-white text-5xl font-extrabold tracking-widest text-center mt-6">LENTERA</h1>
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
                
                <!-- Help Button (Top-Right) -->
                <div class="absolute top-6 right-8">
                    <a href="#" class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 text-slate-600 hover:bg-slate-50 text-[11px] font-bold rounded-full shadow-xs transition">
                        <span class="material-symbols-outlined text-sm">help</span>
                        Butuh Bantuan?
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

                        <!-- Nama Pengguna (Email) -->
                        <div>
                            <label for="email" class="block text-gray-700 text-xs font-bold mb-2 uppercase tracking-wide">Nama Pengguna</label>
                            <div class="flex rounded-xl shadow-md overflow-hidden bg-white border @error('email') border-red-500 @else border-gray-100 @enderror focus-within:ring-2 focus-within:ring-indigo-150 transition-all duration-300">
                                <div class="flex items-center justify-center px-4 bg-slate-50 border-r border-gray-200/50">
                                    <span class="material-symbols-outlined text-gray-500 text-lg">person</span>
                                </div>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Masukkan nama pengguna Anda" class="w-full py-3 px-4 text-gray-750 leading-tight focus:outline-none placeholder-gray-400 border-0 text-sm" required autofocus autocomplete="username">
                            </div>
                            @error('email')
                                <p class="text-red-500 text-[11px] italic mt-1.5 font-medium flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">error</span>
                                    {{ $message }}
                                </p>
                            @enderror
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
                    </form>

                    <!-- OR Separator -->
                    <div class="my-6 flex items-center justify-between text-xs text-gray-400">
                        <div class="flex-1 h-px bg-gray-200"></div>
                        <span class="px-4 font-bold uppercase tracking-wider text-[10px]">atau</span>
                        <div class="flex-1 h-px bg-gray-200"></div>
                    </div>

                    <!-- Shortcut Demo Login Button -->
                    <div>
                        <button type="button" onclick="document.getElementById('email').value='admin@lentera.test'; document.getElementById('password').value='password';" class="w-full py-3.5 border-2 border-indigo-200 hover:bg-indigo-50/20 text-[#0d2a5c] font-black rounded-xl shadow-sm hover:shadow transition-all flex items-center justify-center gap-2 text-xs uppercase tracking-wide">
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
