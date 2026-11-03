@extends(getTheme('layouts.app'))
@section('title', 'Album Galeri Foto')

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
            <span class="text-white font-semibold">Album Galeri</span>
        </nav>
        <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
            Dokumentasi & Galeri Foto
        </h1>
        <p class="text-xs sm:text-sm text-blue-100 mt-2 max-w-2xl">
            Kumpulan dokumentasi visual kegiatan, rapat koordinasi, musrenbang, dan program kerja Bappeda Provinsi Lampung.
        </p>
    </div>
</div>

<!-- Main Content (Tailwind CSS) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 font-sans">
    
    @if(count($albums) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($albums as $album)
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col group">
                    @php
                        $albumImg = $album->picture ? (berkas($album->picture) ?: url('berkas/' . $album->picture)) : url('berkas/no-image.jpg');
                    @endphp
                    <!-- Image Thumbnail with Overlay -->
                    <a href="{{ url('/detail-gallery/'.$album->seotitle) }}" class="relative block aspect-[4/3] bg-slate-100 overflow-hidden text-decoration-none">
                        <img src="{{ $albumImg }}" 
                             alt="{{ $album->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-between p-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm text-slate-800 text-[11px] font-bold shadow">
                                <i class="fas fa-images text-blue-600"></i> Lihat Album
                            </span>
                        </div>
                    </a>

                    <!-- Album Info -->
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="text-[10px] font-bold text-blue-600 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                                <i class="far fa-folder-open"></i> Album Dokumentasi
                            </div>
                            <h3 class="text-sm font-bold text-slate-800 group-hover:text-blue-700 leading-snug transition">
                                <a href="{{ url('/detail-gallery/'.$album->seotitle) }}" class="text-slate-800 group-hover:text-blue-700 text-decoration-none">
                                    {{ \Illuminate\Support\Str::limit($album->title, 120) }}
                                </a>
                            </h3>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-slate-400 text-[11px]">Bappeda Lampung</span>
                            <a href="{{ url('/detail-gallery/'.$album->seotitle) }}" 
                               class="text-blue-600 font-bold hover:text-blue-800 inline-flex items-center gap-1 text-[11px] text-decoration-none">
                                Buka Galeri <i class="fas fa-arrow-right text-[9px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10 flex justify-center">
            {!! $albums->render() !!}
        </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center text-slate-400 text-sm">
            <i class="fas fa-images text-4xl mb-3 text-slate-300 block"></i>
            Belum ada album foto yang diterbitkan.
        </div>
    @endif

</div>

@endsection
