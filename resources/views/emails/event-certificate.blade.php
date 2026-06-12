<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sertifikat Kegiatan</title>
</head>

<body style="margin:0;background:#111827;color:#f9fafb;font-family:Arial,Helvetica,sans-serif;">
    <div style="max-width:640px;margin:0 auto;padding:32px 20px;">
        <div style="background:#1f2937;border:1px solid #374151;border-radius:18px;padding:28px;">
            <p style="margin:0 0 8px;color:#10b981;font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase;">
                HMIF UKRI
            </p>
            <h1 style="margin:0 0 16px;font-size:24px;line-height:1.25;color:#ffffff;">
                Sertifikat Kegiatan
            </h1>
            <p style="margin:0 0 18px;color:#d1d5db;line-height:1.6;">
                Halo {{ $registration->full_name }},
            </p>
            <div style="margin:0 0 24px;color:#d1d5db;line-height:1.7;">
                {!! nl2br(e($messageBody)) !!}
            </div>

            <div style="background:#111827;border:1px solid #374151;border-radius:14px;padding:18px;margin-bottom:20px;">
                <h2 style="margin:0 0 12px;font-size:16px;color:#ffffff;">Detail Kegiatan</h2>
                <p style="margin:0 0 8px;color:#d1d5db;">
                    <strong>Event:</strong> {{ $event->title }}
                </p>
                <p style="margin:0;color:#d1d5db;">
                    <strong>Tanggal:</strong>
                    {{ \Carbon\Carbon::parse($event->event_date)->locale('id')->translatedFormat('l, d F Y') }}
                </p>
            </div>

            <p style="margin:24px 0 0;color:#9ca3af;font-size:12px;line-height:1.6;text-align:center;">
                Sertifikat terlampir pada email ini.
            </p>
        </div>
    </div>
</body>

</html>
