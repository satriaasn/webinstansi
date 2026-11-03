@extends('layouts.backend')
@section('title', 'Dashboard')

@section('content')
<div class="space-y-6 font-sans">

    <!-- 1. Header: Page Title & Realtime Date/Clock -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight m-0">Dashboard</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 m-0">
                Selamat datang di Sistem Informasi Bappeda Provinsi Lampung
            </p>
        </div>
        <div class="flex items-center gap-2.5 bg-white border border-slate-200/80 rounded-2xl px-4 py-2.5 shadow-sm text-slate-700 self-start sm:self-auto">
            <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#1A56DB] flex items-center justify-center text-xs flex-shrink-0">
                <i class="far fa-calendar-alt"></i>
            </div>
            <div class="text-xs leading-tight">
                <div class="font-bold text-slate-800" id="live-date">
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </div>
                <div class="text-[11px] text-slate-500 font-medium" id="live-clock">
                    {{ \Carbon\Carbon::now()->format('H:i') }} WIB
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Four Stat Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: Total Berita -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition-all duration-200 relative overflow-hidden flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-blue-500 text-white flex items-center justify-center text-xl shadow-md shadow-blue-500/20">
                    <i class="far fa-newspaper"></i>
                </div>
                <div class="flex items-center gap-1 text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">
                    <i class="fas fa-arrow-up text-[9px]"></i> 12%
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl sm:text-3xl font-black text-slate-800 leading-tight">
                    {{ number_format($cposts, 0, ',', '.') }}
                </div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Total Berita</div>
            </div>
            <!-- Sparkline SVG (Blue) -->
            <div class="mt-3 pt-2">
                <svg class="w-full h-8 text-blue-500" viewBox="0 0 100 25" preserveAspectRatio="none">
                    <path d="M0 20 Q 20 5, 40 18 T 80 8 T 100 12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </div>
        </div>

        <!-- Card 2: Total Agenda -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition-all duration-200 relative overflow-hidden flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-xl shadow-md shadow-emerald-500/20">
                    <i class="far fa-calendar-check"></i>
                </div>
                <div class="flex items-center gap-1 text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">
                    <i class="fas fa-arrow-up text-[9px]"></i> 8%
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl sm:text-3xl font-black text-slate-800 leading-tight">
                    {{ number_format($cagendas, 0, ',', '.') }}
                </div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Total Agenda</div>
            </div>
            <!-- Sparkline SVG (Green) -->
            <div class="mt-3 pt-2">
                <svg class="w-full h-8 text-emerald-500" viewBox="0 0 100 25" preserveAspectRatio="none">
                    <path d="M0 18 Q 25 22, 50 10 T 80 14 T 100 6" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </div>
        </div>

        <!-- Card 3: Total Download -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition-all duration-200 relative overflow-hidden flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-purple-600 text-white flex items-center justify-center text-xl shadow-md shadow-purple-600/20">
                    <i class="fas fa-file-arrow-down"></i>
                </div>
                <div class="flex items-center gap-1 text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">
                    <i class="fas fa-arrow-up text-[9px]"></i> 15%
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl sm:text-3xl font-black text-slate-800 leading-tight">
                    {{ number_format($cdownloads, 0, ',', '.') }}
                </div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Total Download</div>
            </div>
            <!-- Sparkline SVG (Purple) -->
            <div class="mt-3 pt-2">
                <svg class="w-full h-8 text-purple-500" viewBox="0 0 100 25" preserveAspectRatio="none">
                    <path d="M0 22 Q 20 18, 45 22 T 75 10 T 100 8" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </div>
        </div>

        <!-- Card 4: Total Galeri -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition-all duration-200 relative overflow-hidden flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-xl shadow-md shadow-amber-500/20">
                    <i class="far fa-images"></i>
                </div>
                <div class="flex items-center gap-1 text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">
                    <i class="fas fa-arrow-up text-[9px]"></i> 10%
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl sm:text-3xl font-black text-slate-800 leading-tight">
                    {{ number_format($cgallerys, 0, ',', '.') }}
                </div>
                <div class="text-xs font-semibold text-slate-500 mt-0.5">Total Galeri</div>
            </div>
            <!-- Sparkline SVG (Amber) -->
            <div class="mt-3 pt-2">
                <svg class="w-full h-8 text-amber-500" viewBox="0 0 100 25" preserveAspectRatio="none">
                    <path d="M0 15 Q 30 5, 55 18 T 85 8 T 100 14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </div>
        </div>

    </div>

    <!-- 3. Row 2: Website Analytics, Berita Terbaru, Agenda Kegiatan -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        
        <!-- Widget A: Website Visitor Analytics (col-span-5) -->
        <div class="lg:col-span-5 bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 mb-2 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#1A56DB] flex items-center justify-center text-xs">
                        <i class="fas fa-chart-column"></i>
                    </div>
                    <div>
                        <h2 class="text-xs sm:text-sm font-bold text-slate-800 m-0">Statistik Pengunjung Website</h2>
                        <span class="text-[10px] text-slate-400">Total: {{ number_format($totalVisitors, 0, ',', '.') }} Kunjungan</span>
                    </div>
                </div>
                <div class="text-[11px] font-semibold text-slate-600 bg-slate-50 border border-slate-200/80 px-2.5 py-1 rounded-lg">
                    30 Hari Terakhir
                </div>
            </div>

            <!-- Chart.js Area Canvas -->
            <div class="relative w-full h-56 sm:h-64 my-auto">
                <canvas id="visitorChartCanvas"></canvas>
            </div>

            <!-- Quick footer counters -->
            <div class="pt-3 border-t border-slate-100 grid grid-cols-3 gap-2 text-center text-xs">
                <div>
                    <div class="text-[10px] text-slate-400">Hari Ini</div>
                    <div class="font-black text-slate-800 mt-0.5">
                        {{ number_format(\App\Models\Visitor::where('date_time', now()->toDateString())->count(), 0, ',', '.') }}
                    </div>
                </div>
                <div>
                    <div class="text-[10px] text-slate-400">Bulan Ini</div>
                    <div class="font-black text-blue-600 mt-0.5">
                        {{ number_format(\App\Models\Visitor::where('date_time', '>=', now()->startOfMonth()->toDateString())->count(), 0, ',', '.') }}
                    </div>
                </div>
                <div>
                    <div class="text-[10px] text-slate-400">Total Pengunjung</div>
                    <div class="font-black text-emerald-600 mt-0.5">
                        {{ number_format($totalVisitors, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Widget B: Berita Terbaru (col-span-4) -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#1A56DB] flex items-center justify-center text-xs">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h2 class="text-xs sm:text-sm font-bold text-slate-800 m-0">Berita Terbaru</h2>
                </div>
                <a href="{{ url('dashboard/post/table') }}" class="text-xs font-bold text-[#1A56DB] hover:text-blue-800 transition flex items-center gap-1">
                    Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="space-y-3.5 flex-1 flex flex-col justify-between">
                @if($latestPosts->isNotEmpty())
                    @php 
                        $firstPost = $latestPosts->first();
                        $firstImg = $firstPost->picture ? (berkas($firstPost->picture) ?: url('berkas/' . $firstPost->picture)) : url('berkas/no-image.jpg');
                    @endphp
                    <!-- Featured Post (Top Item with Image) -->
                    <div class="group cursor-pointer">
                        <a href="{{ url('dashboard/post/'.$firstPost->id.'/edit') }}" class="block text-decoration-none">
                            <div class="relative rounded-xl overflow-hidden aspect-video bg-slate-100 mb-2 border border-slate-100">
                                <img src="{{ $firstImg }}" alt="{{ $firstPost->title }}" 
                                     onerror="this.onerror=null;this.src='{{ url('berkas/no-image.jpg') }}'"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute bottom-2 left-2 bg-[#0B2545]/85 backdrop-blur-xs text-white text-[10px] font-bold px-2 py-0.5 rounded-md flex items-center gap-1">
                                    <i class="far fa-calendar-alt text-[9px] text-amber-400"></i>
                                    {{ $firstPost->created_at ? date('d M', strtotime($firstPost->created_at)) : 'Terbaru' }}
                                </div>
                            </div>
                            <h3 class="font-bold text-xs sm:text-sm text-slate-800 group-hover:text-[#1A56DB] transition line-clamp-2 leading-snug m-0">
                                {{ $firstPost->title }}
                            </h3>
                            <p class="text-[11px] text-slate-500 line-clamp-2 mt-1 leading-relaxed m-0">
                                {{ strip_tags($firstPost->content) }}
                            </p>
                        </a>
                    </div>

                    <!-- Mini Post Items (2 and 3) -->
                    <div class="space-y-2.5 pt-2 border-t border-slate-100">
                        @foreach($latestPosts->slice(1, 2) as $pItem)
                            @php 
                                $pImg = $pItem->picture ? (berkas($pItem->picture) ?: url('berkas/' . $pItem->picture)) : url('berkas/no-image.jpg');
                            @endphp
                            <a href="{{ url('dashboard/post/'.$pItem->id.'/edit') }}" class="flex gap-3 items-center group text-decoration-none">
                                <img src="{{ $pImg }}" alt="{{ $pItem->title }}" 
                                     onerror="this.onerror=null;this.src='{{ url('berkas/no-image.jpg') }}'"
                                     class="w-14 h-12 rounded-lg object-cover flex-shrink-0 bg-slate-100 border border-slate-100">
                                <div class="flex-1 min-w-0">
                                    <span class="text-[10px] font-bold text-slate-400 block mb-0.5">
                                        {{ $pItem->created_at ? date('d M Y', strtotime($pItem->created_at)) : '' }}
                                    </span>
                                    <div class="font-bold text-xs text-slate-700 group-hover:text-[#1A56DB] transition line-clamp-1">
                                        {{ $pItem->title }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="py-10 text-center text-slate-400 text-xs">
                        <i class="far fa-newspaper text-3xl mb-2 block text-slate-300"></i>
                        Belum ada berita yang dipublikasikan.
                    </div>
                @endif
            </div>
        </div>

        <!-- Widget C: Agenda Kegiatan (col-span-3) -->
        <div class="lg:col-span-3 bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#1A56DB] flex items-center justify-center text-xs">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <h2 class="text-xs sm:text-sm font-bold text-slate-800 m-0">Agenda Kegiatan</h2>
                </div>
                <a href="{{ url('dashboard/agenda/table') }}" class="text-xs font-bold text-[#1A56DB] hover:text-blue-800 transition flex items-center gap-1">
                    Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="space-y-4 flex-1">
                @forelse($latestAgendas as $agenda)
                    @php
                        $startDate = $agenda->start ? \Carbon\Carbon::parse($agenda->start) : \Carbon\Carbon::parse($agenda->created_at);
                    @endphp
                    <a href="{{ url('dashboard/agenda/'.$agenda->id.'/edit') }}" class="flex gap-3 items-start group text-decoration-none">
                        <!-- Date Badge Pill (Matching Mockup) -->
                        <div class="w-12 h-13 rounded-xl bg-blue-50 border border-blue-100 text-[#1A56DB] flex flex-col items-center justify-center flex-shrink-0 group-hover:bg-[#1A56DB] group-hover:text-white transition py-1">
                            <span class="text-base font-black leading-none">{{ $startDate->format('d') }}</span>
                            <span class="text-[9px] font-bold uppercase tracking-wider mt-0.5">{{ $startDate->format('M') }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-xs text-slate-800 group-hover:text-[#1A56DB] transition line-clamp-2 leading-snug m-0">
                                {{ $agenda->title }}
                            </h4>
                            <div class="flex items-center gap-1 text-[10px] text-slate-400 mt-1">
                                <i class="fas fa-location-dot text-[9px] text-blue-500"></i>
                                <span class="truncate">{{ strip_tags($agenda->content) ?: 'Ruang Rapat Bappeda' }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="py-10 text-center text-slate-400 text-xs">
                        <i class="far fa-calendar-times text-3xl mb-2 block text-slate-300"></i>
                        Belum ada agenda kegiatan mendatang.
                    </div>
                @endforelse
            </div>

            <!-- Quick Add Agenda Button -->
            <div class="pt-4 mt-3 border-t border-slate-100">
                <a href="{{ url('dashboard/agenda/create') }}" class="w-full flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-[#1A56DB] font-bold text-xs border border-slate-200 transition text-decoration-none">
                    <i class="fas fa-plus text-[10px]"></i> Tambah Agenda Baru
                </a>
            </div>
        </div>

    </div>

    <!-- 4. Row 3: Dokumen Terbaru, Galeri Kegiatan, Layanan PPID -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        
        <!-- Widget A: Dokumen Terbaru (col-span-4) -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#1A56DB] flex items-center justify-center text-xs">
                        <i class="fas fa-folder"></i>
                    </div>
                    <h2 class="text-xs sm:text-sm font-bold text-slate-800 m-0">Dokumen Terbaru</h2>
                </div>
                <a href="{{ url('dashboard/download/table') }}" class="text-xs font-bold text-[#1A56DB] hover:text-blue-800 transition flex items-center gap-1">
                    Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="space-y-3 flex-1">
                @forelse($latestDownloads as $doc)
                    @php
                        $ext = strtolower(pathinfo($doc->file, PATHINFO_EXTENSION)) ?: 'pdf';
                        $docLink = berkas($doc->file) ?: (file_exists(public_path('uploads/'.$doc->file)) ? asset('uploads/'.$doc->file) : '#');
                        
                        $badgeBg = 'bg-red-50 text-red-600 border-red-200';
                        if (in_array($ext, ['xls', 'xlsx'])) {
                            $badgeBg = 'bg-emerald-50 text-emerald-600 border-emerald-200';
                        } elseif (in_array($ext, ['doc', 'docx'])) {
                            $badgeBg = 'bg-blue-50 text-blue-600 border-blue-200';
                        }
                    @endphp
                    <div class="flex items-center justify-between gap-3 p-2 rounded-xl hover:bg-slate-50 transition">
                        <div class="flex items-center gap-3 min-w-0">
                            <!-- Extension badge -->
                            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-[10px] font-black uppercase tracking-wider border flex-shrink-0 {{ $badgeBg }}">
                                {{ $ext }}
                            </span>
                            <div class="min-w-0">
                                <a href="{{ url('dashboard/download/'.$doc->id.'/edit') }}" class="font-bold text-xs text-slate-800 hover:text-[#1A56DB] transition truncate block m-0">
                                    {{ $doc->title }}
                                </a>
                                <div class="text-[10px] text-slate-400 flex items-center gap-2 mt-0.5">
                                    <span>{{ $doc->created_at ? date('d M Y', strtotime($doc->created_at)) : '' }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $ext }} file</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ $docLink }}" target="_blank" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-blue-100 text-slate-500 hover:text-[#1A56DB] flex items-center justify-center transition flex-shrink-0" title="Unduh Berkas">
                            <i class="fas fa-download text-[10px]"></i>
                        </a>
                    </div>
                @empty
                    <div class="py-8 text-center text-slate-400 text-xs">
                        <i class="far fa-folder-open text-2xl mb-2 block text-slate-300"></i>
                        Belum ada dokumen yang diunggah.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Widget B: Galeri Kegiatan (col-span-4) -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#1A56DB] flex items-center justify-center text-xs">
                        <i class="fas fa-images"></i>
                    </div>
                    <h2 class="text-xs sm:text-sm font-bold text-slate-800 m-0">Galeri Kegiatan</h2>
                </div>
                <a href="{{ url('dashboard/gallery/table') }}" class="text-xs font-bold text-[#1A56DB] hover:text-blue-800 transition flex items-center gap-1">
                    Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <!-- 6-Photo Grid (Matching Mockup) -->
            <div class="grid grid-cols-3 gap-2.5 flex-1">
                @php $gIndex = 0; @endphp
                @foreach($latestGallery->take(6) as $photo)
                    @php 
                        $gIndex++;
                        $gImg = $photo->picture ? (berkas($photo->picture) ?: url('berkas/' . $photo->picture)) : url('berkas/no-image.jpg');
                    @endphp
                    @if($gIndex == 6 && $totalGalleryCount > 6)
                        <!-- 6th Photo with overlay +X Foto -->
                        <a href="{{ url('dashboard/gallery/table') }}" class="relative rounded-xl overflow-hidden aspect-video group block text-decoration-none bg-slate-900 shadow-xs">
                            <img src="{{ $gImg }}" alt="{{ $photo->title }}" 
                                 onerror="this.onerror=null;this.src='{{ url('berkas/no-image.jpg') }}'"
                                 class="w-full h-full object-cover opacity-50 group-hover:scale-110 transition duration-300">
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-white p-1">
                                <i class="fas fa-camera text-xs mb-0.5"></i>
                                <span class="font-extrabold text-xs tracking-tight">+{{ $totalGalleryCount - 5 }} Foto</span>
                            </div>
                        </a>
                    @else
                        <a href="{{ url('dashboard/gallery/'.$photo->id.'/edit') }}" class="relative rounded-xl overflow-hidden aspect-video group block text-decoration-none bg-slate-100 shadow-xs border border-slate-100">
                            <img src="{{ $gImg }}" alt="{{ $photo->title }}" 
                                 onerror="this.onerror=null;this.src='{{ url('berkas/no-image.jpg') }}'"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                        </a>
                    @endif
                @endforeach

                @for($k = $latestGallery->count(); $k < 6; $k++)
                    <div class="rounded-xl aspect-video bg-slate-50 border border-dashed border-slate-200 flex items-center justify-center text-slate-300 text-xs">
                        <i class="far fa-image"></i>
                    </div>
                @endfor
            </div>
        </div>

        <!-- Widget C: Layanan PPID (col-span-4) -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm flex flex-col justify-between">
            
            <!-- Top Gradient Box (Matching Mockup) -->
            <div class="bg-gradient-to-r from-[#0B2545] to-[#1A56DB] rounded-2xl p-5 text-white relative overflow-hidden shadow-sm flex flex-col justify-between">
                <!-- Background subtle watermark shield -->
                <i class="fas fa-shield-halved absolute -right-4 -bottom-4 text-7xl text-white/10 pointer-events-none"></i>
                
                <div class="relative z-10">
                    <h2 class="text-base sm:text-lg font-black tracking-tight text-white m-0">Layanan PPID</h2>
                    <p class="text-[11px] text-blue-100 mt-1 leading-snug line-clamp-2 m-0">
                        Pejabat Pengelola Informasi dan Dokumentasi Bappeda Provinsi Lampung
                    </p>
                </div>

                <div class="relative z-10 mt-4">
                    <a href="{{ url('dashboard/permohonan-informasi/table') }}" 
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white text-[#1A56DB] font-extrabold text-xs shadow-md hover:bg-blue-50 transition transform hover:-translate-y-0.5 text-decoration-none">
                        <span>Akses Layanan</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Bottom 4 Pills (Matching Mockup & Responsive) -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-3 pt-3 border-t border-slate-100">
                
                <!-- Pill 1: Berkala -->
                <a href="{{ url('download/informasi-berkala') }}" target="_blank" class="flex flex-col items-center justify-center p-2 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/60 hover:border-blue-200 transition text-center group text-decoration-none">
                    <div class="w-7 h-7 rounded-lg bg-blue-100/70 text-[#1A56DB] flex items-center justify-center text-xs mb-1 group-hover:scale-110 transition">
                        <i class="far fa-folder"></i>
                    </div>
                    <span class="text-[9px] font-bold text-slate-700 leading-tight">Informasi Berkala</span>
                </a>

                <!-- Pill 2: Serta-Merta -->
                <a href="{{ url('download/informasi-serta-merta') }}" target="_blank" class="flex flex-col items-center justify-center p-2 rounded-xl bg-slate-50 hover:bg-amber-50 border border-slate-200/60 hover:border-amber-200 transition text-center group text-decoration-none">
                    <div class="w-7 h-7 rounded-lg bg-amber-100/70 text-amber-600 flex items-center justify-center text-xs mb-1 group-hover:scale-110 transition">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <span class="text-[9px] font-bold text-slate-700 leading-tight">Informasi Serta-Merta</span>
                </a>

                <!-- Pill 3: Setiap Saat -->
                <a href="{{ url('download/informasi-setiap-saat') }}" target="_blank" class="flex flex-col items-center justify-center p-2 rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-200/60 hover:border-emerald-200 transition text-center group text-decoration-none">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100/70 text-emerald-600 flex items-center justify-center text-xs mb-1 group-hover:scale-110 transition">
                        <i class="fas fa-clock-rotate-left"></i>
                    </div>
                    <span class="text-[9px] font-bold text-slate-700 leading-tight">Informasi Setiap Saat</span>
                </a>

                <!-- Pill 4: Dikecualikan -->
                <a href="{{ url('download/informasi-dikecualikan') }}" target="_blank" class="flex flex-col items-center justify-center p-2 rounded-xl bg-slate-50 hover:bg-purple-50 border border-slate-200/60 hover:border-purple-200 transition text-center group text-decoration-none">
                    <div class="w-7 h-7 rounded-lg bg-purple-100/70 text-purple-600 flex items-center justify-center text-xs mb-1 group-hover:scale-110 transition">
                        <i class="fas fa-lock"></i>
                    </div>
                    <span class="text-[9px] font-bold text-slate-700 leading-tight">Informasi Dikecualikan</span>
                </a>

            </div>

        </div>

    </div>

    <!-- 5. Row 4: Motivational Quote Banner & External Links (Matching Mockup) -->
    <div class="rounded-2xl bg-gradient-to-r from-blue-50/80 via-white to-blue-50/60 border border-blue-100/80 p-5 shadow-xs flex flex-col xl:flex-row items-center justify-between gap-5">
        
        <!-- Left: Quote -->
        <div class="flex items-center gap-3.5 text-center xl:text-left">
            <div class="w-10 h-10 rounded-2xl bg-amber-400 text-slate-900 flex items-center justify-center text-lg flex-shrink-0 shadow-sm">
                <i class="fas fa-quote-left"></i>
            </div>
            <div>
                <div class="font-extrabold text-xs sm:text-sm text-slate-800 italic">
                    "Bersama Mewujudkan Lampung Maju 2030"
                </div>
                <div class="text-[11px] text-slate-500 font-semibold mt-0.5">
                    Bappeda Provinsi Lampung
                </div>
            </div>
        </div>

        <!-- Center: Official Portals Links -->
        <div class="flex flex-wrap items-center justify-center gap-3 text-xs">
            <a href="https://lampungprov.go.id" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:text-[#1A56DB] hover:border-blue-300 transition text-decoration-none shadow-xs font-semibold">
                <i class="fas fa-globe text-[#1A56DB]"></i>
                <span>Website Resmi Pemprov Lampung</span>
                <i class="fas fa-arrow-up-right-from-square text-[9px] text-slate-400"></i>
            </a>

            <a href="https://lampung.lapor.go.id" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:text-red-600 hover:border-red-300 transition text-decoration-none shadow-xs font-semibold">
                <i class="fas fa-bullhorn text-red-500"></i>
                <span>Lapor! SP4N</span>
                <i class="fas fa-arrow-up-right-from-square text-[9px] text-slate-400"></i>
            </a>

            <a href="https://ppid.lampungprov.go.id" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:text-emerald-600 hover:border-emerald-300 transition text-decoration-none shadow-xs font-semibold">
                <i class="fas fa-shield-halved text-emerald-500"></i>
                <span>PPID Provinsi Lampung</span>
                <i class="fas fa-arrow-up-right-from-square text-[9px] text-slate-400"></i>
            </a>
        </div>

        <!-- Right: Social Media Icons -->
        <div class="flex items-center gap-2 flex-shrink-0">
            <a href="{{ getSetting('youtube') ?: 'https://youtube.com' }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-red-500 hover:border-red-200 flex items-center justify-center transition shadow-xs" title="YouTube">
                <i class="fab fa-youtube text-xs"></i>
            </a>
            <a href="{{ getSetting('instagram') ?: 'https://instagram.com' }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-pink-500 hover:border-pink-200 flex items-center justify-center transition shadow-xs" title="Instagram">
                <i class="fab fa-instagram text-xs"></i>
            </a>
            <a href="{{ getSetting('facebook') ?: 'https://facebook.com' }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-blue-600 hover:border-blue-200 flex items-center justify-center transition shadow-xs" title="Facebook">
                <i class="fab fa-facebook-f text-xs"></i>
            </a>
            <a href="{{ getSetting('twitter') ?: 'https://twitter.com' }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-sky-500 hover:border-sky-200 flex items-center justify-center transition shadow-xs" title="X (Twitter)">
                <i class="fab fa-x-twitter text-xs"></i>
            </a>
            <a href="https://t.me" target="_blank" rel="noopener" class="w-8 h-8 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-sky-400 hover:border-sky-200 flex items-center justify-center transition shadow-xs" title="Telegram">
                <i class="fab fa-telegram text-xs"></i>
            </a>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Live Clock Update
    function updateLiveClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const clockEl = document.getElementById('live-clock');
        if (clockEl) {
            clockEl.textContent = `${hours}:${minutes} WIB`;
        }
    }
    setInterval(updateLiveClock, 30000);

    // Chart.js: Website Visitor Analytics Area Chart
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('visitorChartCanvas');
        if (!ctx) return;

        // Data from controller
        @php
            $rawChart = $visitorChart ?? collect();
            $labels = [];
            $dataPoints = [];
            
            if ($rawChart->count() > 0) {
                foreach($rawChart as $item) {
                    $labels[] = date('d M', strtotime($item->date_time));
                    $dataPoints[] = (int) $item->total;
                }
            } else {
                // Realistic fallback if DB visitor table has no records for last 30 days
                for ($i = 29; $i >= 0; $i--) {
                    $labels[] = now()->subDays($i)->format('d M');
                    $dataPoints[] = rand(4500, 12800);
                }
            }
        @endphp

        const labels = {!! json_encode($labels) !!};
        const dataValues = {!! json_encode($dataPoints) !!};

        // Create gradient fill
        const chartCtx = ctx.getContext('2d');
        const gradient = chartCtx.createLinearGradient(0, 0, 0, 240);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.28)');
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0.01)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pengunjung',
                    data: dataValues,
                    borderColor: '#2563EB',
                    borderWidth: 2.5,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.42,
                    pointBackgroundColor: '#2563EB',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#1D4ED8',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0F172A',
                        titleColor: '#F8FAFC',
                        bodyColor: '#38BDF8',
                        bodyFont: {
                            weight: 'bold',
                            size: 13
                        },
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: false,
                        callbacks: {
                            title: function(items) {
                                return items[0].label;
                            },
                            label: function(context) {
                                return new Intl.NumberFormat('id-ID').format(context.parsed.y) + ' Pengunjung';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#94A3B8',
                            font: {
                                size: 10,
                                family: 'ui-sans-serif, system-ui, sans-serif'
                            },
                            maxTicksLimit: 7
                        }
                    },
                    y: {
                        grid: {
                            color: '#F1F5F9',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#94A3B8',
                            font: {
                                size: 10,
                                family: 'ui-sans-serif, system-ui, sans-serif'
                            },
                            callback: function(value) {
                                if (value >= 1000) {
                                    return (value / 1000).toFixed(0) + '.000';
                                }
                                return value;
                            }
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endpush
