@extends(getTheme('layouts.app'))
@section('title', 'Pencarian: ' . ucfirst($query))

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
            <span class="text-white font-semibold">Pencarian</span>
        </nav>
        <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
            Hasil Pencarian: <span class="text-yellow-400">"{{ $query }}"</span>
        </h1>
        <p class="text-xs sm:text-sm text-blue-100 mt-2 max-w-2xl">
            Ditemukan {{ count($contents) }} artikel berita dan {{ count($downloads) }} berkas dokumen yang cocok dengan kata kunci pencarian Anda.
        </p>

        <!-- Inline Search Form -->
        <div class="mt-6 max-w-xl">
            <form action="{{ url('home/search') }}" method="GET" class="relative flex items-center">
                <input type="text" name="query" value="{{ $query }}" required
                       placeholder="Cari berita, agenda, atau dokumen..."
                       class="w-full pl-4 pr-24 py-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-white placeholder-blue-200 text-xs sm:text-sm focus:outline-none focus:bg-white focus:text-slate-800 focus:ring-2 focus:ring-yellow-400 transition shadow-inner">
                <button type="submit"
                        class="absolute right-1.5 px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-slate-900 font-bold text-xs rounded-xl transition shadow">
                    <i class="fas fa-search mr-1"></i> Cari
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Main Content (Tailwind CSS) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 font-sans">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Search Results (8 cols) -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Section 1: Berita / Konten -->
            <div>
                <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-200">
                    <h2 class="text-base sm:text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-newspaper text-blue-700"></i> Berita & Artikel Terkait
                    </h2>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                        {{ count($contents) }} Hasil
                    </span>
                </div>

                @if(count($contents) > 0)
                    <div class="space-y-4">
                        @foreach($contents as $content)
                            <article class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 shadow-sm hover:shadow-md transition flex flex-col sm:flex-row gap-4 items-start group">
                                @if(!empty($content->picture))
                                    <div class="w-full sm:w-44 h-32 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                                        <img src="{{ berkas($content->picture) }}" 
                                             alt="{{ $content->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-2 text-[11px] text-slate-500">
                                        @if($content->ctitle)
                                            <span class="px-2 py-0.5 rounded font-bold uppercase tracking-wider bg-blue-50 text-blue-700">
                                                {{ $content->ctitle }}
                                            </span>
                                        @endif
                                        <span><i class="far fa-clock text-slate-400 mr-1"></i> {{ $content->created_at ? $content->created_at->diffForHumans() : '' }}</span>
                                        <span><i class="far fa-eye text-slate-400 mr-1"></i> {{ $content->hit }} kali dilihat</span>
                                    </div>

                                    <h3 class="text-sm sm:text-base font-bold text-slate-800 group-hover:text-blue-700 leading-snug mb-2 transition">
                                        <a href="{{ url('/detail-post/'.$content->seotitle) }}" class="text-slate-800 group-hover:text-blue-700 text-decoration-none">
                                            {{ $content->title }}
                                        </a>
                                    </h3>

                                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                        {{ strip_tags($content->content) }}
                                    </p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-8 text-center text-slate-400 text-xs">
                        <i class="fas fa-file-circle-xmark text-3xl mb-2 text-slate-300 block"></i>
                        Tidak ditemukan artikel berita untuk kata kunci "<strong>{{ $query }}</strong>".
                    </div>
                @endif
            </div>

            <!-- Section 2: Dokumen & Unduhan -->
            <div>
                <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-200">
                    <h2 class="text-base sm:text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-file-lines text-emerald-700"></i> Dokumen Publikasi & Perencanaan
                    </h2>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                        {{ count($downloads) }} Hasil
                    </span>
                </div>

                @if(count($downloads) > 0)
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-600">
                            <thead>
                                <tr class="border-b border-slate-200 text-slate-800 text-[11px] font-bold uppercase tracking-wider bg-slate-50">
                                    <th class="py-3 px-3">No.</th>
                                    <th class="py-3 px-3">Kategori</th>
                                    <th class="py-3 px-3">Nama Berkas / Dokumen</th>
                                    <th class="py-3 px-3 text-center">Unduh</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($downloads as $download)
                                    @php
                                        $linkdownload = berkas($download->file) ?: (file_exists(public_path('uploads/'.$download->file)) ? asset('uploads/'.$download->file) : '#');
                                        $ext = strtolower(pathinfo($download->file, PATHINFO_EXTENSION)) ?: 'pdf';
                                    @endphp
                                    <tr class="hover:bg-blue-50/40 transition">
                                        <td class="py-3 px-3 font-semibold text-slate-400">{{ $loop->iteration }}</td>
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
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-[11px] transition shadow-sm text-decoration-none">
                                                <i class="fas fa-download text-[10px]"></i> Unduh
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-8 text-center text-slate-400 text-xs">
                        <i class="fas fa-folder-open text-3xl mb-2 text-slate-300 block"></i>
                        Tidak ditemukan berkas dokumen untuk kata kunci "<strong>{{ $query }}</strong>".
                    </div>
                @endif
            </div>

        </div>

        <!-- Sidebar (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            @include(getTheme('partials.sidebar'))
        </div>

    </div>
</div>

@endsection
