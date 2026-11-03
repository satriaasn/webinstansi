<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Pemberitahuan Status Permohonan Informasi - Bappeda Provinsi Lampung</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; color: #333333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .header { background: #002B5C; padding: 25px 30px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0 0 5px 0; font-size: 20px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase; }
        .header p { margin: 0; font-size: 13px; color: #e2e8f0; font-weight: 500; }
        .content { padding: 30px; }
        .ticket-box { background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 8px; padding: 18px; text-align: center; margin: 20px 0; }
        .ticket-number { font-size: 22px; font-weight: 900; color: #002B5C; letter-spacing: 1px; margin-top: 5px; }
        .badge { display: inline-block; padding: 6px 14px; border-radius: 50px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-pending { background-color: #fef3c7; color: #92400e; }
        .badge-diproses { background-color: #dbeafe; color: #1e40af; }
        .badge-selesai { background-color: #d1fae5; color: #065f46; }
        .badge-ditolak { background-color: #ffe4e6; color: #9f1239; }
        .section-title { font-size: 14px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 25px; margin-bottom: 8px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; }
        .info-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .info-table td { padding: 8px 0; font-size: 13px; vertical-align: top; }
        .info-table td.label { width: 35%; color: #64748b; font-weight: 600; }
        .info-table td.value { width: 65%; color: #1e293b; }
        .response-box { background: #eff6ff; border-left: 4px solid #3b82f6; padding: 15px; border-radius: 4px; margin-top: 15px; font-size: 13px; color: #1e3a8a; }
        .btn { display: inline-block; background-color: #F59E0B; color: #071D36; text-decoration: none; padding: 12px 28px; border-radius: 50px; font-weight: 800; font-size: 13px; text-align: center; margin: 25px 0 10px 0; box-shadow: 0 4px 6px rgba(245, 158, 11, 0.25); }
        .btn:hover { background-color: #d97706; }
        .footer { background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 30px; text-align: center; font-size: 11px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>BAPPEDA PROVINSI LAMPUNG</h1>
            <p>Pejabat Pengelola Informasi dan Dokumentasi (PPID)</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p style="margin-top: 0;">Yth. <strong>{{ $permohonan->nama_pemohon }}</strong>,</p>
            <p>
                Terima kasih telah mengajukan permohonan informasi publik melalui Layanan PPID Bappeda Provinsi Lampung. 
                Berikut adalah pembaruan status terkini untuk permohonan Anda:
            </p>

            <!-- Ticket Code Box -->
            <div class="ticket-box">
                <div style="font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700;">Nomor Tiket Registrasi</div>
                <div class="ticket-number">{{ $permohonan->nomor_tiket }}</div>
                <div style="margin-top: 10px;">
                    @php
                        $badgeClass = match($permohonan->status) {
                            'pending' => 'badge-pending',
                            'diproses' => 'badge-diproses',
                            'selesai' => 'badge-selesai',
                            'ditolak' => 'badge-ditolak',
                            default => 'badge-pending'
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $permohonan->status_label }}</span>
                </div>
            </div>

            <!-- Detail Permohonan -->
            <div class="section-title">Rincian Permohonan</div>
            <table class="info-table">
                <tr>
                    <td class="label">Tanggal Pengajuan</td>
                    <td class="value">: {{ $permohonan->created_at->format('d/m/Y H:i') }} WIB</td>
                </tr>
                <tr>
                    <td class="label">Kategori Pemohon</td>
                    <td class="value">: {{ $permohonan->kategori_pemohon }}</td>
                </tr>
                <tr>
                    <td class="label">Informasi Dimohon</td>
                    <td class="value">: {{ $permohonan->rincian_informasi }}</td>
                </tr>
                <tr>
                    <td class="label">Tujuan Penggunaan</td>
                    <td class="value">: {{ $permohonan->tujuan_penggunaan }}</td>
                </tr>
            </table>

            <!-- Tanggapan Resmi dari PPID jika ada -->
            @if(!empty($permohonan->tanggapan))
                <div class="section-title">Tanggapan / Catatan Resmi PPID</div>
                <div class="response-box">
                    {!! nl2br(e($permohonan->tanggapan)) !!}
                </div>
            @endif

            <!-- Button Call to Action -->
            <div style="text-align: center;">
                <a href="{{ url('permohonan-informasi/tracking?tiket=' . $permohonan->nomor_tiket) }}" class="btn" target="_blank">
                    Lacak Status & Unduh Berkas &rarr;
                </a>
            </div>

            <p style="font-size: 12px; color: #64748b; margin-top: 20px;">
                Anda dapat melacak perkembangan status permohonan informasi Anda kapan saja melalui website resmi kami dengan memasukkan Nomor Tiket di atas.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <strong>BAPPEDA PROVINSI LAMPUNG</strong><br>
            Jl. Basuki Rahmat No. 86, Bandar Lampung, 35214<br>
            Telepon: (0721) 470411 | Email: bappeda@lampungprov.go.id<br>
            <em>Email ini dikirim secara otomatis oleh Sistem Informasi PPID Bappeda Provinsi Lampung.</em>
        </div>
    </div>
</body>
</html>
