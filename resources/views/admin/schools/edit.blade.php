<x-app-layout>
    <x-slot name="title">Edit Sekolah</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Sekolah: {{ $school->nama }}</h1>
        <nav class="text-sm text-gray-500 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.schools.index') }}" class="text-indigo-600 hover:text-indigo-700">Sekolah</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-500">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <form action="{{ route('admin.schools.update', $school) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div class="col-span-1 md:col-span-2">
                    <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama Sekolah *</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $school->nama) }}" required class="shadow appearance-none @error('nama') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('nama')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NPSN -->
                <div>
                    <label for="npsn" class="block text-gray-700 text-sm font-bold mb-2">NPSN</label>
                    <input type="text" name="npsn" id="npsn" value="{{ old('npsn', $school->npsn) }}" class="shadow appearance-none @error('npsn') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('npsn')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telepon -->
                <div>
                    <label for="telepon" class="block text-gray-700 text-sm font-bold mb-2">Telepon</label>
                    <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $school->telepon) }}" class="shadow appearance-none @error('telepon') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('telepon')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="col-span-1 md:col-span-2">
                    <label for="alamat" class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3" class="shadow appearance-none @error('alamat') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('alamat', $school->alamat) }}</textarea>
                    @error('alamat')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Logo -->
                <div class="col-span-1 md:col-span-2">
                    <label for="logo" class="block text-gray-700 text-sm font-bold mb-2">Logo Sekolah</label>
                    @if($school->logo)
                        <div class="my-2">
                            <img src="{{ Storage::url($school->logo) }}" alt="Logo" class="h-20 w-auto rounded border border-gray-300 shadow-xs">
                        </div>
                    @endif
                    <input type="file" name="logo" id="logo" accept="image/*" class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline file:bg-gray-100 file:border-0 file:rounded-md file:px-2 file:py-1 file:font-semibold file:text-xs file:text-gray-700 hover:file:bg-gray-200">
                    <p class="text-gray-500 text-xs mt-1">Biarkan kosong jika tidak ingin mengubah logo.</p>
                    @error('logo')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="col-span-1 md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="status" value="1" {{ old('status', $school->status) ? 'checked' : '' }} class="shadow-xs border border-gray-300 rounded text-blue-500 focus:ring-blue-500 focus:ring-opacity-20">
                        <span class="ml-2 text-sm text-gray-700 font-medium">Aktif</span>
                    </label>
                    @error('status')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('admin.schools.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-app-layout>
