@extends(getTheme('layouts.app'))
@section('title', 'Struktur Organisasi Bappeda Provinsi Lampung')

@push('meta')
    @include('metadefault')
@endpush

@section('content')

{{-- Header Breadcrumb Banner --}}
<div class="bg-gradient-to-r from-[#0B2545] to-blue-900 text-white py-10 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-blue-200 mb-3">
            <a href="{{ url('') }}" class="hover:text-white transition flex items-center gap-1 text-decoration-none"><i class="fas fa-home"></i> Beranda</a>
            <i class="fas fa-chevron-right text-[9px] text-blue-300"></i>
            <span class="text-white font-semibold">Struktur Organisasi</span>
        </nav>
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400/20 border border-amber-300/30 text-amber-200 text-[11px] font-bold mb-2">
                    <i class="fas fa-landmark"></i> Lampiran Peraturan Gubernur Lampung Nomor 37 Tahun 2024
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    Bagan Struktur Organisasi
                </h1>
                <p class="text-xs sm:text-sm text-blue-100 mt-1.5 max-w-2xl">
                    Badan Perencanaan Pembangunan Daerah Provinsi Lampung. Klik pada kartu pejabat untuk melihat rincian profil &amp; tugas fungsi.
                </p>
            </div>

            {{-- Search & View Toggle --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
                <div class="relative">
                    <input type="text" id="org-search" placeholder="Cari nama, NIP, jabatan..."
                           class="w-full sm:w-64 bg-white/10 text-white placeholder-blue-200/75 border border-white/20 rounded-xl pl-9 pr-4 py-2 text-xs focus:outline-none focus:bg-white focus:text-slate-800 transition">
                    <i class="fas fa-search absolute left-3 top-2.5 text-blue-200 text-xs"></i>
                </div>
                <div class="inline-flex rounded-xl bg-white/10 p-1 border border-white/15">
                    <button type="button" id="btn-view-chart" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-white text-[#0B2545] shadow-xs transition">
                        <i class="fas fa-sitemap mr-1"></i> Bagan
                    </button>
                    <button type="button" id="btn-view-list" class="px-3 py-1.5 rounded-lg text-xs font-bold text-white hover:bg-white/10 transition">
                        <i class="fas fa-list mr-1"></i> Direktori
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Main Org Chart Workspace --}}
<div class="bg-slate-100/80 min-h-[600px] py-8 font-sans">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">

        {{-- 1. INTERACTIVE CHART VIEW --}}
        <div id="org-chart-view">
            {{-- Zoom Toolbar --}}
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4 bg-white rounded-2xl border border-slate-200 px-4 py-2.5 shadow-xs">
                <div class="text-xs text-slate-500 flex items-center gap-2">
                    <i class="fas fa-hand-pointer text-blue-600"></i>
                    <span>Klik kartu mana saja untuk melihat profil lengkap &amp; foto pejabat. Geser horizontal jika layar sempit.</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <button type="button" onclick="orgZoom(-0.1)" class="w-8 h-8 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold" title="Perkecil">
                        <i class="fas fa-minus"></i>
                    </button>
                    <span id="zoom-label" class="px-2.5 text-xs font-bold text-slate-700 min-w-[52px] text-center">100%</span>
                    <button type="button" onclick="orgZoom(0.1)" class="w-8 h-8 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold" title="Perbesar">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button type="button" onclick="orgZoomReset()" class="px-2.5 h-8 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-semibold ml-1">
                        Reset
                    </button>
                </div>
            </div>

            {{-- Scrollable Org Canvas --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-10 overflow-x-auto">
                <div id="org-canvas" class="min-w-[1220px] mx-auto transition-transform origin-top-left" style="transform: scale(1);">

                    @if($root)
                        {{-- LEVEL 1: KEPALA BADAN --}}
                        <div class="flex flex-col items-center">
                            @include(getTheme('partials._org_card'), ['node' => $root, 'widthClass' => 'w-72'])
                            <div class="w-0.5 h-8 bg-slate-400"></div>
                        </div>

                        {{-- LEVEL 2: SEKRETARIS BRANCH (Exact 50%/50% grid around center spine so line aligns 100% with Kaban) --}}
                        @if($sekretaris)
                            <div class="grid w-full items-stretch" style="grid-template-columns: minmax(0, 1fr) 2px minmax(0, 1fr);">
                                {{-- Left Spacer (exact 50% minus 1px) --}}
                                <div></div>

                                {{-- Center Vertical Spine (exact 50% center, auto-stretches) --}}
                                <div class="bg-slate-400 w-full"></div>

                                {{-- Right Side (exact 50% minus 1px): Horizontal Branch + Sekretaris + Children --}}
                                <div class="relative flex justify-center pb-8 pl-6">
                                    {{-- Seamless horizontal line from center spine into Sekretaris card --}}
                                    <div class="absolute left-0 right-1/2 bg-slate-400" style="top: 56px; height: 2px;"></div>

                                    <div class="relative z-10 flex flex-col items-center">
                                        @include(getTheme('partials._org_card'), [
                                            'node' => $sekretaris,
                                            'parentJabatan' => $root->jabatan,
                                            'widthClass' => 'w-64'
                                        ])

                                        @if($sekretarisChildren->isNotEmpty())
                                            <div class="w-0.5 bg-slate-400" style="height: 20px;"></div>
                                            @php
                                                $scCount = $sekretarisChildren->count();
                                                $scInset = $scCount > 1 ? round(50 / $scCount, 2) : 0;
                                            @endphp
                                            <div class="relative flex items-start justify-center gap-3" style="padding-top: 20px;">
                                                @if($scCount > 1)
                                                    <div class="absolute top-0 bg-slate-400" style="left: {{ $scInset }}%; right: {{ $scInset }}%; height: 2px;"></div>
                                                @endif
                                                @foreach($sekretarisChildren as $sc)
                                                    <div class="relative flex flex-col items-center">
                                                        <div class="w-0.5 bg-slate-400" style="height: 20px; margin-top: -20px;"></div>
                                                        @include(getTheme('partials._org_card'), [
                                                            'node' => $sc,
                                                            'parentJabatan' => $sekretaris->jabatan,
                                                            'widthClass' => 'w-44'
                                                        ])
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- LEVEL 3: KEPALA UPTD & 4 KABID --}}
                        @if($bidangList->isNotEmpty())
                            @php
                                $colCount = $bidangList->count();
                                $barInset = $colCount > 1 ? round(50 / $colCount, 2) : 0;
                            @endphp
                            <div class="relative grid gap-4" style="grid-template-columns: repeat({{ $colCount }}, minmax(0, 1fr)); padding-top: 24px;">
                                @if($colCount > 1)
                                    <div class="absolute top-0 bg-slate-400" style="left: {{ $barInset }}%; right: {{ $barInset }}%; height: 2px;"></div>
                                @endif
                                @foreach($bidangList as $bidang)
                                    @php
                                        $subUnits = $childrenByParent->get($bidang->id, collect());
                                    @endphp
                                    <div class="relative flex flex-col items-center">
                                        <div class="w-0.5 bg-slate-400" style="height: 24px; margin-top: -24px;"></div>
                                        @include(getTheme('partials._org_card'), [
                                            'node' => $bidang,
                                            'parentJabatan' => $root->jabatan,
                                            'widthClass' => 'w-full'
                                        ])

                                        {{-- Children under UPTD / Kabid --}}
                                        @if($subUnits->isNotEmpty())
                                            <div class="w-0.5 bg-slate-400" style="height: 20px;"></div>
                                            <div class="flex flex-col items-center w-full">
                                                @foreach($subUnits as $subIdx => $sub)
                                                    @if($subIdx > 0)
                                                        <div class="w-0.5 bg-slate-400" style="height: 12px;"></div>
                                                    @endif
                                                    @include(getTheme('partials._org_card'), [
                                                        'node' => $sub,
                                                        'parentJabatan' => $bidang->jabatan,
                                                        'widthClass' => 'w-full'
                                                    ])
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="text-center py-16 text-slate-400 text-sm">
                            Data struktur organisasi belum tersedia.
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- 2. DIRECTORY LIST VIEW (Easy mobile & quick lookup) --}}
        <div id="org-list-view" class="hidden">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($nodes as $node)
                    @php
                        $parentNode = $node->parent_id ? $nodes->firstWhere('id', $node->parent_id) : null;
                    @endphp
                    @include(getTheme('partials._org_card'), [
                        'node' => $node,
                        'parentJabatan' => $parentNode->jabatan ?? 'Pimpinan Tertinggi',
                        'widthClass' => 'w-full'
                    ])
                @endforeach
            </div>
        </div>

    </div>
</div>

{{-- Interactive Detail Modal --}}
<div id="org-modal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs">
    <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200 font-sans">
        <div class="bg-gradient-to-r from-[#0B2545] to-blue-800 px-6 py-5 text-white flex items-start justify-between gap-4">
            <div>
                <span id="modal-tipe" class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-400 text-slate-950 mb-1.5"></span>
                <h3 id="modal-jabatan" class="text-base sm:text-lg font-black leading-snug text-white"></h3>
            </div>
            <button type="button" onclick="closeOrgModal()" class="w-8 h-8 rounded-full bg-white/15 hover:bg-white/30 text-white flex items-center justify-center flex-shrink-0 transition">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>

        <div class="p-6 space-y-5 max-h-[75vh] overflow-y-auto">
            <div class="flex items-center gap-4">
                <div id="modal-foto-wrap" class="w-20 h-20 rounded-2xl overflow-hidden border-2 border-blue-100 bg-slate-100 flex-shrink-0 flex items-center justify-center shadow-sm">
                </div>
                <div class="min-w-0">
                    <div id="modal-nama" class="text-base font-extrabold text-slate-800 leading-snug"></div>
                    <div id="modal-nip" class="text-xs font-mono text-slate-500 mt-1"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/70">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Pangkat / Golongan</div>
                    <div id="modal-pangkat" class="font-bold text-slate-800 mt-0.5"></div>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/70">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Atasan Langsung</div>
                    <div id="modal-parent" class="font-bold text-slate-800 mt-0.5"></div>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/70">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">TMT Pangkat</div>
                    <div id="modal-tmt-pangkat" class="font-bold text-slate-800 mt-0.5"></div>
                </div>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/70">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">TMT Jabatan</div>
                    <div id="modal-tmt-jabatan" class="font-bold text-slate-800 mt-0.5"></div>
                </div>
            </div>

            <div id="modal-deskripsi-wrap" class="hidden p-4 rounded-2xl bg-blue-50/60 border border-blue-100 text-xs text-slate-700 leading-relaxed">
                <div class="text-[10px] font-bold uppercase tracking-wider text-blue-700 mb-1">Tugas &amp; Fungsi</div>
                <div id="modal-deskripsi"></div>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var zoomLevel = 1;
    var canvas = document.getElementById('org-canvas');
    var zoomLabel = document.getElementById('zoom-label');

    window.orgZoom = function (delta) {
        zoomLevel = Math.max(0.55, Math.min(1.3, +(zoomLevel + delta).toFixed(2)));
        canvas.style.transform = 'scale(' + zoomLevel + ')';
        zoomLabel.textContent = Math.round(zoomLevel * 100) + '%';
    };

    window.orgZoomReset = function () {
        zoomLevel = 1;
        canvas.style.transform = 'scale(1)';
        zoomLabel.textContent = '100%';
    };

    // View toggle
    var btnChart = document.getElementById('btn-view-chart');
    var btnList = document.getElementById('btn-view-list');
    var viewChart = document.getElementById('org-chart-view');
    var viewList = document.getElementById('org-list-view');

    btnChart.addEventListener('click', function () {
        viewChart.classList.remove('hidden');
        viewList.classList.add('hidden');
        btnChart.className = 'px-3 py-1.5 rounded-lg text-xs font-bold bg-white text-[#0B2545] shadow-xs transition';
        btnList.className = 'px-3 py-1.5 rounded-lg text-xs font-bold text-white hover:bg-white/10 transition';
    });

    btnList.addEventListener('click', function () {
        viewList.classList.remove('hidden');
        viewChart.classList.add('hidden');
        btnList.className = 'px-3 py-1.5 rounded-lg text-xs font-bold bg-white text-[#0B2545] shadow-xs transition';
        btnChart.className = 'px-3 py-1.5 rounded-lg text-xs font-bold text-white hover:bg-white/10 transition';
    });

    // Live Search Highlight
    document.getElementById('org-search').addEventListener('input', function () {
        var q = this.value.trim().toLowerCase();
        var cards = document.querySelectorAll('.org-card');
        cards.forEach(function (card) {
            var haystack = card.getAttribute('data-search') || '';
            if (!q) {
                card.classList.remove('ring-4', 'ring-amber-400', 'opacity-30');
            } else if (haystack.indexOf(q) !== -1) {
                card.classList.add('ring-4', 'ring-amber-400');
                card.classList.remove('opacity-30');
            } else {
                card.classList.remove('ring-4', 'ring-amber-400');
                card.classList.add('opacity-30');
            }
        });
    });

    // Modal
    window.openOrgModal = function (data) {
        document.getElementById('modal-tipe').textContent = (data.tipe_node || 'Jabatan').toUpperCase();
        document.getElementById('modal-jabatan').textContent = data.jabatan || '-';
        document.getElementById('modal-nama').textContent = data.nama || 'Kelompok Jabatan Fungsional / Pelaksana';
        document.getElementById('modal-nip').textContent = data.nip ? 'NIP. ' + data.nip : '';
        document.getElementById('modal-pangkat').textContent = data.pangkat || '-';
        document.getElementById('modal-parent').textContent = data.parent_jabatan || 'Pimpinan Tertinggi';
        document.getElementById('modal-tmt-pangkat').textContent = data.tmt_pangkat || '-';
        document.getElementById('modal-tmt-jabatan').textContent = data.tmt_jabatan || '-';

        var fotoWrap = document.getElementById('modal-foto-wrap');
        if (data.foto) {
            fotoWrap.innerHTML = '<img src="' + data.foto + '" alt="" class="w-full h-full object-cover">';
        } else {
            fotoWrap.innerHTML = '<i class="fas fa-user-tie text-blue-600 text-2xl"></i>';
        }

        var descWrap = document.getElementById('modal-deskripsi-wrap');
        var descEl = document.getElementById('modal-deskripsi');
        if (data.deskripsi && data.deskripsi.trim() !== '') {
            descEl.textContent = data.deskripsi;
            descWrap.classList.remove('hidden');
        } else {
            descWrap.classList.add('hidden');
        }

        var modal = document.getElementById('org-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    };

    window.closeOrgModal = function () {
        var modal = document.getElementById('org-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    };

    document.getElementById('org-modal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeOrgModal();
        }
    });
})();
</script>

@endsection
