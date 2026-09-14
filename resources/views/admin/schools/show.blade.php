<x-app-layout>
    <x-slot name="title">Detail Sekolah</x-slot>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Sekolah: {{ $school->nama }}</h1>
            <nav class="text-sm text-gray-500 mt-1">
                <ol class="list-reset flex">
                    <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('admin.schools.index') }}" class="text-indigo-600 hover:text-indigo-700">Sekolah</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-500">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.schools.edit', $school) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Edit
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- School Info -->
        <div class="col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="text-center mb-6">
                    @if($school->logo)
                        <img src="{{ Storage::url($school->logo) }}" alt="Logo" class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-gray-100">
                    @else
                        <div class="w-32 h-32 mx-auto rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-3xl">S</div>
                    @endif
                    <h2 class="mt-4 text-xl font-bold text-gray-900">{{ $school->nama }}</h2>
                    <p class="text-sm text-gray-500 mt-1">NPSN: {{ $school->npsn ?? '-' }}</p>
                    <div class="mt-2">
                        @if($school->status)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Nonaktif</span>
                        @endif
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4 space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Telepon</p>
                        <p class="text-sm text-gray-900">{{ $school->telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Alamat</p>
                        <p class="text-sm text-gray-900">{{ $school->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-1 lg:col-span-2 space-y-6">
            <!-- Classes List -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Kelas</h3>
                    <a href="{{ route('admin.kelas.create', ['school_id' => $school->id]) }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">Tambah Kelas</a>
                </div>
                <div class="p-0">
                    @if(isset($school->kelas) && $school->kelas->count() > 0)
                        <ul class="divide-y divide-gray-200">
                            @foreach($school->kelas as $kelas)
                            <li class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $kelas->nama_kelas }}</p>
                                    <p class="text-sm text-gray-500">Tingkat: {{ $kelas->tingkat }} | Tahun: {{ $kelas->tahun_ajaran }}</p>
                                </div>
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $kelas->students_count ?? 0 }} Siswa
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-6 text-center text-gray-500 text-sm">Belum ada kelas.</div>
                    @endif
                </div>
            </div>

            <!-- Counselors List -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">Konselor Ditugaskan</h3>
                </div>
                <div class="p-0">
                    @if(isset($school->counselors) && $school->counselors->count() > 0)
                        <ul class="divide-y divide-gray-200">
                            @foreach($school->counselors as $counselor)
                            <li class="px-6 py-4 flex items-center hover:bg-gray-50">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mr-3">
                                    {{ substr($counselor->user->nama ?? 'C', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $counselor->user->nama ?? '-' }}</p>
                                    <p class="text-sm text-gray-500">NIP: {{ $counselor->nip ?? '-' }}</p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-6 text-center text-gray-500 text-sm">Belum ada konselor.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
