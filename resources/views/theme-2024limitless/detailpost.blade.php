@extends(getTheme('layouts.app'))
@section('title', $post->title)

@push('meta')
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 250) }}"/>
    <meta property="og:title" content="{{ $post->title }}"/>
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 250) }}"/>
    @if(!empty($post->picture))
        <meta property="og:image" content="{{ berkas($post->picture) }}"/>
    @else
        <meta property="og:image" content="{{ berkas(getSetting('logo')) }}"/>
    @endif
@endpush

@section('content')

<!-- Header Breadcrumb Banner (Tailwind CSS) -->
<div class="bg-gradient-to-r from-[#0B2545] to-blue-900 text-white py-8 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-blue-200 mb-2">
            <a href="{{ url('') }}" class="hover:text-white transition flex items-center gap-1"><i class="fas fa-home"></i> Beranda</a>
            <i class="fas fa-chevron-right text-[9px] text-blue-300"></i>
            <a href="{{ url('post/all') }}" class="hover:text-white transition">Berita</a>
            <i class="fas fa-chevron-right text-[9px] text-blue-300"></i>
            <span class="text-white font-semibold truncate max-w-xs sm:max-w-md">{{ $post->title }}</span>
        </nav>
        <span class="inline-block text-[10px] font-extrabold uppercase tracking-wider text-blue-200 bg-white/10 px-2.5 py-0.5 rounded mb-2">
            {{ $post->category->title ?? 'Berita' }}
        </span>
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-black tracking-tight text-white leading-snug">
            {{ $post->title }}
        </h1>
        <div class="flex items-center gap-4 text-xs text-blue-200 mt-3">
            <span><i class="far fa-calendar-alt mr-1"></i> {{ $post->created_at ? $post->created_at->isoFormat('dddd, DD MMMM Y') : '' }}</span>
            <span><i class="far fa-user mr-1"></i> {{ $post->user->name ?? 'Admin Bappeda' }}</span>
            <span><i class="far fa-eye mr-1"></i> {{ $post->hit }} dilihat</span>
        </div>
    </div>
</div>

<!-- Main Article Content (Tailwind CSS) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 font-sans">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Article Body (8 cols) -->
        <article class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
            @if($post->picture)
                <div class="rounded-xl overflow-hidden mb-6 bg-slate-100 max-h-[460px]">
                    <img src="{{ $post->picture ? (berkas($post->picture) ?: url('berkas/' . $post->picture)) : url('berkas/no-image.jpg') }}" 
                         alt="{{ $post->title }}" 
                         class="w-full h-auto object-cover mx-auto">
                </div>
            @endif

            <div class="prose max-w-none text-slate-700 text-sm leading-relaxed space-y-4">
                {!! $post->content !!}
            </div>

            <!-- Share Buttons -->
            <div class="mt-8 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
                <div class="text-xs font-bold text-slate-700">Bagikan Informasi Ini:</div>
                <div class="flex items-center gap-2">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs hover:bg-blue-700 transition" title="Bagikan ke Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-sky-500 text-white flex items-center justify-center text-xs hover:bg-sky-600 transition" title="Bagikan ke Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs hover:bg-emerald-600 transition" title="Bagikan ke WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </article>

        <!-- Sidebar (4 cols) -->
        <div class="lg:col-span-4">
            @include(getTheme('partials.sidebar'))
        </div>

    </div>
</div>

@endsection
