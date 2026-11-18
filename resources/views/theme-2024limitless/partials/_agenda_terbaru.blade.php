<section class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm mb-4 font-sans">
    <div class="flex justify-between items-center pb-3 mb-3 border-b border-slate-100">
        <h4 class="text-xs font-black uppercase tracking-wider text-[#0B2545] flex items-center gap-2">
            <i class="far fa-calendar-check text-blue-600"></i>
            <span>Agenda Terbaru</span>
        </h4>
        <a href="{{ url('agenda/all') }}" class="text-[11px] font-bold text-blue-700 hover:text-blue-800 transition text-decoration-none">Semua</a>
    </div>

    <div class="space-y-3">
        @forelse(App\Http\Controllers\HomeController::agenda('3') as $agendaside)
            <a href="{{ url('/detail-agenda/'.$agendaside->seotitle) }}" class="block group text-decoration-none">
                <div class="text-[10px] font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded inline-block mb-1">
                    <i class="far fa-clock mr-1"></i>
                    {{ $agendaside->start ? date('d M Y H:i', strtotime($agendaside->start)) : 'Segera' }} WIB
                </div>
                <div class="text-xs font-semibold text-slate-800 group-hover:text-blue-700 line-clamp-2 leading-snug transition mb-1">
                    {{ $agendaside->title }}
                </div>
                @php
                    $loc = !empty($agendaside->location) ? $agendaside->location : trim(strip_tags($agendaside->content ?? ''));
                @endphp
                @if(!empty($loc))
                    <div class="text-[11px] text-slate-500 truncate flex items-center gap-1">
                        <i class="fas fa-location-dot text-rose-500 text-[10px] flex-shrink-0"></i>
                        <span class="truncate">{{ $loc }}</span>
                    </div>
                @endif
            </a>
        @empty
            <div class="text-center py-4 text-xs text-slate-400">
                Belum ada agenda terbaru.
            </div>
        @endforelse
    </div>
</section>
