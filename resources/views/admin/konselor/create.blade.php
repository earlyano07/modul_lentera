<x-app-layout>
    <x-slot name="title">Tambah Konselor</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Konselor</h1>
        <nav class="text-sm text-gray-500 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.konselor.index') }}" class="text-indigo-600 hover:text-indigo-700">Konselor</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-500">Tambah</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <form action="{{ route('admin.konselor.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Akun Info -->
                <div class="col-span-1 md:col-span-2 border-b border-gray-200 pb-4 mb-2">
                    <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Informasi Akun</h2>
                </div>

                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required class="shadow appearance-none @error('nama') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('nama')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email *</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="shadow appearance-none @error('email') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password *</label>
                    <input type="password" name="password" id="password" required class="shadow appearance-none @error('password') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Profil Info -->
                <div class="col-span-1 md:col-span-2 border-b border-gray-200 pb-4 mb-2 mt-4">
                    <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Profil Konselor</h2>
                </div>

                <!-- NIP -->
                <div>
                    <label for="nip" class="block text-gray-700 text-sm font-bold mb-2">NIP</label>
                    <input type="text" name="nip" id="nip" value="{{ old('nip') }}" class="shadow appearance-none @error('nip') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('nip')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No HP -->
                <div>
                    <label for="no_hp" class="block text-gray-700 text-sm font-bold mb-2">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" class="shadow appearance-none @error('no_hp') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('no_hp')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Schools Assignment -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Penugasan Sekolah</label>
                    <div class="bg-gray-50 p-4 rounded border border-gray-300 max-h-60 overflow-y-auto">
                        @if(count($schools) > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($schools as $school)
                                    <label class="flex items-start cursor-pointer">
                                        <input type="checkbox" name="schools[]" value="{{ $school->id }}" {{ in_array($school->id, old('schools', [])) ? 'checked' : '' }} class="mt-1 shadow-xs border border-gray-300 rounded text-blue-500 focus:ring-blue-500 focus:ring-opacity-20">
                                        <span class="ml-2 text-sm text-gray-700 font-medium">{{ $school->nama }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500">Belum ada data sekolah. Silakan <a href="{{ route('admin.schools.create') }}" class="text-blue-500 hover:text-blue-800 font-bold hover:underline">tambah sekolah</a> terlebih dahulu.</p>
                        @endif
                    </div>
                    @error('schools')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('admin.konselor.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
