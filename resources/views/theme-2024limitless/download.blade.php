@extends(getTheme('layouts.app'))
@section('title', ($seotitle == 'all' ? 'Dokumen & Unduhan' : $downloadcategorys->title))

@push('meta')
    @include('metadefault')
@endpush

@section('content')

<!-- Header Breadcrumb Banner (Tailwind CSS) -->
<div class="bg-gradient-to-r from-[#0B2545] to-blue-900 text-white py-10 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-blue-200 mb-3">
            <a href="{{ url('') }}" class="hover:text-white transition flex items-center gap-1"><i class="fas fa-home"></i> Beranda</a>
            <i class="fas fa-chevron-right text-[9px] text-blue-300"></i>
            <span class="text-white font-semibold">{{ ($seotitle == 'all' ? 'Dokumen Perencanaan' : $downloadcategorys->title) }}</span>
        </nav>
        <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
            {{ ($seotitle == 'all' ? 'Koleksi Dokumen & Publikasi' : $downloadcategorys->title) }}
        </h1>
        <p class="text-xs sm:text-sm text-blue-100 mt-2 max-w-2xl">
            Unduh berkas perencanaan pembangunan daerah, RKPD, RPJMD, Renstra, dan laporan resmi Bappeda Provinsi Lampung.
        </p>
    </div>
</div>

<!-- Main Content (Tailwind CSS) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 font-sans">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Document List Table / Cards (8 cols) -->
        <div class="lg:col-span-8 space-y-4">
            <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-6 shadow-sm">
                
                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="w-full text-left text-xs bappeda-doc-table">
                        <thead>
                            <tr style="background-color: #F8FAFC !important; border-bottom: 2px solid #E2E8F0 !important;">
                                <th class="py-3.5 px-4 text-center w-12 font-extrabold text-[11px] uppercase tracking-wider" style="color: #0B2545 !important;">No.</th>
                                <th class="py-3.5 px-4 w-36 font-extrabold text-[11px] uppercase tracking-wider" style="color: #0B2545 !important;">Kategori</th>
                                <th class="py-3.5 px-4 font-extrabold text-[11px] uppercase tracking-wider" style="color: #0B2545 !important;">Judul Dokumen</th>
                                <th class="py-3.5 px-4 text-center w-28 font-extrabold text-[11px] uppercase tracking-wider" style="color: #0B2545 !important;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @php $no = ($downloads->currentpage()-1)* $downloads->perpage() + 1; @endphp
                            @forelse($downloads as $download)
                                @php
                                    $linkdownload = berkas($download->file) ?: (file_exists(public_path('uploads/'.$download->file)) ? asset('uploads/'.$download->file) : '#');
                                    $ext = strtolower(pathinfo($download->file, PATHINFO_EXTENSION)) ?: 'pdf';
                                    
                                    $catTitle = $download->dctitle ?: 'Dokumen';
                                    $badgeBg = '#EFF6FF';
                                    $badgeColor = '#1A56DB';
                                    $badgeBorder = '#BFDBFE';
                                    
                                    if (stripos($catTitle, 'anggaran') !== false) {
                                        $badgeBg = '#EFF6FF';
                                        $badgeColor = '#1A56DB';
                                        $badgeBorder = '#BFDBFE';
                                    } elseif (stripos($catTitle, 'rpjmd') !== false || stripos($catTitle, 'rkpd') !== false) {
                                        $badgeBg = '#ECFDF5';
                                        $badgeColor = '#059669';
                                        $badgeBorder = '#A7F3D0';
                                    } elseif (stripos($catTitle, 'renstra') !== false || stripos($catTitle, 'renja') !== false) {
                                        $badgeBg = '#FFFBEB';
                                        $badgeColor = '#D97706';
                                        $badgeBorder = '#FDE68A';
                                    }
                                @endphp
                                <tr class="hover:bg-slate-50 transition border-b border-slate-100">
                                    <td class="py-3.5 px-4 text-center font-bold text-xs" style="color: #64748B !important;">{{ $no++ }}</td>
                                    <td class="py-3.5 px-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wider"
                                              style="background-color: {{ $badgeBg }} !important; color: {{ $badgeColor }} !important; border: 1px solid {{ $badgeBorder }} !important;">
                                            {{ $catTitle }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <a href="{{ $linkdownload }}" target="_blank" 
                                           class="font-bold text-xs sm:text-sm leading-snug block transition text-decoration-none hover:text-blue-600 mb-1"
                                           style="color: #0B2545 !important;">
                                            {{ $download->title }}
                                        </a>
                                        <div class="flex flex-wrap items-center gap-2 text-[11px]" style="color: #64748B !important;">
                                            @if($ext)
                                                <span class="uppercase font-bold text-[9px] px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200">
                                                    {{ $ext }}
                                                </span>
                                            @endif
                                            @if($download->created_at)
                                                <span>&bull; {{ date('d M Y', strtotime($download->created_at)) }}</span>
                                            @endif
                                            @if($download->content)
                                                <span class="line-clamp-1 italic text-slate-500">&mdash; {{ strip_tags($download->content) }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <a href="{{ $linkdownload }}" target="_blank" 
                                           class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl text-white font-bold text-xs shadow-sm hover:shadow transition transform hover:-translate-y-0.5 text-decoration-none"
                                           style="background-color: #1A56DB !important; color: #FFFFFF !important;">
                                            <i class="fas fa-download text-[11px]" style="color: #FFFFFF !important;"></i>
                                            <span>Unduh</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-slate-400 text-xs">
                                        <i class="far fa-folder-open text-3xl mb-2 block text-slate-300"></i>
                                        Tidak ada dokumen yang ditemukan pada kategori ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pt-6 flex justify-center">
                    {{ $downloads->links() }}
                </div>
            </div>
        </div>

        <!-- Sidebar (4 cols) -->
        <div class="lg:col-span-4">
            @include(getTheme('partials.sidebar'))
        </div>

    </div>
</div>

@endsection
