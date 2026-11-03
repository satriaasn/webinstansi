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
        <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
            Agenda Kegiatan Bappeda
        </h1>
        <p class="text-xs sm:text-sm text-blue-100 mt-2 max-w-2xl">
            Jadwal kegiatan rapat koordinasi, forum konsultasi publik, dan agenda dinas Bappeda Provinsi Lampung.
        </p>
    </div>
</div>

<!-- Main Content (Tailwind CSS) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 font-sans">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Agenda List (8 cols) -->
        <div class="lg:col-span-8 space-y-4">
            @forelse($agendas as $agenda)
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between group">
                    <div class="flex items-start gap-3.5 min-w-0">
                        <div class="w-14 h-14 rounded-xl flex flex-col items-center justify-center font-bold text-xs flex-shrink-0 shadow-sm"
                             style="background-color: #EFF6FF !important; border: 1px solid #BFDBFE !important;">
                            <span class="text-base font-black leading-none" style="color: #1A56DB !important;">{{ date('d', strtotime($agenda->start)) }}</span>
                            <span class="text-[9px] uppercase tracking-wider font-extrabold mt-1" style="color: #1A56DB !important;">{{ date('M', strtotime($agenda->start)) }}</span>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-sm sm:text-base font-bold text-slate-800 group-hover:text-blue-700 leading-snug mb-1 transition">
                                <a href="{{ url('/detail-agenda/'.$agenda->seotitle) }}" class="text-slate-800 group-hover:text-blue-700 text-decoration-none">
                                    {{ $agenda->title }}
                                </a>
                            </h2>
                            <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500">
                                <span><i class="far fa-clock text-blue-600 mr-1"></i> {{ date('H:i', strtotime($agenda->start)) }} WIB</span>
                                <span><i class="fas fa-location-dot text-red-500 mr-1"></i> {{ strip_tags($agenda->content) ?: 'Ruang Rapat Utama Bappeda' }}</span>
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
                    Tidak ada agenda kegiatan.
                </div>
            @endforelse

            <div class="pt-4 flex justify-center">
                {{ $agendas->links() }}
            </div>
        </div>

        <!-- Sidebar (4 cols) -->
        <div class="lg:col-span-4">
            @include(getTheme('partials.sidebar'))
        </div>

    </div>
</div>

@endsection
