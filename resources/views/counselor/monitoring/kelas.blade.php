<x-app-layout>
    <x-slot name="title">Daftar Kelas - {{ $school->nama ?? 'Sekolah' }}</x-slot>

    <!-- Breadcrumb -->
    <nav class="flex text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('counselor.monitoring.schools') }}" class="hover:text-emerald-600 transition-colors">Sekolah</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="text-gray-900 font-medium">{{ $school->nama ?? 'Detail' }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Daftar Kelas</h1>
        <p class="mt-2 text-gray-600">Pilih kelas untuk memantau progress masing-masing siswa.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($kelasList ?? [] as $kelas)
        <a href="{{ route('counselor.monitoring.students', $kelas->id) }}" class="block group">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md hover:border-emerald-300 transition-all">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-2xl font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">{{ $kelas->nama_kelas }}</h3>
                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-emerald-800 bg-emerald-100 rounded-full">
                        Tingkat {{ $kelas->tingkat }}
                    </span>
                </div>
                
                <div class="flex items-center text-gray-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span class="font-medium">{{ $kelas->students_count ?? 0 }} Siswa</span>
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-sm">
                    <span class="text-gray-500">Lihat data siswa</span>
                    <svg class="w-4 h-4 text-emerald-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full py-12 text-center text-gray-500 bg-white rounded-xl border border-gray-200 border-dashed">
            Tidak ada data kelas untuk sekolah ini.
        </div>
        @endforelse
    </div>
</x-app-layout>
