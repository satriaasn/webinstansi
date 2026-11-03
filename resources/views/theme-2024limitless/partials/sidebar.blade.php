<!-- Modern Tailwind Sidebar for Inner Pages -->
<aside class="space-y-6 font-sans">
    
    <!-- Widget 1: Agenda Terbaru -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
        <div class="flex justify-between items-center pb-3 mb-3 border-b border-slate-100">
            <h4 class="text-xs font-black uppercase tracking-wider text-[#0B2545] flex items-center gap-2 m-0">
                <i class="far fa-calendar-check text-[#1A56DB]"></i>
                <span>Agenda Terbaru</span>
            </h4>
            <a href="{{ url('agenda/all') }}" class="text-[11px] font-bold text-[#1A56DB] hover:text-blue-800 transition text-decoration-none">Semua</a>
        </div>
        <div class="space-y-3">
            @foreach(\App\Models\Agenda::where('active', 'Y')->orderBy('start', 'desc')->limit(3)->get() as $sideAgenda)
                <a href="{{ url('detail-agenda/'.$sideAgenda->seotitle) }}" class="block group text-decoration-none">
                    <span class="bappeda-sidebar-date">
                        <i class="far fa-clock"></i>
                        {{ $sideAgenda->start ? date('d M Y H:i', strtotime($sideAgenda->start)) : '' }} WIB
                    </span>
                    <div class="bappeda-sidebar-title group-hover:text-[#1A56DB]">
                        {{ $sideAgenda->title }}
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Widget 2: Berita Unggulan -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
        <div class="flex justify-between items-center pb-3 mb-3 border-b border-slate-100">
            <h4 class="text-xs font-black uppercase tracking-wider text-[#0B2545] flex items-center gap-2 m-0">
                <i class="fas fa-fire text-amber-500"></i>
                <span>Berita Unggulan</span>
            </h4>
            <a href="{{ url('post/all') }}" class="text-[11px] font-bold text-[#1A56DB] hover:text-blue-800 transition text-decoration-none">Semua</a>
        </div>
        <div class="space-y-3">
            @foreach(\App\Models\Post::leftJoin('post_categorys', 'post_categorys.id', 'posts.post_category_id')->where('posts.active', 'Y')->select('posts.*', 'post_categorys.title as ctitle')->orderBy('posts.hit', 'desc')->limit(4)->get() as $sidePost)
                @php
                    $sideImg = $sidePost->picture ? (berkas($sidePost->picture) ?: url('berkas/' . $sidePost->picture)) : url('berkas/no-image.jpg');
                @endphp
                <a href="{{ url('detail-post/'.$sidePost->seotitle) }}" class="flex gap-3 items-center group text-decoration-none">
                    <img src="{{ $sideImg }}" 
                         alt="{{ $sidePost->title }}" class="w-14 h-12 rounded-lg object-cover flex-shrink-0 bg-slate-100 border border-slate-200/60">
                    <div class="flex-1 min-w-0">
                        <span class="bappeda-sidebar-cat">{{ $sidePost->ctitle ?: 'Berita' }}</span>
                        <div class="bappeda-sidebar-title line-clamp-2 group-hover:text-[#1A56DB]">
                            {{ $sidePost->title }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Widget 3: Layanan Cepat -->
    <div class="bg-gradient-to-br from-[#0B2545] via-[#0E3566] to-[#071D36] rounded-2xl p-5 text-white shadow-md border border-blue-900/30">
        <div class="flex items-center gap-3 mb-2.5">
            <div class="w-10 h-10 rounded-xl bg-white/10 text-amber-400 flex items-center justify-center text-lg border border-white/10">
                <i class="fas fa-file-shield"></i>
            </div>
            <div>
                <div class="font-black text-xs uppercase tracking-wider text-white">Layanan PPID</div>
                <div class="text-[10px] text-blue-200 font-medium">Keterbukaan Informasi</div>
            </div>
        </div>
        <p class="text-xs text-blue-100 leading-relaxed mb-4">
            Akses informasi publik resmi dan dokumen perencanaan pembangunan Provinsi Lampung.
        </p>
        <a href="{{ url('pages/layanan-permohonan-informasi-bappeda-provinsi-lampung') }}" class="block text-center py-2 px-4 rounded-xl bg-amber-400 hover:bg-amber-500 text-slate-950 font-black text-xs transition text-decoration-none shadow-sm">
            Akses Layanan PPID &rarr;
        </a>
    </div>

</aside>
