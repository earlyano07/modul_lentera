<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Belajar - {{ $student->nama ?? $student->user->nama ?? 'Siswa' }}</title>
    
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

        /* Progress Card */
        .progress-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .progress-title {
            font-size: 11px;
            font-weight: 700;
            color: #334155;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .progress-desc {
            font-size: 11px;
            color: #64748b;
        }

        .progress-metric {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .progress-bar-bg {
            width: 120px;
            height: 8px;
            background-color: #e2e8f0;
            border-radius: 9999px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background-color: #059669;
            border-radius: 9999px;
        }

        .progress-percent {
            font-size: 14px;
            font-weight: 800;
            color: #059669;
            min-width: 42px;
            text-align: right;
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

        .text-right {
            text-align: right !important;
        }

        .badge-kategori {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            text-align: center;
        }

        .badge-sangat-baik {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .badge-baik {
            background-color: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        .badge-cukup {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .badge-kurang {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Counselor Notes Box */
        .note-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 12px;
            margin-bottom: 8px;
            font-size: 11px;
        }

        .note-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .note-title {
            font-weight: 800;
            color: #1e293b;
        }

        .note-body {
            color: #475569;
            line-height: 1.4;
        }

        /* Signature Section */
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

        /* Media Print Specific */
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
                Laporan Hasil Belajar: {{ $student->nama ?? $student->user->nama ?? 'Siswa' }}
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
                    <div class="kop-school">{{ $student->kelas->school->nama ?? 'Bimbingan dan Konseling Sekolah' }}</div>
                </div>
            </div>

            <!-- Judul Dokumen -->
            <div class="doc-title-box">
                <div class="doc-title">LEMBAR LAPORAN HASIL BELAJAR PESERTA DIDIK</div>
                <div class="doc-subtitle">Rekapitulasi Capaian Asesmen dan Evaluasi Perkembangan Empati</div>
            </div>

            <!-- Identitas Siswa -->
            <div class="section-title">I. Identitas Peserta Didik</div>
            <table class="info-table">
                <tr>
                    <td class="info-label">Nama Lengkap</td>
                    <td class="info-val">: {{ $student->nama ?? $student->user->nama ?? '-' }}</td>
                    <td class="info-label">Nomor Induk Siswa</td>
                    <td class="info-val">: {{ $student->nis ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Kelas</td>
                    <td class="info-val">: {{ $student->kelas->nama_kelas ?? '-' }} (Tingkat {{ $student->kelas->tingkat ?? 'X' }})</td>
                    <td class="info-label">Jenis Kelamin</td>
                    <td class="info-val">: {{ $student->jenis_kelamin ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Satuan Pendidikan</td>
                    <td class="info-val" colspan="3">: {{ $student->kelas->school->nama ?? '-' }}</td>
                </tr>
            </table>

            <!-- Ringkasan Progress Program -->
            <div class="progress-box">
                <div>
                    <div class="progress-title">Status Penyelesaian Program LENTERA</div>
                    <div class="progress-desc">Dihitung berdasarkan modul dan seluruh rangkaian asesmen yang telah diselesaikan.</div>
                </div>
                <div class="progress-metric">
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: {{ $progressPercentage ?? 0 }}%;"></div>
                    </div>
                    <div class="progress-percent">{{ $progressPercentage ?? 0 }}%</div>
                </div>
            </div>

            <!-- Hasil Asesmen Siswa -->
            <div class="section-title">II. Rekapitulasi Nilai Asesmen</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="35%">Nama Instrumen Asesmen</th>
                        <th width="25%">Topik / Modul Terkait</th>
                        <th width="12%" class="text-center">Nilai Capaian</th>
                        <th width="13%" class="text-center">Predikat</th>
                        <th width="10%" class="text-center">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assessmentResults ?? [] as $index => $result)
                    @php
                        $val = (float)($result->nilai ?? $result->score ?? 0);
                        $cat = \App\Models\StudentEvaluation::getCategoryFromPercentage($val);
                        $badgeClass = match($cat['category'] ?? '') {
                            'Sangat Baik' => 'badge-sangat-baik',
                            'Baik' => 'badge-baik',
                            'Cukup' => 'badge-cukup',
                            default => 'badge-kurang'
                        };
                    @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $result->assessment->judul ?? 'Asesmen' }}</strong></td>
                        <td>{{ $result->assessment->module->judul ?? '-' }}</td>
                        <td class="text-center"><strong>{{ number_format($val, 0) }}%</strong></td>
                        <td class="text-center">
                            <span class="badge-kategori {{ $badgeClass }}">{{ $cat['category'] ?? '-' }}</span>
                        </td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($result->finished_at ?? $result->created_at)->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center" style="color: #94a3b8; padding: 14px;">Belum ada data asesmen yang diselesaikan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Catatan & Evaluasi Konselor -->
            @if(isset($evaluations) && $evaluations->count() > 0)
            <div class="section-title">III. Catatan Perkembangan & Rekomendasi Konselor</div>
            <div style="margin-bottom: 20px;">
                @foreach($evaluations as $eval)
                @php
                    $cat = $eval->category;
                    $badgeClass = match($cat['category'] ?? '') {
                        'Sangat Baik' => 'badge-sangat-baik',
                        'Baik' => 'badge-baik',
                        'Cukup' => 'badge-cukup',
                        default => 'badge-kurang'
                    };
                    $catatan = $eval->notes ?: ($eval->self_note ?: ($eval->commitment_note ?: ($eval->lkpd_note ?: 'Peserta didik telah menyelesaikan tahapan pembelajaran empati dengan baik.')));
                @endphp
                <div class="note-card">
                    <div class="note-header">
                        <span class="note-title">Topik {{ $eval->module->urutan ?? 1 }}: {{ $eval->module->judul ?? 'Modul' }}</span>
                        @if($cat)
                        <span class="badge-kategori {{ $badgeClass }}">Capaian: {{ $cat['category'] }} ({{ number_format($eval->percentage, 0) }}%)</span>
                        @endif
                    </div>
                    <div class="note-body">
                        <strong>Catatan Konselor:</strong> {{ $catatan }}
                    </div>
                </div>
                @endforeach
            </div>
            @endif

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
