@extends(getTheme('layouts.app'))
@section('title', $agenda->title)

@push('meta')
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($agenda->title), 250) }}"/>
    <meta property="og:title" content="@yield('title') - {{ getSetting('web_name') }}"/>
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($agenda->content), 250) }}"/>
    <meta property="og:image" content="{{ berkas( getSetting('logo')) }}"/>
    <meta property="og:image:secure_url" content="{{ berkas( getSetting('logo')) }}"/>
    <meta property="og:image:width" content="100"/>
    <meta property="og:image:height" content="100"/>
@endpush

@section('content')

<!-- Header Breadcrumb Banner (Tailwind CSS) -->
<div class="bg-gradient-to-r from-[#0B2545] to-blue-900 text-white py-10 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-blue-200 mb-3">
            <a href="{{ url('') }}" class="hover:text-white transition flex items-center gap-1"><i class="fas fa-home"></i> Beranda</a>
            <i class="fas fa-chevron-right text-[9px] text-blue-300"></i>
            <a href="{{ url('agenda/all') }}" class="hover:text-white transition">Agenda Kegiatan</a>
            <i class="fas fa-chevron-right text-[9px] text-blue-300"></i>
            <span class="text-white font-semibold">Detail Kegiatan</span>
        </nav>
        <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white max-w-4xl leading-tight">
            {{ $agenda->title }}
        </h1>
    </div>
</div>

<!-- Main Content (Tailwind CSS) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 font-sans">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Agenda Detail Body (8 cols) -->
        <article class="lg:col-span-8 space-y-6">
            
            <!-- Quick Info Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-sm">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex items-start gap-3.5 p-3.5 rounded-xl bg-blue-50/70 border border-blue-100">
                        <div class="w-10 h-10 rounded-lg bg-blue-600 text-white flex items-center justify-center flex-shrink-0">
                            <i class="far fa-calendar text-base"></i>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-blue-600 uppercase tracking-wider mb-0.5">Waktu & Jadwal</div>
                            <div class="text-xs font-bold text-slate-800">
                                {{ date('d F Y', strtotime($agenda->start)) }}
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                Pukul {{ date('H:i', strtotime($agenda->start)) }} WIB
                                @if($agenda->end && $agenda->end != $agenda->start)
                                    s.d. {{ date('H:i', strtotime($agenda->end)) }} WIB
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5 p-3.5 rounded-xl bg-amber-50/70 border border-amber-100">
                        <div class="w-10 h-10 rounded-lg bg-amber-600 text-white flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-location-dot text-base"></i>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-amber-700 uppercase tracking-wider mb-0.5">Lokasi / Tempat</div>
                            <div class="text-xs font-bold text-slate-800">
                                Kantor Bappeda Provinsi Lampung
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                Ruang Rapat / Aula Gedung Bappeda
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Details Content -->
                <div class="mt-6 pt-6 border-t border-slate-100">
                    <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <i class="fas fa-circle-info text-blue-600"></i> Deskripsi & Rincian Agenda
                    </h2>
                    <div class="prose max-w-none text-slate-700 text-xs sm:text-sm leading-relaxed space-y-3">
                        {!! $agenda->content ?: '<p class="text-slate-400 italic">Tidak ada catatan tambahan untuk agenda ini.</p>' !!}
                    </div>
                </div>

                <!-- Action Button Back -->
                <div class="mt-8 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ url('agenda/all') }}" class="inline-flex items-center gap-2 text-xs font-bold text-blue-700 hover:text-blue-900 transition text-decoration-none">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Agenda
                    </a>
                    <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-xs text-slate-600 hover:bg-slate-50 transition">
                        <i class="fas fa-print"></i> Cetak Agenda
                    </button>
                </div>
            </div>

        </article>

        <!-- Sidebar (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            @include(getTheme('partials.sidebar'))
        </div>

    </div>
</div>

@endsection
