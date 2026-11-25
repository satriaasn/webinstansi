@extends(getTheme('layouts.app'))
@section('title', 'Perencanaan Pembangunan')

@push('meta')
    @include('metadefault')
@endpush

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-r from-[#072146] via-[#09356E] to-[#0B4182] py-12 text-white font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="inline-block px-3 py-1 rounded-full bg-[#F59E0B] text-slate-950 font-black text-[10px] tracking-wider uppercase mb-3 shadow">
                    DOKUMEN PERENCANAAN
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white leading-tight m-0">
                    Perencanaan Pembangunan
                </h1>
                <p class="text-blue-100/90 text-xs sm:text-sm mt-2 mb-0 max-w-2xl">
                    Pilih kategori dokumen perencanaan pembangunan daerah (RPJPD, RPJMD, RKPD, Renstra, dan dokumen perencanaan lainnya) untuk mengunduh berkas terkait.
                </p>
            </div>
            <div>
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 text-white text-xs font-bold border border-white/20 transition text-decoration-none">
                    <i class="fas fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Category Cards Grid -->
<section class="py-10 bg-slate-50 font-sans min-h-[420px]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($categories->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach($categories as $index => $cat)
                    @php
                        $palette = [
                            ['bg' => '#EFF6FF', 'border' => '#BFDBFE', 'color' => '#1A56DB', 'icon' => 'fas fa-file-lines'],
                            ['bg' => '#EEF2FF', 'border' => '#C7D2FE', 'color' => '#4F46E5', 'icon' => 'fas fa-chart-line'],
                            ['bg' => '#ECFDF5', 'border' => '#A7F3D0', 'color' => '#059669', 'icon' => 'fas fa-layer-group'],
                            ['bg' => '#FFFBEB', 'border' => '#FDE68A', 'color' => '#D97706', 'icon' => 'fas fa-compass-drafting'],
                            ['bg' => '#F0F9FF', 'border' => '#BAE6FD', 'color' => '#0284C7', 'icon' => 'fas fa-folder-tree'],
                            ['bg' => '#FAF5FF', 'border' => '#DDD6FE', 'color' => '#7C3AED', 'icon' => 'fas fa-book-open'],
                        ];
                        $style = $palette[$index % count($palette)];
                    @endphp
                    <a href="{{ url('download/' . $cat->seotitle) }}"
                       class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-lg hover:border-blue-300 hover:-translate-y-1 transition duration-200 flex flex-col justify-between group text-decoration-none">
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl shadow-sm flex-shrink-0 transition duration-200 group-hover:scale-110"
                                 style="background-color: {{ $style['bg'] }} !important; border: 1px solid {{ $style['border'] }} !important;">
                                <i class="{{ $style['icon'] }}" style="color: {{ $style['color'] }} !important;"></i>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200/70">
                                {{ $cat->downloads_count }} Dokumen
                            </span>
                        </div>

                        <div>
                            <h2 class="text-sm font-bold text-[#0B2545] group-hover:text-[#1A56DB] leading-snug mb-2 transition">
                                {{ $cat->title }}
                            </h2>
                            <div class="inline-flex items-center gap-1.5 text-[11px] font-bold text-[#1A56DB]">
                                <span>Lihat Dokumen</span>
                                <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center shadow-sm">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[#1A56DB] flex items-center justify-center text-2xl mx-auto mb-3">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h2 class="text-base font-bold text-[#0B2545] mb-1">Belum Ada Kategori Dokumen Perencanaan</h2>
                <p class="text-xs text-slate-500 m-0">Silakan centang opsi <strong>Dokumen Perencanaan</strong> pada kategori download di Dashboard Admin.</p>
            </div>
        @endif
    </div>
</section>
@endsection
