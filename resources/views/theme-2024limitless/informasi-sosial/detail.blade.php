@extends(getTheme('layouts.app'))
@section('title', $layanan->nama)
@push('meta')
    <meta name="description" content="{{ \Illuminate\Support\Str::limit($layanan->deskripsi, 160) }}">
@endpush
@push('css')
<style>
.detail-hero {
    background: linear-gradient(135deg, {{ $layanan->warna }}dd, {{ $layanan->warna }}88);
    padding: 30px;
    border-radius: 16px;
    position: relative;
    overflow: hidden;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
}
.detail-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,.25);
    pointer-events: none;
}
.detail-hero .container-fluid { position: relative; z-index: 1; padding:0; }
.detail-hero h1   { font-size: 2rem; font-weight: 800; color: #fff; margin-bottom: 0; }
.detail-hero .badge-type { background: rgba(255,255,255,.2); color: #fff; border-radius: 999px; padding: 4px 14px; font-size: .8rem; font-weight: 600; backdrop-filter: blur(4px); }

.syarat-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
    padding: 28px;
    height: 100%;
}
.syarat-card h5 { font-weight: 700; color: #8b0000; margin-bottom: 16px; }
.syarat-list li { padding: 6px 0; border-bottom: 1px solid #f0f0f0; font-size: .9rem; color: #444; }
.syarat-list li:last-child { border-bottom: none; }

.file-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,.07);
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    color: inherit;
    transition: box-shadow .2s, transform .2s;
    border: 1px solid #f0f0f0;
}
.file-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,.13); transform: translateY(-2px); color: inherit; }
.file-card .fc-icon { font-size: 2.4rem; }
.file-card .fc-name { font-weight: 600; font-size: .88rem; color: #222; }
.file-card .fc-type { font-size: .75rem; color: #888; text-transform: uppercase; }

.cta-daftar {
    background: linear-gradient(135deg, #8b0000, #c0392b);
    border-radius: 16px;
    padding: 32px 36px;
    color: #fff;
    text-align: center;
}
.cta-daftar h4   { font-weight: 800; }
.cta-daftar p    { opacity: .88; font-size: .92rem; }
.btn-daftar-now  {
    background: #fff;
    color: #8b0000;
    font-weight: 700;
    border-radius: 10px;
    padding: 12px 30px;
    font-size: 1rem;
    border: none;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: opacity .2s;
}
.btn-daftar-now:hover { opacity: .9; color: #8b0000; }

/* Responsive Adjustments */
@media(max-width: 768px) {
    .detail-hero { padding: 24px; text-align: center; }
    .detail-hero h1 { font-size: 1.6rem; }
    .detail-hero .d-flex { flex-direction: column; text-align: center; }
    .syarat-card { padding: 20px; }
    .cta-daftar { padding: 24px 20px; }
    .btn-daftar-now { width: 100%; justify-content: center; }
}
</style>
@endpush
@section('content')

<section class="">
    <div class="container">
        <div class="content-wrapper">
            <div class="content">

                {{-- BREADCRUMB --}}
                <div class="breadcrumb text-truncate d-block mb-3" style="max-width: 1160px">
                    <a class="breadcrumb-item" href="{{url('')}}"><i class="icon-home2 mr-2"></i>Beranda</a>
                    <a class="breadcrumb-item" href="{{ route('informasi-sosial.index') }}">Informasi Sosial</a>
                    <span class="breadcrumb-item active">{{ $layanan->singkatan ?: $layanan->nama }}</span>
                </div>

                {{-- HERO BANNER --}}
                <div class="detail-hero">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:64px;height:64px;border-radius:16px;background:rgba(255,255,255,.2);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;font-size:26px;color:#fff;">
                                <i class="fa-solid {{ $layanan->icon }}"></i>
                            </div>
                            <div>
                                <span class="badge-type badge mb-1">{{ $layanan->jenis === 'uptd' ? 'UPTD' : 'Bidang' }}</span>
                                <h1>{{ $layanan->nama }}</h1>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MAIN CONTENT --}}
                <div class="row">

                    {{-- LEFT: Deskripsi + File Sampel --}}
                    <div class="col-lg-8 mb-4">

                        {{-- Deskripsi --}}
                        <div class="syarat-card mb-4">
                            <h5><i class="fa-solid fa-circle-info me-2"></i>Tentang Layanan</h5>
                            <p style="color:#444;line-height:1.8;font-size:.93rem;">{{ $layanan->deskripsi }}</p>
                        </div>

                        {{-- File Informasi & Formulir + Visualisasi --}}
                        @if(count($sampelFiles) > 0)
                        <div class="syarat-card mb-4">
                            <h5 class="mb-3"><i class="fa-solid fa-folder-open me-2"></i>Dokumen Informasi & Formulir (Pratinjau)</h5>
                            
                            @foreach($sampelFiles as $file)
                            <div class="mb-4">
                                {{-- Header File --}}
                                <div class="d-flex align-items-center justify-content-between p-3" style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:12px 12px 0 0; border-bottom:none;">
                                    <div class="d-flex align-items-center gap-3" style="overflow:hidden;">
                                        <i class="fa-solid {{ $file['icon'] }} {{ $file['icon_color'] }}" style="font-size:1.6rem;"></i>
                                        <div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                            <div style="font-weight:700; font-size:.95rem; color:#1f2937;">{{ $file['nama'] }}</div>
                                            <div style="font-size:.75rem; color:#6b7280; text-transform:uppercase;">FORMAT: {{ $file['ext'] }}</div>
                                        </div>
                                    </div>
                                    <a href="{{ $file['url'] }}" target="_blank" class="btn btn-sm btn-outline-danger text-nowrap" style="border-radius:8px; font-weight:600;">
                                        <i class="fa-solid fa-download me-1"></i> Unduh
                                    </a>
                                </div>

                                {{-- Area Visualisasi / Preview --}}
                                <div style="border:1px solid #e5e7eb; border-radius:0 0 12px 12px; background:#fff; overflow:hidden; display:flex; justify-content:center;">
                                    @if($file['ext'] === 'pdf')
                                        <iframe src="{{ $file['url'] }}#view=FitH" width="100%" height="550px" style="border:none; display:block;" title="{{ $file['nama'] }}" loading="lazy"></iframe>
                                    @elseif(in_array($file['ext'], ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']))
                                        <img src="{{ $file['url'] }}" alt="{{ $file['nama'] }}" style="max-width:100%; height:auto; display:block;" loading="lazy">
                                    @else
                                        <div class="py-5 px-3 text-center w-100" style="background:#f3f4f6;">
                                            <i class="fa-solid fa-eye-slash fa-3x mb-3 text-muted" style="opacity:0.3;"></i>
                                            <h6 style="font-weight:700; color:#4b5563;">Pratinjau Tidak Tersedia</h6>
                                            <p class="mb-0 text-muted" style="font-size:.85rem;">Sistem tidak dapat menampilkan pratinjau untuk file berekstensi <strong>.{{ $file['ext'] }}</strong> secara langsung.<br>Silakan unduh file untuk membukanya di perangkat Anda.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        {{-- CTA Daftar --}}
                        <div class="cta-daftar">
                            <h4><i class="fa-solid fa-file-pen me-2"></i>Ajukan Permohonan Online</h4>
                            <p>Daftarkan permohonan Anda secara online. Proses mudah, cepat, dan dapat dipantau statusnya.</p>
                            <a href="{{ route('informasi-sosial.daftar', ['kode' => $layanan->kode]) }}" class="btn-daftar-now">
                                <i class="fa-solid fa-paper-plane"></i> Daftar Sekarang
                            </a>
                        </div>
                    </div>

                    {{-- RIGHT: Persyaratan --}}
                    <div class="col-lg-4 mb-4">
                        <div class="syarat-card mb-4">
                            <h5><i class="fa-solid fa-clipboard-list me-2"></i>Persyaratan</h5>
                            @if($layanan->persyaratan)
                                <ul class="syarat-list list-unstyled mb-0">
                                    @foreach(explode("\n", $layanan->persyaratan) as $line)
                                        @if(trim($line))
                                        <li>
                                            @if(str_starts_with(trim($line), '#') || str_starts_with(trim($line), 'Untuk'))
                                                <strong>{{ trim($line) }}</strong>
                                            @else
                                                <i class="fa-solid fa-check text-success me-2" style="font-size:.7rem;"></i>{{ trim($line) }}
                                            @endif
                                        </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Hubungi petugas untuk informasi persyaratan.</p>
                            @endif
                        </div>

                        {{-- Cek Status --}}
                        <div class="syarat-card" style="border:2px dashed #dee2e6;box-shadow:none;">
                            <h5 style="color:#495057;"><i class="fa-solid fa-magnifying-glass me-2"></i>Sudah Mendaftar?</h5>
                            <p style="font-size:.85rem;color:#6c757d;">Cek status pendaftaran Anda menggunakan nomor registrasi yang Anda terima.</p>
                            <a href="{{ route('informasi-sosial.cek-status') }}" class="btn btn-outline-secondary btn-sm w-100">
                                <i class="fa-solid fa-search me-1"></i> Cek Status Pendaftaran
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>

@endsection
