<!-- Dashboard Link -->
<a href="{{ route('admin.dashboard') }}"
    class="mx-3 px-4 py-3 rounded-lg flex items-center gap-3 transition-all relative active:scale-95 {{ request()->routeIs('admin.dashboard') ? 'bg-[#1a73e8] text-white font-semibold' : 'text-[#adc7ff] hover:text-white hover:bg-white/10' }}">
    @if (request()->routeIs('admin.dashboard'))
        <div class="absolute left-0 w-1 h-6 bg-white rounded-r-full"></div>
    @endif
    <span class="material-symbols-outlined text-[24px]">dashboard</span>
    <span class="text-sm font-semibold">Dashboard</span>
</a>

<p class="px-6 mt-5 mb-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Data Master</p>

<!-- Sekolah Link -->
<a href="{{ route('admin.schools.index') }}"
    class="mx-3 px-4 py-3 rounded-lg flex items-center gap-3 transition-all relative active:scale-95 {{ request()->routeIs('admin.schools.*') ? 'bg-[#1a73e8] text-white font-semibold' : 'text-[#adc7ff] hover:text-white hover:bg-white/10' }}">
    @if (request()->routeIs('admin.schools.*'))
        <div class="absolute left-0 w-1 h-6 bg-white rounded-r-full"></div>
    @endif
    <span class="material-symbols-outlined text-[24px]">domain</span>
    <span class="text-sm font-semibold">Sekolah</span>
</a>

<!-- Kelas Link -->
<a href="{{ route('admin.kelas.index') }}"
    class="mx-3 px-4 py-3 rounded-lg flex items-center gap-3 transition-all relative active:scale-95 {{ request()->routeIs('admin.kelas.*') ? 'bg-[#1a73e8] text-white font-semibold' : 'text-[#adc7ff] hover:text-white hover:bg-white/10' }}">
    @if (request()->routeIs('admin.kelas.*'))
        <div class="absolute left-0 w-1 h-6 bg-white rounded-r-full"></div>
    @endif
    <span class="material-symbols-outlined text-[24px]">school</span>
    <span class="text-sm font-semibold">Kelas</span>
</a>

<!-- Siswa Link -->
<a href="{{ route('admin.students.index') }}"
    class="mx-3 px-4 py-3 rounded-lg flex items-center gap-3 transition-all relative active:scale-95 {{ request()->routeIs('admin.students.*') ? 'bg-[#1a73e8] text-white font-semibold' : 'text-[#adc7ff] hover:text-white hover:bg-white/10' }}">
    @if (request()->routeIs('admin.students.*'))
        <div class="absolute left-0 w-1 h-6 bg-white rounded-r-full"></div>
    @endif
    <span class="material-symbols-outlined text-[24px]">group</span>
    <span class="text-sm font-semibold">Siswa</span>
</a>

<!-- Konselor Link -->
<a href="{{ route('admin.konselor.index') }}"
    class="mx-3 px-4 py-3 rounded-lg flex items-center gap-3 transition-all relative active:scale-95 {{ request()->routeIs('admin.konselor.*') ? 'bg-[#1a73e8] text-white font-semibold' : 'text-[#adc7ff] hover:text-white hover:bg-white/10' }}">
    @if (request()->routeIs('admin.konselor.*'))
        <div class="absolute left-0 w-1 h-6 bg-white rounded-r-full"></div>
    @endif
    <span class="material-symbols-outlined text-[24px]">support_agent</span>
    <span class="text-sm font-semibold">Konselor</span>
</a>

<p class="px-6 mt-5 mb-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Konten</p>

<!-- Modul & Materi Link -->
<a href="{{ route('admin.modules.index') }}"
    class="mx-3 px-4 py-3 rounded-lg flex items-center gap-3 transition-all relative active:scale-95 {{ request()->routeIs('admin.modules.*') || request()->routeIs('admin.materials.*') || request()->routeIs('admin.assessments.*') || request()->routeIs('admin.questions.*') ? 'bg-[#1a73e8] text-white font-semibold' : 'text-[#adc7ff] hover:text-white hover:bg-white/10' }}">
    @if (request()->routeIs('admin.modules.*') ||
            request()->routeIs('admin.materials.*') ||
            request()->routeIs('admin.assessments.*') ||
            request()->routeIs('admin.questions.*'))
        <div class="absolute left-0 w-1 h-6 bg-white rounded-r-full"></div>
    @endif
    <span class="material-symbols-outlined text-[24px]">auto_stories</span>
    <span class="text-sm font-semibold">Topik & Fasilitas</span>
</a>

<p class="px-6 mt-5 mb-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Pengaturan</p>

<!-- Template Sertifikat Link -->
<a href="{{ route('admin.certificate-template.index') }}"
    class="mx-3 px-4 py-3 rounded-lg flex items-center gap-3 transition-all relative active:scale-95 {{ request()->routeIs('admin.certificate-template.*') ? 'bg-[#1a73e8] text-white font-semibold' : 'text-[#adc7ff] hover:text-white hover:bg-white/10' }}">
    @if (request()->routeIs('admin.certificate-template.*'))
        <div class="absolute left-0 w-1 h-6 bg-white rounded-r-full"></div>
    @endif
    <span class="material-symbols-outlined text-[24px]">workspace_premium</span>
    <span class="text-sm font-semibold">Template Sertifikat</span>
</a>

