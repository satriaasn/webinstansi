<section class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm mb-4">
    <div class="flex justify-between items-center pb-3 mb-3 border-b border-slate-100">
        <h4 class="text-xs font-black uppercase tracking-wider text-[#0B2545] flex items-center gap-2">
            <i class="far fa-newspaper text-blue-600"></i>
            <span>Berita Terbaru</span>
        </h4>
        <a href="{{ url('post/all') }}" class="text-[11px] font-bold text-blue-700 hover:text-blue-800 transition">Semua</a>
    </div>

    <div class="space-y-3">
        @foreach(App\Http\Controllers\HomeController::latestPost('4') as $latestside)
            <a href="{{ url('/detail-post/'.$latestside->seotitle) }}" class="block group text-decoration-none">
                <span class="text-[10px] text-slate-400 block mb-0.5">
                    <i class="far fa-clock mr-1"></i> {{ $latestside->created_at ? $latestside->created_at->diffForHumans() : '' }}
                </span>
                <h5 class="text-xs font-semibold text-slate-800 group-hover:text-blue-700 line-clamp-2 leading-snug transition">
                    {{ $latestside->title }}
                </h5>
            </a>
        @endforeach
    </div>
</section>