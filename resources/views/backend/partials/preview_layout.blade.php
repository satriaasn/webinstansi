@php
    $isActive = isset($active) ? ($active === 'Y' || $active === 1 || $active === '1' || $active === true) : null;
    $resolvedImage = null;
    if (!empty($image)) {
        $resolvedImage = \Illuminate\Support\Str::startsWith($image, ['http://', 'https://'])
            ? $image
            : berkas($image);
    }
    $resolvedPdf = !empty($pdfFile) ? berkas($pdfFile) : null;
    $hasMedia = !empty($image) || !empty($youtubeId) || !empty($pdfFile);
@endphp

<div class="font-sans space-y-5">
    {{-- Top Action & Title Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 border-b border-slate-200">
        <div class="min-w-0">
            <div class="flex flex-wrap items-center gap-2 mb-1">
                @if($isActive !== null)
                    @if($isActive)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Non Active
                        </span>
                    @endif
                @endif
                @if(!empty($badgeText))
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                        {{ $badgeText }}
                    </span>
                @endif
            </div>
            <h2 class="text-lg sm:text-xl font-extrabold text-slate-800 leading-snug mb-0 break-words">
                {{ $title ?: 'Detail Data' }}
            </h2>
            @if(!empty($subtitle))
                <p class="text-xs text-slate-400 mt-1 mb-0 break-all">{{ $subtitle }}</p>
            @endif
        </div>

        <div class="flex items-center gap-2 flex-shrink-0">
            <a href="{{ $backUrl }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition text-decoration-none">
                <i class="fas fa-arrow-left text-[11px]"></i> Kembali
            </a>
            @if(!empty($editUrl))
                <a href="{{ $editUrl }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-sm transition text-decoration-none">
                    <i class="fas fa-pen text-[11px]"></i> Edit Data
                </a>
            @endif
        </div>
    </div>

    {{-- Media Showcase (Image / YouTube / PDF) --}}
    @if($hasMedia)
        <div class="rounded-2xl border border-slate-200 bg-slate-50 overflow-hidden shadow-sm">
            @if(!empty($youtubeId))
                <div class="aspect-video w-full bg-slate-950">
                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allowfullscreen></iframe>
                </div>
            @elseif(!empty($pdfFile))
                <div class="p-6 flex flex-col sm:flex-row items-center justify-between gap-4 bg-white">
                    <div class="flex items-center gap-3.5 min-w-0">
                        <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 border border-rose-200 flex items-center justify-center flex-shrink-0 text-xl">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-slate-800 truncate">{{ $pdfFile }}</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">Dokumen Lampiran</div>
                        </div>
                    </div>
                    @if($resolvedPdf)
                        <a href="{{ $resolvedPdf }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-sm transition text-decoration-none flex-shrink-0">
                            <i class="fas fa-external-link-alt text-[10px]"></i> Buka / Unduh File
                        </a>
                    @else
                        <span class="text-xs text-amber-600 font-semibold">File tidak ditemukan di server</span>
                    @endif
                </div>
            @elseif(!empty($image))
                @if($resolvedImage)
                    <div class="p-4 sm:p-6 flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200/70">
                        <a href="{{ $resolvedImage }}" target="_blank" class="block group relative" title="Klik untuk melihat ukuran penuh">
                            <img src="{{ $resolvedImage }}"
                                 alt="{{ $title ?? 'Preview' }}"
                                 class="max-h-[380px] w-auto max-w-full rounded-xl shadow-md object-contain bg-white transition duration-300 group-hover:scale-[1.01]">
                        </a>
                    </div>
                    <div class="px-4 py-2.5 bg-white border-t border-slate-200 flex flex-wrap items-center justify-between gap-2 text-xs">
                        <span class="text-slate-500 font-mono text-[11px] truncate max-w-md">{{ $image }}</span>
                        <a href="{{ $resolvedImage }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-[11px] transition text-decoration-none">
                            <i class="fas fa-expand text-[10px]"></i> Buka Ukuran Penuh
                        </a>
                    </div>
                @else
                    <div class="p-5 text-center bg-amber-50/70 text-amber-800 text-xs">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        File gambar <code>{{ $image }}</code> tidak ditemukan di server.
                    </div>
                @endif
            @endif
        </div>
    @endif

    {{-- Metadata Fields Grid --}}
    @if(!empty($fields))
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($fields as $field)
                <div class="rounded-xl bg-slate-50/80 border border-slate-200/70 p-3.5 {{ !empty($field['full']) ? 'sm:col-span-2 lg:col-span-3' : '' }}">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">
                        {{ $field['label'] }}
                    </div>
                    <div class="text-xs sm:text-sm font-semibold text-slate-800 break-words">
                        @if(!empty($field['icon']))
                            <i class="{{ $field['icon'] }} mr-1 text-blue-600"></i>
                        @endif
                        @if(!empty($field['url']) && !empty($field['value']) && $field['value'] !== '-')
                            <a href="{{ $field['url'] }}" target="_blank" class="text-blue-600 hover:underline">{{ $field['value'] }}</a>
                        @elseif(!empty($field['code']))
                            <code class="text-xs bg-white px-2 py-0.5 rounded border border-slate-200">{{ $field['value'] }}</code>
                        @else
                            {{ $field['value'] !== null && $field['value'] !== '' ? $field['value'] : '-' }}
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Rich HTML Content --}}
    @if(isset($htmlContent) && trim(strip_tags((string)$htmlContent)) !== '')
        <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-xs">
            <div class="px-5 py-3 bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-600 flex items-center gap-2">
                <i class="fas fa-align-left text-blue-600"></i>
                <span>{{ $contentTitle ?? 'Deskripsi & Konten' }}</span>
            </div>
            <div class="p-5 prose prose-sm max-w-none text-slate-700 leading-relaxed">
                {!! $htmlContent !!}
            </div>
        </div>
    @endif
</div>
