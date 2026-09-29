<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat - {{ $student_name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">
    
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
            color: #1e293b;
            min-height: 100vh;
        }

        /* Screen Toolbar */
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
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
            border: 1px solid transparent;
        }

        .btn-outline {
            background: #fff;
            color: #475569;
            border-color: #cbd5e1;
        }
        .btn-outline:hover {
            background: #f8fafc;
            color: #0f172a;
        }

        .btn-primary {
            background: #059669;
            color: #fff;
            box-shadow: 0 2px 4px rgba(5, 150, 105, 0.25);
        }
        .btn-primary:hover {
            background: #047857;
        }

        .info-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
        }

        /* Certificate Container */
        .cert-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 20px;
            gap: 40px;
        }

        /* Certificate Sheet: Exact A4 Landscape (297mm x 210mm) */
        .cert-sheet {
            width: 297mm;
            height: 210mm;
            background: #ffffff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        /* Inner Decorative Border Frame */
        .cert-inner-frame {
            position: absolute;
            inset: 14mm 16mm;
            border: 1.5px solid #059669;
            pointer-events: none;
            z-index: 10;
        }
        .cert-inner-frame::after {
            content: "";
            position: absolute;
            inset: 3px;
            border: 0.75px solid #a7f3d0;
        }

        /* Corner SVG Accents */
        .corner-accent-tr {
            position: absolute;
            top: 0;
            right: 0;
            width: 220px;
            height: 180px;
            z-index: 5;
            pointer-events: none;
        }
        .corner-accent-bl {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 220px;
            height: 180px;
            z-index: 5;
            pointer-events: none;
        }

        /* Content Areas */
        .cert-content-front {
            position: relative;
            z-index: 20;
            padding: 16mm 22mm;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
        }

        .logo-wrap img {
            height: 52px;
            object-fit: contain;
            margin: 0 auto;
            display: block;
        }

        .cert-title {
            font-family: 'Cinzel', serif;
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 5px;
            color: #064e3b;
            margin-top: 4px;
            line-height: 1.1;
        }

        .cert-subtitle {
            font-size: 13.5px;
            font-weight: 700;
            letter-spacing: 2px;
            color: #059669;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .cert-caption {
            font-size: 12px;
            font-style: italic;
            color: #64748b;
            margin-top: 2px;
        }

        .cert-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 10px auto 12px;
            width: 70%;
        }
        .cert-divider .line {
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, #10b981, transparent);
        }
        .cert-divider .diamond {
            width: 6px;
            height: 6px;
            background: #059669;
            transform: rotate(45deg);
        }

        .recipient-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #64748b;
            font-weight: 500;
        }

        .recipient-name {
            font-family: 'Cinzel', serif;
            font-size: 27px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: 1px;
            margin: 4px 0 6px;
            display: inline-block;
            position: relative;
        }
        .recipient-name::after {
            content: "";
            display: block;
            width: 80%;
            height: 2px;
            background: #059669;
            margin: 4px auto 0;
            border-radius: 2px;
        }

        .cert-body-narrative {
            font-size: 12px;
            line-height: 1.55;
            color: #334155;
            max-width: 82%;
            margin: 0 auto 12px;
        }

        /* 5 Topics Row */
        .topics-row {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 16px;
            flex-wrap: nowrap;
        }
        .topic-badge {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 6px;
            padding: 5px 9px;
            font-size: 10.5px;
            font-weight: 600;
            color: #166534;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }
        .topic-badge .num {
            color: #059669;
            font-weight: 700;
        }

        /* Signatures Front */
        .signatures-front {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding: 0 10px 4px;
        }
        .sig-left {
            text-align: left;
            font-size: 11px;
            color: #64748b;
            line-height: 1.5;
        }
        .sig-left strong {
            color: #0f172a;
            font-size: 11.5px;
        }
        .cert-number-badge {
            display: inline-block;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            padding: 2px 8px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 11px;
            color: #475569;
            margin-top: 4px;
        }

        .sig-right {
            text-align: center;
            min-width: 240px;
        }
        .sig-right .date {
            font-size: 11.5px;
            color: #334155;
            margin-bottom: 2px;
        }
        .sig-right .role {
            font-size: 11.5px;
            font-weight: 600;
            color: #065f46;
        }
        .sig-right .sig-space {
            height: 48px;
        }
        .sig-right .name {
            font-size: 12.5px;
            font-weight: 700;
            color: #0f172a;
            text-decoration: underline;
            text-underline-offset: 3px;
        }
        .sig-right .nip {
            font-size: 10.5px;
            color: #64748b;
            margin-top: 2px;
        }

        /* PAGE 2 - REKAP & KOMITMEN */
        .cert-content-back {
            position: relative;
            z-index: 20;
            padding: 16mm 22mm;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .back-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #059669;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .back-header-title {
            font-size: 17px;
            font-weight: 800;
            color: #064e3b;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .back-header-logo img {
            height: 32px;
        }

        /* Student Identity Table / Grid */
        .student-identity-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 12px;
            font-size: 11.5px;
        }
        .id-item .label {
            color: #64748b;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .id-item .val {
            font-weight: 700;
            color: #0f172a;
        }

        /* Two columns body on Page 2: Left = Table & Disclaimer, Right = Commitment & Personal Prompt */
        .back-body-cols {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            flex: 1;
        }

        /* Scores Table */
        .score-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        .score-table th {
            background: #ecfdf5;
            color: #065f46;
            font-weight: 700;
            padding: 6px 8px;
            border: 1px solid #bbf7d0;
            text-align: left;
            font-size: 10.5px;
        }
        .score-table th.center, .score-table td.center {
            text-align: center;
        }
        .score-table td {
            padding: 5px 8px;
            border: 1px solid #e2e8f0;
            color: #334155;
        }
        .score-table tr:nth-child(even) {
            background: #fafafa;
        }
        .score-table .summary-row td {
            background: #ecfdf5;
            font-weight: 700;
            color: #065f46;
            border-color: #bbf7d0;
            font-size: 11px;
        }
        .predicate-badge {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 10px;
        }
        .pred-sangat-baik {
            background: #dcfce7;
            color: #15803d;
        }
        .pred-baik {
            background: #e0f2fe;
            color: #0369a1;
        }
        .pred-cukup {
            background: #fef3c7;
            color: #b45309;
        }
        .pred-kurang {
            background: #fee2e2;
            color: #b91c1c;
        }
        .pred-belum {
            background: #f1f5f9;
            color: #64748b;
        }

        .disclaimer-box {
            margin-top: 8px;
            padding: 6px 8px;
            background: #fffbeb;
            border-left: 3px solid #f59e0b;
            font-size: 9.5px;
            line-height: 1.4;
            color: #78350f;
            border-radius: 0 4px 4px 0;
        }

        /* Right Column: Commitment */
        .commitment-card {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 6px;
            padding: 10px 12px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .commitment-title {
            font-size: 12.5px;
            font-weight: 800;
            color: #064e3b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .commitment-intro {
            font-size: 10.5px;
            color: #166534;
            margin-bottom: 6px;
        }
        .commitment-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-bottom: 8px;
        }
        .commitment-list li {
            font-size: 10px;
            color: #1f2937;
            display: flex;
            align-items: flex-start;
            gap: 6px;
            line-height: 1.35;
        }
        .commitment-list li .chk {
            color: #059669;
            font-weight: bold;
            flex-shrink: 0;
        }

        .personal-box {
            background: #ffffff;
            border: 1px dashed #059669;
            border-radius: 6px;
            padding: 8px 10px;
        }
        .personal-box .p-label {
            font-size: 10px;
            font-weight: 700;
            color: #065f46;
            margin-bottom: 2px;
        }
        .personal-box .p-prompt {
            font-size: 10.5px;
            font-style: italic;
            color: #64748b;
            margin-bottom: 6px;
        }
        .personal-box .p-answer {
            font-size: 11px;
            font-weight: 700;
            font-style: italic;
            color: #0f172a;
            padding: 5px 8px;
            background: #f0fdf4;
            border-radius: 4px;
            border-left: 3px solid #059669;
            line-height: 1.4;
            margin-top: 3px;
            white-space: pre-line;
            word-break: break-word;
        }
        .personal-box .writing-lines {
            height: 24px;
            border-bottom: 1px dashed #cbd5e1;
        }

        /* Signatures Back */
        .signatures-back {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 12px;
            padding: 0 10px 0;
        }
        .sig-box {
            text-align: center;
            min-width: 200px;
        }
        .sig-box .role {
            font-size: 11px;
            font-weight: 600;
            color: #065f46;
        }
        .sig-box .sig-space {
            height: 42px;
        }
        .sig-box .name {
            font-size: 12px;
            font-weight: 700;
            color: #0f172a;
            text-decoration: underline;
            text-underline-offset: 3px;
        }
        .sig-box .nip {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }

        /* PRINT STYLES */
        @media print {
            body {
                background: none !important;
                color: #000 !important;
            }
            .no-print {
                display: none !important;
            }
            .cert-container {
                padding: 0 !important;
                gap: 0 !important;
            }
            .cert-sheet {
                box-shadow: none !important;
                margin: 0 !important;
                page-break-after: always;
                page-break-inside: avoid;
                width: 297mm !important;
                height: 210mm !important;
            }
            @page {
                size: A4 landscape;
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Floating Screen Toolbar (Hidden on print) -->
    <div class="toolbar no-print">
        <div class="toolbar-left">
            <a href="{{ $back_url ?? url()->previous() }}" class="btn btn-outline">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
            @if(!empty($is_sample) || !empty($is_admin_preview))
                <span class="info-pill" style="background:#fef3c7; color:#92400e; border-color:#fde68a;">
                    🔍 Mode Pratinjau Template (Data Contoh)
                </span>
            @else
                <span class="info-pill">
                    ✓ Sertifikat Resmi Model LENTERA
                </span>
            @endif
        </div>
        <div class="toolbar-right">
            <span style="font-size: 12px; color: #64748b;">
                Orientasi: <strong>Landscape (A4)</strong> &bull; Centang: <em>Background Graphics</em>
            </span>
            @if(!empty($student))
                @if(auth()->check() && auth()->user()->isSiswa())
                    <a href="{{ route('student.certificate.docx') }}" class="btn btn-outline" style="border-color:#059669; color:#059669;">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/></svg>
                        Unduh Word (.docx)
                    </a>
                @elseif(auth()->check() && auth()->user()->isKonselor())
                    <a href="{{ route('counselor.monitoring.student.certificate.docx', $student->id) }}" class="btn btn-outline" style="border-color:#059669; color:#059669;">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/></svg>
                        Unduh Word (.docx)
                    </a>
                @endif
            @elseif(!empty($is_sample) || !empty($is_admin_preview))
                <a href="{{ route('admin.certificate-template.preview-docx') }}" class="btn btn-outline" style="border-color:#059669; color:#059669;">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/></svg>
                    Unduh Contoh Word (.docx)
                </a>
            @endif
            <button onclick="window.print()" class="btn btn-primary">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <div class="cert-container">

        <!-- ==================== HALAMAN 1 (DEPAN) ==================== -->
        <div class="cert-sheet">
            <!-- Corner Geometric Accents (SVG matching original sample) -->
            <svg class="corner-accent-tr" viewBox="0 0 220 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Polygons shades of emerald and teal -->
                <polygon points="220,0 120,0 220,100" fill="#064e3b" opacity="0.95" />
                <polygon points="220,40 150,0 220,140" fill="#047857" opacity="0.85" />
                <polygon points="220,80 180,0 220,170" fill="#10b981" opacity="0.75" />
                <polygon points="220,120 200,30 220,180" fill="#6ee7b7" opacity="0.65" />
                <!-- Thin accent line stripes -->
                <line x1="80" y1="0" x2="220" y2="140" stroke="#10b981" stroke-width="2" opacity="0.8" />
                <line x1="100" y1="0" x2="220" y2="120" stroke="#34d399" stroke-width="1" opacity="0.5" />
                <line x1="60" y1="0" x2="220" y2="160" stroke="#047857" stroke-width="1.5" opacity="0.6" />
            </svg>

            <svg class="corner-accent-bl" viewBox="0 0 220 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Symmetrical bottom-left geometric polygons -->
                <polygon points="0,180 100,180 0,80" fill="#064e3b" opacity="0.95" />
                <polygon points="0,140 70,180 0,40" fill="#047857" opacity="0.85" />
                <polygon points="0,100 40,180 0,10" fill="#10b981" opacity="0.75" />
                <polygon points="0,60 20,150 0,0" fill="#6ee7b7" opacity="0.65" />
                <!-- Thin accent line stripes -->
                <line x1="140" y1="180" x2="0" y2="40" stroke="#10b981" stroke-width="2" opacity="0.8" />
                <line x1="120" y1="180" x2="0" y2="60" stroke="#34d399" stroke-width="1" opacity="0.5" />
                <line x1="160" y1="180" x2="0" y2="20" stroke="#047857" stroke-width="1.5" opacity="0.6" />
            </svg>

            <div class="cert-inner-frame"></div>

            <div class="cert-content-front">
                <!-- Header -->
                <div>
                    <div class="logo-wrap">
                        <img src="{{ asset($template->logo_path ?? 'images/certificate/lentera_logo.png') }}" alt="Logo Lentera">
                    </div>
                    <h1 class="cert-title">{{ $template->title }}</h1>
                    <div class="cert-subtitle">{{ $template->sub_title }}</div>
                    @if($template->caption)
                        <div class="cert-caption">{{ $template->caption }}</div>
                    @endif

                    <div class="cert-divider">
                        <div class="line"></div>
                        <div class="diamond"></div>
                        <div class="line"></div>
                    </div>
                </div>

                <!-- Recipient Info -->
                <div>
                    <div class="recipient-label">Diberikan kepada:</div>
                    <div class="recipient-name">{{ $student_name }}</div>
                    
                    <p class="cert-body-narrative">
                        {{ $template->body_text }}
                    </p>

                    <!-- 5 Service Topics Badges -->
                    <div class="topics-row">
                        @foreach($template->topics_list as $topic)
                            <div class="topic-badge">
                                <span class="num">✓</span>
                                <span>{{ $topic }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Signatures & Meta -->
                <div class="signatures-front">
                    <div class="sig-left">
                        <div><strong>{{ $school_name }}</strong></div>
                        <div>Kelas: {{ $class_name }}</div>
                        <div class="cert-number-badge">{{ $cert_number }}</div>
                    </div>

                    <div class="sig-right">
                        <div class="date">{{ $issue_date }}</div>
                        <div class="role">{{ $signer_title }}</div>
                        <div class="sig-space"></div>
                        <div class="name">{{ $signer_name }}</div>
                        @if($signer_nip)
                            <div class="nip">{{ $signer_nip }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <!-- ==================== HALAMAN 2 (BELAKANG / REKAP & KOMITMEN) ==================== -->
        <div class="cert-sheet">
            <!-- Corner Geometric Accents (Back page) -->
            <svg class="corner-accent-tr" viewBox="0 0 220 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polygon points="220,0 140,0 220,80" fill="#064e3b" opacity="0.8" />
                <polygon points="220,30 170,0 220,110" fill="#047857" opacity="0.6" />
                <line x1="100" y1="0" x2="220" y2="120" stroke="#10b981" stroke-width="1.5" opacity="0.6" />
            </svg>

            <svg class="corner-accent-bl" viewBox="0 0 220 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polygon points="0,180 80,180 0,100" fill="#064e3b" opacity="0.8" />
                <polygon points="0,150 50,180 0,70" fill="#047857" opacity="0.6" />
                <line x1="120" y1="180" x2="0" y2="60" stroke="#10b981" stroke-width="1.5" opacity="0.6" />
            </svg>

            <div class="cert-inner-frame"></div>

            <div class="cert-content-back">
                <div>
                    <!-- Top Bar -->
                    <div class="back-header">
                        <div class="back-header-title">{{ $template->recap_title }}</div>
                        <div class="back-header-logo">
                            <img src="{{ asset($template->logo_path ?? 'images/certificate/lentera_logo.png') }}" alt="Logo Lentera">
                        </div>
                    </div>

                    <!-- Student Identity -->
                    <div class="student-identity-grid">
                        <div class="id-item">
                            <div class="label">Nama Peserta Didik</div>
                            <div class="val">{{ $student_name }}</div>
                        </div>
                        <div class="id-item">
                            <div class="label">Kelas / NIS</div>
                            <div class="val">{{ $class_name }} {{ $student_nis !== '-' ? "({$student_nis})" : '' }}</div>
                        </div>
                        <div class="id-item">
                            <div class="label">Sekolah</div>
                            <div class="val">{{ $school_name }}</div>
                        </div>
                        <div class="id-item">
                            <div class="label">Tanggal Penyelesaian</div>
                            <div class="val">{{ $issue_date }}</div>
                        </div>
                    </div>

                    <!-- Main Columns: Scores on Left, Commitment on Right -->
                    <div class="back-body-cols">
                        <!-- Left: Table & Disclaimer -->
                        <div>
                            <table class="score-table">
                                <thead>
                                    <tr>
                                        <th class="center" style="width: 32px;">NO</th>
                                        <th>TOPIK LAYANAN</th>
                                        <th class="center" style="width: 130px;">CAPAIAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topic_scores as $ts)
                                        <tr>
                                            <td class="center font-semibold">{{ sprintf('%02d', $ts['urutan']) }}</td>
                                            <td>Topik {{ $ts['urutan'] }}: {{ $ts['title'] }}</td>
                                            <td class="center">
                                                @php
                                                    $catLower = strtolower($ts['category']);
                                                    $tsBadge = str_contains($catLower, 'sangat') ? 'pred-sangat-baik' : 
                                                              (str_contains($catLower, 'baik') ? 'pred-baik' : 
                                                              (str_contains($catLower, 'cukup') ? 'pred-cukup' : 
                                                              (str_contains($catLower, 'kurang') ? 'pred-kurang' : 'pred-belum')));
                                                @endphp
                                                <span class="predicate-badge {{ $tsBadge }}">
                                                    {{ $ts['percentage_formatted'] }} &mdash; {{ $ts['category'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="summary-row">
                                        <td colspan="2" style="text-align: right; padding-right: 12px;">Capaian Keseluruhan:</td>
                                        <td class="center">
                                            @php
                                                $ovLower = strtolower($overall_category ?? '');
                                                $ovBadge = str_contains($ovLower, 'sangat') ? 'pred-sangat-baik' : 
                                                          (str_contains($ovLower, 'baik') ? 'pred-baik' : 
                                                          (str_contains($ovLower, 'cukup') ? 'pred-cukup' : 
                                                          (str_contains($ovLower, 'kurang') ? 'pred-kurang' : 'pred-belum')));
                                            @endphp
                                            <span class="predicate-badge {{ $ovBadge }}" style="font-size: 11px; padding: 2px 8px;">
                                                {{ $overall_label }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            @if($template->disclaimer)
                                <div class="disclaimer-box">
                                    <strong>Catatan:</strong> {{ $template->disclaimer }}
                                </div>
                            @endif
                        </div>

                        <!-- Right: Commitment Checklist & Personal Prompt -->
                        <div class="commitment-card">
                            <div>
                                <div class="commitment-title">{{ $template->commitment_title }}</div>
                                <div class="commitment-intro">{{ $template->commitment_intro }}</div>
                                
                                <ul class="commitment-list">
                                    @php
                                        $displayPoints = !empty($student_commitment_points) ? $student_commitment_points : ($template->commitment_points ?? []);
                                    @endphp
                                    @foreach($displayPoints as $pt)
                                        <li>
                                            <span class="chk">✓</span>
                                            <span>{{ $pt }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="personal-box">
                                <div class="p-label">{{ $template->commitment_personal_prompt ?? 'Komitmen pribadi saya:' }}</div>
                                @if(!empty($student_commitment_text))
                                    <div class="p-answer">
                                        “{!! nl2br(e($student_commitment_text)) !!}”
                                    </div>
                                @else
                                    <div class="p-prompt">{{ $template->commitment_personal_subprompt ?? '“Mulai sekarang, saya akan...”' }}</div>
                                    <div class="writing-lines"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Signatures Back (Student & Counselor) -->
                <div class="signatures-back">
                    <div class="sig-box">
                        <div class="role">Peserta Didik</div>
                        <div class="sig-space"></div>
                        <div class="name">{{ $student_name }}</div>
                        <div class="nip">Peserta LENTERA</div>
                    </div>

                    <div class="sig-box">
                        <div class="role">{{ $signer_title }}</div>
                        <div class="sig-space"></div>
                        <div class="name">{{ $signer_name }}</div>
                        @if($signer_nip)
                            <div class="nip">{{ $signer_nip }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>