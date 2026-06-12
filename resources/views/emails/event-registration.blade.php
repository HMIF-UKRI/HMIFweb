<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pendaftaran</title>
</head>

<body style="margin:0;background:#111827;color:#f9fafb;font-family:Arial,Helvetica,sans-serif;">
    <div style="max-width:640px;margin:0 auto;padding:32px 20px;">
        <div style="background:#1f2937;border:1px solid #374151;border-radius:18px;padding:28px;">
            <p style="margin:0 0 8px;color:#ef4444;font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase;">
                HMIF UKRI
            </p>
            <h1 style="margin:0 0 16px;font-size:24px;line-height:1.25;color:#ffffff;">
                Pendaftaran Berhasil
            </h1>
            <p style="margin:0 0 24px;color:#d1d5db;line-height:1.6;">
                Halo {{ $registration->full_name }}, pendaftaran kamu untuk kegiatan
                <strong style="color:#ffffff;">{{ $event->title }}</strong> sudah kami terima.
            </p>

            <div style="background:#111827;border:1px solid #374151;border-radius:14px;padding:18px;margin-bottom:20px;">
                <h2 style="margin:0 0 12px;font-size:16px;color:#ffffff;">Detail Kegiatan</h2>
                <p style="margin:0 0 8px;color:#d1d5db;">
                    <strong>Tanggal:</strong>
                    {{ \Carbon\Carbon::parse($event->event_date)->locale('id')->translatedFormat('l, d F Y') }}
                </p>
                <p style="margin:0;color:#d1d5db;">
                    <strong>Lokasi:</strong> {{ $event->location }}
                </p>
            </div>

            <div style="background:#111827;border:1px solid #374151;border-radius:14px;padding:18px;margin-bottom:20px;">
                <h2 style="margin:0 0 12px;font-size:16px;color:#ffffff;">Data Pendaftar</h2>
                <p style="margin:0 0 8px;color:#d1d5db;"><strong>Nama:</strong> {{ $registration->full_name }}</p>
                <p style="margin:0 0 8px;color:#d1d5db;"><strong>Email:</strong> {{ $registration->email }}</p>
                <p style="margin:0 0 8px;color:#d1d5db;"><strong>No. WhatsApp:</strong> {{ $registration->phone }}</p>
                @if ($registration->participant_category)
                    <p style="margin:0 0 8px;color:#d1d5db;"><strong>Kategori Peserta:</strong> {{ $registration->participant_category }}</p>
                @endif
                @if ($registration->institution)
                    <p style="margin:0 0 8px;color:#d1d5db;"><strong>Instansi:</strong> {{ $registration->institution }}</p>
                @endif
                @if ($registration->major)
                    <p style="margin:0 0 8px;color:#d1d5db;"><strong>Prodi/Jurusan:</strong> {{ $registration->major }}</p>
                @endif
                @if ($registration->batch)
                    <p style="margin:0;color:#d1d5db;"><strong>Angkatan:</strong> {{ $registration->batch }}</p>
                @endif
            </div>

            @if ($event->whatsapp_group_link)
                <div style="text-align:center;margin-top:24px;">
                    <a href="{{ $event->whatsapp_group_link }}"
                        style="display:inline-block;background:#16a34a;color:#ffffff;text-decoration:none;font-weight:700;padding:14px 22px;border-radius:12px;">
                        Buka Link Grup WhatsApp
                    </a>
                </div>
            @endif

            <p style="margin:28px 0 0;color:#9ca3af;font-size:12px;line-height:1.6;text-align:center;">
                Simpan email ini sebagai bukti pendaftaran.
            </p>
        </div>
    </div>
</body>

</html>
