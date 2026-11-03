@extends(getTheme('layouts.app'))
@section('title', 'Cek Status Pendaftaran')
@push('css')
<style>
.cek-hero {
    background: linear-gradient(135deg,#0f3460,#16213e);
    padding: 30px;
    border-radius: 16px;
    margin-bottom: 30px;
}
.cek-hero h1 { color:#fff; font-weight:800; font-size:1.8rem; margin-bottom:8px;}
.cek-hero p  { color:rgba(255,255,255,.78); margin-bottom:0;}

.cek-card {
    background:#fff;
    border-radius:20px;
    box-shadow:0 4px 20px rgba(0,0,0,.08);
    position:relative;
    z-index:10;
    overflow:hidden;
    border: 1px solid #f0f0f0;
}
.cek-form-area { padding:36px; }
.cek-input {
    border:2px solid #e5e7eb;
    border-radius:12px;
    padding:14px 18px;
    font-size:1.05rem;
    font-family:monospace;
    letter-spacing:1px;
    width:100%;
    outline:none;
    transition:border-color .2s;
}
.cek-input:focus { border-color:#0f3460; box-shadow:0 0 0 3px rgba(15,52,96,.12); }
.btn-cek {
    background:linear-gradient(135deg,#0f3460,#1a6fa0);
    color:#fff;
    border:none;
    border-radius:12px;
    padding:14px 30px;
    font-weight:700;
    font-size:.95rem;
    display:inline-flex;
    align-items:center;
    gap:8px;
    cursor:pointer;
    transition:opacity .2s;
}
.btn-cek:hover { opacity:.88; }

/* Status Result */
.status-result { display:none; border-top:1px solid #f0f0f0; padding:32px 36px; }
.status-result.show { display:block; }

.status-badge-lg {
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:8px 20px;
    border-radius:999px;
    font-weight:700;
    font-size:1rem;
}
.status-menunggu { background:#fef3c7; color:#92400e; }
.status-diproses  { background:#dbeafe; color:#1e40af; }
.status-diterima  { background:#d1fae5; color:#065f46; }
.status-ditolak   { background:#fee2e2; color:#991b1b; }
.status-selesai   { background:#e5e7eb; color:#374151; }

.status-timeline { position:relative; padding-left:24px; }
.status-timeline::before {
    content:''; position:absolute; left:6px; top:0; bottom:0;
    width:2px; background:#e5e7eb;
}
.sti { position:relative; padding-bottom:20px; }
.sti:last-child { padding-bottom:0; }
.sti-dot {
    position:absolute; left:-18px; top:3px;
    width:12px; height:12px;
    border-radius:50%;
    background:#e5e7eb;
    border:2px solid #fff;
}
.sti.done .sti-dot { background:#27ae60; }
.sti.active .sti-dot { background:#3498db; }
.sti-label { font-size:.82rem; color:#6b7280; }
.sti-val   { font-weight:600; font-size:.9rem; color:#111827; }

.not-found-box {
    background:#fef2f2;
    border:1px solid #fecaca;
    border-radius:14px;
    padding:28px;
    text-align:center;
}

/* Responsive Adjustments */
@media(max-width: 768px) {
    .cek-hero { padding: 24px; text-align: center; }
    .cek-hero h1 { font-size: 1.5rem; }
    .cek-form-area { padding: 20px; }
    .d-flex.gap-3 { flex-direction: column; }
    .btn-cek { width: 100%; justify-content: center; }
    .status-result { padding: 20px; }
    .status-result table tr { display: flex; flex-direction: column; margin-bottom: 10px; }
    .status-result table td { padding: 2px 0 !important; }
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
                    <span class="breadcrumb-item active">Cek Status Pendaftaran</span>
                </div>

                <div class="cek-hero">
                    <div class="container-fluid p-0">
                        <h1><i class="fa-solid fa-magnifying-glass me-2"></i>Cek Status Pendaftaran</h1>
                        <p class="mt-1 mb-0">Masukkan nomor registrasi yang Anda terima setelah mendaftar.</p>
                    </div>
                </div>

                <div class="col-lg-8 mx-auto p-0">
                    <div class="cek-card">
                        <div class="cek-form-area">
                            <form method="GET" action="{{ route('informasi-sosial.cek-status') }}">
                        <div style="margin-bottom:16px;">
                            <label style="font-weight:700;font-size:.88rem;color:#374151;display:block;margin-bottom:8px;">
                                <i class="fa-solid fa-hashtag me-1 text-muted"></i> Nomor Registrasi
                            </label>
                            <div class="d-flex gap-3">
                                <input type="text" name="nomor" class="cek-input"
                                       placeholder="REG/FM/20260409/0001"
                                       value="{{ $nomor ?? '' }}" autocomplete="off">
                                <button type="submit" class="btn-cek">
                                    <i class="fa-solid fa-search"></i> Cek
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Result --}}
                @if($nomor)
                <div class="status-result show">
                    @if($pendaftaran)
                    {{-- FOUND --}}
                    <div class="row align-items-start">
                        <div class="col-md-7">
                            <div style="font-size:.78rem;color:#9ca3af;margin-bottom:4px;">NOMOR REGISTRASI</div>
                            <div style="font-size:1.1rem;font-weight:800;font-family:monospace;color:#0f3460;margin-bottom:16px;">
                                {{ $pendaftaran->nomor_registrasi }}
                            </div>
                            <table style="font-size:.88rem;color:#374151;width:100%;margin-bottom:20px;">
                                <tr><td style="color:#9ca3af;padding:5px 0;width:38%;">Nama Pemohon</td><td><strong>{{ $pendaftaran->nama_lengkap }}</strong></td></tr>
                                <tr><td style="color:#9ca3af;padding:5px 0;">Jenis Layanan</td><td>{{ $pendaftaran->layanan->nama ?? '-' }}</td></tr>
                                <tr><td style="color:#9ca3af;padding:5px 0;">Tanggal Daftar</td><td>{{ $pendaftaran->created_at->format('d M Y') }}</td></tr>
                                <tr><td style="color:#9ca3af;padding:5px 0;">Terakhir Update</td><td>{{ $pendaftaran->updated_at->format('d M Y, H:i') }} WIB</td></tr>
                            </table>
                            @if($pendaftaran->catatan_petugas)
                            <div style="background:#f8f9fa;border-radius:10px;padding:14px;font-size:.85rem;">
                                <div style="font-weight:700;color:#374151;margin-bottom:4px;"><i class="fa-solid fa-comment-dots me-1 text-muted"></i> Catatan Petugas</div>
                                <div style="color:#4b5563;">{{ $pendaftaran->catatan_petugas }}</div>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-5 mt-4 mt-md-0">
                            <div style="text-align:center;margin-bottom:20px;">
                                @php
                                $statusClass = [
                                    'menunggu' => 'status-menunggu',
                                    'diproses' => 'status-diproses',
                                    'diterima' => 'status-diterima',
                                    'ditolak'  => 'status-ditolak',
                                    'selesai'  => 'status-selesai',
                                ][$pendaftaran->status] ?? 'status-menunggu';
                                $statusIcon = [
                                    'menunggu' => 'fa-clock',
                                    'diproses' => 'fa-spinner fa-spin',
                                    'diterima' => 'fa-circle-check',
                                    'ditolak'  => 'fa-circle-xmark',
                                    'selesai'  => 'fa-flag-checkered',
                                ][$pendaftaran->status] ?? 'fa-clock';
                                @endphp
                                <span class="status-badge-lg {{ $statusClass }}">
                                    <i class="fa-solid {{ $statusIcon }}"></i>
                                    {{ $pendaftaran->status_label }}
                                </span>
                            </div>
                            {{-- Timeline --}}
                            @php
                            $allStatus = ['menunggu','diproses','diterima','selesai'];
                            $curIdx    = array_search($pendaftaran->status, $allStatus);
                            $labels    = [
                                'menunggu' => 'Menunggu Verifikasi',
                                'diproses' => 'Sedang Diproses',
                                'diterima' => 'Diterima',
                                'selesai'  => 'Selesai',
                            ];
                            @endphp
                            @if($pendaftaran->status !== 'ditolak')
                            <div class="status-timeline">
                                @foreach($allStatus as $i => $s)
                                <div class="sti {{ $i < $curIdx ? 'done' : ($i == $curIdx ? 'active' : '') }}">
                                    <div class="sti-dot"></div>
                                    <div class="sti-val">{{ $labels[$s] }}</div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div style="background:#fee2e2;border-radius:10px;padding:14px;text-align:center;font-size:.85rem;color:#991b1b;">
                                <i class="fa-solid fa-circle-xmark fa-2x mb-2 d-block"></i>
                                Permohonan <strong>Ditolak</strong><br>Silakan hubungi kantor Dinas Sosial untuk informasi lebih lanjut.
                            </div>
                            @endif
                        </div>
                    </div>
                    @else
                    {{-- NOT FOUND --}}
                    <div class="not-found-box">
                        <i class="fa-solid fa-circle-question text-danger" style="font-size:3rem;margin-bottom:12px;display:block;"></i>
                        <h5 style="font-weight:700;color:#991b1b;">Nomor Registrasi Tidak Ditemukan</h5>
                        <p style="color:#6b7280;font-size:.88rem;margin-bottom:16px;">Pastikan Anda memasukkan nomor registrasi yang benar. Format: <code>REG/KODE/TANGGAL/URUTAN</code></p>
                        <a href="{{ route('informasi-sosial.daftar') }}"
                           style="background:linear-gradient(135deg,#8b0000,#c0392b);color:#fff;padding:10px 22px;border-radius:10px;font-weight:600;text-decoration:none;font-size:.88rem;">
                            <i class="fa-solid fa-file-pen me-1"></i> Daftar Layanan
                        </a>
                    </div>
                    @endif
                </div>
                @endif

            </div>
        </div>

            </div>
        </div>
    </div>
</section>

@endsection
