<x-app-layout>
    <x-slot name="title">Import Siswa</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Import Data Siswa</h1>
        <nav class="text-sm text-gray-500 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.students.index') }}" class="text-indigo-600 hover:text-indigo-700">Siswa</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-500">Import</li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <form action="{{ route('admin.students.import.process') ?? '#' }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Kelas -->
                        <div>
                            <label for="kelas_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Kelas *</label>
                            <select name="kelas_id" id="kelas_id" required class="shadow appearance-none @error('kelas_id') border border-red-500 mb-3 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelasList ?? [] as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }} ({{ $kelas->school->nama ?? '' }})</option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div>
                            <label for="file" class="block text-gray-700 text-sm font-bold mb-2">File Excel/CSV *</label>
                            <input id="file" name="file" type="file" required class="shadow appearance-none @error('file') border border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline file:bg-gray-100 file:border-0 file:rounded-md file:px-2 file:py-1 file:font-semibold file:text-xs file:text-gray-700 hover:file:bg-gray-200" accept=".xlsx,.csv">
                            @error('file')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('admin.students.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Batal</a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Proses Import</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-span-1">
            <div class="bg-blue-50 border border-blue-200 rounded p-6 shadow-md mb-4">
                <h3 class="text-sm font-bold text-blue-900 uppercase tracking-wider mb-3">Panduan Import</h3>
                <div class="text-sm text-blue-800/90 space-y-3 font-medium">
                    <p>Pastikan file excel/csv Anda mengikuti format berikut:</p>
                    <ul class="list-disc list-inside ml-2 space-y-1 text-blue-900/80">
                        <li>Kolom A: Nama Lengkap</li>
                        <li>Kolom B: NIS</li>
                        <li>Kolom C: Email (opsional, unik)</li>
                        <li>Kolom D: Jenis Kelamin (L/P)</li>
                        <li>Kolom E: Tanggal Lahir (YYYY-MM-DD)</li>
                    </ul>
                    <p class="mt-4 pt-3 border-t border-blue-100/50">
                        <a href="#" class="inline-flex items-center font-bold text-blue-500 hover:text-blue-800">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download Template
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
