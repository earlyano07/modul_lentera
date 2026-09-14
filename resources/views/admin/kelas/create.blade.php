<x-app-layout>
    <x-slot name="title">Tambah Kelas</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Kelas</h1>
        <nav class="text-sm text-gray-500 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.kelas.index') }}" class="text-indigo-600 hover:text-indigo-700">Kelas</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-500">Tambah</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <form action="{{ route('admin.kelas.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Sekolah -->
                <div class="col-span-1 md:col-span-2">
                    <label for="school_id" class="block text-gray-700 text-sm font-bold mb-2">Sekolah *</label>
                    <select name="school_id" id="school_id" required class="shadow appearance-none @error('school_id') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}" {{ old('school_id', request('school_id')) == $school->id ? 'selected' : '' }}>
                                {{ $school->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('school_id')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Kelas -->
                <div class="col-span-1">
                    <label for="nama_kelas" class="block text-gray-700 text-sm font-bold mb-2">Nama Kelas *</label>
                    <input type="text" name="nama_kelas" id="nama_kelas" value="{{ old('nama_kelas') }}" placeholder="Contoh: X MIPA 1" required class="shadow appearance-none @error('nama_kelas') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('nama_kelas')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tingkat -->
                <div class="col-span-1">
                    <label for="tingkat" class="block text-gray-700 text-sm font-bold mb-2">Tingkat *</label>
                    <input type="text" name="tingkat" id="tingkat" value="{{ old('tingkat') }}" placeholder="Contoh: 10, 11, 12" required class="shadow appearance-none @error('tingkat') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('tingkat')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tahun Ajaran -->
                <div class="col-span-1">
                    <label for="tahun_ajaran" class="block text-gray-700 text-sm font-bold mb-2">Tahun Ajaran *</label>
                    <input type="text" name="tahun_ajaran" id="tahun_ajaran" value="{{ old('tahun_ajaran') }}" placeholder="Contoh: 2023/2024" required class="shadow appearance-none @error('tahun_ajaran') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('tahun_ajaran')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('admin.kelas.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
