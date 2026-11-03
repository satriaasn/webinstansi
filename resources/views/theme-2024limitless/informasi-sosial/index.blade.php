@extends(getTheme('layouts.app'))
@section('title', 'Informasi Sosial')
@push('meta')
    <meta name="description" content="Informasi layanan sosial Dinas Sosial Provinsi Lampung – Bidang dan UPTD pelayanan masyarakat.">
@endpush
@push('css')
<style>
/* ===== INFORMASI SOSIAL – INDEX PAGE ===== */
.is-hero-banner {
    background: linear-gradient(135deg, #8b0000 0%, #c0392b 50%, #e74c3c 100%);
    padding: 50px 40px;
    position: relative;
    overflow: hidden;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0,0,0,.15);
}
.is-hero-banner::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='20'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
    pointer-events: none;
}
.is-hero-banner h1 { font-size: 2.2rem; font-weight: 700; color: #fff; margin-bottom: 12px; }
.is-hero-banner p  { color: rgba(255,255,255,.9); font-size: 1.05rem; }

.is-cta-bar {
    background: #fff;
    border-radius: 12px;
    padding: 20px 28px;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
    margin-top: -30px;
    position: relative;
    z-index: 10;
    border: 1px solid #f0f0f0;
}

/* Section header */
.is-section-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #8b0000;
    border-left: 4px solid #c0392b;
    padding-left: 12px;
    margin-bottom: 24px;
}

/* Layanan card */
.is-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,.07);
    transition: transform .22s ease, box-shadow .22s ease;
    text-decoration: none;
    display: block;
    overflow: hidden;
    color: inherit;
}
.is-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 36px rgba(0,0,0,.15);
    color: inherit;
}
.is-card-top {
    padding: 28px 24px 16px;
}
.is-card-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #fff;
    margin-bottom: 14px;
    flex-shrink: 0;
}
.is-card h5  { font-size: .97rem; font-weight: 700; margin-bottom: 6px; color: #1a1a2e; }
.is-card p   { font-size: .82rem; color: #6c757d; line-height: 1.5; margin: 0; }
.is-card-footer {
    background: #f8f9fa;
    padding: 10px 24px;
    font-size: .8rem;
    color: #8b0000;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Badge jenis */
.badge-bidang { background: #ebf5fb; color: #1a6fa0; }
.badge-uptd   { background: #eafaf1; color: #1e8449; }
.badge-layanan { font-size: .72rem; padding: 3px 8px; border-radius: 999px; font-weight: 600; }

/* CTA Quick links */
.is-quick-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #8b0000, #c0392b);
    color: #fff;
    padding: 10px 22px;
    border-radius: 10px;
    font-weight: 600;
    font-size: .9rem;
    text-decoration: none;
    transition: opacity .2s;
}
.is-quick-btn:hover { opacity: .88; color: #fff; }
.is-quick-btn.outline {
    background: transparent;
    border: 2px solid #c0392b;
    color: #c0392b;
}
.is-quick-btn.outline:hover { background: #c0392b; color: #fff; }

/* Stats bar */
.is-stat-item { text-align: center; }
.is-stat-item .stat-num { font-size: 2rem; font-weight: 800; color: #8b0000; line-height: 1; }
.is-stat-item .stat-lbl { font-size: .78rem; color: #6c757d; margin-top: 4px; }

/* Responsive Adjustments */
@media(max-width: 768px) {
    .is-hero-banner { padding: 30px 20px; text-align: center; }
    .is-hero-banner h1 { font-size: 1.8rem; }
    .col-lg-4.text-lg-right { text-align: center !important; }
    .is-cta-bar { flex-direction: column; align-items: center !important; justify-content: center; text-align: center; margin-top: 20px; margin-bottom: 20px;}
    .is-cta-bar > div:first-child { justify-content: center; width: 100%; }
    .is-quick-btn { width: 100%; justify-content: center; }
}
</style>
@endpush
@section('content')

<section class="">
    <div class="container">
        <div class="content-wrapper">
            <div class="content">

                <div class="breadcrumb text-truncate d-block mb-3" style="max-width: 1160px">
                    <a class="breadcrumb-item" href="{{url('')}}"><i class="icon-home2 mr-2"></i>Beranda</a>
                    <span class="breadcrumb-item active">Informasi Sosial</span>
                </div>

                {{-- HERO --}}
                <div class="is-hero-banner mb-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <span class="badge badge-light mb-3" style="font-size:.82rem;padding:6px 14px;border-radius:999px;color:#8b0000;background:#fff;">
                                <i class="fa-solid fa-heart-pulse mr-1 text-danger"></i> Dinas Sosial Provinsi Lampung
                            </span>
                            <h1>Informasi Layanan Sosial</h1>
                            <p class="mb-0">Temukan informasi layanan, persyaratan, dan formulir pendaftaran dari Bidang serta UPTD Dinas Sosial Provinsi Lampung untuk membantu masyarakat yang membutuhkan.</p>
                        </div>
                        <div class="col-lg-4 text-lg-right mt-4 mt-lg-0">
                            <a href="{{ route('informasi-sosial.daftar') }}" class="is-quick-btn">
                                <i class="fa-solid fa-file-pen"></i> Daftar Layanan Sekarang
                            </a>
                            <div class="mt-2 text-lg-right">
                                <a href="{{ route('informasi-sosial.cek-status') }}" class="is-quick-btn outline mt-2" style="background:rgba(255,255,255,0.1); border-color:#fff; color:#fff;">
                                    <i class="fa-solid fa-magnifying-glass mr-1"></i> Cek Status Pendaftaran
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CTA BAR --}}
                <div class="is-cta-bar d-flex flex-wrap align-items-center justify-content-between mb-5 mx-3">
                    <div class="d-flex flex-wrap">
                        <div class="is-stat-item mr-4">
                            <div class="stat-num">{{ $layanan->count() }}</div>
                            <div class="stat-lbl">Total Layanan</div>
                        </div>
                        <div class="is-stat-item mr-4">
                            <div class="stat-num">{{ $bidang->count() }}</div>
                            <div class="stat-lbl">Bidang</div>
                        </div>
                        <div class="is-stat-item">
                            <div class="stat-num">{{ $uptd->count() }}</div>
                            <div class="stat-lbl">UPTD</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3 mt-lg-0" style="color:#6c757d;font-size:.85rem;">
                        <i class="fa-solid fa-file-pdf text-danger mr-2"></i>
                        Upload dokumen PDF, maks 500KB
                    </div>
                </div>

                {{-- BIDANG --}}
                <div class="is-section-title"><i class="fa-solid fa-sitemap mr-2"></i>Bidang Layanan</div>
                <div class="row">
                    @foreach($bidang as $item)
                    <div class="col-md-6 col-lg-3 mb-4">
                        <a href="{{ route('informasi-sosial.detail', $item->kode) }}" class="is-card">
                            <div class="is-card-top">
                                <div class="is-card-icon" style="background:{{ $item->warna }}">
                                    <i class="fa-solid {{ $item->icon }}"></i>
                                </div>
                                <span class="badge-layanan badge-bidang">Bidang</span>
                                <h5 class="mt-2">{{ $item->nama }}</h5>
                                <p>{{ \Illuminate\Support\Str::limit($item->deskripsi, 90) }}</p>
                            </div>
                            <div class="is-card-footer">
                                <i class="fa-solid fa-arrow-right mr-1"></i> Lihat Detail & Daftar
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <div class="is-section-title mt-4"><i class="fa-solid fa-building mr-2"></i>Unit Pelaksana Teknis Daerah (UPTD)</div>
                <div class="row">
                    @foreach($uptd as $item)
                    <div class="col-md-6 col-lg-3 mb-4">
                        <a href="{{ route('informasi-sosial.detail', $item->kode) }}" class="is-card">
                            <div class="is-card-top">
                                <div class="is-card-icon" style="background:{{ $item->warna }}">
                                    <i class="fa-solid {{ $item->icon }}"></i>
                                </div>
                                <span class="badge-layanan badge-uptd">UPTD</span>
                                <h5 class="mt-2">{{ $item->nama }}</h5>
                                <p>{{ \Illuminate\Support\Str::limit($item->deskripsi, 90) }}</p>
                            </div>
                            <div class="is-card-footer">
                                <i class="fa-solid fa-arrow-right mr-1"></i> Lihat Detail & Daftar
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
