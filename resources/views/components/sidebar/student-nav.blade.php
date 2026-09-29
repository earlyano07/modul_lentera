<!-- Menu LKPD Pembelajaran -->
<a href="{{ route('student.roadmap') }}" class="mx-3 px-4 py-3 rounded-xl flex items-center gap-3 transition-all relative active:scale-95 {{ request()->routeIs('student.roadmap') || request()->routeIs('student.dashboard') || request()->routeIs('student.assessment.*') || request()->routeIs('student.module') || request()->routeIs('student.material') ? 'bg-[#1a73e8] text-white font-bold shadow-xs' : 'text-[#adc7ff] hover:text-white hover:bg-white/10 font-semibold' }}">
    @if(request()->routeIs('student.roadmap') || request()->routeIs('student.dashboard') || request()->routeIs('student.assessment.*') || request()->routeIs('student.module') || request()->routeIs('student.material'))
        <div class="absolute left-0 w-1.5 h-6 bg-white rounded-r-full"></div>
    @endif
    <span class="material-symbols-outlined text-[22px]" style="{{ request()->routeIs('student.roadmap') || request()->routeIs('student.dashboard') || request()->routeIs('student.assessment.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">assignment</span>
    <span class="text-sm font-bold tracking-wide">Asesmen Siswa</span>
</a>

<!-- Menu Pengaturan Profil -->
<a href="{{ route('student.profile.edit') }}" class="mx-3 px-4 py-3 rounded-xl flex items-center gap-3 transition-all relative active:scale-95 {{ request()->routeIs('student.profile.*') ? 'bg-[#1a73e8] text-white font-bold shadow-xs' : 'text-[#adc7ff] hover:text-white hover:bg-white/10 font-semibold' }}">
    @if(request()->routeIs('student.profile.*'))
        <div class="absolute left-0 w-1.5 h-6 bg-white rounded-r-full"></div>
    @endif
    <span class="material-symbols-outlined text-[22px]" style="{{ request()->routeIs('student.profile.*') ? "font-variation-settings: 'FILL' 1;" : "" }}">manage_accounts</span>
    <span class="text-sm font-bold tracking-wide">Profil Akun</span>
</a>

@php
    $studentUser = auth()->user()->student;
    $isProgDone = $studentUser ? app(\App\Services\ProgressService::class)->isProgramCompleted($studentUser) : false;
@endphp
@if($isProgDone)
    <!-- Menu Sertifikat -->
    <a href="{{ route('student.certificate') }}" target="_blank" class="mx-3 px-4 py-3 rounded-xl flex items-center gap-3 transition-all relative active:scale-95 bg-emerald-600/20 text-emerald-300 hover:text-white hover:bg-emerald-600 font-bold border border-emerald-500/30">
        <span class="material-symbols-outlined text-[22px] text-emerald-300">workspace_premium</span>
        <span class="text-sm font-bold tracking-wide">Sertifikat Kelulusan</span>
    </a>
@endif


