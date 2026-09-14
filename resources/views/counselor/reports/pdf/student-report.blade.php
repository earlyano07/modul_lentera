<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Belajar - {{ $student->nama ?? 'Siswa' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
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
        .section-title {
            font-size: 16px;
            font-weight: bold;
            background-color: #f3f4f6;
            padding: 8px 12px;
            margin-bottom: 15px;
            border-left: 4px solid #059669;
        }
        .info-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-table td {
            padding: 5px 0;
        }
        .info-label {
            width: 150px;
            color: #555;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .data-table th, .data-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .data-table th {
            background-color: #f9fafb;
            font-weight: bold;
        }
        .text-center {
            text-align: center !important;
        }
        .signatures {
            width: 100%;
            margin-top: 50px;
        }
        .signatures td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
        }
        .sign-area {
            height: 100px;
        }
        .progress-box {
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
            text-align: center;
        }
        .progress-text {
            font-size: 18px;
            font-weight: bold;
            color: #065f46;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="logo-text">LENTERA LMS</h1>
        <p class="sub-header">Laporan Hasil Belajar Program Bimbingan Karir</p>
    </div>

    <div class="section-title">Identitas Siswa</div>
    <table class="info-table">
        <tr>
            <td class="info-label">Nama Lengkap</td>
            <td>: <strong>{{ $student->nama ?? '-' }}</strong></td>
            <td class="info-label">NIS</td>
            <td>: {{ $student->nis ?? '-' }}</td>
        </tr>
        <tr>
            <td class="info-label">Sekolah</td>
            <td>: {{ $student->kelas->school->nama ?? '-' }}</td>
            <td class="info-label">Kelas</td>
            <td>: {{ $student->kelas->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td class="info-label">Jenis Kelamin</td>
            <td colspan="3">: {{ $student->jenis_kelamin ?? '-' }}</td>
        </tr>
    </table>

    <div class="progress-box">
        <p style="margin:0; color:#047857;">Total Penyelesaian Program:</p>
        <div class="progress-text">{{ $progressPercentage ?? 0 }}%</div>
    </div>

    <div class="section-title">Hasil Asesmen</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="40%">Nama Asesmen</th>
                <th width="30%">Modul Terkait</th>
                <th width="10%" class="text-center">Nilai</th>
                <th width="15%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assessmentResults ?? [] as $index => $result)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $result->assessment->judul ?? 'Asesmen' }}</td>
                <td>{{ $result->assessment->module->judul ?? '-' }}</td>
                <td class="text-center"><strong>{{ $result->score ?? 0 }}</strong></td>
                <td>{{ \Carbon\Carbon::parse($result->created_at)->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada asesmen yang diselesaikan.</td>
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
