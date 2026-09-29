<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Situasi Model LENTERA - Topik {{ $module->urutan }}: {{ $module->judul }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,700&display=swap" rel="stylesheet">
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
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f1f5f9;
            color: #0f172a;
            min-height: 100vh;
        }

        /* Screen Sticky Toolbar */
        .toolbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
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
            padding: 9px 18px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
            border: 1px solid transparent;
        }

        .btn-primary {
            background-color: #4338ca;
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(67, 56, 202, 0.3);
        }

        .btn-primary:hover {
            background-color: #3730a3;
        }

        .btn-secondary {
            background-color: #ffffff;
            color: #334155;
            border-color: #cbd5e1;
        }

        .btn-secondary:hover {
            background-color: #f8fafc;
            border-color: #94a3b8;
        }

        .btn-docx {
            background-color: #2563eb;
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
        }

        .btn-docx:hover {
            background-color: #1d4ed8;
        }

        /* Screen A4 Preview Container */
        .a4-container {
            width: 100%;
            max-width: 860px;
            margin: 24px auto 60px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 20px 22px;
            position: relative;
        }

        /* Page Top Header */
        .poster-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e2e8f0;
        }

        .header-logo-area {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 170px;
            flex-shrink: 0;
        }

        .logo-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(217, 119, 6, 0.3);
            flex-shrink: 0;
        }

        .logo-text-title {
            font-size: 16px;
            font-weight: 900;
            color: #1e1b4b;
            letter-spacing: 0.5px;
            line-height: 1;
        }

        .logo-text-sub {
            font-size: 7.5px;
            font-weight: 700;
            color: #64748b;
            line-height: 1.2;
            margin-top: 2px;
        }

        .header-center-area {
            text-align: center;
            flex-grow: 1;
        }

        .poster-main-title {
            font-size: 20px;
            font-weight: 900;
            color: #1e1b4b;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .poster-topic-pill {
            display: inline-block;
            background: #4338ca;
            color: #ffffff;
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            padding: 4px 18px;
            border-radius: 9999px;
            margin-bottom: 6px;
        }

        .poster-instruction {
            font-size: 9.5px;
            font-weight: 700;
            color: #334155;
            font-style: italic;
        }

        .header-heart-area {
            width: 170px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 2px;
        }

        .heart-svg {
            width: 32px;
            height: 32px;
            fill: #ec4899;
        }

        .heart-quote {
            font-size: 8px;
            font-weight: 700;
            color: #be185d;
            line-height: 1.25;
            max-width: 130px;
        }

        /* Cards Grid: 3 columns x 2 rows (6 cards) */
        .poster-cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 14px;
        }

        /* Individual Card */
        .poster-card {
            border: 1.5px solid #cbd5e1;
            border-radius: 18px;
            background: #ffffff;
            padding: 12px 14px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 290px;
            position: relative;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        /* Card Top Header */
        .card-top-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .card-num-circle {
            width: 26px;
            height: 26px;
            border-radius: 9999px;
            background-color: #4338ca;
            color: #ffffff;
            font-size: 13px;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .card-title-heading {
            font-size: 10px;
            font-weight: 900;
            color: #1e1b4b;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            line-height: 1.2;
            flex-grow: 1;
        }

        /* Illustration Box */
        .card-img-box {
            width: 100%;
            height: 100px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
        }

        .card-img-content {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-img-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 8px;
            text-align: center;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
            width: 100%;
            height: 100%;
        }

        .card-img-placeholder span {
            font-size: 28px;
            color: #059669;
        }

        .card-img-placeholder p {
            font-size: 8px;
            font-weight: 800;
            color: #047857;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        /* Situasi Section */
        .card-situasi-badge {
            display: inline-block;
            background-color: #4338ca;
            color: #ffffff;
            font-size: 8px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 2px 8px;
            border-radius: 4px;
            margin-bottom: 4px;
        }

        .card-situasi-content {
            font-size: 9px;
            font-weight: 600;
            color: #334155;
            line-height: 1.45;
            margin-bottom: 8px;
            min-height: 48px;
        }

        /* Two columns: Peran & Diskusikan */
        .card-two-cols {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
            margin-top: auto;
        }

        .col-title {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 8.5px;
            font-weight: 800;
            color: #4338ca;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 4px;
        }

        .col-title span.material-symbols-outlined {
            font-size: 11px;
        }

        .col-ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .col-ul li {
            font-size: 8px;
            font-weight: 600;
            color: #475569;
            line-height: 1.35;
            display: flex;
            align-items: flex-start;
            gap: 4px;
        }

        .col-ul li .bullet-dot {
            color: #4338ca;
            font-size: 7px;
            margin-top: 2px;
            flex-shrink: 0;
            user-select: none;
        }

        /* Bottom Section: 3 Panels */
        .poster-bottom-panels {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            margin-bottom: 12px;
        }

        .panel-box {
            border-radius: 14px;
            padding: 10px 12px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .panel-purple {
            background-color: #f5f3ff;
            border: 1px solid #ddd6fe;
        }

        .panel-indigo {
            background-color: #eef2ff;
            border: 1px solid #c7d2fe;
        }

        .panel-pink {
            background-color: #fdf2f8;
            border: 1px solid #fbcfe8;
        }

        .panel-heading {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 8px;
        }

        .panel-purple .panel-heading { color: #5b21b6; }
        .panel-indigo .panel-heading { color: #3730a3; }
        .panel-pink .panel-heading { color: #9d174d; }

        .panel-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .panel-list li {
            display: flex;
            align-items: flex-start;
            gap: 6px;
            font-size: 8px;
            font-weight: 600;
            color: #334155;
            line-height: 1.35;
        }

        .num-badge-sm {
            width: 14px;
            height: 14px;
            border-radius: 9999px;
            background-color: #5b21b6;
            color: #ffffff;
            font-size: 7.5px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .check-icon-sm {
            color: #db2777;
            font-size: 11px;
            font-weight: 900;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* Bottom Ribbons */
        .poster-ribbon-pink {
            background: linear-gradient(90deg, #fce7f3 0%, #fbcfe8 50%, #fce7f3 100%);
            border: 1px solid #f472b6;
            border-radius: 8px;
            padding: 6px 12px;
            text-align: center;
            font-size: 11px;
            font-weight: 900;
            color: #9d174d;
            letter-spacing: 0.3px;
            margin-bottom: 4px;
        }

        .poster-ribbon-purple {
            background-color: #312e81;
            border-radius: 6px;
            padding: 4px 12px;
            text-align: center;
            font-size: 8.5px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.5px;
        }

        /* Print Specific Styles */
        @media print {
            @page {
                size: A4 portrait;
                margin: 6mm 8mm;
            }

            body {
                background: #ffffff !important;
                color: #000000 !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .toolbar {
                display: none !important;
            }

            .a4-container {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
                box-shadow: none !important;
            }

            .poster-card {
                box-shadow: none !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            .panel-box {
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body>

    <!-- Sticky Screen Toolbar -->
    <div class="toolbar">
        <div class="toolbar-left">
            <a href="{{ $backUrl ?? url()->previous() }}" class="btn btn-secondary">
                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
                Kembali
            </a>
            <div>
                <span style="font-size: 14px; font-weight: 900; color: #1e1b4b;">Kartu Situasi Model LENTERA</span>
                <span style="font-size: 12px; font-weight: 700; color: #4338ca; margin-left: 8px;">Topik {{ $module->urutan }}: {{ $module->judul }}</span>
            </div>
        </div>
        <div class="toolbar-right">
            @if(isset($docxUrl))
                <a href="{{ $docxUrl }}" class="btn btn-docx">
                    <span class="material-symbols-outlined" style="font-size: 18px;">description</span>
                    Unduh Word (.docx)
                </a>
            @endif
            <button type="button" onclick="window.print()" class="btn btn-primary">
                <span class="material-symbols-outlined" style="font-size: 18px;">print</span>
                Cetak / Simpan PDF (A4)
            </button>
        </div>
    </div>

    <!-- A4 Sheet Container (Matches the uploaded poster mockup) -->
    <div class="a4-container">
        
        <!-- 1. Header Section -->
        <div class="poster-header">
            <!-- Left Logo -->
            <div class="header-logo-area">
                <div class="logo-icon-box">
                    <span class="material-symbols-outlined" style="font-size: 26px;">lightbulb</span>
                </div>
                <div>
                    <div class="logo-text-title">LENTERA</div>
                    <div class="logo-text-sub">Learning Empathy through Structured Learning Approach</div>
                </div>
            </div>

            <!-- Center Title -->
            <div class="header-center-area">
                <h1 class="poster-main-title">KARTU SITUASI MODEL LENTERA</h1>
                <div class="poster-topic-pill">
                    TOPIK {{ $module->urutan }} – {{ mb_strtoupper($module->subtitle ?: ($module->judul . ($module->fokus_utama ? ': ' . $module->fokus_utama : '')), 'UTF-8') }}
                </div>
                <p class="poster-instruction">
                    Bacalah setiap situasi dengan saksama, rasakan perasaan korban, lalu diskusikan bersama kelompokmu!
                </p>
            </div>

            <!-- Right Heart Quote -->
            <div class="header-heart-area">
                <svg class="heart-svg" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                <div class="heart-quote">
                    Empati dimulai dari memahami perasaan orang lain.
                </div>
            </div>
        </div>

        <!-- 2. Middle Section: Cards Grid (3 Columns x 2 Rows) -->
        <div class="poster-cards-grid">
            @php
                // Display up to 6 cards per sheet
                $displayCards = $cards->take(6);
            @endphp

            @forelse($displayCards as $index => $card)
                <div class="poster-card">
                    <div>
                        <!-- Card Header -->
                        <div class="card-top-row">
                            <div class="card-num-circle">
                                {{ $index + 1 }}
                            </div>
                            <h3 class="card-title-heading">
                                {{ $card->judul }}
                            </h3>
                        </div>

                        <!-- Card Illustration -->
                        <div class="card-img-box">
                            @if($card->file_path)
                                <img src="{{ asset('storage/' . $card->file_path) }}" class="card-img-content" alt="{{ $card->judul }}">
                            @else
                                <div class="card-img-placeholder">
                                    <span class="material-symbols-outlined">diversity_3</span>
                                    <p>Ilustrasi Kejadian Skenario</p>
                                </div>
                            @endif
                        </div>

                        <!-- Situasi Badge & Text -->
                        <span class="card-situasi-badge">Situasi</span>
                        <p class="card-situasi-content">
                            {{ $card->situasi ?: '-' }}
                        </p>
                    </div>

                    <!-- Two Columns: Peran & Diskusikan -->
                    <div class="card-two-cols">
                        <!-- Left: Peran -->
                        <div>
                            <div class="col-title">
                                <span class="material-symbols-outlined">person</span>
                                <span>Peran</span>
                            </div>
                            @php
                                $peranItems = array_filter(array_map('trim', explode("\n", $card->peran ?? '')));
                            @endphp
                            <ul class="col-ul">
                                @forelse($peranItems as $p)
                                    <li>
                                        <span class="bullet-dot">●</span>
                                        <span>{{ $p }}</span>
                                    </li>
                                @empty
                                    <li style="color: #94a3b8;">-</li>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Right: Diskusikan -->
                        <div>
                            <div class="col-title">
                                <span class="material-symbols-outlined">chat</span>
                                <span>Diskusikan</span>
                            </div>
                            @php
                                $diskusiItems = array_filter(array_map('trim', explode("\n", $card->diskusi ?? '')));
                            @endphp
                            <ul class="col-ul">
                                @forelse($diskusiItems as $d)
                                    <li>
                                        <span class="bullet-dot">●</span>
                                        <span>{{ $d }}</span>
                                    </li>
                                @empty
                                    <li style="color: #94a3b8;">-</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 16px; padding: 48px 24px; text-align: center; color: #64748b;">
                    <span class="material-symbols-outlined" style="font-size: 40px; color: #94a3b8; margin-bottom: 8px;">style</span>
                    <p style="font-weight: 800; font-size: 13px;">Belum ada kartu situasi untuk topik ini.</p>
                </div>
            @endforelse
        </div>

        <!-- 3. Bottom Section: 3 Educational Panels -->
        <div class="poster-bottom-panels">
            <!-- Panel 1: Petunjuk Konselor -->
            <div class="panel-box panel-purple">
                <div class="panel-heading">
                    <span class="material-symbols-outlined" style="font-size: 15px;">assignment</span>
                    <span>PETUNJUK UNTUK KONSELOR<br><span style="font-size: 7.5px; opacity: 0.85;">(Performance Feedback)</span></span>
                </div>
                <ul class="panel-list">
                    <li>
                        <span class="num-badge-sm">1</span>
                        <span>Fasilitasi role playing sesuai setiap situasi.</span>
                    </li>
                    <li>
                        <span class="num-badge-sm">2</span>
                        <span>Ajak siswa mengungkapkan perasaan korban yang mereka perankan.</span>
                    </li>
                    <li>
                        <span class="num-badge-sm">3</span>
                        <span>Berikan umpan balik positif dan penguatan empatik.</span>
                    </li>
                    <li>
                        <span class="num-badge-sm">4</span>
                        <span>Tegaskan bahwa memahami emosi korban adalah langkah awal untuk mencegah bullying.</span>
                    </li>
                </ul>
            </div>

            <!-- Panel 2: Pertanyaan Refleksi Kelompok -->
            <div class="panel-box panel-indigo">
                <div class="panel-heading">
                    <span class="material-symbols-outlined" style="font-size: 15px;">help</span>
                    <span>PERTANYAAN REFLEKSI KELOMPOK</span>
                </div>
                <ul class="panel-list">
                    <li>
                        <span class="num-badge-sm">1</span>
                        <span>Apa yang dirasakan korban pada setiap situasi?</span>
                    </li>
                    <li>
                        <span class="num-badge-sm">2</span>
                        <span>Tanda-tanda apa yang menunjukkan bahwa korban merasa tidak nyaman atau terluka?</span>
                    </li>
                    <li>
                        <span class="num-badge-sm">3</span>
                        <span>Mengapa penting untuk memperhatikan perasaan orang lain?</span>
                    </li>
                    <li>
                        <span class="num-badge-sm">4</span>
                        <span>Bagaimana perasaanmu jika berada di posisi korban tersebut?</span>
                    </li>
                    <li>
                        <span class="num-badge-sm">5</span>
                        <span>Apa yang bisa kita lakukan agar teman kita merasa aman dan dihargai?</span>
                    </li>
                </ul>
            </div>

            <!-- Panel 3: Indikator Keberhasilan -->
            <div class="panel-box panel-pink">
                <div class="panel-heading">
                    <span class="material-symbols-outlined" style="font-size: 15px;">verified</span>
                    <span>INDIKATOR KEBERHASILAN TOPIK {{ $module->urutan }}</span>
                </div>
                <ul class="panel-list">
                    <li>
                        <span class="check-icon-sm">☑</span>
                        <span>Siswa mampu mengenali perasaan korban bullying.</span>
                    </li>
                    <li>
                        <span class="check-icon-sm">☑</span>
                        <span>Siswa menunjukkan empati terhadap korban.</span>
                    </li>
                    <li>
                        <span class="check-icon-sm">☑</span>
                        <span>Siswa mampu mengidentifikasi tindakan yang menyebabkan sakit hati.</span>
                    </li>
                    <li>
                        <span class="check-icon-sm">☑</span>
                        <span>Siswa memahami bahwa bullying berdampak pada emosi dan mental korban.</span>
                    </li>
                    <li>
                        <span class="check-icon-sm">☑</span>
                        <span>Siswa berkomitmen untuk tidak melakukan bullying dan menghargai teman.</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 4. Bottom Ribbons Slogan -->
        <div class="poster-ribbon-pink">
            💖 Pahami Perasaannya, Tanamkan Empatinya, Hentikan Perundungan! 💖
        </div>
        <div class="poster-ribbon-purple">
            ★ Model LENTERA – Latihan Empati Terstruktur untuk Atasi Perundungan ★
        </div>

    </div>

</body>
</html>
