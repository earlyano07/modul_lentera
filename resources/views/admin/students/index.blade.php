<x-app-layout>
    <x-slot name="title">Daftar Siswa</x-slot>

    <div x-data="studentManager()">
        <!-- Main Content Area with Dynamic Blur Filter -->
        <div :class="(showCreateModal || showEditModal || showImportModal) ? 'filter blur-[4px] pointer-events-none transition-all duration-300' : 'transition-all duration-300'">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Siswa</h1>
                    <nav class="text-sm text-gray-500 mt-1">
                        <ol class="list-reset flex">
                            <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-700">Dashboard</a></li>
                            <li><span class="mx-2">/</span></li>
                            <li class="text-gray-500">Siswa</li>
                        </ol>
                    </nav>
                </div>
                <div class="flex space-x-3">
                    <button type="button" @click="showImportModal = true" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Import
                    </button>
                    <button type="button" @click="openCreateModal()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Siswa
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs font-semibold shadow-xs">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 js-datatable">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Siswa</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">NIS</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kelas</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Sekolah</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">J. Kelamin</th>
                                <th class="px-6 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($students as $student)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-extrabold mr-3 text-xs shadow-2xs">
                                            {{ substr($student->user->nama ?? 'S', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-extrabold text-slate-800">{{ $student->user->nama ?? '-' }}</div>
                                            <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium mt-0.5">
                                                @if(!empty($student->user->username))
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                                        @ {{ $student->user->username }}
                                                    </span>
                                                @endif
                                                @if(!empty($student->user->email))
                                                    <span>{{ $student->user->email }}</span>
                                                @elseif(empty($student->user->username))
                                                    <span>-</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-600">{{ $student->nis ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-slate-100 text-slate-700">
                                        {{ $student->kelas->nama_kelas ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-600">{{ $student->kelas->school->nama ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold">
                                    @if($student->jenis_kelamin == 'L')
                                        <span class="text-blue-600 font-bold">Laki-laki</span>
                                    @elseif($student->jenis_kelamin == 'P')
                                        <span class="text-pink-600 font-bold">Perempuan</span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button" 
                                            @click="openEditModal({{ json_encode([
                                                'id' => $student->id,
                                                'nama' => $student->user->nama ?? '',
                                                'username' => $student->user->username ?? '',
                                                'email' => $student->user->email ?? '',
                                                'kelas_id' => $student->kelas_id,
                                                'nis' => $student->nis ?? '',
                                                'jenis_kelamin' => $student->jenis_kelamin,
                                                'tanggal_lahir' => optional($student->tanggal_lahir)->format('Y-m-d') ?? '',
                                                'update_url' => route('admin.students.update', $student)
                                            ]) }})" 
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-extrabold bg-slate-100 text-slate-700 hover:bg-slate-200 transition shadow-2xs cursor-pointer">
                                            <span class="material-symbols-outlined text-[14px]">edit</span>
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus siswa ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-extrabold bg-rose-50 text-rose-600 hover:bg-rose-100 transition shadow-2xs cursor-pointer">
                                                <span class="material-symbols-outlined text-[14px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 whitespace-nowrap text-center text-sm text-slate-400">Tidak ada data siswa.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create Student Modal -->
        <div x-show="showCreateModal" 
             class="fixed inset-0 z-[100] overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-250"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="fixed inset-0 transition-all duration-300" 
                 style="background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);" 
                 @click="showCreateModal = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
                <div x-show="showCreateModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-250"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-xl p-6 md:p-8 flex flex-col max-h-[90vh] z-10 border border-slate-100">
                    
                    <button type="button" @click="showCreateModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition p-1 hover:bg-slate-100 rounded-lg">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-600 text-2xl">person_add</span>
                            Tambah Siswa Baru
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Lengkapi data akun dan biodata siswa</p>
                    </div>

                    <div class="overflow-y-auto flex-1 px-1">
                        <form action="{{ route('admin.students.store') }}" method="POST" class="space-y-4">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="create_nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap Siswa *</label>
                                    <input type="text" name="nama" id="create_nama" x-ref="createNamaInput" required placeholder="Contoh: Muhammad Rizky Pratama"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                                <div>
                                    <label for="create_username" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Username (Opsional)</label>
                                    <input type="text" name="username" id="create_username" placeholder="Otomatis jika dikosongkan"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="create_email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Akun (Opsional)</label>
                                    <input type="email" name="email" id="create_email" placeholder="siswa@sekolah.sch.id"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                                <div>
                                    <label for="create_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password *</label>
                                    <input type="password" name="password" id="create_password" required minlength="8" placeholder="Minimal 8 karakter"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="create_kelas_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kelas *</label>
                                    <select name="kelas_id" id="create_kelas_id" required
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach($kelasList as $kelas)
                                            <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }} ({{ $kelas->school->nama ?? '-' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="create_nis" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">NIS *</label>
                                    <input type="text" name="nis" id="create_nis" required placeholder="Nomor Induk Siswa"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="create_jenis_kelamin" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jenis Kelamin *</label>
                                    <select name="jenis_kelamin" id="create_jenis_kelamin" required
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                        <option value="">-- Pilih --</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="create_tanggal_lahir" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Lahir *</label>
                                    <input type="date" name="tanggal_lahir" id="create_tanggal_lahir" required
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4 mt-6">
                                <button type="button" @click="showCreateModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-wider transition">
                                    Batal
                                </button>
                                <button type="submit" 
                                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition duration-200 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                    Simpan Siswa
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Student Modal -->
        <div x-show="showEditModal" 
             class="fixed inset-0 z-[100] overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-250"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="fixed inset-0 transition-all duration-300" 
                 style="background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);" 
                 @click="showEditModal = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
                <div x-show="showEditModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-250"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-xl p-6 md:p-8 flex flex-col max-h-[90vh] z-10 border border-slate-100">
                    
                    <button type="button" @click="showEditModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition p-1 hover:bg-slate-100 rounded-lg">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-600 text-2xl">edit_note</span>
                            Edit Data Siswa
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Perbarui profil dan informasi kelas siswa</p>
                    </div>

                    <div class="overflow-y-auto flex-1 px-1">
                        <form :action="form.update_url" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="edit_nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap Siswa *</label>
                                    <input type="text" name="nama" id="edit_nama" x-ref="editNamaInput" x-model="form.nama" required
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                                <div>
                                    <label for="edit_username" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Username</label>
                                    <input type="text" name="username" id="edit_username" x-model="form.username" placeholder="Username login siswa"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="edit_email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Akun (Opsional)</label>
                                    <input type="email" name="email" id="edit_email" x-model="form.email" placeholder="siswa@sekolah.sch.id"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                                <div>
                                    <label for="edit_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password Baru</label>
                                    <input type="password" name="password" id="edit_password" placeholder="Kosongkan jika tidak diubah" minlength="8"
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="edit_kelas_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kelas *</label>
                                    <select name="kelas_id" id="edit_kelas_id" x-model="form.kelas_id" required
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach($kelasList as $kelas)
                                            <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }} ({{ $kelas->school->nama ?? '-' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="edit_nis" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">NIS *</label>
                                    <input type="text" name="nis" id="edit_nis" x-model="form.nis" required
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="edit_jenis_kelamin" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jenis Kelamin *</label>
                                    <select name="jenis_kelamin" id="edit_jenis_kelamin" x-model="form.jenis_kelamin" required
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="edit_tanggal_lahir" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Lahir *</label>
                                    <input type="date" name="tanggal_lahir" id="edit_tanggal_lahir" x-model="form.tanggal_lahir" required
                                        class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4 mt-6">
                                <button type="button" @click="showEditModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-wider transition">
                                    Batal
                                </button>
                                <button type="submit" 
                                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition duration-200 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Import Student Modal -->
        <div x-show="showImportModal" 
             class="fixed inset-0 z-[100] overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-250"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="fixed inset-0 transition-all duration-300" 
                 style="background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);" 
                 @click="showImportModal = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
                <div x-show="showImportModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-250"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-lg p-6 md:p-8 flex flex-col max-h-[90vh] z-10 border border-slate-100">
                    
                    <button type="button" @click="showImportModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition p-1 hover:bg-slate-100 rounded-lg">
                        <span class="material-symbols-outlined">close</span>
                    </button>

                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-600 text-2xl">upload_file</span>
                            Import Data Siswa
                        </h2>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Unggah file Excel / CSV data siswa sekaligus</p>
                    </div>

                    <div class="overflow-y-auto flex-1 px-1">
                        <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf

                            <div>
                                <label for="import_kelas_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kelas Tujuan *</label>
                                <select name="kelas_id" id="import_kelas_id" required
                                    class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($kelasList as $kelas)
                                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }} ({{ $kelas->school->nama ?? '-' }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">File Excel / CSV *</label>
                                <div class="relative flex flex-col items-center justify-center p-5 border-2 border-dashed border-slate-200 hover:border-indigo-400 bg-slate-50/50 rounded-2xl cursor-pointer transition duration-200 group">
                                    <input type="file" name="file" id="import_file" accept=".xlsx,.xls,.csv" required
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        @change="const file = $event.target.files[0]; importFileName = file ? file.name : ''">
                                    <div class="text-center">
                                        <span class="material-symbols-outlined text-slate-400 group-hover:text-indigo-500 text-2xl transition duration-200 mb-1">table_view</span>
                                        <p class="text-xs font-extrabold text-slate-700" x-text="importFileName ? importFileName : 'Pilih File Excel / CSV'"></p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">Format: .xlsx, .xls, .csv (Maks: 5MB)</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-4 mt-6">
                                <button type="button" @click="showImportModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-wider transition">
                                    Batal
                                </button>
                                <button type="submit" 
                                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xs hover:shadow-md transition duration-200 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm">upload</span>
                                    Import Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('studentManager', () => ({
                showCreateModal: false,
                showEditModal: false,
                showImportModal: false,
                importFileName: '',
                form: {
                    id: '',
                    nama: '',
                    username: '',
                    email: '',
                    kelas_id: '',
                    nis: '',
                    jenis_kelamin: 'L',
                    tanggal_lahir: '',
                    update_url: ''
                },
                openCreateModal() {
                    this.showCreateModal = true;
                    this.$nextTick(() => {
                        this.$refs.createNamaInput?.focus();
                    });
                },
                openEditModal(data) {
                    this.form = { ...data };
                    this.showEditModal = true;
                    this.$nextTick(() => {
                        this.$refs.editNamaInput?.focus();
                        this.$refs.editNamaInput?.select();
                    });
                }
            }));
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @endpush
</x-app-layout>
