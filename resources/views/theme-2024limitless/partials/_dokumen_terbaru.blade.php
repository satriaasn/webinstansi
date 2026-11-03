<section class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm mb-4">
    <div class="flex justify-between items-center pb-3 mb-3 border-b border-slate-100">
        <h4 class="text-xs font-black uppercase tracking-wider text-[#0B2545] flex items-center gap-2">
            <i class="far fa-file-lines text-blue-600"></i>
            <span>Dokumen Terbaru</span>
        </h4>
        <a href="{{ url('download/all') }}" class="text-[11px] font-bold text-blue-700 hover:text-blue-800 transition">Semua</a>
    </div>

    <div class="space-y-2.5">
        @foreach(App\Http\Controllers\HomeController::latestDownload('4') as $downloadside)
            @php
                $linkdown = berkas($downloadside->file) ?: (file_exists(public_path('uploads/'.$downloadside->file)) ? asset('uploads/'.$downloadside->file) : '#');
            @endphp
            <div class="flex items-center justify-between gap-2 p-2 rounded-xl bg-slate-50 hover:bg-blue-50/60 transition group">
                <div class="min-w-0 flex-1">
                    <a href="{{ $linkdown }}" target="_blank" class="text-xs font-semibold text-slate-700 group-hover:text-blue-700 line-clamp-1 block text-decoration-none">
                        {{ $downloadside->title }}
                    </a>
                </div>
                <a href="{{ $linkdown }}" target="_blank"
                   class="w-7 h-7 rounded-lg bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center flex-shrink-0 text-xs shadow-sm transition">
                    <i class="fas fa-download text-[10px]"></i>
                </a>
            </div>
        @endforeach
    </div>
</section>