<!-- Modern Tailwind Sidebar for Inner Pages -->
<aside class="space-y-6 font-sans">
    
    <!-- Widget 1: Agenda Terbaru -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
        <div class="flex justify-between items-center pb-3 mb-3 border-b border-slate-100">
            <h4 class="text-xs font-black uppercase tracking-wider text-[#0B2545] flex items-center gap-2">
                <i class="far fa-calendar-check text-blue-600"></i>
                <span>Agenda Terbaru</span>
            </h4>
            <a href="{{ url('agenda/all') }}" class="text-[11px] font-bold text-blue-700 hover:text-blue-800 transition">Semua</a>
        </div>
        <div class="space-y-3">
            @foreach(\App\Models\Agenda::where('active', 'Y')->orderBy('start', 'desc')->limit(3)->get() as $sideAgenda)
                <a href="{{ url('detail-agenda/'.$sideAgenda->seotitle) }}" class="block group text-decoration-none">
                    <div class="text-[10px] font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded inline-block mb-1">
                        <i class="far fa-clock mr-1"></i>
                        {{ $sideAgenda->start ? date('d M Y H:i', strtotime($sideAgenda->start)) : '' }}
                    </div>
                    <div class="text-xs font-semibold text-slate-800 group-hover:text-blue-700 line-clamp-2 leading-snug transition">
                        {{ $sideAgenda->title }}
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Widget 2: Berita Unggulan -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
        <div class="flex justify-between items-center pb-3 mb-3 border-b border-slate-100">
            <h4 class="text-xs font-black uppercase tracking-wider text-[#0B2545] flex items-center gap-2">
                <i class="fas fa-fire text-amber-500"></i>
                <span>Berita Unggulan</span>
            </h4>
            <a href="{{ url('post/all') }}" class="text-[11px] font-bold text-blue-700 hover:text-blue-800 transition">Semua</a>
        </div>
        <div class="space-y-3">
            @foreach(\App\Models\Post::leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')->where('posts.active', 'Y')->select('posts.*', 'post_categorys.title as ctitle')->orderBy('posts.hit', 'desc')->limit(4)->get() as $sidePost)
                <a href="{{ url('detail-post/'.$sidePost->seotitle) }}" class="flex gap-3 items-center group text-decoration-none">
                    <img src="{{ berkas($sidePost->picture) ?: (file_exists(public_path('assets/images/gallery_meeting.jpg')) ? asset('assets/images/gallery_meeting.jpg') : asset('assets/images/lampung_hero_banner.jpg')) }}" 
                         alt="{{ $sidePost->title }}" class="w-14 h-12 rounded-lg object-cover flex-shrink-0 bg-slate-100">
                    <div class="flex-1 min-w-0">
                        <span class="text-[9px] font-bold text-blue-600 uppercase block">{{ $sidePost->ctitle ?: 'Berita' }}</span>
                        <div class="text-xs font-semibold text-slate-800 group-hover:text-blue-700 line-clamp-2 leading-snug transition">
                            {{ $sidePost->title }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Widget 3: Layanan Cepat -->
    <div class="bg-gradient-to-br from-blue-700 to-blue-900 rounded-2xl p-5 text-white shadow-md">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg">
                <i class="fas fa-file-shield"></i>
            </div>
            <div>
                <div class="font-bold text-xs uppercase tracking-wider">Layanan PPID</div>
                <div class="text-[10px] text-blue-200">Keterbukaan Informasi</div>
            </div>
        </div>
        <p class="text-xs text-blue-100 leading-relaxed mb-4">
            Akses informasi publik resmi dan dokumen perencanaan pembangunan Provinsi Lampung.
        </p>
        <a href="{{ url('download/sk-ppid') }}" class="block text-center py-2 px-4 rounded-xl bg-white text-blue-900 font-bold text-xs hover:bg-blue-50 transition text-decoration-none">
            Akses Layanan PPID
        </a>
    </div>

</aside>
