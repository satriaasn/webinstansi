@extends(getTheme('layouts.app'))
@section('title', $pages->title)

@push('meta')
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($pages->content), 250) }}"/>
    <meta property="og:title" content="{{ $pages->title }}"/>
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($pages->content), 250) }}"/>
    @if(!empty($pages->picture))
        <meta property="og:image" content="{{ berkas($pages->picture) }}"/>
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
            <span class="text-white font-semibold">{{ $pages->title }}</span>
        </nav>
        <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
            {{ $pages->title }}
        </h1>
    </div>
</div>

<!-- Main Content (Tailwind CSS) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 font-sans">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Page Body (8 cols) -->
        <article class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 shadow-sm">
            @if(!empty($pages->picture))
                <div class="rounded-xl overflow-hidden mb-6 bg-slate-100 max-h-[460px]">
                    <img src="{{ berkas($pages->picture) }}" alt="{{ $pages->title }}" class="w-full h-auto object-cover mx-auto">
                </div>
            @endif

            <div class="prose max-w-none text-slate-700 text-sm leading-relaxed space-y-4">
                {!! $pages->content !!}
            </div>
        </article>

        <!-- Sidebar (4 cols) -->
        <div class="lg:col-span-4">
            @include(getTheme('partials.sidebar'))
        </div>

    </div>
</div>

@endsection
