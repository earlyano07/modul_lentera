<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'LENTERA' }} - {{ config('app.name', 'LENTERA') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- simple-datatables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3/dist/style.css" rel="stylesheet" type="text/css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(224, 224, 224, 0.5);
        }

        /* DataTables Modern Tailored Styling */
        .datatable-wrapper {
            width: 100%;
            font-family: inherit;
        }

        .datatable-top {
            padding: 1rem 1.5rem;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f1f5f9;
            gap: 1rem;
            flex-wrap: wrap;
            background-color: #ffffff;
        }

        .datatable-dropdown {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .datatable-dropdown label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
        }

        .datatable-selector {
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            padding: 0.4rem 2rem 0.4rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #334155;
            background-color: #f8fafc;
            transition: all 0.2s;
            cursor: pointer;
        }

        .datatable-selector:focus {
            outline: none;
            border-color: #6366f1;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        .datatable-search {
            position: relative;
        }

        .datatable-search input {
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            padding: 0.45rem 1rem 0.45rem 2.25rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #1e293b;
            background-color: #f8fafc;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: 0.65rem center;
            background-size: 1rem;
            transition: all 0.2s;
            min-width: 220px;
        }

        .datatable-search input:focus {
            outline: none;
            border-color: #6366f1;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        .datatable-search input::placeholder {
            color: #94a3b8;
            font-weight: 500;
        }

        .datatable-container {
            overflow-x: auto;
            width: 100%;
            border: none;
        }

        .datatable-table {
            width: 100% !important;
            border-collapse: separate;
            border-spacing: 0;
            text-align: left;
        }

        .datatable-table thead th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.875rem 1.25rem;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
            white-space: nowrap;
        }

        .datatable-table thead th button,
        .datatable-table thead th a {
            color: inherit;
            font-weight: inherit;
            text-transform: inherit;
            letter-spacing: inherit;
            font-size: inherit;
            background: transparent;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            width: 100%;
        }

        .datatable-table tbody tr {
            transition: background-color 0.15s ease-in-out;
        }

        .datatable-table tbody tr:hover {
            background-color: #f8fafc !important;
        }

        .datatable-table tbody td {
            padding: 0.875rem 1.25rem;
            vertical-align: middle;
            font-size: 0.8125rem;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        .datatable-table tbody tr:last-child td {
            border-bottom: none;
        }

        .datatable-bottom {
            padding: 0.875rem 1.5rem;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f1f5f9;
            background-color: #ffffff;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .datatable-info {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
        }

        .datatable-pagination {
            margin: 0;
        }

        .datatable-pagination ul {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .datatable-pagination li a,
        .datatable-pagination li button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2rem;
            height: 2rem;
            padding: 0 0.5rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #475569;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            transition: all 0.15s;
            text-decoration: none;
            cursor: pointer;
        }

        .datatable-pagination li a:hover,
        .datatable-pagination li button:hover {
            background-color: #f1f5f9;
            color: #0f172a;
            border-color: #cbd5e1;
        }

        .datatable-pagination li.active a,
        .datatable-pagination li.active button {
            background-color: #4f46e5 !important;
            color: #ffffff !important;
            border-color: #4f46e5 !important;
            font-weight: 800;
            box-shadow: 0 1px 2px rgba(79, 70, 229, 0.2);
        }

        .datatable-pagination li.disabled a,
        .datatable-pagination li.disabled button {
            opacity: 0.4;
            pointer-events: none;
            cursor: not-allowed;
            background-color: #f8fafc;
        }
    </style>
</head>

<body class="bg-surface text-on-background antialiased">
    <div class="min-h-screen flex">
        <!-- SideNavBar -->
        <aside id="sidebar"
            class="w-[260px] h-screen fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out bg-primary shadow-md flex flex-col py-6 gap-2">
            <!-- Logo -->
            <div class="px-6 mb-8 flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-primary text-[24px]"
                        style="font-variation-settings: 'FILL' 1;">lightbulb</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-white leading-none">LENTERA</span>
                    <span class="text-[10px] text-white uppercase tracking-widest font-bold">Education
                        Platform</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 flex flex-col gap-1 overflow-y-auto">
                @auth
                    @if (auth()->user()->isAdmin())
                        @include('components.sidebar.admin-nav')
                    @elseif(auth()->user()->isKonselor())
                        @include('components.sidebar.counselor-nav')
                    @elseif(auth()->user()->isSiswa())
                        @include('components.sidebar.student-nav')
                    @endif
                @endauth
            </nav>
        </aside>

        <!-- Mobile Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden" onclick="toggleSidebar()">
        </div>

        <!-- Main Content & Top Bar -->
        <div class="flex-1 lg:ml-[260px] min-h-screen flex flex-col bg-background">
            <!-- TopNavBar -->
            <header
                class="h-16 sticky top-0 z-40 bg-surface border-b border-outline-variant flex justify-between items-center px-6">
                <div class="flex items-center gap-4 flex-1">
                    <button onclick="toggleSidebar()"
                        class="lg:hidden text-gray-600 hover:text-gray-900 focus:outline-none">
                        <span class="material-symbols-outlined text-[28px]">menu</span>
                    </button>
                    <!-- Search Bar -->
                    <div
                        class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-primary rounded-xl transition-all hidden md:block">
                        <span
                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                        <input
                            class="w-full pl-10 pr-4 py-2 bg-surface-container-low border-none rounded-xl text-body-sm focus:ring-0 focus:outline-none"
                            placeholder="Cari siswa, kelas, atau modul..." type="text" />
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <button class="relative p-2 hover:bg-surface-container-low rounded-full transition-colors">
                        <span class="material-symbols-outlined text-on-surface-variant">notifications</span>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full"></span>
                    </button>
                    <div class="h-8 w-[1px] bg-outline-variant"></div>
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="font-label-md text-label-md text-on-surface leading-tight">
                                {{ auth()->user()->nama ?? 'User' }}</p>
                            <p class="text-[10px] text-on-surface-variant font-medium">
                                {{ auth()->user()->getRoleName() }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-primary-container text-white flex items-center justify-center font-bold border-2 border-primary-container/20 shadow-sm"
                            title="{{ auth()->user()->nama }}">
                            {{ substr(auth()->user()->nama ?? 'U', 0, 1) }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="flex items-center">
                            @csrf
                            <button type="submit"
                                class="text-slate-400 hover:text-error transition cursor-pointer p-2 rounded-full hover:bg-red-50"
                                title="Logout">
                                <span class="material-symbols-outlined text-[20px]">logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if (session('success'))
                <div id="flash-success"
                    class="mx-6 mt-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mx-6 mt-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-2">
                    <span class="material-symbols-outlined text-red-500">error</span>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Page Content -->
            <main class="p-6 lg:p-8 flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-surface-container-lowest border-t border-outline-variant py-8">
                <div
                    class="max-w-container-max mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex flex-col gap-1">
                        <span class="font-headline-sm text-headline-sm text-primary">LENTERA</span>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">© 2026 LENTERA Educational
                            Platform. Seluruh Hak Cipta Dilindungi.</p>
                    </div>
                    <div class="flex gap-8">
                        <a class="text-on-surface-variant hover:text-primary transition-colors text-label-sm"
                            href="#">Beranda</a>
                        <a class="text-on-surface-variant hover:text-primary transition-colors text-label-sm"
                            href="#">Tentang</a>
                        <a class="text-on-surface-variant hover:text-primary transition-colors text-label-sm"
                            href="#">Fitur</a>
                        <a class="text-on-surface-variant hover:text-primary transition-colors text-label-sm"
                            href="#">Tahapan SLA</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Auto-hide flash messages
        setTimeout(() => {
            const flash = document.getElementById('flash-success');
            if (flash) flash.style.display = 'none';
        }, 5000);

        // Micro-interactions active state
        document.querySelectorAll('a, button').forEach(elem => {
            elem.addEventListener('mousedown', () => {
                elem.classList.add('scale-95');
            });
            elem.addEventListener('mouseup', () => {
                elem.classList.remove('scale-95');
            });
            elem.addEventListener('mouseleave', () => {
                elem.classList.remove('scale-95');
            });
        });
    </script>

    <!-- simple-datatables JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3/dist/umd/simple-datatables.js" type="text/javascript">
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tables = document.querySelectorAll(".js-datatable");
            tables.forEach(table => {
                new simpleDatatables.DataTable(table, {
                    searchable: true,
                    fixedHeight: false,
                    perPage: 10,
                    labels: {
                        placeholder: "Cari data...",
                        perPage: "{select} entri per halaman",
                        noRows: "Tidak ada data ditemukan",
                        info: "Menampilkan {start} sampai {end} dari {rows} entri",
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
