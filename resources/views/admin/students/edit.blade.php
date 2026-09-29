<x-app-layout>
    <x-slot name="title">Edit Siswa</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Siswa: {{ $student->user->nama ?? '' }}</h1>
        <nav class="text-sm text-gray-500 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.students.index') }}" class="text-indigo-600 hover:text-indigo-700">Siswa</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-500">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" x-data="{
        selectedSchool: '{{ old('school_id', $student->kelas->school_id ?? '') }}',
        selectedKelas: '{{ old('kelas_id', $student->kelas_id) }}',
        allClasses: @json($classesData),
        get filteredClasses() {
            if (!this.selectedSchool) return [];
            return this.allClasses.filter(k => k.school_id == this.selectedSchool);
        }
    }">
        <form action="{{ route('admin.students.update', $student) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Akun Info -->
                <div class="col-span-1 md:col-span-2 border-b border-gray-200 pb-4 mb-2">
                    <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Informasi Akun</h2>
                </div>

                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $student->user->nama ?? '') }}" required class="shadow appearance-none @error('nama') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('nama')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $student->user->username ?? '') }}" class="shadow appearance-none @error('username') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('username')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $student->user->email ?? '') }}" class="shadow appearance-none @error('email') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password Baru</label>
                    <input type="password" name="password" id="password" minlength="8" placeholder="Kosongkan jika tidak diubah" class="shadow appearance-none @error('password') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Profil Info -->
                <div class="col-span-1 md:col-span-2 border-b border-gray-200 pb-4 mb-2 mt-4">
                    <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Data Akademik</h2>
                </div>

                <!-- Sekolah -->
                <div>
                    <label for="school_id" class="block text-gray-700 text-sm font-bold mb-2">Sekolah *</label>
                    <select name="school_id" id="school_id" x-model="selectedSchool" @change="selectedKelas = ''" required class="shadow appearance-none @error('school_id') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach($schools ?? [] as $school)
                            <option value="{{ $school->id }}">{{ $school->nama }}</option>
                        @endforeach
                    </select>
                    @error('school_id')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kelas -->
                <div>
                    <label for="kelas_id" class="block text-gray-700 text-sm font-bold mb-2">Kelas *</label>
                    <select name="kelas_id" id="kelas_id" x-model="selectedKelas" :disabled="!selectedSchool" required class="shadow appearance-none @error('kelas_id') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed">
                        <option value="" x-text="selectedSchool ? '-- Pilih Kelas --' : '-- Pilih Sekolah Terlebih Dahulu --'"></option>
                        <template x-for="k in filteredClasses" :key="k.id">
                            <option :value="k.id" x-text="k.nama_kelas + (k.tingkat ? ' (' + k.tingkat + ')' : '')"></option>
                        </template>
                    </select>
                    @error('kelas_id')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIS -->
                <div>
                    <label for="nis" class="block text-gray-700 text-sm font-bold mb-2">NIS *</label>
                    <input type="text" name="nis" id="nis" value="{{ old('nis', $student->nis) }}" required class="shadow appearance-none @error('nis') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('nis')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin</label>
                    <div class="flex items-center space-x-4 mt-2">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'L' ? 'checked' : '' }} class="shadow-xs border border-gray-300 rounded text-blue-500 focus:ring-blue-500 focus:ring-opacity-20">
                            <span class="ml-2 text-sm text-gray-700 font-medium">Laki-laki</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'P' ? 'checked' : '' }} class="shadow-xs border border-gray-300 rounded text-blue-500 focus:ring-blue-500 focus:ring-opacity-20">
                            <span class="ml-2 text-sm text-gray-700 font-medium">Perempuan</span>
                        </label>
                    </div>
                    @error('jenis_kelamin')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="tanggal_lahir" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $student->tanggal_lahir) }}" class="shadow appearance-none @error('tanggal_lahir') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('tanggal_lahir')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('admin.students.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-app-layout>
