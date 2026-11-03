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
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-sm">
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-800 text-[11px] font-bold uppercase tracking-wider bg-slate-50">
                                <th class="py-3 px-3">No.</th>
                                <th class="py-3 px-3">Kategori</th>
                                <th class="py-3 px-3">Judul Dokumen</th>
                                <th class="py-3 px-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @php $no = ($downloads->currentpage()-1)* $downloads->perpage() + 1; @endphp
                            @forelse($downloads as $download)
                                @php
                                    $linkdownload = berkas($download->file) ?: (file_exists(public_path('uploads/'.$download->file)) ? asset('uploads/'.$download->file) : '#');
                                    $ext = strtolower(pathinfo($download->file, PATHINFO_EXTENSION)) ?: 'pdf';
                                    $badgeColor = 'bg-red-50 text-red-600';
                                    if(in_array($ext, ['doc', 'docx'])) $badgeColor = 'bg-blue-50 text-blue-700';
                                    if(in_array($ext, ['xls', 'xlsx'])) $badgeColor = 'bg-emerald-50 text-emerald-700';
                                @endphp
                                <tr class="hover:bg-blue-50/40 transition">
                                    <td class="py-3 px-3 font-semibold text-slate-400">{{ $no++ }}</td>
                                    <td class="py-3 px-3">
                                        <span class="inline-block text-[10px] font-bold uppercase tracking-wider text-blue-700 bg-blue-50 px-2 py-0.5 rounded">
                                            {{ $download->dctitle ?: 'Dokumen' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-3">
                                        <a href="{{ $linkdownload }}" target="_blank" class="font-semibold text-slate-800 hover:text-blue-700 leading-snug block transition text-decoration-none">
                                            {{ $download->title }}
                                        </a>
                                        @if($download->content)
                                            <div class="text-[11px] text-slate-400 mt-0.5 line-clamp-1">{!! strip_tags($download->content) !!}</div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <a href="{{ $linkdownload }}" target="_blank" 
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-[11px] shadow-sm transition text-decoration-none">
                                            <i class="fas fa-download"></i> Unduh
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-slate-400">Tidak ada dokumen yang ditemukan.</td>
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
