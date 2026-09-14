<x-app-layout>
    <x-slot name="title">Dashboard Siswa</x-slot>

    <!-- Welcome Card -->
    <div class="bg-gradient-to-br from-primary to-primary-container rounded-2xl p-8 mb-8 text-white shadow-lg relative overflow-hidden">
        <!-- Abstract background shapes -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10"></div>
        <div class="absolute bottom-0 right-32 -mb-20 w-48 h-48 rounded-full bg-white opacity-10"></div>
        
        <div class="relative z-10">
            <h1 class="text-3xl font-extrabold mb-2 tracking-tight">Halo, {{ $student->nama ?? 'Siswa' }}! 👋</h1>
            <p class="text-blue-100 text-lg mb-6">{{ $student->kelas->school->nama ?? 'Sekolah' }} | Kelas {{ $student->kelas->nama_kelas ?? '-' }}</p>
            
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-6 inline-block min-w-full md:min-w-[400px]">
                <div class="flex justify-between items-center mb-2">
                    <span class="font-medium text-blue-50">Progress Belajar Anda</span>
                    <span class="font-bold text-xl">{{ $progressPercentage ?? 0 }}%</span>
                </div>
                <div class="w-full bg-white/30 rounded-full h-3">
                    <div class="bg-white rounded-full h-3 transition-all duration-1000" style="width: {{ $progressPercentage ?? 0 }}%"></div>
                </div>
                @if($isProgramCompleted ?? false)
                    <p class="mt-3 text-sm text-green-200 font-medium flex items-center">
                        <span class="material-symbols-outlined text-sm mr-1">check_circle</span>
                        Selamat! Anda telah menyelesaikan seluruh program pembelajaran.
                    </p>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content Area -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Current Stage Card -->
            @if(isset($currentStage) && !($isProgramCompleted ?? false))
            <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm border border-outline-variant/30 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-primary"></div>
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="inline-block px-2.5 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full mb-3 uppercase tracking-wider">Sedang Dikerjakan</span>
                        <h2 class="text-2xl font-bold text-on-surface mb-2">{{ $currentStage['title'] ?? 'Topik Selanjutnya' }}</h2>
                        <p class="text-on-surface-variant">{{ $currentStage['description'] ?? 'Lanjutkan pembelajaran Anda untuk mencapai target.' }}</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ $currentStage['url'] ?? route('student.roadmap') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary text-white rounded-xl hover:bg-primary/95 font-semibold text-sm transition-colors shadow-sm w-full md:w-auto">
                        Lanjutkan Belajar
                        <span class="material-symbols-outlined text-sm ml-2">arrow_forward</span>
                    </a>
                </div>
            </div>
            @elseif($isProgramCompleted ?? false)
            <div class="bg-surface-container-lowest rounded-2xl p-8 shadow-sm border border-tertiary/30 text-center">
                <div class="w-20 h-20 bg-tertiary/10 text-tertiary rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-[40px]">check_circle</span>
                </div>
                <h2 class="text-2xl font-bold text-on-surface mb-2">Program Selesai!</h2>
                <p class="text-on-surface-variant mb-6">Anda telah menyelesaikan semua topik dan asesmen. Anda dapat melihat kembali materi di Roadmap.</p>
                <a href="{{ route('student.roadmap') }}" class="inline-flex items-center justify-center px-6 py-3 bg-surface border border-outline-variant text-on-surface rounded-xl hover:bg-surface-container-low font-semibold text-sm transition-colors shadow-sm">
                    Lihat Roadmap
                </a>
            </div>
            @endif
        </div>

        <!-- Right Sidebar (Timeline Preview) -->
        <div class="lg:col-span-1">
            <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm border border-outline-variant/30">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-on-surface">Roadmap Ringkas</h3>
                    <a href="{{ route('student.roadmap') }}" class="text-sm font-semibold text-primary hover:underline">Lihat Semua</a>
                </div>
                
                <div class="relative border-l-2 border-gray-200 ml-3 space-y-6">
                    @forelse(collect($timeline)->take(4) as $item)
                    <div class="relative pl-6">
                        @if($item['status'] === 'completed')
                            <div class="absolute -left-[10px] top-1 w-4 h-4 rounded-full bg-green-500 border-2 border-white flex items-center justify-center"></div>
                        @elseif($item['status'] === 'in_progress' || $item['status'] === 'available')
                            <div class="absolute -left-[12px] top-0 w-5 h-5 rounded-full bg-primary border-4 border-white shadow-sm flex items-center justify-center animate-pulse"></div>
                        @else
                            <div class="absolute -left-[10px] top-1 w-4 h-4 rounded-full bg-gray-300 border-2 border-white flex items-center justify-center"></div>
                        @endif
                        
                        <div>
                            <h4 class="text-sm font-semibold {{ ($item['status'] === 'available' || $item['status'] === 'in_progress') ? 'text-primary' : 'text-on-surface' }}">
                                {{ $item['title'] ?? 'Topik' }}
                            </h4>
                            <p class="text-xs text-gray-500 mt-1">{{ $item['type_label'] ?? 'Materi' }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="pl-6 text-gray-500 text-sm">Belum ada topik tersedia.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
