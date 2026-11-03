@extends(getTheme('layouts.app'))
@section('title', ($seotitle == 'all' ? 'Berita & Post' : $category->title))

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
            <a href="{{ url('post/all') }}" class="hover:text-white transition">Berita</a>
            <i class="fas fa-chevron-right text-[9px] text-blue-300"></i>
            <span class="text-white font-semibold">{{ ($seotitle == 'all' ? 'Semua Berita' : $category->title) }}</span>
        </nav>
        <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
            {{ ($seotitle == 'all' ? 'Berita & Informasi Terkini' : $category->title) }}
        </h1>
        <p class="text-xs sm:text-sm text-blue-100 mt-2 max-w-2xl">
            Kumpulan publikasi berita resmi, pengumuman, dan informasi terkini dari Bappeda Provinsi Lampung.
        </p>
    </div>
</div>

<!-- Main Content (Tailwind CSS) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 font-sans">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Post List (8 cols) -->
        <div class="lg:col-span-8 space-y-5">
            @forelse($posts as $article)
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition flex flex-col sm:flex-row gap-5 items-center group">
                    <div class="w-full sm:w-48 h-36 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0 relative">
                        <img src="{{ $article->picture ? (berkas($article->picture) ?: url('berkas/' . $article->picture)) : url('berkas/no-image.jpg') }}" 
                             alt="{{ $article->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300" loading="lazy">
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="inline-block text-[10px] font-extrabold uppercase tracking-wider text-blue-700 bg-blue-50 px-2 py-0.5 rounded mb-2">
                            {{ $article->ctitle ?: 'Berita' }}
                        </span>
                        <h2 class="text-base font-bold text-slate-800 group-hover:text-blue-700 leading-snug mb-2 transition">
                            <a href="{{ url('/detail-post/'.$article->seotitle) }}" class="text-slate-800 group-hover:text-blue-700 text-decoration-none">
                                {{ $article->title }}
                            </a>
                        </h2>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-3">
                            {{ strip_tags(\Illuminate\Support\Str::limit($article->content, 130)) }}
                        </p>
                        <div class="flex items-center gap-4 text-[11px] text-slate-400">
                            <span><i class="far fa-calendar-alt mr-1"></i> {{ $article->created_at ? $article->created_at->isoFormat('DD MMMM Y') : '' }}</span>
                            <span><i class="far fa-eye mr-1"></i> {{ $article->hit }} dilihat</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center text-slate-400 text-sm">
                    Belum ada postingan untuk kategori ini.
                </div>
            @endforelse

            <!-- Pagination -->
            <div class="pt-4 flex justify-center">
                {{ $posts->links() }}
            </div>
        </div>

        <!-- Sidebar (4 cols) -->
        <div class="lg:col-span-4">
            @include(getTheme('partials.sidebar'))
        </div>

    </div>
</div>

@endsection
