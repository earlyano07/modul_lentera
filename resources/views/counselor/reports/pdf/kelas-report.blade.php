<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kelas - {{ $kelas->nama_kelas ?? 'Kelas' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
            font-size: 14px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #059669;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: #059669;
            margin: 0;
        }
        .sub-header {
            font-size: 16px;
            color: #666;
            margin: 5px 0 0 0;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 5px 0;
        }
        .info-label {
            width: 120px;
            font-weight: bold;
        }
        .stats-container {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stat-box {
            display: table-cell;
            width: 25%;
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f9fafb;
        }
        .stat-number {
            font-size: 20px;
            font-weight: bold;
            color: #059669;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .data-table th, .data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .data-table th {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        .text-center {
            text-align: center !important;
        }
        .signatures {
            width: 100%;
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .signatures td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
        }
        .sign-area {
            height: 80px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="logo-text">LENTERA LMS</h1>
        <p class="sub-header">Rekapitulasi Progress Belajar Kelas</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="info-label">Sekolah</td>
            <td>: {{ $kelas->school->nama ?? '-' }}</td>
            <td class="info-label">Total Siswa</td>
            <td>: {{ count($studentsData ?? []) }}</td>
        </tr>
        <tr>
            <td class="info-label">Kelas / Tingkat</td>
            <td>: {{ $kelas->nama_kelas ?? '-' }} / {{ $kelas->tingkat ?? '-' }}</td>
            <td class="info-label">Tahun Ajaran</td>
            <td>: {{ date('Y') }}/{{ date('Y', strtotime('+1 year')) }}</td>
        </tr>
    </table>

    @php
        $totalSiswa = count($studentsData ?? []);
        $totalSelesai = collect($studentsData ?? [])->where('is_completed', true)->count();
        $totalSedang = collect($studentsData ?? [])->where('is_completed', false)->filter(fn($s) => ($s->progress_percentage ?? 0) > 0)->count();
        $totalBelum = collect($studentsData ?? [])->filter(fn($s) => ($s->progress_percentage ?? 0) == 0)->count();
        $persentaseSelesai = $totalSiswa > 0 ? round(($totalSelesai / $totalSiswa) * 100) : 0;
    @endphp

    <div class="stats-container">
        <div class="stat-box">
            <div>Penyelesaian</div>
            <div class="stat-number">{{ $persentaseSelesai }}%</div>
        </div>
        <div class="stat-box" style="border-left: none;">
            <div>Selesai</div>
            <div class="stat-number" style="color: #15803d;">{{ $totalSelesai }}</div>
        </div>
        <div class="stat-box" style="border-left: none;">
            <div>Sedang</div>
            <div class="stat-number" style="color: #b45309;">{{ $totalSedang }}</div>
        </div>
        <div class="stat-box" style="border-left: none;">
            <div>Belum Mulai</div>
            <div class="stat-number" style="color: #b91c1c;">{{ $totalBelum }}</div>
        </div>
    </div>

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
                <td>{{ $data->student->nama ?? 'Siswa' }}</td>
                <td>{{ $data->student->nis ?? '-' }}</td>
                <td class="text-center">{{ $data->progress_percentage ?? 0 }}%</td>
                <td class="text-center">
                    @if($data->is_completed)
                        Selesai
                    @elseif(($data->progress_percentage ?? 0) > 0)
                        Sedang Mengerjakan
                    @else
                        Belum Mulai
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada data siswa.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table class="signatures">
        <tr>
            <td>
                <p>Mengetahui,<br>Kepala Sekolah</p>
                <div class="sign-area"></div>
                <p><strong>______________________</strong></p>
            </td>
            <td>
                <p>Diterbitkan tanggal: {{ date('d F Y') }}<br>Guru Bimbingan dan Konseling</p>
                <div class="sign-area"></div>
                <p><strong>{{ auth()->user()->counselor->nama ?? 'Guru BK' }}</strong></p>
            </td>
        </tr>
    </table>
</body>
</html>
