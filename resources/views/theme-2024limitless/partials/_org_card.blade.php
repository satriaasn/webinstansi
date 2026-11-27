@php
    $fotoUrl = !empty($node->foto) ? berkas($node->foto) : null;
    $isFungsional = $node->tipe_node === 'fungsional';
    $headerBg = match($node->tipe_node) {
        'pimpinan' => 'from-[#0B2545] to-blue-800 text-white',
        'sekretaris' => 'from-sky-700 to-blue-700 text-white',
        'uptd' => 'from-indigo-700 to-blue-700 text-white',
        'kabid' => 'from-sky-600 to-cyan-700 text-white',
        'kasubbag', 'kasi' => 'from-sky-500 to-blue-600 text-white',
        'fungsional' => 'from-slate-600 to-slate-700 text-white',
        default => 'from-sky-600 to-blue-700 text-white',
    };
    $cardPayload = [
        'id' => $node->id,
        'jabatan' => $node->jabatan,
        'nama' => $node->nama,
        'nip' => $node->nip,
        'pangkat' => $node->pangkat,
        'tmt_pangkat' => $node->tmt_pangkat,
        'tmt_jabatan' => $node->tmt_jabatan,
        'foto' => $fotoUrl,
        'tipe_node' => $node->tipe_node,
        'deskripsi' => $node->deskripsi,
        'parent_jabatan' => $parentJabatan ?? null,
    ];
@endphp

<div class="org-card group bg-white rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:border-blue-400 transition-all duration-200 overflow-hidden cursor-pointer flex flex-col {{ $widthClass ?? 'w-60' }}"
     data-search="{{ strtolower(($node->jabatan ?? '') . ' ' . ($node->nama ?? '') . ' ' . ($node->nip ?? '') . ' ' . ($node->pangkat ?? '')) }}"
     onclick='openOrgModal(@json($cardPayload))'>
    {{-- Header Jabatan --}}
    <div class="bg-gradient-to-r {{ $headerBg }} px-3 py-2 text-center">
        <div class="text-[10px] font-extrabold uppercase tracking-wider leading-tight">
            {{ $node->jabatan }}
        </div>
    </div>

    @if($isFungsional && empty($node->nama))
        <div class="p-3 text-center bg-slate-50/70 flex-1 flex flex-col items-center justify-center min-h-[70px]">
            <div class="grid grid-cols-3 gap-1.5 w-full mb-1.5">
                <div class="h-6 rounded bg-white border border-slate-200/80"></div>
                <div class="h-6 rounded bg-white border border-slate-200/80"></div>
                <div class="h-6 rounded bg-white border border-slate-200/80"></div>
            </div>
            <span class="text-[10px] text-slate-400 font-medium">Klik untuk rincian</span>
        </div>
    @else
        <div class="p-3.5 flex flex-col items-center text-center flex-1">
            {{-- Foto Pejabat --}}
            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-blue-100 shadow-sm mb-2.5 bg-slate-100 flex-shrink-0 group-hover:scale-105 transition-transform">
                @if($fotoUrl)
                    <img src="{{ $fotoUrl }}" alt="{{ $node->nama ?? $node->jabatan }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-sky-100 text-blue-700 text-lg font-bold">
                        <i class="fas fa-user-tie"></i>
                    </div>
                @endif
            </div>

            {{-- Nama & NIP --}}
            <div class="text-xs font-extrabold text-slate-800 group-hover:text-blue-700 leading-snug transition">
                {{ $node->nama ?: '-' }}
            </div>
            @if(!empty($node->nip))
                <div class="text-[10px] text-slate-500 font-mono mt-0.5">
                    NIP. {{ $node->nip }}
                </div>
            @endif

            {{-- Pangkat & TMT --}}
            @if(!empty($node->pangkat) || !empty($node->tmt_pangkat) || !empty($node->tmt_jabatan))
                <div class="w-full mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-slate-500 space-y-0.5 leading-tight">
                    @if(!empty($node->pangkat))
                        <div class="font-semibold text-slate-700">{{ $node->pangkat }}</div>
                    @endif
                    @if(!empty($node->tmt_pangkat))
                        <div>TMT Pangkat: {{ $node->tmt_pangkat }}</div>
                    @endif
                    @if(!empty($node->tmt_jabatan))
                        <div>TMT Jabatan: {{ $node->tmt_jabatan }}</div>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>
