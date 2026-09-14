<x-app-layout>
    <x-slot name="title">Dashboard Konselor</x-slot>

    <div class="flex flex-col xl:flex-row gap-8">
        <!-- Main Content (Left) -->
        <div class="flex-1 flex flex-col gap-8">
            <!-- Welcome Section -->
            <div>
                <h1 class="text-3xl font-extrabold text-on-surface mb-1 tracking-tight">Selamat datang, Konselor 👋</h1>
                <p class="text-body-md text-on-surface-variant">Mari lanjutkan intervensi empati hari ini.</p>
            </div>

            <!-- Stats Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/30">
                    <p class="text-xs font-semibold text-on-surface-variant mb-2">Siswa Aktif</p>
                    <div class="flex items-end gap-2">
                        <span class="text-3xl font-bold text-on-surface">{{ $totalStudents }}</span>
                        <span class="text-tertiary text-xs mb-1 flex items-center"><span class="material-symbols-outlined text-sm">arrow_upward</span> 12%</span>
                    </div>
                    <p class="text-[10px] text-on-surface-variant mt-1">dari bulan lalu</p>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/30">
                    <p class="text-xs font-semibold text-on-surface-variant mb-2">Kelas</p>
                    <div class="flex items-end gap-2">
                        <span class="text-3xl font-bold text-on-surface">{{ $totalKelas }}</span>
                    </div>
                    <p class="text-[10px] text-on-surface-variant mt-1">Total kelas dibimbing</p>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/30">
                    <p class="text-xs font-semibold text-on-surface-variant mb-2">Modul Selesai</p>
                    <div class="flex items-end gap-2">
                        <span class="text-3xl font-bold text-on-surface">76%</span>
                    </div>
                    <p class="text-[10px] text-on-surface-variant mt-1">Rata-rata penyelesaian</p>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/30">
                    <p class="text-xs font-semibold text-on-surface-variant mb-2">Intervensi Berjalan</p>
                    <div class="flex items-end gap-2">
                        <span class="text-3xl font-bold text-on-surface">{{ $intervensiBerjalan }}</span>
                    </div>
                    <p class="text-[10px] text-on-surface-variant mt-1">Siswa mengikuti modul</p>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Line Chart Card -->
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/30">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-on-surface">Perkembangan Empati Siswa</h3>
                            <p class="text-xs text-on-surface-variant">Rata-rata skor empati (semua kelas)</p>
                        </div>
                        <span class="material-symbols-outlined text-on-surface-variant cursor-pointer">more_horiz</span>
                    </div>
                    <div class="h-64 flex items-end justify-between relative px-2">
                        <!-- Simple Line Graph Representation -->
                        <svg class="absolute inset-0 w-full h-full px-2" viewBox="0 0 400 150">
                            <path d="M0,120 L80,100 L160,110 L240,70 L320,60 L400,30" fill="none" stroke="#005bbf" stroke-linecap="round" stroke-width="3"></path>
                            <circle cx="0" cy="120" fill="#005bbf" r="4"></circle>
                            <circle cx="80" cy="100" fill="#005bbf" r="4"></circle>
                            <circle cx="160" cy="110" fill="#005bbf" r="4"></circle>
                            <circle cx="240" cy="70" fill="#005bbf" r="4"></circle>
                            <circle cx="320" cy="60" fill="#005bbf" r="4"></circle>
                            <circle cx="400" cy="30" fill="#005bbf" r="4"></circle>
                        </svg>
                        <div class="flex flex-col items-center gap-2 z-10">
                            <span class="text-[10px] text-on-surface-variant mt-[130px]">Jan</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 z-10">
                            <span class="text-[10px] text-on-surface-variant mt-[130px]">Feb</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 z-10">
                            <span class="text-[10px] text-on-surface-variant mt-[130px]">Mar</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 z-10">
                            <span class="text-[10px] text-on-surface-variant mt-[130px]">Apr</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 z-10">
                            <span class="text-[10px] text-on-surface-variant mt-[130px]">Mei</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 z-10">
                            <span class="text-[10px] text-on-surface-variant mt-[130px]">Jun</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-4">
                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                        <span class="text-xs text-on-surface-variant">Skor Empati</span>
                    </div>
                </div>

                <!-- Bar Chart Card -->
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/30">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-on-surface">Kasus Bullying</h3>
                            <p class="text-xs text-on-surface-variant">Jumlah kasus per bulan</p>
                        </div>
                        <span class="material-symbols-outlined text-on-surface-variant cursor-pointer">more_horiz</span>
                    </div>
                    <div class="h-64 flex items-end justify-between px-2">
                        <div class="flex flex-col items-center gap-2 w-full">
                            <div class="w-8 bg-primary/20 rounded-t-md h-12 transition-all hover:bg-primary"></div>
                            <span class="text-[10px] text-on-surface-variant">Jan</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 w-full">
                            <div class="w-8 bg-primary/20 rounded-t-md h-24 transition-all hover:bg-primary"></div>
                            <span class="text-[10px] text-on-surface-variant">Feb</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 w-full">
                            <div class="w-8 bg-primary/20 rounded-t-md h-16 transition-all hover:bg-primary"></div>
                            <span class="text-[10px] text-on-surface-variant">Mar</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 w-full">
                            <div class="w-8 bg-primary/20 rounded-t-md h-32 transition-all hover:bg-primary"></div>
                            <span class="text-[10px] text-on-surface-variant">Apr</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 w-full">
                            <div class="w-8 bg-primary/20 rounded-t-md h-40 transition-all hover:bg-primary"></div>
                            <span class="text-[10px] text-on-surface-variant">Mei</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 w-full">
                            <div class="w-8 bg-primary/20 rounded-t-md h-28 transition-all hover:bg-primary"></div>
                            <span class="text-[10px] text-on-surface-variant">Jun</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-4">
                        <span class="w-2 h-2 rounded-full bg-primary/40"></span>
                        <span class="text-xs text-on-surface-variant">Kasus Terdeteksi</span>
                    </div>
                </div>
            </div>

            <!-- Sekolah Binaan Section -->
            <div>
                <div class="mb-6 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-on-surface">Sekolah Binaan Anda</h2>
                    <a href="{{ route('counselor.monitoring.schools') }}" class="text-sm font-semibold text-primary hover:underline">Lihat Semua &rarr;</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($schools ?? [] as $school)
                    <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6 hover:shadow-md transition-shadow">
                        <h3 class="text-lg font-bold text-on-surface mb-2">{{ $school->nama }}</h3>
                        <div class="flex justify-between items-center text-sm text-on-surface-variant mb-4">
                            <span>{{ $school->kelas_count ?? 0 }} Kelas</span>
                            <span>{{ $school->students_count ?? 0 }} Siswa</span>
                        </div>
                        <a href="{{ route('counselor.monitoring.kelas', $school->id) }}" class="inline-flex w-full justify-center px-4 py-2 border border-primary text-primary rounded-xl hover:bg-primary/5 font-semibold text-sm transition-colors text-center">
                            Pantau Kelas
                        </a>
                    </div>
                    @empty
                    <div class="col-span-full py-8 text-center text-on-surface-variant bg-surface-container-lowest rounded-2xl border border-outline-variant border-dashed">
                        Belum ada sekolah yang ditugaskan kepada Anda.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Widgets (Right) -->
        <aside class="w-full xl:w-80 flex flex-col gap-6">
            <!-- Aktivitas Terbaru -->
            <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/30">
                <h3 class="text-lg font-bold text-on-surface mb-6">Aktivitas Terbaru</h3>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-tertiary/10 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-tertiary text-[20px]">person</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-on-surface leading-tight">Siswa menyelesaikan Role Playing</p>
                            <p class="text-xs text-on-surface-variant mt-0.5">10 menit yang lalu</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-primary text-[20px]">military_tech</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-on-surface leading-tight">Siswa mendapatkan badge Empatik</p>
                            <p class="text-xs text-on-surface-variant mt-0.5">1 jam yang lalu</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-secondary text-[20px]">group</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-on-surface leading-tight">Kelas memulai modul baru</p>
                            <p class="text-xs text-on-surface-variant mt-0.5">3 jam yang lalu</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengingat -->
            <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/30">
                <div class="flex items-center gap-2 mb-4">
                    <span class="material-symbols-outlined text-primary text-[20px]">event_note</span>
                    <h3 class="text-lg font-bold text-on-surface">Pengingat</h3>
                </div>
                <div class="bg-surface-container-low p-4 rounded-xl mb-6">
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Pantau kemajuan siswa secara berkala. Berikan bimbingan langsung kepada siswa yang nilainya masih di bawah batas kelulusan modul.
                    </p>
                </div>
                <a href="{{ route('counselor.monitoring.schools') }}" class="w-full py-3 bg-primary text-white font-semibold text-sm rounded-xl hover:bg-primary/95 transition-colors flex items-center justify-center gap-2 active:scale-95 duration-100">
                    <span>Lihat Detail</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <!-- Support -->
            <div class="p-6 border border-dashed border-outline rounded-2xl flex flex-col items-center text-center gap-4">
                <div class="w-12 h-12 bg-surface-container-high rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-surface-variant text-[24px]">help</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-on-surface">Butuh bantuan?</p>
                    <p class="text-xs text-on-surface-variant">Hubungi Admin Sekolah via WhatsApp</p>
                </div>
                <a class="text-primary font-bold text-sm hover:underline transition-all" href="#">Chat Admin</a>
            </div>
        </aside>
    </div>
</x-app-layout>
