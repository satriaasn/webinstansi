@extends(getTheme('layouts.app'))
@section('title', 'Galeri ' . $album->title)

@push('meta')
    <meta name="description" content="{{ $album->title }}"/>
    <meta property="og:title" content="@yield('title')"/>
    <meta property="og:description" content="{{ getSetting('web_description') }}"/>
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
            <a href="{{ url('album/all') }}" class="hover:text-white transition">Album Galeri</a>
            <i class="fas fa-chevron-right text-[9px] text-blue-300"></i>
            <span class="text-white font-semibold">{{ $album->title }}</span>
        </nav>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white leading-tight">
                    {{ $album->title }}
                </h1>
                <p class="text-xs sm:text-sm text-blue-100 mt-2 max-w-2xl">
                    Dokumentasi visual foto kegiatan pada album {{ $album->title }}.
                </p>
            </div>
            <a href="{{ url('album/all') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white border border-white/20 text-xs font-semibold backdrop-blur-sm transition self-start sm:self-center text-decoration-none">
                <i class="fas fa-arrow-left text-[10px]"></i> Semua Album
            </a>
        </div>
    </div>
</div>

<!-- Main Content (Tailwind CSS) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 font-sans">
    
    @if(count($gallerys) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach($gallerys as $gallery)
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col group">
                    <!-- Photo Container -->
                    @php
                        $galImg = $gallery->picture ? (berkas($gallery->picture) ?: url('berkas/' . $gallery->picture)) : url('berkas/no-image.jpg');
                    @endphp
                    <div class="relative aspect-square bg-slate-100 overflow-hidden cursor-pointer"
                         onclick="openModal('{{ $galImg }}', '{{ addslashes($gallery->title) }}')">
                        <img src="{{ $galImg }}" 
                             alt="{{ $gallery->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        
                        <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="w-10 h-10 rounded-full bg-white/90 text-slate-800 flex items-center justify-center shadow-lg transform scale-90 group-hover:scale-100 transition">
                                <i class="fas fa-magnifying-glass-plus text-sm"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Photo Caption -->
                    @if(!empty($gallery->title))
                        <div class="p-3 bg-white">
                            <p class="text-xs text-slate-700 font-medium line-clamp-2 leading-snug">
                                {{ $gallery->title }}
                            </p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10 flex justify-center">
            {!! $gallerys->render() !!}
        </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center text-slate-400 text-sm">
            <i class="fas fa-camera text-4xl mb-3 text-slate-300 block"></i>
            Belum ada foto dalam album ini.
        </div>
    @endif

</div>

<!-- Image Lightbox Modal -->
<div id="imageModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl w-full bg-slate-900 rounded-2xl overflow-hidden shadow-2xl border border-white/10">
        <!-- Close Button -->
        <button onclick="closeModal()" 
                class="absolute top-4 right-4 z-10 w-9 h-9 rounded-full bg-white/20 hover:bg-white/40 text-white flex items-center justify-center transition">
            <i class="fas fa-times text-sm"></i>
        </button>
        <!-- Modal Image -->
        <div class="max-h-[75vh] flex items-center justify-center bg-black/40 p-2">
            <img id="modalImg" src="" alt="" class="max-w-full max-h-[70vh] object-contain rounded-lg">
        </div>
        <!-- Modal Caption -->
        <div class="p-4 bg-slate-900 text-white text-xs sm:text-sm font-medium border-t border-white/10" id="modalCaption">
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openModal(src, caption) {
        document.getElementById('modalImg').src = src;
        document.getElementById('modalCaption').innerText = caption || 'Foto Dokumentasi Bappeda';
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>
@endpush
