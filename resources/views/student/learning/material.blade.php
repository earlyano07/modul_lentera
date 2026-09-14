<x-app-layout>
    <x-slot name="title">{{ $material->judul ?? 'Fasilitas Pembelajaran' }}</x-slot>

    <!-- Breadcrumb -->
    <nav class="flex text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 flex-wrap">
            <li class="inline-flex items-center">
                <a href="{{ route('student.roadmap') }}" class="hover:text-sky-600 transition-colors">Roadmap</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="{{ route('student.module', $material->module_id ?? 1) }}" class="hover:text-sky-600 transition-colors line-clamp-1 max-w-[150px] sm:max-w-[200px]">{{ $material->module->judul ?? 'Topik' }}</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="text-gray-900 font-medium line-clamp-1 max-w-[150px] sm:max-w-[200px]">{{ $material->judul ?? 'Fasilitas' }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8">
        <!-- Material Header -->
        <div class="bg-gray-50 border-b border-gray-200 p-6 sm:p-8">
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-indigo-50 text-indigo-700 border border-indigo-200/50">
                    {{ \App\Models\Material::JENIS_OPTIONS[$material->jenis] ?? 'Materi' }}
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">{{ $material->judul ?? 'Judul Fasilitas' }}</h1>
            <div class="flex items-center gap-3 text-sm text-gray-500">
                <span class="flex items-center text-xs font-semibold text-slate-500">
                    <span class="material-symbols-outlined text-[16px] mr-1">menu_book</span>
                    Bagian dari Topik: {{ $material->module->judul ?? 'Topik' }}
                </span>
            </div>
        </div>

        <!-- Video Player if exists -->
        @if($material->jenis === \App\Models\Material::JENIS_VIDEO && $material->video)
        <div class="bg-black w-full aspect-video">
            @if($material->isYoutubeVideo())
                <iframe class="w-full h-full" src="{{ $material->getYoutubeEmbedUrl() }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            @else
                <!-- HTML5 Video Player -->
                <video class="w-full h-full" controls>
                    <source src="{{ asset('storage/' . $material->video) }}" type="video/mp4">
                    Browser Anda tidak mendukung tag video.
                </video>
            @endif
        </div>
        @endif

        <!-- Material Content -->
        <div class="p-6 sm:p-10 prose prose-lg prose-sky max-w-none prose-img:rounded-xl">
            @if($material->jenis === \App\Models\Material::JENIS_KARTU_SITUASI)
                <!-- Premium Kartu Situasi Render (Mockup Style) -->
                <div class="max-w-md mx-auto bg-white border-2 border-emerald-600/30 rounded-[2rem] p-6 shadow-md relative overflow-hidden not-prose">
                    <!-- Card Header -->
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 rounded-full bg-[#006d2c] text-white flex items-center justify-center text-base font-black shrink-0">
                            {{ $material->module->urutan }}
                        </div>
                        <h4 class="flex-grow text-center text-sm font-black text-[#006d2c] uppercase tracking-wide leading-tight">
                            {{ $material->judul }}
                        </h4>
                        <div class="w-9 h-9 shrink-0"></div> <!-- Balance spacer -->
                    </div>

                    <!-- Card Photo / Illustration -->
                    @if($material->file_path)
                        <div class="my-4 overflow-hidden rounded-2xl border border-gray-100 shadow-sm aspect-[16/10]">
                            <img src="{{ asset('storage/' . $material->file_path) }}" class="w-full h-full object-cover">
                        </div>
                    @else
                        <!-- Cartoon illustration placeholder -->
                        <div class="my-4 overflow-hidden rounded-2xl border border-emerald-100 bg-emerald-50/20 shadow-sm flex items-center justify-center min-h-[160px] p-6 text-center text-emerald-700/60">
                            <div class="flex flex-col items-center gap-1">
                                <span class="material-symbols-outlined text-[48px]">school</span>
                                <span class="text-[10px] font-bold uppercase tracking-wider">Ilustrasi Kegiatan Pelatihan</span>
                            </div>
                        </div>
                    @endif

                    <!-- Situasi Description -->
                    <div class="mt-4">
                        <span class="inline-block px-3 py-1 bg-[#006d2c] text-white text-[10px] font-extrabold rounded-md uppercase tracking-wider mb-2">
                            Situasi
                        </span>
                        <p class="text-xs text-slate-700 font-semibold leading-relaxed">
                            {{ $material->situasi }}
                        </p>
                    </div>

                    <!-- Peran & Diskusi Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-t border-emerald-100/50 mt-5 pt-4">
                        <!-- Peran -->
                        <div>
                            <div class="flex items-center gap-1.5 text-emerald-800 font-extrabold text-[10px] uppercase tracking-wider mb-2">
                                <span class="material-symbols-outlined text-[14px]">person</span>
                                <span>Peran</span>
                            </div>
                            @php
                                $peranList = array_filter(array_map('trim', explode("\n", $material->peran)));
                            @endphp
                            <ul class="space-y-1">
                                @foreach($peranList as $item)
                                    <li class="flex items-start gap-1.5 text-[10px] text-slate-600 font-semibold leading-normal">
                                        <span class="text-emerald-600 text-[8px] mt-0.5 select-none">●</span>
                                        <span>{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Diskusi -->
                        <div>
                            <div class="flex items-center gap-1.5 text-emerald-800 font-extrabold text-[10px] uppercase tracking-wider mb-2">
                                <span class="material-symbols-outlined text-[14px]">chat</span>
                                <span>Diskusikan</span>
                            </div>
                            @php
                                $diskusiList = array_filter(array_map('trim', explode("\n", $material->diskusi)));
                            @endphp
                            <ul class="space-y-1">
                                @foreach($diskusiList as $item)
                                    <li class="flex items-start gap-1.5 text-[10px] text-slate-600 font-semibold leading-normal">
                                        <span class="text-emerald-600 text-[8px] mt-0.5 select-none">●</span>
                                        <span>{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @else
                {!! $material->isi ?? '<p>Konten akan tampil di sini.</p>' !!}
            @endif
        </div>

        <!-- File Attachment download button if exists -->
        @if($material->file_path)
        <div class="mx-6 sm:mx-10 mb-6 p-4 bg-blue-50 border border-blue-100 rounded-xl flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-[32px] text-blue-500">picture_as_pdf</span>
                <div class="text-left">
                    <h4 class="font-bold text-blue-900 text-sm">Dokumen Tugas Lampiran</h4>
                    <p class="text-xs text-blue-700 font-medium">Unduh dokumen tugas ini untuk dipelajari atau dikerjakan.</p>
                </div>
            </div>
            <a href="{{ asset('storage/' . $material->file_path) }}" download class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 text-xs shadow transition-all gap-1.5 w-full sm:w-auto">
                <span class="material-symbols-outlined text-[16px]">download</span> Unduh Dokumen
            </a>
        </div>
        @endif
        
        <!-- Navigation Footer -->
        <div class="bg-gray-50 border-t border-gray-200 p-6 flex items-center justify-between gap-4">
            <div></div>
            <a href="{{ route('student.module', $material->module_id) }}" class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors w-full sm:w-auto justify-center shadow-sm text-sm">
                Kembali ke Topik
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </a>
        </div>
    </div>
</x-app-layout>
