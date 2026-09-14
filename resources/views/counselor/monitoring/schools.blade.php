<x-app-layout>
    <x-slot name="title">Monitoring Sekolah</x-slot>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Monitoring Sekolah</h1>
        <p class="mt-2 text-gray-600">Pilih sekolah untuk memantau kelas dan siswa.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($schools ?? [] as $school)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $school->nama }}</h3>
            <p class="text-gray-500 text-sm mb-4">{{ $school->alamat ?? 'Alamat tidak tersedia' }}</p>
            
            <div class="border-t border-gray-100 pt-4 mb-4 flex gap-4">
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Total Kelas</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $school->kelas_count ?? 0 }}</p>
                </div>
            </div>
            
            <a href="{{ route('counselor.monitoring.kelas', $school->id) }}" class="block text-center w-full px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-medium transition-colors">
                Lihat Daftar Kelas
            </a>
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-gray-500 bg-white rounded-xl border border-gray-200 border-dashed">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
            Tidak ada data sekolah.
        </div>
        @endforelse
    </div>
</x-app-layout>
