@extends(getTheme('layouts.app'))
@section('title', 'Agenda Kegiatan')

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
            <span class="text-white font-semibold">Agenda Kegiatan</span>
        </nav>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    Agenda Kegiatan Bappeda
                </h1>
                <p class="text-xs sm:text-sm text-blue-100 mt-2 max-w-2xl">
                    Jadwal kegiatan rapat koordinasi, forum konsultasi publik, dan agenda dinas Bappeda Provinsi Lampung terintegrasi.
                </p>
            </div>
            <!-- Search Bar -->
            <form action="{{ url('agenda/all') }}" method="GET" class="w-full md:w-80">
                <div class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kegiatan atau lokasi..."
                           class="w-full bg-white/10 text-white placeholder-blue-200/70 border border-white/20 rounded-xl px-4 py-2 text-xs focus:outline-none focus:bg-white focus:text-slate-800 transition shadow-inner">
                    <button type="submit" class="absolute right-2.5 top-2 text-blue-200 hover:text-white">
                        <i class="fas fa-search text-xs"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Main Content (Tailwind CSS) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 font-sans">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Agenda List (8 cols) -->
        <div class="lg:col-span-8 space-y-4">
            @if(request('q'))
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 flex items-center justify-between text-xs text-blue-800">
                    <span>Hasil pencarian untuk: <strong>"{{ request('q') }}"</strong></span>
                    <a href="{{ url('agenda/all') }}" class="text-blue-600 hover:underline font-bold text-[11px]">Reset</a>
                </div>
            @endif

            @forelse($agendas as $agenda)
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between group">
                    <div class="flex items-start gap-3.5 min-w-0 flex-1">
                        <!-- Date Badge -->
                        <div class="w-14 h-14 rounded-xl flex flex-col items-center justify-center font-bold text-xs flex-shrink-0 shadow-sm"
                             style="background-color: #EFF6FF !important; border: 1px solid #BFDBFE !important;">
                            <span class="text-base font-black leading-none" style="color: #1A56DB !important;">{{ date('d', strtotime($agenda->start)) }}</span>
                            <span class="text-[9px] uppercase tracking-wider font-extrabold mt-1" style="color: #1A56DB !important;">{{ date('M', strtotime($agenda->start)) }}</span>
                        </div>

                        <div class="min-w-0 flex-1">
                            <!-- Category / Source Badges -->
                            <div class="flex flex-wrap items-center gap-1.5 mb-1.5">
                                @if(!empty($agenda->sumber_agenda))
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700">
                                        {{ $agenda->sumber_agenda }}
                                    </span>
                                @endif
                                @if(!empty($agenda->pakaian))
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600">
                                        <i class="fas fa-shirt text-[9px] mr-1 text-slate-400"></i>{{ $agenda->pakaian }}
                                    </span>
                                @endif
                            </div>

                            <h2 class="text-sm sm:text-base font-bold text-slate-800 group-hover:text-blue-700 leading-snug mb-2 transition">
                                <a href="{{ url('/detail-agenda/'.$agenda->seotitle) }}" class="text-slate-800 group-hover:text-blue-700 text-decoration-none">
                                    {{ $agenda->title }}
                                </a>
                            </h2>

                            <!-- Metadata Info Line -->
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500">
                                <span class="flex items-center gap-1.5">
                                    <i class="far fa-clock text-blue-600"></i> 
                                    <span>{{ date('H:i', strtotime($agenda->start)) }} WIB</span>
                                </span>
                                <span class="flex items-center gap-1.5 max-w-full">
                                    <i class="fas fa-location-dot text-rose-500 flex-shrink-0"></i> 
                                    <span class="truncate max-w-[280px]" title="{{ $agenda->display_location }}">
                                        {{ $agenda->display_location }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ url('/detail-agenda/'.$agenda->seotitle) }}" 
                       class="px-4 py-2 rounded-xl bg-slate-50 hover:bg-blue-600 hover:text-white text-slate-700 text-xs font-semibold transition flex-shrink-0 self-end sm:self-center text-decoration-none">
                        Detail <i class="fas fa-arrow-right text-[10px] ml-1"></i>
                    </a>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center text-slate-400 text-sm">
                    <i class="far fa-calendar-times text-3xl mb-2 text-slate-300 block"></i>
                    Tidak ada agenda kegiatan yang ditemukan.
                </div>
            @endforelse

            <div class="pt-6 flex justify-center w-full overflow-x-auto">
                {{ $agendas->onEachSide(1)->links() }}
            </div>
        </div>

        <!-- Sidebar (4 cols) -->
        <div class="lg:col-span-4">
            @include(getTheme('partials.sidebar'))
        </div>

    </div>
</div>

@endsection
