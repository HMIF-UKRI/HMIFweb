<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Absensi - {{ $event->title }}</title>
    <style>
        @page {
            margin: 1cm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #1a1a1a;
            margin: 0;
            padding: 0;
        }

        .header-container {
            border-bottom: 2px solid #dc2626;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .header-content {
            text-align: center;
        }

        .org-name {
            font-size: 18px;
            font-weight: bold;
            color: #dc2626;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .univ-name {
            font-size: 12px;
            color: #4b5563;
            margin: 2px 0;
            font-weight: 600;
        }

        .doc-title {
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: underline;
        }

        .info-section {
            width: 100%;
            margin-bottom: 20px;
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .label {
            color: #6b7280;
            font-weight: bold;
            width: 120px;
        }

        .value {
            color: #111827;
            font-weight: bold;
        }

        .table-container {
            margin-top: 10px;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            background-color: transparent;
        }

        .main-table th {
            background-color: #111827;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
            padding: 10px;
            text-align: left;
            letter-spacing: 0.5px;
        }

        .main-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        .main-table tr:nth-child(even) {
            background-color: #f3f4f6;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-internal {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-external {
            background-color: #fef3c7;
            color: #92400e;
        }

        .npm-text {
            font-family: 'Courier', monospace;
            font-size: 10px;
            color: #374151;
        }

        .time-text {
            color: #6b7280;
        }

        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 8px;
            color: #9ca3af;
            border-top: 0.5px solid #e5e7eb;
            padding-top: 5px;
        }
    </style>
</head>

<body>

    <div class="header-container">
        <div class="header-content">
            <h1 class="org-name">Himpunan Mahasiswa Informatika Teknik Informatika</h1>
            <p class="univ-name">Universitas Kebangsaan Republik Indonesia</p>
            <div class="doc-title">REKAPITULASI DAFTAR HADIR PESERTA</div>
        </div>
    </div>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="label">Nama Kegiatan</td>
                <td class="value">: {{ $event->title }}</td>
                <td class="label">Total Kehadiran</td>
                <td class="value">: {{ $attendances->count() }} Orang</td>
            </tr>
            <tr>
                <td class="label">Waktu & Tanggal</td>
                <td class="value">: {{ $event->event_date->format('l, d F Y') }}</td>
                <td class="label">Status Event</td>
                <td class="value">: {{ strtoupper($event->status) }}</td>
            </tr>
            <tr>
                <td class="label">Lokasi</td>
                <td colspan="3" class="value">: {{ $event->location }}</td>
            </tr>
        </table>
    </div>

    <div class="table-container">
        <table class="main-table">
            <thead>
                <tr>
                    <th style="width: 30px; text-align: center;">No</th>
                    <th style="width: 70px;">Pukul</th>
                    <th>Nama Lengkap</th>
                    <th style="width: 120px;">NPM / Identitas</th>
                    <th style="width: 80px; text-align: center;">Tipe</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $index => $item)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td class="time-text">{{ $item->check_in_time->format('H:i:s') }} WIB</td>
                        <td>
                            <div style="font-weight: bold; color: #111827;">
                                {{ $item->participant_type == 'internal' ? $item->member->full_name ?? 'N/A' : $item->external_name }}
                            </div>
                        </td>
                        <td class="npm-text">
                            {{ $item->participant_type == 'internal' ? $item->member->npm ?? '-' : $item->external_npm }}
                        </td>
                        <td style="text-align: center;">
                            <span
                                class="badge {{ $item->participant_type == 'internal' ? 'badge-internal' : 'badge-external' }}">
                                {{ $item->participant_type }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        Dokumen ini dihasilkan secara otomatis oleh <strong>HMIF Dashboard &bull; Kabinet Metaforsa 2026</strong><br>
        Dicetak pada: {{ now()->locale('id')->translatedFormat('d F Y, H:i:s') }}
    </div>

</body>

</html>
