@extends(getTheme('layouts.app'))
@section('title', 'Galeri Video Multimedia')

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
            <span class="text-white font-semibold">Galeri Video</span>
        </nav>
        <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
            Galeri Video & Publikasi Audio Visual
        </h1>
        <p class="text-xs sm:text-sm text-blue-100 mt-2 max-w-2xl">
            Kumpulan video liputan program, sosialisasi perencanaan pembangunan daerah, dan tayangan publikasi resmi Bappeda Provinsi Lampung.
        </p>
    </div>
</div>

<!-- Main Content (Tailwind CSS) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 font-sans">
    
    @if(count($videos) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($videos as $video)
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col group">
                    <!-- Video Thumbnail with Play Button Overlay -->
                    <div class="relative aspect-video bg-slate-900 overflow-hidden cursor-pointer"
                         onclick="openVideoModal('{{ $video->youtube_id }}', '{{ addslashes($video->title) }}')">
                        <img src="https://i.ytimg.com/vi/{{ $video->youtube_id }}/hqdefault.jpg" 
                             alt="{{ $video->title }}"
                             onerror="this.src='{{ asset('assets/images/lampung_hero_banner.jpg') }}'"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90 group-hover:opacity-100">
                        
                        <!-- Red Play Button -->
                        <div class="absolute inset-0 bg-slate-950/30 group-hover:bg-slate-950/10 transition flex items-center justify-center">
                            <span class="w-14 h-14 rounded-full bg-red-600 text-white flex items-center justify-center shadow-xl group-hover:scale-110 group-hover:bg-red-700 transition transform">
                                <i class="fas fa-play text-lg ml-1"></i>
                            </span>
                        </div>

                        <!-- Duration or Platform Badge -->
                        <div class="absolute bottom-2.5 right-2.5 px-2 py-0.5 rounded bg-black/75 text-[10px] font-bold text-white flex items-center gap-1">
                            <i class="fab fa-youtube text-red-500"></i> YouTube
                        </div>
                    </div>

                    <!-- Video Info -->
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="text-[10px] font-bold text-red-600 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                                <i class="fas fa-circle text-[8px] animate-pulse"></i> Video Bappeda
                            </div>
                            <h3 class="text-sm font-bold text-slate-800 group-hover:text-blue-700 leading-snug line-clamp-2 transition cursor-pointer"
                                onclick="openVideoModal('{{ $video->youtube_id }}', '{{ addslashes($video->title) }}')">
                                {{ $video->title }}
                            </h3>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-slate-400 text-[11px]">Bappeda Lampung TV</span>
                            <button onclick="openVideoModal('{{ $video->youtube_id }}', '{{ addslashes($video->title) }}')"
                                    class="text-blue-600 font-bold hover:text-blue-800 inline-flex items-center gap-1 text-[11px]">
                                Putar Video <i class="fas fa-circle-play text-[10px]"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10 flex justify-center">
            {!! $videos->render() !!}
        </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center text-slate-400 text-sm">
            <i class="fas fa-video text-4xl mb-3 text-slate-300 block"></i>
            Belum ada video yang dipublikasikan.
        </div>
    @endif

</div>

<!-- Video Player Modal -->
<div id="videoModal" class="fixed inset-0 z-50 bg-slate-950/85 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl w-full bg-slate-900 rounded-2xl overflow-hidden shadow-2xl border border-white/10">
        <!-- Close Button -->
        <button onclick="closeVideoModal()" 
                class="absolute top-3 right-3 z-10 w-9 h-9 rounded-full bg-white/20 hover:bg-white/40 text-white flex items-center justify-center transition">
            <i class="fas fa-times text-sm"></i>
        </button>
        <!-- Modal Video Iframe -->
        <div class="aspect-video w-full bg-black">
            <iframe id="videoIframe" class="w-full h-full" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <!-- Modal Caption -->
        <div class="p-4 bg-slate-900 text-white text-xs sm:text-sm font-semibold border-t border-white/10" id="videoCaption">
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openVideoModal(youtubeId, caption) {
        document.getElementById('videoIframe').src = 'https://www.youtube.com/embed/' + youtubeId + '?autoplay=1';
        document.getElementById('videoCaption').innerText = caption;
        document.getElementById('videoModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeVideoModal() {
        document.getElementById('videoIframe').src = '';
        document.getElementById('videoModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.getElementById('videoModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeVideoModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeVideoModal();
        }
    });
</script>
@endpush
