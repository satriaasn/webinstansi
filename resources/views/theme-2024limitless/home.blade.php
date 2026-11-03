@extends(getTheme('layouts.app'))
@section('title', 'Beranda')

@push('meta')
    @include('metadefault')
@endpush

@section('content')

<!-- ========================================================================
     1. HERO SLIDER BANNER SECTION (Matching Mockup & Database Sliders)
     ======================================================================== -->
@php
    $heroSlider = \App\Models\Slider::where('active', 'Y')->orderBy('id', 'desc')->first() ?: ((isset($sliders) && $sliders->count() > 0) ? $sliders->first() : null);
    $sliderImg = ($heroSlider && $heroSlider->picture) 
        ? (berkas($heroSlider->picture) ?: url('berkas/' . $heroSlider->picture)) 
        : url('berkas/PoqFOYIvER46x4p7bSVwnCiLubDYnfFuZalqSPYt.png');
@endphp
<section class="relative bg-cover bg-center min-h-[500px] lg:min-h-[560px] flex items-center py-16 md:py-20 font-sans overflow-hidden" 
         style="background-image: url('{{ $sliderImg }}');">
    <!-- Dark gradient overlay on left for sharp readable text contrast -->
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-900/65 to-transparent"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="max-w-2xl">
            <!-- Pill Badge -->
            <div class="inline-block px-3.5 py-1 rounded-full bg-[#F59E0B] text-slate-950 font-black text-[11px] tracking-wider uppercase mb-3 shadow">
                BAPPEDA PROVINSI LAMPUNG
            </div>

            <!-- Big Main Headline -->
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-[1.15] tracking-tight mb-3">
                @if($heroSlider && !empty($heroSlider->title))
                    {{ $heroSlider->title }}
                @else
                    Bersama Mewujudkan<br>
                    <span class="text-white">Lampung Maju 2030</span>
                @endif
            </h1>

            <!-- Subtitle Description -->
            <p class="text-blue-50/95 text-xs sm:text-sm leading-relaxed mb-6 max-w-xl italic font-light">
                {{ ($heroSlider && !empty($heroSlider->content)) ? strip_tags($heroSlider->content) : '"Melalui perencanaan pembangunan yang adaptif, kolaboratif dan berkelanjutan untuk kesejahteraan masyarakat Lampung."' }}
            </p>

            <!-- CTA Button -->
            <div>
                <a href="{{ ($heroSlider && !empty($heroSlider->url)) ? $heroSlider->url : '#perencanaan' }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-[#F59E0B] hover:bg-amber-500 text-slate-950 font-black text-xs shadow-lg transition transform hover:-translate-y-0.5 text-decoration-none">
                    <span>Selengkapnya</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <!-- Carousel dots / indicators -->
            <div class="flex items-center gap-2 text-white/80 mt-10 text-xs">
                <button type="button" class="w-6 h-6 rounded-full bg-white/10 hover:bg-white/30 text-white flex items-center justify-center text-[10px] transition">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span class="w-2.5 h-2.5 rounded-full bg-[#F59E0B]"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-white/40"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-white/40"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-white/40"></span>
                <button type="button" class="w-6 h-6 rounded-full bg-white/10 hover:bg-white/30 text-white flex items-center justify-center text-[10px] transition">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================================
     2. FLOATING QUICK ACCESS CARDS (6 Cards Row - High Contrast Icons)
     ======================================================================== -->
<style>
/* Quick Access Icons Protection */
.quick-access-box {
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}
.quick-access-box i {
    transition: color 0.2s ease, transform 0.2s ease;
    display: inline-block;
}
.group:hover .quick-access-box {
    transform: scale(1.1);
}
.group:hover .quick-access-box-blue {
    background-color: #1A56DB !important;
    border-color: #1A56DB !important;
}
.group:hover .quick-access-box-blue i {
    color: #FFFFFF !important;
}
.group:hover .quick-access-box-indigo {
    background-color: #4F46E5 !important;
    border-color: #4F46E5 !important;
}
.group:hover .quick-access-box-indigo i {
    color: #FFFFFF !important;
}
.group:hover .quick-access-box-amber {
    background-color: #D97706 !important;
    border-color: #D97706 !important;
}
.group:hover .quick-access-box-amber i {
    color: #FFFFFF !important;
}
.group:hover .quick-access-box-sky {
    background-color: #0284C7 !important;
    border-color: #0284C7 !important;
}
.group:hover .quick-access-box-sky i {
    color: #FFFFFF !important;
}
.group:hover .quick-access-box-emerald {
    background-color: #059669 !important;
    border-color: #059669 !important;
}
.group:hover .quick-access-box-emerald i {
    color: #FFFFFF !important;
}
.group:hover .quick-access-box-purple {
    background-color: #7C3AED !important;
    border-color: #7C3AED !important;
}
.group:hover .quick-access-box-purple i {
    color: #FFFFFF !important;
}
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 sm:-mt-12 relative z-20 mb-8 font-sans">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-4 sm:p-5">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            
            <!-- 1. Perencanaan Pembangunan (Blue) -->
            <a href="{{ url('download/all') }}" class="p-3 rounded-xl hover:bg-slate-50 transition flex flex-col items-center text-center group text-decoration-none">
                <div class="quick-access-box quick-access-box-blue w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-2 transition duration-200 shadow-sm" style="background-color: #EFF6FF !important; border: 1px solid #BFDBFE !important;">
                    <i class="fas fa-file-lines text-xl" style="color: #1A56DB !important;"></i>
                </div>
                <div class="text-[11px] sm:text-xs font-bold text-[#0B2545] group-hover:text-[#1A56DB] transition leading-snug">
                    Perencanaan Pembangunan
                </div>
            </a>

            <!-- 2. Data & Informasi Pembangunan (Indigo) -->
            <a href="#data-statistik" class="p-3 rounded-xl hover:bg-slate-50 transition flex flex-col items-center text-center group text-decoration-none">
                <div class="quick-access-box quick-access-box-indigo w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-2 transition duration-200 shadow-sm" style="background-color: #EEF2FF !important; border: 1px solid #C7D2FE !important;">
                    <i class="fas fa-chart-column text-xl" style="color: #4F46E5 !important;"></i>
                </div>
                <div class="text-[11px] sm:text-xs font-bold text-[#0B2545] group-hover:text-[#4F46E5] transition leading-snug">
                    Data & Informasi Pembangunan
                </div>
            </a>

            <!-- 3. Dokumen Publik (Amber) -->
            <a href="{{ url('download/all') }}" class="p-3 rounded-xl hover:bg-slate-50 transition flex flex-col items-center text-center group text-decoration-none">
                <div class="quick-access-box quick-access-box-amber w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-2 transition duration-200 shadow-sm" style="background-color: #FFFBEB !important; border: 1px solid #FDE68A !important;">
                    <i class="fas fa-folder-open text-xl" style="color: #D97706 !important;"></i>
                </div>
                <div class="text-[11px] sm:text-xs font-bold text-[#0B2545] group-hover:text-[#D97706] transition leading-snug">
                    Dokumen Publik
                </div>
            </a>

            <!-- 4. Layanan PPID (Sky) -->
            <a href="#ppid-section" class="p-3 rounded-xl hover:bg-slate-50 transition flex flex-col items-center text-center group text-decoration-none">
                <div class="quick-access-box quick-access-box-sky w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-2 transition duration-200 shadow-sm" style="background-color: #F0F9FF !important; border: 1px solid #BAE6FD !important;">
                    <i class="fas fa-users-viewfinder text-xl" style="color: #0284C7 !important;"></i>
                </div>
                <div class="text-[11px] sm:text-xs font-bold text-[#0B2545] group-hover:text-[#0284C7] transition leading-snug">
                    Layanan PPID
                </div>
            </a>

            <!-- 5. Pengaduan Masyarakat (Emerald) -->
            <a href="{{ url('contact') }}" class="p-3 rounded-xl hover:bg-slate-50 transition flex flex-col items-center text-center group text-decoration-none">
                <div class="quick-access-box quick-access-box-emerald w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-2 transition duration-200 shadow-sm" style="background-color: #ECFDF5 !important; border: 1px solid #A7F3D0 !important;">
                    <i class="fas fa-headset text-xl" style="color: #059669 !important;"></i>
                </div>
                <div class="text-[11px] sm:text-xs font-bold text-[#0B2545] group-hover:text-[#059669] transition leading-snug">
                    Pengaduan Masyarakat
                </div>
            </a>

            <!-- 6. Kolaborasi Pembangunan (Purple) -->
            <a href="{{ url('contact') }}" class="p-3 rounded-xl hover:bg-slate-50 transition flex flex-col items-center text-center group text-decoration-none">
                <div class="quick-access-box quick-access-box-purple w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-2 transition duration-200 shadow-sm" style="background-color: #FAF5FF !important; border: 1px solid #DDD6FE !important;">
                    <i class="fas fa-handshake text-xl" style="color: #7C3AED !important;"></i>
                </div>
                <div class="text-[11px] sm:text-xs font-bold text-[#0B2545] group-hover:text-[#7C3AED] transition leading-snug">
                    Kolaborasi Pembangunan
                </div>
            </a>

        </div>
    </div>
</div>

<!-- ========================================================================
     3. SECTION: BERITA TERBARU & AGENDA KEGIATAN (2 Columns)
     ======================================================================== -->
<section class="py-8 font-sans" id="perencanaan">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- LEFT: Berita Terbaru (7 cols) -->
            <div class="lg:col-span-7">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-200">
                    <h2 class="text-base sm:text-lg font-black text-[#0B2545] flex items-center gap-2">
                        <i class="far fa-newspaper text-[#1A56DB]"></i>
                        <span>Berita Terbaru</span>
                    </h2>
                    <a href="{{ url('post/all') }}" class="text-xs font-bold text-[#1A56DB] hover:text-blue-800 transition flex items-center gap-1 text-decoration-none">
                        Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                @php
                    $postsList = \App\Models\Post::leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')
                        ->where('posts.active', 'Y')
                        ->select('posts.*', 'post_categorys.title as ctitle')
                        ->orderBy('posts.id', 'desc')
                        ->limit(4)
                        ->get();
                    $featuredPost = $postsList->first();
                    $subPosts = $postsList->slice(1, 3);
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                    <!-- Featured Big Card (6 cols) -->
                    @if($featuredPost)
                        @php
                            $featuredImg = $featuredPost->picture ? (berkas($featuredPost->picture) ?: url('berkas/' . $featuredPost->picture)) : url('berkas/no-image.jpg');
                        @endphp
                        <div class="md:col-span-6 bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col group">
                            <div class="relative aspect-[16/10] bg-slate-100 overflow-hidden">
                                <img src="{{ $featuredImg }}" 
                                     alt="{{ $featuredPost->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                
                                <!-- Date overlay badge -->
                                <div class="absolute top-3 left-3 bg-[#0B2545]/90 backdrop-blur-sm text-white rounded-lg px-2.5 py-1.5 text-center leading-tight shadow-md">
                                    <div class="text-xs font-black text-white">{{ date('d', strtotime($featuredPost->created_at)) }}</div>
                                    <div class="text-[9px] font-bold uppercase tracking-wider text-blue-200">{{ date('M Y', strtotime($featuredPost->created_at)) }}</div>
                                </div>

                                <!-- Category overlay badge -->
                                @if($featuredPost->ctitle)
                                    <div class="absolute top-3 right-3 bg-[#1A56DB]/90 backdrop-blur-sm text-white rounded-full px-2.5 py-1 text-[10px] font-bold shadow-md max-w-[150px] truncate">
                                        {{ $featuredPost->ctitle }}
                                    </div>
                                @endif
                            </div>

                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="text-[10px] text-slate-400 font-semibold mb-1 flex items-center gap-1.5">
                                        <i class="far fa-clock text-[10px] text-slate-400"></i>
                                        <span>{{ date('d M Y', strtotime($featuredPost->created_at)) }}</span>
                                    </div>
                                    <h3 class="text-xs sm:text-sm font-bold text-[#0B2545] group-hover:text-[#1A56DB] leading-snug mb-2 transition">
                                        <a href="{{ url('/detail-post/'.$featuredPost->seotitle) }}" class="text-[#0B2545] group-hover:text-[#1A56DB] text-decoration-none">
                                            {{ $featuredPost->title }}
                                        </a>
                                    </h3>
                                    <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed mb-3">
                                        {{ strip_tags($featuredPost->content) }}
                                    </p>
                                </div>
                                <div>
                                    <a href="{{ url('/detail-post/'.$featuredPost->seotitle) }}" class="text-xs font-bold text-[#1A56DB] hover:text-blue-800 transition inline-flex items-center gap-1 text-decoration-none">
                                        Selengkapnya <i class="fas fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- 3 Stacked Sub-News (6 cols) -->
                    <div class="md:col-span-6 space-y-3">
                        @foreach($subPosts as $sub)
                            @php
                                $subImg = $sub->picture ? (berkas($sub->picture) ?: url('berkas/' . $sub->picture)) : url('berkas/no-image.jpg');
                            @endphp
                            <a href="{{ url('/detail-post/'.$sub->seotitle) }}" class="bg-white rounded-xl border border-slate-200/80 p-2.5 flex items-center gap-3 shadow-sm hover:shadow-md hover:border-blue-300 transition group text-decoration-none">
                                <img src="{{ $subImg }}" 
                                     alt="{{ $sub->title }}"
                                     class="w-24 h-18 rounded-lg object-cover flex-shrink-0 bg-slate-100">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-1.5 mb-1">
                                        @if($sub->ctitle)
                                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded max-w-[120px] truncate"
                                                  style="background-color: #EFF6FF !important; color: #1A56DB !important; border: 1px solid #BFDBFE !important;">
                                                {{ $sub->ctitle }}
                                            </span>
                                        @endif
                                        <span class="text-[10px] text-slate-400 font-medium">
                                            {{ date('d M Y', strtotime($sub->created_at)) }}
                                        </span>
                                    </div>
                                    <h4 class="text-xs font-bold text-[#0B2545] group-hover:text-[#1A56DB] line-clamp-2 leading-snug transition">
                                        {{ $sub->title }}
                                    </h4>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- RIGHT: Agenda Kegiatan (5 cols) -->
            <div class="lg:col-span-5">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-200">
                    <h2 class="text-base sm:text-lg font-black text-[#0B2545] flex items-center gap-2">
                        <i class="far fa-calendar-check text-[#1A56DB]"></i>
                        <span>Agenda Kegiatan</span>
                    </h2>
                    <a href="{{ url('agenda/all') }}" class="text-xs font-bold text-[#1A56DB] hover:text-blue-800 transition flex items-center gap-1 text-decoration-none">
                        Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                @php
                    $agendasList = \App\Models\Agenda::where('active', 'Y')->orderBy('start', 'desc')->limit(3)->get();
                @endphp

                <div class="space-y-3">
                    @forelse($agendasList as $agenda)
                        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm hover:shadow-md hover:border-blue-300 transition flex items-center gap-4 group">
                            <!-- Date badge box with high-contrast text and hover state -->
                            <div class="w-14 h-14 rounded-xl bg-[#EFF6FF] border border-[#BFDBFE] group-hover:bg-[#1A56DB] group-hover:border-[#1A56DB] transition duration-200 flex flex-col items-center justify-center flex-shrink-0">
                                <span class="text-base font-black leading-none text-[#1A56DB] group-hover:text-white transition">{{ date('d', strtotime($agenda->start)) }}</span>
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#1A56DB] group-hover:text-white mt-1 transition">{{ date('M', strtotime($agenda->start)) }}</span>
                            </div>

                            <div class="min-w-0 flex-1">
                                <h3 class="text-xs sm:text-sm font-bold text-[#0B2545] group-hover:text-[#1A56DB] line-clamp-2 leading-snug mb-1.5 transition">
                                    <a href="{{ url('/detail-agenda/'.$agenda->seotitle) }}" class="text-[#0B2545] group-hover:text-[#1A56DB] text-decoration-none">
                                        {{ $agenda->title }}
                                    </a>
                                </h3>
                                <div class="flex flex-wrap items-center gap-3 text-[11px] text-slate-500">
                                    <span class="flex items-center gap-1">
                                        <i class="fas fa-location-dot text-rose-500 text-[11px]"></i> 
                                        <span>{{ strip_tags($agenda->content) ?: 'Ruang Rapat Bappeda' }}</span>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class="far fa-clock text-slate-400 text-[11px]"></i> 
                                        <span>{{ date('H.i', strtotime($agenda->start)) }} WIB</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl border border-slate-200/80 p-8 text-center text-slate-400 text-xs">
                            Belum ada agenda kegiatan mendatang.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========================================================================
     4. SECTION: DOWNLOAD DOKUMEN & GALERI KEGIATAN (2 Columns)
     ======================================================================== -->
<section class="py-8 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- LEFT: Download Dokumen (6 cols) -->
            <div class="lg:col-span-6">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-200">
                    <h2 class="text-base sm:text-lg font-black text-[#0B2545] flex items-center gap-2">
                        <i class="fas fa-download text-[#1A56DB]"></i>
                        <span>Download Dokumen</span>
                    </h2>
                    <a href="{{ url('download/all') }}" class="text-xs font-bold text-[#1A56DB] hover:text-blue-800 transition flex items-center gap-1 text-decoration-none">
                        Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                @php
                    $docsList = \App\Models\Download::leftJoin('download_categorys', 'download_categorys.id', 'downloads.download_category_id')
                        ->where('downloads.active', 'Y')
                        ->select('downloads.*', 'download_categorys.title as ctitle')
                        ->orderBy('downloads.id', 'desc')
                        ->limit(4)
                        ->get();
                @endphp

                <div class="space-y-2.5">
                    @forelse($docsList as $doc)
                        @php
                            $ext = strtolower(pathinfo($doc->file, PATHINFO_EXTENSION)) ?: 'pdf';
                            if(in_array($ext, ['pdf'])) {
                                $badgeBg = 'bg-[#DC2626]';
                                $badgeLabel = 'PDF';
                            } elseif(in_array($ext, ['xls', 'xlsx', 'csv'])) {
                                $badgeBg = 'bg-[#059669]';
                                $badgeLabel = 'XLS';
                            } elseif(in_array($ext, ['doc', 'docx'])) {
                                $badgeBg = 'bg-[#2563EB]';
                                $badgeLabel = 'DOC';
                            } elseif(in_array($ext, ['zip', 'rar', '7z'])) {
                                $badgeBg = 'bg-[#D97706]';
                                $badgeLabel = 'ZIP';
                            } else {
                                $badgeBg = 'bg-slate-700';
                                $badgeLabel = strtoupper(substr($ext, 0, 3));
                            }
                            $linkdownload = berkas($doc->file) ?: (file_exists(public_path('uploads/'.$doc->file)) ? asset('uploads/'.$doc->file) : '#');
                        @endphp
                        <div class="bg-white rounded-xl border border-slate-200/80 p-3 flex items-center justify-between gap-3 hover:bg-slate-50 transition shadow-sm group">
                            <div class="flex items-center gap-3 min-w-0">
                                <!-- Dynamic Format Badge (Red PDF, Green XLS, Blue DOC) -->
                                <div class="w-10 h-10 rounded-xl {{ $badgeBg }} text-white flex items-center justify-center font-black text-[10px] flex-shrink-0 tracking-wider shadow-sm">
                                    {{ $badgeLabel }}
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ $linkdownload }}" target="_blank" class="font-bold text-xs text-[#0B2545] group-hover:text-[#1A56DB] line-clamp-1 block transition text-decoration-none">
                                        {{ $doc->title }}
                                    </a>
                                    <div class="text-[10px] text-slate-400 mt-0.5">
                                        <span class="text-[#1A56DB] font-semibold">{{ $doc->ctitle ?: 'Dokumen Publik' }}</span> &bull; {{ $doc->created_at ? date('d M Y', strtotime($doc->created_at)) : '2026' }}
                                    </div>
                                </div>
                            </div>
                            <a href="{{ $linkdownload }}" target="_blank" class="w-9 h-9 rounded-xl flex items-center justify-center text-xs transition flex-shrink-0 shadow-sm hover:scale-105" style="background-color: #EFF6FF !important; color: #1A56DB !important;" title="Unduh Berkas">
                                <i class="fas fa-download text-[11px]" style="color: #1A56DB !important;"></i>
                            </a>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl border border-slate-200/80 p-8 text-center text-slate-400 text-xs">
                            Belum ada dokumen publikasi.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- RIGHT: Galeri Kegiatan (6 cols) - Dynamic from Database -->
            <div class="lg:col-span-6">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-200">
                    <h2 class="text-base sm:text-lg font-black text-[#0B2545] flex items-center gap-2">
                        <i class="fas fa-camera text-[#1A56DB]"></i>
                        <span>Galeri Kegiatan</span>
                    </h2>
                    <a href="{{ url('album/all') }}" class="text-xs font-bold text-[#1A56DB] hover:text-blue-800 transition flex items-center gap-1 text-decoration-none">
                        Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                @php
                    $galleriesList = \App\Models\Gallery::leftJoin('albums', 'albums.id', '=', 'gallerys.album_id')
                        ->where('gallerys.active', 'Y')
                        ->select('gallerys.*', 'albums.title as atitle', 'albums.seotitle as aseotitle')
                        ->orderBy('gallerys.id', 'desc')
                        ->limit(6)
                        ->get();
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @forelse($galleriesList as $gItem)
                        @php
                            // Ambil langsung berkas gambar dari database fitur galeri
                            $gImg = berkas($gItem->picture) ?: url('berkas/' . $gItem->picture);
                            $albumLink = $gItem->aseotitle ? url('detail-gallery/' . $gItem->aseotitle) : url('album/all');
                        @endphp
                        <a href="{{ $albumLink }}" 
                           class="group relative aspect-[4/3] rounded-xl overflow-hidden bg-slate-100 shadow-sm border border-slate-200/80 block"
                           title="{{ $gItem->title }}">
                            <img src="{{ $gImg }}" 
                                 alt="{{ $gItem->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <!-- Dynamic Caption & Zoom Icon on Hover -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-900/30 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-between p-2.5">
                                <div class="self-end w-7 h-7 rounded-full bg-white/20 backdrop-blur-sm text-white flex items-center justify-center text-xs">
                                    <i class="fas fa-magnifying-glass-plus"></i>
                                </div>
                                <div class="text-[11px] font-bold text-white line-clamp-2 leading-tight drop-shadow">
                                    {{ $gItem->title }}
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-3 bg-white rounded-xl border border-slate-200/80 p-8 text-center text-slate-400 text-xs">
                            Belum ada foto galeri.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========================================================================
     5. SECTION: PPID BANNER (Matching Mockup)
     ======================================================================== -->
<section class="py-6 font-sans" id="ppid-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-[#072146] via-[#09356E] to-[#0B4182] rounded-3xl p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
            <!-- Background architecture watermark -->
            <div class="absolute right-0 top-0 bottom-0 w-1/2 opacity-10 bg-no-repeat bg-contain bg-right pointer-events-none"
                 style="background-image: url('{{ asset('assets/images/gedung_bappeda.jpg') }}');"></div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <!-- Left Title & CTA -->
                <div class="lg:col-span-5">
                    <span class="inline-block px-3.5 py-1 rounded-full bg-[#F59E0B] text-slate-950 font-black text-[10px] tracking-wider uppercase mb-3 shadow">
                        PPID
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black text-white leading-tight mb-1">
                        Pejabat Pengelola<br>
                        Informasi dan Dokumentasi
                    </h2>
                    <div class="text-[#F59E0B] font-bold text-sm sm:text-base mb-3">
                        Bappeda Provinsi Lampung
                    </div>
                    <p class="text-blue-100/90 text-xs leading-relaxed mb-6 max-w-sm">
                        Keterbukaan Informasi Publik adalah komitmen kami untuk mewujudkan pemerintahan yang transparan dan akuntabel.
                    </p>
                    <a href="{{ url('pages/layanan-permohonan-informasi-bappeda-provinsi-lampung') }}" class="px-5 py-2.5 rounded-full bg-[#F59E0B] hover:bg-amber-500 text-slate-950 font-black text-xs inline-flex items-center gap-2 shadow transition text-decoration-none">
                        <span>Akses Layanan PPID</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <!-- Right 5 White Cards -->
                <div class="lg:col-span-7">
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                        <!-- Card 1 -->
                        <a href="{{ url('pages/daftar-informasi-yang-wajib-disediakan-dan-diumumkan') }}" class="bg-white rounded-2xl p-3 sm:p-4 text-center flex flex-col items-center justify-center hover:shadow-lg hover:-translate-y-1 transition duration-200 group text-decoration-none shadow-sm">
                            <div class="ppid-icon-box ppid-icon-blue w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-2.5 transition duration-200 shadow-sm" style="background-color: #EFF6FF !important; border: 1px solid #BFDBFE !important;">
                                <i class="fas fa-file-lines" style="color: #1A56DB !important;"></i>
                            </div>
                            <span class="text-[11px] font-bold text-[#0B2545] group-hover:text-[#1A56DB] leading-tight transition">
                                Informasi Berkala
                            </span>
                        </a>

                        <!-- Card 2 -->
                        <a href="{{ url('pages/tentang-ppid') }}" class="bg-white rounded-2xl p-3 sm:p-4 text-center flex flex-col items-center justify-center hover:shadow-lg hover:-translate-y-1 transition duration-200 group text-decoration-none shadow-sm">
                            <div class="ppid-icon-box ppid-icon-amber w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-2.5 transition duration-200 shadow-sm" style="background-color: #FFFBEB !important; border: 1px solid #FDE68A !important;">
                                <i class="fas fa-bolt" style="color: #D97706 !important;"></i>
                            </div>
                            <span class="text-[11px] font-bold text-[#0B2545] group-hover:text-amber-600 leading-tight transition">
                                Informasi Serta-Merta
                            </span>
                        </a>

                        <!-- Card 3 -->
                        <a href="{{ url('pages/tentang-ppid') }}" class="bg-white rounded-2xl p-3 sm:p-4 text-center flex flex-col items-center justify-center hover:shadow-lg hover:-translate-y-1 transition duration-200 group text-decoration-none shadow-sm">
                            <div class="ppid-icon-box ppid-icon-emerald w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-2.5 transition duration-200 shadow-sm" style="background-color: #ECFDF5 !important; border: 1px solid #A7F3D0 !important;">
                                <i class="far fa-clock" style="color: #059669 !important;"></i>
                            </div>
                            <span class="text-[11px] font-bold text-[#0B2545] group-hover:text-emerald-600 leading-tight transition">
                                Informasi Setiap Saat
                            </span>
                        </a>

                        <!-- Card 4 -->
                        <a href="{{ url('pages/tentang-ppid') }}" class="bg-white rounded-2xl p-3 sm:p-4 text-center flex flex-col items-center justify-center hover:shadow-lg hover:-translate-y-1 transition duration-200 group text-decoration-none shadow-sm">
                            <div class="ppid-icon-box ppid-icon-rose w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-2.5 transition duration-200 shadow-sm" style="background-color: #FFF1F2 !important; border: 1px solid #FECDD3 !important;">
                                <i class="fas fa-lock" style="color: #E11D48 !important;"></i>
                            </div>
                            <span class="text-[11px] font-bold text-[#0B2545] group-hover:text-rose-600 leading-tight transition">
                                Informasi Dikecualikan
                            </span>
                        </a>

                        <!-- Card 5 -->
                        <a href="{{ url('pages/daftar-informasi-yang-wajib-disediakan-dan-diumumkan') }}" class="bg-white rounded-2xl p-3 sm:p-4 text-center flex flex-col items-center justify-center hover:shadow-lg hover:-translate-y-1 transition duration-200 group col-span-2 sm:col-span-1 text-decoration-none shadow-sm">
                            <div class="ppid-icon-box ppid-icon-indigo w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-2.5 transition duration-200 shadow-sm" style="background-color: #EEF2FF !important; border: 1px solid #C7D2FE !important;">
                                <i class="fas fa-list-check" style="color: #4F46E5 !important;"></i>
                            </div>
                            <span class="text-[11px] font-bold text-[#0B2545] group-hover:text-indigo-600 leading-tight transition">
                                Daftar Informasi Publik (DIP)
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================================
     6. SECTION: TENTANG BAPPEDA, DATA & STATISTIK, QUOTE GUBERNUR (3 Columns)
     ======================================================================== -->
<section class="py-8 font-sans" id="data-statistik">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            
            <!-- Column 1: Tentang Bappeda (4 cols) -->
            <div class="lg:col-span-4 flex flex-col">
                <div class="flex items-center justify-between pb-2.5 mb-3.5 border-b border-slate-200">
                    <h2 class="text-sm sm:text-base font-black text-[#0B2545] flex items-center gap-2 m-0">
                        <i class="fas fa-landmark text-[#1A56DB]"></i>
                        <span>Tentang Bappeda</span>
                    </h2>
                    <a href="{{ url('pages/tentang-kami') }}" class="text-[11px] font-bold text-[#1A56DB] hover:text-blue-800 transition flex items-center gap-1 text-decoration-none">
                        Profil <i class="fas fa-arrow-right text-[9px]"></i>
                    </a>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm flex flex-col justify-between flex-1">
                    <div class="flex gap-3.5 items-start">
                        <div class="w-28 sm:w-32 h-24 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0 shadow-sm border border-slate-100">
                            <img src="{{ getSetting('tentang_bappeda_image') ? (berkas(getSetting('tentang_bappeda_image')) ?: url('berkas/' . getSetting('tentang_bappeda_image'))) : (file_exists(public_path('assets/images/gedung_bappeda.jpg')) ? asset('assets/images/gedung_bappeda.jpg') : asset('assets/images/lampung_hero_banner.jpg')) }}" 
                                 alt="Gedung Bappeda" class="w-full h-full object-cover">
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed line-clamp-4 m-0">
                            {{ getSetting('tentang_bappeda_singkat') ?: 'Bappeda Provinsi Lampung adalah unsur perencana pembangunan daerah yang membantu Gubernur dalam menyelenggarakan urusan pemerintahan di bidang perencanaan pembangunan daerah.' }}
                        </p>
                    </div>
                    <div class="pt-3 mt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400 font-medium truncate pr-2">Bappeda Provinsi Lampung</span>
                        <a href="{{ url('pages/tentang-kami') }}" 
                           class="px-3 py-1.5 rounded-full text-[11px] font-bold inline-flex items-center gap-1.5 transition text-decoration-none shadow-sm flex-shrink-0 hover:scale-105"
                           style="background-color: #EFF6FF !important; color: #1A56DB !important; border: 1px solid #BFDBFE !important;">
                            <span>Selengkapnya</span>
                            <i class="fas fa-arrow-right text-[9px]" style="color: #1A56DB !important;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Column 2: Data & Statistik Pembangunan Lampung (4 cols) -->
            <div class="lg:col-span-4 flex flex-col">
                <div class="flex items-center justify-between pb-2.5 mb-3.5 border-b border-slate-200">
                    <h2 class="text-sm sm:text-base font-black text-[#0B2545] flex items-center gap-2 m-0">
                        <i class="fas fa-chart-pie text-[#1A56DB]"></i>
                        <span>Statistik Daerah</span>
                    </h2>
                    <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full border border-slate-200/60">
                        Tahun 2024
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-3 flex-1">
                    <!-- Stat 1: Penduduk (Blue) -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-3 text-center shadow-sm hover:shadow-md transition flex flex-col justify-center">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-sm mx-auto mb-1.5" style="background-color: #EFF6FF !important; border: 1px solid #BFDBFE !important;">
                            <i class="fas fa-users" style="color: #1A56DB !important;"></i>
                        </div>
                        <div class="text-base font-black text-[#0B2545] leading-tight">{{ getSetting('stat_penduduk_val') ?: '8,85 Juta' }}</div>
                        <div class="text-[10px] text-slate-400 font-medium leading-tight mt-1">{{ getSetting('stat_penduduk_lbl') ?: 'Penduduk' }}</div>
                    </div>

                    <!-- Stat 2: Pertumbuhan Ekonomi (Emerald) -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-3 text-center shadow-sm hover:shadow-md transition flex flex-col justify-center">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-sm mx-auto mb-1.5" style="background-color: #ECFDF5 !important; border: 1px solid #A7F3D0 !important;">
                            <i class="fas fa-chart-line" style="color: #059669 !important;"></i>
                        </div>
                        <div class="text-base font-black text-[#0B2545] leading-tight">{{ getSetting('stat_ekonomi_val') ?: '5,12%' }}</div>
                        <div class="text-[10px] text-slate-400 font-medium leading-tight mt-1">{{ getSetting('stat_ekonomi_lbl') ?: 'Pertumbuhan Ekonomi' }}</div>
                    </div>

                    <!-- Stat 3: PDRB ADHB (Indigo) -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-3 text-center shadow-sm hover:shadow-md transition flex flex-col justify-center">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-sm mx-auto mb-1.5" style="background-color: #EEF2FF !important; border: 1px solid #C7D2FE !important;">
                            <i class="fas fa-coins" style="color: #4F46E5 !important;"></i>
                        </div>
                        <div class="text-base font-black text-[#0B2545] leading-tight">{{ getSetting('stat_pdrb_val') ?: 'Rp 67,45 T' }}</div>
                        <div class="text-[10px] text-slate-400 font-medium leading-tight mt-1">{{ getSetting('stat_pdrb_lbl') ?: 'PDRB ADHB' }}</div>
                    </div>

                    <!-- Stat 4: IPM (Amber) -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-3 text-center shadow-sm hover:shadow-md transition flex flex-col justify-center">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-sm mx-auto mb-1.5" style="background-color: #FFFBEB !important; border: 1px solid #FDE68A !important;">
                            <i class="fas fa-trophy" style="color: #D97706 !important;"></i>
                        </div>
                        <div class="text-base font-black text-[#0B2545] leading-tight">{{ getSetting('stat_ipm_val') ?: '74,20' }}</div>
                        <div class="text-[10px] text-slate-400 font-medium leading-tight mt-1">{{ getSetting('stat_ipm_lbl') ?: 'IPM' }}</div>
                    </div>
                </div>
            </div>

            <!-- Column 3: Quote Arahan Pembangunan (4 cols) -->
            <div class="lg:col-span-4 flex flex-col">
                <div class="flex items-center justify-between pb-2.5 mb-3.5 border-b border-slate-200">
                    <h2 class="text-sm sm:text-base font-black text-[#0B2545] flex items-center gap-2 m-0">
                        <i class="fas fa-quote-left text-[#1A56DB]"></i>
                        <span>Arahan Pembangunan</span>
                    </h2>
                    <span class="text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200/70 px-2 py-0.5 rounded-full">
                        Pimpinan Daerah
                    </span>
                </div>

                <div class="bg-gradient-to-br from-[#0B2545] via-[#0E3566] to-[#071D36] rounded-2xl p-5 text-white shadow-sm flex flex-col justify-between flex-1 border border-blue-900/40 relative overflow-hidden">
                    <!-- Subtle watermark in background -->
                    <div class="absolute -right-3 -bottom-5 text-white/5 text-8xl pointer-events-none select-none">
                        <i class="fas fa-quote-right"></i>
                    </div>

                    <div class="relative z-10">
                        <div class="w-8 h-8 rounded-lg bg-amber-400/20 border border-amber-400/30 text-amber-300 flex items-center justify-center text-xs mb-3 shadow-sm">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p class="text-xs sm:text-sm font-medium italic text-blue-50 leading-relaxed m-0">
                            "{{ getSetting('quote_gubernur') ?: 'Dengan perencanaan yang baik, kita wujudkan Lampung lebih maju dan sejahtera.' }}"
                        </p>
                    </div>

                    <div class="relative z-10 pt-3 mt-3 border-t border-white/10 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-black text-amber-300 tracking-wide uppercase">
                                {{ getSetting('quote_author') ?: 'Gubernur Lampung' }}
                            </div>
                            <div class="text-[10px] text-blue-200/80 font-medium">
                                Pemerintah Provinsi Lampung
                            </div>
                        </div>
                        <div class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center text-amber-300 text-[10px]">
                            <i class="fas fa-award"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========================================================================
     7. SECTION: MITRA KERJA & LINK TERKAIT (Matching Mockup)
     ======================================================================== -->
<section class="py-8 font-sans bg-slate-50 border-t border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-sm sm:text-base font-black text-[#0B2545] flex items-center gap-2 pb-2 mb-4 border-b border-slate-200">
            <i class="fas fa-handshake text-[#1A56DB]"></i>
            <span>Mitra Kerja & Link Terkait</span>
        </h2>

        <div class="flex items-center gap-3">
            <button type="button" class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-500 hover:text-[#1A56DB] flex items-center justify-center text-xs shadow-sm flex-shrink-0 transition">
                <i class="fas fa-chevron-left"></i>
            </button>

            <!-- Partners Scroll / Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3 w-full">
                <!-- 1. Pemprov Lampung -->
                <a href="https://lampungprov.go.id" target="_blank" rel="noopener" class="bg-white rounded-xl border border-slate-200 p-2.5 text-center flex items-center justify-center gap-2 hover:shadow-md hover:border-[#1A56DB] transition text-decoration-none">
                    <img src="{{ file_exists(public_path('assets/images/logo_lampung.png')) ? asset('assets/images/logo_lampung.png') : asset('no-image.jpg') }}" alt="Pemprov Lampung" class="h-6 w-auto">
                    <span class="text-[10px] font-bold text-slate-700 leading-tight">Pemerintah Provinsi Lampung</span>
                </a>

                <!-- 2. Bappenas -->
                <a href="https://bappenas.go.id" target="_blank" rel="noopener" class="bg-white rounded-xl border border-slate-200 p-2.5 text-center flex items-center justify-center gap-2 hover:shadow-md hover:border-[#1A56DB] transition text-decoration-none">
                    <div class="w-6 h-6 rounded-full bg-blue-100 text-[#1A56DB] flex items-center justify-center text-[10px] font-black">PPN</div>
                    <span class="text-[10px] font-bold text-slate-700 leading-tight">Kementerian PPN/Bappenas</span>
                </a>

                <!-- 3. Indonesia.go.id -->
                <a href="https://indonesia.go.id" target="_blank" rel="noopener" class="bg-white rounded-xl border border-slate-200 p-2.5 text-center flex items-center justify-center gap-2 hover:shadow-md hover:border-[#1A56DB] transition text-decoration-none">
                    <div class="w-6 h-6 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-[10px] font-black"><i class="fas fa-flag"></i></div>
                    <span class="text-[10px] font-bold text-slate-700 leading-tight">Laman Indonesia.go.id</span>
                </a>

                <!-- 4. BerAKHLAK -->
                <a href="#" class="bg-white rounded-xl border border-slate-200 p-2.5 text-center flex items-center justify-center gap-1.5 hover:shadow-md hover:border-[#1A56DB] transition text-decoration-none">
                    <span class="text-[11px] font-black text-red-600">Ber</span><span class="text-[11px] font-black text-slate-800">AKHLAK</span>
                </a>

                <!-- 5. Satu Data -->
                <a href="https://data.go.id" target="_blank" rel="noopener" class="bg-white rounded-xl border border-slate-200 p-2.5 text-center flex items-center justify-center gap-2 hover:shadow-md hover:border-[#1A56DB] transition text-decoration-none">
                    <div class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-[10px] font-black"><i class="fas fa-database"></i></div>
                    <span class="text-[10px] font-bold text-slate-700 leading-tight">Satu Data Indonesia</span>
                </a>

                <!-- 6. Open Government -->
                <a href="https://opengovindonesia.org" target="_blank" rel="noopener" class="bg-white rounded-xl border border-slate-200 p-2.5 text-center flex items-center justify-center gap-2 hover:shadow-md hover:border-[#1A56DB] transition text-decoration-none">
                    <div class="w-6 h-6 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center text-[10px] font-black"><i class="fas fa-landmark"></i></div>
                    <span class="text-[10px] font-bold text-slate-700 leading-tight">Open Government</span>
                </a>

                <!-- 7. SP4N LAPOR -->
                <a href="https://lapor.go.id" target="_blank" rel="noopener" class="bg-white rounded-xl border border-slate-200 p-2.5 text-center flex items-center justify-center gap-2 hover:shadow-md hover:border-[#1A56DB] transition text-decoration-none">
                    <div class="w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center text-[10px] font-black"><i class="fas fa-bullhorn"></i></div>
                    <span class="text-[10px] font-bold text-red-600 leading-tight">LAPOR!</span>
                </a>
            </div>

            <button type="button" class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-500 hover:text-[#1A56DB] flex items-center justify-center text-xs shadow-sm flex-shrink-0 transition">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

@endsection
