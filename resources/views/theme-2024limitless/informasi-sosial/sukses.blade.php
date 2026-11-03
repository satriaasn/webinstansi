@extends(getTheme('layouts.app'))
@section('title', 'Pendaftaran Berhasil')
@push('css')
<style>
@media(max-width: 768px) {
    .sukses-inner { padding: 24px 20px !important; }
    .sukses-table tr { display: flex; flex-direction: column; margin-bottom: 10px; border-bottom: 1px dashed #eee; padding-bottom: 10px; }
    .sukses-table td { padding: 4px 0 !important; width: 100% !important; }
    .btn-action-sukses { width: 100%; justify-content: center; }
}
</style>
@endpush
@section('content')

<section class="pb-5">
    <div class="container">
        <div class="content-wrapper">
            <div class="content">

                {{-- BREADCRUMB --}}
                <div class="breadcrumb text-truncate d-block mb-3" style="max-width: 1160px">
                    <a class="breadcrumb-item" href="{{url('')}}"><i class="icon-home2 mr-2"></i>Beranda</a>
                    <a class="breadcrumb-item" href="{{ route('informasi-sosial.index') }}">Informasi Sosial</a>
                    <span class="breadcrumb-item active">Pendaftaran Berhasil</span>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-7 py-4">
                        <div style="background:#fff;border-radius:20px;box-shadow:0 8px 40px rgba(0,0,0,.1);overflow:hidden;text-align:center;">
                            <div style="background:linear-gradient(135deg,#27ae60,#2ecc71);padding:48px 32px 40px;">
                                <div style="width:90px;height:90px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;backdrop-filter:blur(4px);">
                                    <i class="fa-solid fa-circle-check" style="font-size:3rem;color:#fff;"></i>
                                </div>
                                <h2 style="color:#fff;font-weight:800;margin:0;">Pendaftaran Berhasil!</h2>
                                <p style="color:rgba(255,255,255,.85);margin-top:8px;font-size:.95rem;margin-bottom:0;">Permohonan Anda telah diterima dan sedang menunggu verifikasi petugas.</p>
                            </div>
                    <div style="padding:36px 40px;">
                        @if($pendaftaran)
                        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:14px;padding:20px 24px;margin-bottom:24px;">
                            <div style="font-size:.8rem;color:#6b7280;margin-bottom:4px;">Nomor Registrasi Anda</div>
                            <div style="font-size:1.5rem;font-weight:800;color:#15803d;letter-spacing:1px;font-family:monospace;">
                                {{ $pendaftaran->nomor_registrasi }}
                            </div>
                        </div>
                        <table class="sukses-table" style="width:100%;text-align:left;font-size:.9rem;color:#374151;margin-bottom:24px;">
                            <tr><td style="color:#9ca3af;padding:5px 0;width:40%;">Nama Pemohon</td><td><strong>{{ $pendaftaran->nama_lengkap }}</strong></td></tr>
                            <tr><td style="color:#9ca3af;padding:5px 0;">Layanan</td><td><strong>{{ $pendaftaran->layanan->nama ?? '-' }}</strong></td></tr>
                            <tr><td style="color:#9ca3af;padding:5px 0;">Status</td><td><span style="background:#fef3c7;color:#92400e;padding:3px 12px;border-radius:999px;font-size:.8rem;font-weight:700;">Menunggu Verifikasi</span></td></tr>
                            <tr><td style="color:#9ca3af;padding:5px 0;">Tanggal Daftar</td><td>{{ $pendaftaran->created_at->format('d M Y, H:i') }} WIB</td></tr>
                        </table>
                        @else
                        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:14px;padding:20px 24px;margin-bottom:24px;">
                            <div style="font-size:.8rem;color:#6b7280;margin-bottom:4px;">Nomor Registrasi Anda</div>
                            <div style="font-size:1.5rem;font-weight:800;color:#15803d;letter-spacing:1px;font-family:monospace;">{{ $nomor }}</div>
                        </div>
                        @endif

                        <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:14px;text-align:left;font-size:.83rem;color:#92400e;margin-bottom:24px;">
                            <i class="fa-solid fa-circle-info me-1"></i>
                            <strong>Simpan nomor registrasi ini!</strong> Gunakan untuk memantau status permohonan Anda.
                        </div>

                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <a href="{{ route('informasi-sosial.cek-status') }}?nomor={{ urlencode($pendaftaran->nomor_registrasi ?? $nomor) }}"
                               class="btn-action-sukses" style="background:linear-gradient(135deg,#15803d,#22c55e);color:#fff;padding:12px 24px;border-radius:10px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:8px;">
                                <i class="fa-solid fa-magnifying-glass"></i> Cek Status
                            </a>
                            <a href="{{ route('informasi-sosial.index') }}"
                               class="btn-action-sukses" style="border:2px solid #e5e7eb;color:#6b7280;padding:12px 24px;border-radius:10px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:8px;">
                                <i class="fa-solid fa-house"></i> Kembali ke Beranda Layanan
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
