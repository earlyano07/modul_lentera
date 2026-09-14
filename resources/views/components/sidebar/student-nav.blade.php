<!-- Menu LKPD (Satu-satunya Menu untuk Siswa) -->
<a href="{{ route('student.roadmap') }}" class="mx-3 px-4 py-3 rounded-xl flex items-center gap-3 transition-all relative active:scale-95 {{ request()->routeIs('student.*') ? 'bg-[#1a73e8] text-white font-bold shadow-xs' : 'text-[#adc7ff] hover:text-white hover:bg-white/10 font-semibold' }}">
    @if(request()->routeIs('student.*'))
        <div class="absolute left-0 w-1.5 h-6 bg-white rounded-r-full"></div>
    @endif
    <span class="material-symbols-outlined text-[22px]" style="{{ request()->routeIs('student.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">assignment</span>
    <span class="text-sm font-bold tracking-wide">LKPD</span>
</a>
