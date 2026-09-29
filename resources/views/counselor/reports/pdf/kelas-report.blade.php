<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kelas - {{ $kelas->nama_kelas ?? 'Kelas' }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            color: #1e293b;
            background-color: #f1f5f9;
            line-height: 1.5;
            min-height: 100vh;
        }

        /* Top Sticky Toolbar (Screen only) */
        .toolbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .toolbar-left, .toolbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
            border: 1px solid transparent;
        }

        .btn-secondary {
            background-color: #f8fafc;
            color: #475569;
            border-color: #cbd5e1;
        }

        .btn-secondary:hover {
            background-color: #e2e8f0;
            color: #0f172a;
        }

        .btn-primary {
            background-color: #059669;
            color: #ffffff;
            box-shadow: 0 2px 4px rgba(5, 150, 105, 0.2);
        }

        .btn-primary:hover {
            background-color: #047857;
        }

        .print-tip {
            font-size: 12px;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Sheet / Paper Container */
        .sheet-container {
            padding: 24px 16px;
            display: flex;
            justify-content: center;
        }

        .sheet {
            background: #ffffff;
            width: 210mm;
            min-height: 297mm;
            padding: 20mm 20mm;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border-radius: 4px;
            position: relative;
        }

        /* Letterhead / Kop Laporan */
        .kop-header {
            display: flex;
            align-items: center;
            gap: 16px;
            border-bottom: 3px double #059669;
            padding-bottom: 14px;
            margin-bottom: 24px;
        }

        .logo-box {
            width: 54px;
            height: 54px;
            background: #059669;
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            font-weight: 800;
            flex-shrink: 0;
        }

        .kop-text {
            flex-grow: 1;
            text-align: center;
        }

        .kop-title {
            font-size: 16px;
            font-weight: 800;
            color: #059669;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .kop-subtitle {
            font-size: 12px;
            color: #475569;
            font-weight: 600;
            margin-top: 2px;
        }

        .kop-school {
            font-size: 13px;
            color: #0f172a;
            font-weight: 700;
            margin-top: 2px;
        }

        /* Document Title */
        .doc-title-box {
            text-align: center;
            margin-bottom: 22px;
        }

        .doc-title {
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            display: inline-block;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 4px;
        }

        .doc-subtitle {
            font-size: 11px;
            color: #64748b;
            font-weight: 600;
            margin-top: 4px;
        }

        /* Sections */
        .section-title {
            font-size: 12px;
            font-weight: 800;
            color: #065f46;
            background-color: #ecfdf5;
            padding: 6px 10px;
            border-left: 4px solid #059669;
            margin-bottom: 12px;
            border-radius: 0 6px 6px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Identity Table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
            font-size: 12px;
        }

        .info-table td {
            padding: 4px 6px;
            vertical-align: top;
        }

        .info-label {
            width: 120px;
            color: #64748b;
            font-weight: 600;
        }

        .info-val {
            color: #0f172a;
            font-weight: 700;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 22px;
        }

        .stat-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 12px;
            text-align: center;
        }

        .stat-label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .stat-val {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }

        /* Data Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
            font-size: 11px;
        }

        .data-table th, .data-table td {
            border: 1px solid #cbd5e1;
            padding: 7px 10px;
            text-align: left;
            vertical-align: middle;
        }

        .data-table th {
            background-color: #f8fafc;
            font-weight: 800;
            color: #334155;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
        }

        .text-center {
            text-align: center !important;
        }

        /* Signatures */
        .signatures {
            width: 100%;
            margin-top: 28px;
            font-size: 11px;
            page-break-inside: avoid;
        }

        .signatures td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 16px;
        }

        .sign-title {
            color: #64748b;
            font-weight: 600;
            line-height: 1.3;
        }

        .sign-area {
            height: 60px;
        }

        .sign-name {
            font-weight: 800;
            color: #0f172a;
            text-decoration: underline;
            font-size: 12px;
        }

        .sign-sub {
            color: #64748b;
            font-size: 10px;
            margin-top: 2px;
        }

        @media print {
            body {
                background-color: #ffffff;
                color: #000000;
            }

            .toolbar {
                display: none !important;
            }

            .sheet-container {
                padding: 0;
                display: block;
            }

            .sheet {
                width: 100% !important;
                min-height: auto !important;
                padding: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            @page {
                size: A4 portrait;
                margin: 15mm 15mm 15mm 15mm;
            }

            .signatures {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <!-- Top Screen Toolbar -->
    <div class="toolbar">
        <div class="toolbar-left">
            <button type="button" onclick="window.close(); if(window.opener){window.opener.focus();}" class="btn btn-secondary">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Kembali
            </button>
            <span style="font-weight: 700; font-size: 14px; color: #1e293b;">
                Laporan Kelas: {{ $kelas->nama_kelas ?? 'Kelas' }}
            </span>
        </div>
        <div class="toolbar-right">
            <div class="print-tip">
                <span class="material-symbols-outlined" style="font-size: 16px; color: #059669;">info</span>
                <span>Pilih <strong>"Save as PDF"</strong> pada tujuan cetak browser untuk mengunduh PDF.</span>
            </div>
            <button type="button" onclick="window.print()" class="btn btn-primary">
                <span class="material-symbols-outlined text-sm">print</span>
                Cetak / Download PDF (A4)
            </button>
        </div>
    </div>

    <!-- Printable Paper Sheet -->
    <div class="sheet-container">
        <div class="sheet">
            <!-- Kop Laporan Resmi -->
            <div class="kop-header">
                <div class="logo-box">
                    L
                </div>
                <div class="kop-text">
                    <div class="kop-title">PROGRAM LAYANAN EDUKASI EMPATI BERBASIS PERAN</div>
                    <div class="kop-subtitle">MODEL LENTERA (LAYANAN EDUKASI EMPATI BERBASIS PERAN)</div>
                    <div class="kop-school">{{ $kelas->school->nama ?? 'Bimbingan dan Konseling Sekolah' }}</div>
                </div>
            </div>

            <!-- Judul Dokumen -->
            <div class="doc-title-box">
                <div class="doc-title">REKAPITULASI LAPORAN KEMAJUAN BELAJAR KELAS</div>
                <div class="doc-subtitle">Kelas: {{ $kelas->nama_kelas ?? '-' }} • Tingkat {{ $kelas->tingkat ?? '-' }}</div>
            </div>

            <!-- Info Identitas Kelas -->
            <div class="section-title">I. Identitas Kelas</div>
            <table class="info-table">
                <tr>
                    <td class="info-label">Satuan Pendidikan</td>
                    <td class="info-val">: {{ $kelas->school->nama ?? '-' }}</td>
                    <td class="info-label">Jumlah Siswa</td>
                    <td class="info-val">: {{ count($studentsData ?? []) }} Siswa</td>
                </tr>
                <tr>
                    <td class="info-label">Rombongan Belajar</td>
                    <td class="info-val">: {{ $kelas->nama_kelas ?? '-' }} (Tingkat {{ $kelas->tingkat ?? '-' }})</td>
                    <td class="info-label">Tahun Ajaran</td>
                    <td class="info-val">: {{ date('Y') }}/{{ date('Y', strtotime('+1 year')) }}</td>
                </tr>
            </table>

            @php
                $totalSiswa = count($studentsData ?? []);
                $totalSelesai = collect($studentsData ?? [])->where('is_completed', true)->count();
                $totalSedang = collect($studentsData ?? [])->where('is_completed', false)->filter(fn($s) => ($s->progress_percentage ?? 0) > 0)->count();
                $totalBelum = collect($studentsData ?? [])->filter(fn($s) => ($s->progress_percentage ?? 0) == 0)->count();
                $persentaseSelesai = $totalSiswa > 0 ? round(($totalSelesai / $totalSiswa) * 100) : 0;
            @endphp

            <!-- Statistik -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Penyelesaian Kelas</div>
                    <div class="stat-val" style="color: #059669;">{{ $persentaseSelesai }}%</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Selesai Seluruh Modul</div>
                    <div class="stat-val" style="color: #15803d;">{{ $totalSelesai }} Siswa</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Sedang Mengerjakan</div>
                    <div class="stat-val" style="color: #b45309;">{{ $totalSedang }} Siswa</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Belum Memulai</div>
                    <div class="stat-val" style="color: #b91c1c;">{{ $totalBelum }} Siswa</div>
                </div>
            </div>

            <!-- Tabel Siswa -->
            <div class="section-title">II. Daftar Capaian Peserta Didik</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="35%">Nama Siswa</th>
                        <th width="20%">NIS</th>
                        <th width="15%" class="text-center">Progress</th>
                        <th width="25%" class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($studentsData ?? [] as $index => $data)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $data->student->nama ?? $data->student->user->nama ?? 'Siswa' }}</strong></td>
                        <td>{{ $data->student->nis ?? '-' }}</td>
                        <td class="text-center"><strong>{{ $data->progress_percentage ?? 0 }}%</strong></td>
                        <td class="text-center">
                            @if($data->is_completed)
                                <span style="color: #15803d; font-weight: 700;">✓ Selesai Lengkap</span>
                            @elseif(($data->progress_percentage ?? 0) > 0)
                                <span style="color: #b45309; font-weight: 700;">Sedang Berjalan</span>
                            @else
                                <span style="color: #94a3b8; font-weight: 600;">Belum Mulai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 14px; color: #94a3b8;">Belum ada data siswa di kelas ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Lembar Tanda Tangan -->
            <table class="signatures">
                <tr>
                    <td>
                        <p class="sign-title">Mengetahui,<br>Kepala Sekolah</p>
                        <div class="sign-area"></div>
                        <p class="sign-name">_________________________________</p>
                        <p class="sign-sub">NIP. .....................................................</p>
                    </td>
                    <td>
                        <p class="sign-title">Diterbitkan pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>Guru Bimbingan dan Konseling</p>
                        <div class="sign-area"></div>
                        <p class="sign-name">{{ auth()->user()->counselor->nama ?? auth()->user()->nama ?? 'Guru BK' }}</p>
                        <p class="sign-sub">Konselor Bimbingan & Konseling</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Auto Print Script if ?print=1 in URL -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('print') === '1' || urlParams.get('autoprint') === '1') {
                setTimeout(() => {
                    window.print();
                }, 350);
            }
        });
    </script>
</body>
</html>
