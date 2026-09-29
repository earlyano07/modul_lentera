<!-- Dashboard Link -->
<a href="{{ route('counselor.dashboard') }}" class="mx-3 px-4 py-3 rounded-lg flex items-center gap-3 transition-all relative active:scale-95 {{ request()->routeIs('counselor.dashboard') ? 'bg-[#1a73e8] text-white font-semibold' : 'text-[#adc7ff] hover:text-white hover:bg-white/10' }}">
    @if(request()->routeIs('counselor.dashboard'))
        <div class="absolute left-0 w-1 h-6 bg-white rounded-r-full"></div>
    @endif
    <span class="material-symbols-outlined text-[24px]">dashboard</span>
    <span class="text-sm font-semibold">Dashboard</span>
</a>

<!-- Data Peserta Link -->
<a href="{{ route('counselor.monitoring.schools') }}" class="mx-3 px-4 py-3 rounded-lg flex items-center gap-3 transition-all relative active:scale-95 {{ (request()->routeIs('counselor.monitoring.schools') || request()->routeIs('counselor.monitoring.kelas') || request()->routeIs('counselor.monitoring.students') || request()->routeIs('counselor.monitoring.student.detail')) && !request()->routeIs('counselor.reports.*') ? 'bg-[#1a73e8] text-white font-semibold' : 'text-[#adc7ff] hover:text-white hover:bg-white/10' }}">
    @if((request()->routeIs('counselor.monitoring.schools') || request()->routeIs('counselor.monitoring.kelas') || request()->routeIs('counselor.monitoring.students') || request()->routeIs('counselor.monitoring.student.detail')) && !request()->routeIs('counselor.reports.*'))
        <div class="absolute left-0 w-1 h-6 bg-white rounded-r-full"></div>
    @endif
    <span class="material-symbols-outlined text-[24px]">group</span>
    <span class="text-sm font-semibold">Data Peserta</span>
</a>

<!-- Layanan (Topik 1-5) Link -->
<a href="{{ route('counselor.layanan') }}" class="mx-3 px-4 py-3 rounded-lg flex items-center gap-3 transition-all relative active:scale-95 {{ request()->routeIs('counselor.layanan') || request()->routeIs('counselor.layanan.show') ? 'bg-[#1a73e8] text-white font-semibold' : 'text-[#adc7ff] hover:text-white hover:bg-white/10' }}">
    @if(request()->routeIs('counselor.layanan') || request()->routeIs('counselor.layanan.show'))
        <div class="absolute left-0 w-1 h-6 bg-white rounded-r-full"></div>
    @endif
    <span class="material-symbols-outlined text-[24px]">menu_book</span>
    <span class="text-sm font-semibold">Layanan (Topik 1-5)</span>
</a>

<!-- Evaluasi Link -->
<a href="{{ route('counselor.evaluasi') }}" class="mx-3 px-4 py-3 rounded-lg flex items-center gap-3 transition-all relative active:scale-95 {{ request()->routeIs('counselor.evaluasi') ? 'bg-[#1a73e8] text-white font-semibold' : 'text-[#adc7ff] hover:text-white hover:bg-white/10' }}">
    @if(request()->routeIs('counselor.evaluasi'))
        <div class="absolute left-0 w-1 h-6 bg-white rounded-r-full"></div>
    @endif
    <span class="material-symbols-outlined text-[24px]">quiz</span>
    <span class="text-sm font-semibold">Evaluasi</span>
</a>

<!-- Profil Perkembangan Empati Link -->
<a href="{{ route('counselor.profil-empati') }}" class="mx-3 px-4 py-3 rounded-lg flex items-center gap-3 transition-all relative active:scale-95 {{ request()->routeIs('counselor.profil-empati') ? 'bg-[#1a73e8] text-white font-semibold' : 'text-[#adc7ff] hover:text-white hover:bg-white/10' }}">
    @if(request()->routeIs('counselor.profil-empati'))
        <div class="absolute left-0 w-1 h-6 bg-white rounded-r-full"></div>
    @endif
    <span class="material-symbols-outlined text-[24px]">psychology</span>
    <span class="text-sm font-semibold">Profil Perkembangan Empati</span>
</a>

<!-- Laporan Link -->
<a href="{{ route('counselor.monitoring.schools') }}" class="mx-3 px-4 py-3 rounded-lg flex items-center gap-3 transition-all relative active:scale-95 {{ request()->routeIs('counselor.reports.*') ? 'bg-[#1a73e8] text-white font-semibold' : 'text-[#adc7ff] hover:text-white hover:bg-white/10' }}">
    @if(request()->routeIs('counselor.reports.*'))
        <div class="absolute left-0 w-1 h-6 bg-white rounded-r-full"></div>
    @endif
    <span class="material-symbols-outlined text-[24px]">analytics</span>
    <span class="text-sm font-semibold">Laporan</span>
</a>

<!-- Pengaturan Profil Link -->
<a href="{{ route('counselor.profile.edit') }}" class="mx-3 px-4 py-3 rounded-lg flex items-center gap-3 transition-all relative active:scale-95 {{ request()->routeIs('counselor.profile.*') || request()->routeIs('counselor.settings') ? 'bg-[#1a73e8] text-white font-semibold' : 'text-[#adc7ff] hover:text-white hover:bg-white/10' }}">
    @if(request()->routeIs('counselor.profile.*') || request()->routeIs('counselor.settings'))
        <div class="absolute left-0 w-1 h-6 bg-white rounded-r-full"></div>
    @endif
    <span class="material-symbols-outlined text-[24px]">manage_accounts</span>
    <span class="text-sm font-semibold">Pengaturan Profil</span>
</a>

<!-- Branding Section -->
<div class="mt-auto mx-3 p-4 bg-white/5 rounded-xl border border-white/10">
    <div class="flex items-center gap-2 mb-1.5">
        <span class="material-symbols-outlined text-amber-400 text-[18px]">gpp_good</span>
        <span class="text-white font-bold text-xs tracking-wide uppercase">Model LENTERA</span>
    </div>
    <p class="text-[#adc7ff] text-[10px] leading-relaxed">
        Intervensi Empati untuk Menciptakan Budaya Anti-Perundungan di Sekolah
    </p>
</div>
