<x-app-layout>
    <x-slot name="title">Layanan (Topik 1-5)</x-slot>

    <!-- Header Section with Breadcrumbs and User Profile Info -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/30 shadow-sm">
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Pelaksanaan Layanan</p>
            <h1 class="text-3xl font-extrabold text-on-surface mt-1 tracking-tight">5 Topik Pelatihan Model LENTERA</h1>
            <p class="text-sm text-on-surface-variant mt-2 max-w-2xl">
                Kelima topik ini dirancang secara berurutan untuk membantu peserta didik meningkatkan empati dan mencegah bullying secara efektif dan berkelanjutan.
            </p>
        </div>
        <div class="flex flex-col items-start md:items-end justify-center bg-primary-container/5 px-4 py-3 rounded-xl border border-primary-container/10">
            <div class="flex items-center gap-2 text-primary font-semibold text-sm">
                <span class="material-symbols-outlined text-[18px]">school</span>
                <span>{{ auth()->user()->konselor?->schools?->first()?->nama ?? 'SMP Negeri Model Blitar' }}</span>
            </div>
            <div class="text-xs text-on-surface-variant mt-1">
                Dashboard &gt; Layanan (Topik 1-5)
            </div>
        </div>
    </div>

    <!-- 5 Topik Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        @foreach($topiks as $topik)
            @php
                // Design parameters for each Topic to match specific color coding
                $design = match($topik->urutan) {
                    1 => [
                        'bg' => 'from-blue-50 to-indigo-50/30 border-blue-200/60',
                        'text' => 'text-blue-700',
                        'badge' => 'bg-blue-600',
                        'accent' => 'blue',
                        'icon' => 'emoji_objects',
                        'focus_bg' => 'bg-blue-50/50',
                        'svg' => '<svg class="w-full h-full text-blue-500/80" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="50" cy="50" r="35" fill="currentColor" fill-opacity="0.1"/>
                                    <circle cx="40" cy="40" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="2 2"/>
                                    <circle cx="60" cy="40" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="2 2"/>
                                    <path d="M35 70 C45 60, 55 60, 65 70" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                                    <path d="M50 20 L50 28 M50 72 L50 80 M20 50 L28 50 M72 50 L80 50" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                                  </svg>'
                    ],
                    2 => [
                        'bg' => 'from-emerald-50 to-green-50/30 border-emerald-200/60',
                        'text' => 'text-emerald-700',
                        'badge' => 'bg-emerald-600',
                        'accent' => 'emerald',
                        'icon' => 'favorite',
                        'focus_bg' => 'bg-emerald-50/50',
                        'svg' => '<svg class="w-full h-full text-emerald-500/80" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="50" cy="50" r="35" fill="currentColor" fill-opacity="0.1"/>
                                    <path d="M50 35 C50 35, 38 25, 28 35 C18 45, 30 60, 50 75 C70 60, 82 45, 72 35 C62 25, 50 35, 50 35 Z" fill="currentColor" fill-opacity="0.2" stroke="currentColor" stroke-width="4" stroke-linejoin="round"/>
                                  </svg>'
                    ],
                    3 => [
                        'bg' => 'from-amber-50 to-orange-50/30 border-amber-200/60',
                        'text' => 'text-amber-700',
                        'badge' => 'bg-amber-600',
                        'accent' => 'amber',
                        'icon' => 'visibility',
                        'focus_bg' => 'bg-amber-50/50',
                        'svg' => '<svg class="w-full h-full text-amber-500/80" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="50" cy="50" r="35" fill="currentColor" fill-opacity="0.1"/>
                                    <path d="M25 50 C35 35, 65 35, 75 50 C65 65, 35 65, 25 50 Z" stroke="currentColor" stroke-width="4" stroke-linejoin="round"/>
                                    <circle cx="50" cy="50" r="10" stroke="currentColor" stroke-width="3"/>
                                    <circle cx="50" cy="50" r="3" fill="currentColor"/>
                                  </svg>'
                    ],
                    4 => [
                        'bg' => 'from-purple-50 to-fuchsia-50/30 border-purple-200/60',
                        'text' => 'text-purple-700',
                        'badge' => 'bg-purple-600',
                        'accent' => 'purple',
                        'icon' => 'forum',
                        'focus_bg' => 'bg-purple-50/50',
                        'svg' => '<svg class="w-full h-full text-purple-500/80" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="50" cy="50" r="35" fill="currentColor" fill-opacity="0.1"/>
                                    <path d="M30 40 H70 V65 H45 L30 75 V40 Z" fill="currentColor" fill-opacity="0.2" stroke="currentColor" stroke-width="4" stroke-linejoin="round"/>
                                    <path d="M45 52 H55" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                                  </svg>'
                    ],
                    5 => [
                        'bg' => 'from-teal-50 to-cyan-50/30 border-teal-200/60',
                        'text' => 'text-teal-700',
                        'badge' => 'bg-teal-600',
                        'accent' => 'teal',
                        'icon' => 'diversity_3',
                        'focus_bg' => 'bg-teal-50/50',
                        'svg' => '<svg class="w-full h-full text-teal-500/80" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="50" cy="50" r="35" fill="currentColor" fill-opacity="0.1"/>
                                    <path d="M25 75 C25 60, 35 55, 50 55 C65 55, 75 60, 75 75" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                                    <circle cx="50" cy="35" r="12" fill="currentColor" fill-opacity="0.2" stroke="currentColor" stroke-width="4"/>
                                  </svg>'
                    ],
                    default => [
                        'bg' => 'from-slate-50 to-slate-100/30 border-slate-200',
                        'text' => 'text-slate-700',
                        'badge' => 'bg-slate-600',
                        'accent' => 'slate',
                        'icon' => 'book',
                        'focus_bg' => 'bg-slate-50/50',
                        'svg' => ''
                    ]
                };
            @endphp

            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/50 p-5 shadow-sm flex flex-col hover:shadow-md hover:border-outline-variant transition-all relative overflow-hidden bg-gradient-to-b {{ $design['bg'] }}">
                
                <!-- Badge & Topik Label -->
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-9 h-9 rounded-full text-white flex items-center justify-center font-bold text-sm shadow-sm {{ $design['badge'] }}">
                        {{ str_pad($topik->urutan, 2, '0', STR_PAD_LEFT) }}
                    </span>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500">
                        Topik {{ $topik->urutan }}
                    </span>
                </div>

                <!-- Judul Topik -->
                <h3 class="text-md font-bold text-on-surface leading-tight min-h-[44px]">
                    {{ $topik->judul }}
                </h3>
                <p class="text-xs text-on-surface-variant font-medium mt-1 leading-normal italic">
                    ({{ $topik->subtitle }})
                </p>

                <!-- Illustration Box (Inline Premium SVG) -->
                <div class="w-full h-32 my-5 flex items-center justify-center bg-white/40 rounded-xl border border-white/50 shadow-inner overflow-hidden">
                    {!! $design['svg'] !!}
                </div>

                <!-- Fokus Utama Panel -->
                <div class="p-3.5 rounded-xl border border-outline-variant/30 {{ $design['focus_bg'] }} mb-4 flex-grow-0">
                    <p class="text-[10px] font-bold text-error flex items-center gap-1.5 uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[14px]">favorite</span>
                        Fokus Utama
                    </p>
                    <p class="text-[11px] text-on-surface-variant font-medium mt-1.5 leading-relaxed">
                        {{ $topik->fokus_utama }}
                    </p>
                </div>

                <!-- Facility Checklist -->
                <div class="space-y-2 mt-2 mb-6">
                    @foreach(['Video / Ilustrasi Kejadian', 'Kartu Situasi', 'LKPD Online (Asesmen)'] as $facility)
                        <div class="flex items-center gap-2 text-xs text-on-surface font-medium">
                            <span class="material-symbols-outlined text-[16px] text-tertiary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span>{{ $facility }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Detail Topik Button -->
                <a href="{{ route('counselor.layanan.show', $topik->id) }}" class="mt-auto w-full py-2.5 bg-primary text-on-primary hover:bg-primary/95 text-center text-xs font-bold rounded-xl shadow-sm hover:shadow transition-all flex items-center justify-center gap-1">
                    <span>Detail Topik</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>

            </div>
        @endforeach
    </div>

    <!-- Footer Info Panels -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- SLA Flow Guide -->
        <div class="bg-surface-container-low rounded-2xl p-6 border border-outline-variant/40 shadow-sm">
            <h3 class="font-bold text-on-surface flex items-center gap-2 text-md">
                <span class="material-symbols-outlined text-primary text-[22px]">info</span>
                <span>Petunjuk Penggunaan</span>
            </h3>
            <p class="text-sm text-on-surface-variant mt-2.5 leading-relaxed font-medium">
                Setiap topik terdiri dari rangkaian kegiatan terstruktur yang mengacu pada pendekatan <strong>Structured Learning Approach (SLA)</strong> untuk optimalisasi perkembangan empati:
            </p>
            <div class="flex items-center gap-2 mt-4 flex-wrap">
                <span class="px-3 py-1.5 bg-blue-100/60 text-blue-700 text-xs font-bold rounded-lg border border-blue-200/40">Modeling</span>
                <span class="text-slate-400 font-bold">➔</span>
                <span class="px-3 py-1.5 bg-emerald-100/60 text-emerald-700 text-xs font-bold rounded-lg border border-emerald-200/40">Role Playing</span>
                <span class="text-slate-400 font-bold">➔</span>
                <span class="px-3 py-1.5 bg-amber-100/60 text-amber-700 text-xs font-bold rounded-lg border border-amber-200/40 font-semibold">Performance Feedback</span>
                <span class="text-slate-400 font-bold">➔</span>
                <span class="px-3 py-1.5 bg-purple-100/60 text-purple-700 text-xs font-bold rounded-lg border border-purple-200/40">Transfer of Training</span>
            </div>
        </div>

        <!-- Tips Panel -->
        <div class="bg-surface-container-low rounded-2xl p-6 border border-outline-variant/40 shadow-sm flex flex-col justify-center">
            <h3 class="font-bold text-on-surface flex items-center gap-2 text-md">
                <span class="material-symbols-outlined text-tertiary text-[22px]">lightbulb</span>
                <span>Tips Konselor</span>
            </h3>
            <p class="text-sm text-on-surface-variant mt-2.5 leading-relaxed font-medium">
                Laksanakan kelima topik secara berurutan dari Topik 1 sampai 5 untuk memperoleh hasil yang optimal. Lakukan penyesuaian instruksi dan pemaparan berdasarkan kondisi psikososial serta kebutuhan peserta didik di sekolah bimbingan Anda.
            </p>
        </div>
    </div>
</x-app-layout>
