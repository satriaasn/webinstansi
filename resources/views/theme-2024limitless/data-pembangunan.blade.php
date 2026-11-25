@extends(getTheme('layouts.app'))
@section('title', 'Data & Informasi Pembangunan')

@push('meta')
    @include('metadefault')
@endpush

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-[#072146] via-[#09356E] to-[#0B4182] py-10 text-white font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="inline-block px-3 py-1 rounded-full bg-[#F59E0B] text-slate-950 font-black text-[10px] tracking-wider uppercase mb-2.5 shadow">
                    PUSDATIN BAPPEDA LAMPUNG
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white leading-tight m-0">
                    Data &amp; Informasi Pembangunan
                </h1>
                <p class="text-blue-100/90 text-xs sm:text-sm mt-2 mb-0 max-w-2xl">
                    Kumpulan lengkap indikator makro dan data statistik pembangunan Provinsi Lampung yang disinkronkan secara berkala dari Pusdatin Bappeda.
                </p>
            </div>
            <div>
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 text-white text-xs font-bold border border-white/20 transition text-decoration-none">
                    <i class="fas fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Filter & Cards Section -->
<section class="py-10 bg-slate-50 font-sans min-h-[480px]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Search & Category Filter -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 shadow-sm mb-6 space-y-4">
            <form action="{{ route('data-pembangunan.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2.5">
                @if(!empty($kategori))
                    <input type="hidden" name="kategori" value="{{ $kategori }}">
                @endif
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text"
                           name="q"
                           value="{{ $q }}"
                           placeholder="Cari indikator pembangunan (misal: Kemiskinan, IPM, Pertumbuhan Ekonomi, Padi)..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1A56DB] transition">
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#1A56DB] hover:bg-[#1344B5] text-white font-bold text-xs shadow-sm transition border-0 cursor-pointer inline-flex items-center gap-1.5">
                        <i class="fas fa-search text-[10px]"></i>
                        <span>Cari Data</span>
                    </button>
                    @if($q !== '' || $kategori !== '')
                        <a href="{{ route('data-pembangunan.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition text-decoration-none inline-flex items-center gap-1.5">
                            <i class="fas fa-times text-[10px]"></i>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>
            </form>

            @if($categories->count() > 0)
                <div class="flex flex-wrap items-center gap-2 pt-1">
                    <span class="text-[11px] font-bold text-slate-500 mr-1">Kategori:</span>
                    <a href="{{ route('data-pembangunan.index', $q ? ['q' => $q] : []) }}"
                       class="px-3 py-1 rounded-full text-[11px] font-bold transition text-decoration-none {{ $kategori === '' ? 'bg-[#1A56DB] text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Semua ({{ \App\Models\StatistikMakro::count() }})
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('data-pembangunan.index', array_filter(['kategori' => $cat, 'q' => $q])) }}"
                           class="px-3 py-1 rounded-full text-[11px] font-bold transition text-decoration-none {{ $kategori === $cat ? 'bg-[#1A56DB] text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Count info -->
        <div class="mb-4 text-xs text-slate-500 font-medium">
            Menampilkan <strong class="text-[#0B2545]">{{ $items->count() }}</strong> indikator statistik pembangunan
            @if($kategori !== '') pada kategori <strong>{{ $kategori }}</strong> @endif
            @if($q !== '') untuk kata kunci "<strong>{{ $q }}</strong>" @endif
        </div>

        @if($items->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($items as $idx => $stat)
                    @php
                        $palettes = [
                            ['bg' => '#EFF6FF', 'border' => '#BFDBFE', 'color' => '#1A56DB', 'icon' => 'fas fa-chart-line'],
                            ['bg' => '#ECFDF5', 'border' => '#A7F3D0', 'color' => '#059669', 'icon' => 'fas fa-arrow-trend-up'],
                            ['bg' => '#EEF2FF', 'border' => '#C7D2FE', 'color' => '#4F46E5', 'icon' => 'fas fa-layer-group'],
                            ['bg' => '#FFFBEB', 'border' => '#FDE68A', 'color' => '#D97706', 'icon' => 'fas fa-trophy'],
                            ['bg' => '#F0F9FF', 'border' => '#BAE6FD', 'color' => '#0284C7', 'icon' => 'fas fa-chart-pie'],
                        ];
                        $pal = $palettes[$idx % count($palettes)];

                        $isUp = $stat->arah_perubahan === 'up';
                        $isDown = $stat->arah_perubahan === 'down';
                        $isPositiveGood = ($stat->jenis_indikator !== 'negatif');
                        $isGood = ($isUp && $isPositiveGood) || ($isDown && !$isPositiveGood);
                    @endphp
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-base flex-shrink-0" style="background-color: {{ $pal['bg'] }} !important; border: 1px solid {{ $pal['border'] }} !important;">
                                        <i class="{{ $pal['icon'] }}" style="color: {{ $pal['color'] }} !important;"></i>
                                    </div>
                                    @if($stat->kategori_nama)
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200/70 line-clamp-1">
                                            {{ $stat->kategori_nama }}
                                        </span>
                                    @endif
                                </div>
                                @if($stat->delta_formatted)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold flex-shrink-0 {{ $stat->arah_perubahan === 'flat' ? 'bg-slate-100 text-slate-600' : ($isGood ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200') }}">
                                        @if($isUp)<i class="fas fa-caret-up mr-0.5"></i>@elseif($isDown)<i class="fas fa-caret-down mr-0.5"></i>@endif
                                        {{ $stat->delta_formatted }}
                                    </span>
                                @endif
                            </div>

                            <div class="text-2xl font-black text-[#0B2545] leading-tight mb-1">
                                {{ $stat->nilai_formatted ?: $stat->nilai_terbaru }}
                                @if($stat->satuan && !str_contains($stat->nilai_formatted ?? '', '%'))
                                    <span class="text-xs font-bold text-slate-500">{{ $stat->satuan }}</span>
                                @endif
                            </div>

                            <h2 class="text-sm font-bold text-[#0B2545] leading-snug mb-2">
                                {{ $stat->judul }}
                            </h2>

                            @if($stat->deskripsi)
                                <p class="text-[11px] text-slate-500 leading-relaxed line-clamp-3 mb-3">
                                    {{ $stat->deskripsi }}
                                </p>
                            @endif
                        </div>

                        <div class="pt-3 mt-2 border-t border-slate-100 flex items-center justify-between gap-2 text-[10px]">
                            <div class="text-slate-400 truncate">
                                <span class="font-semibold text-slate-500">{{ $stat->periode_terbaru ?: $stat->periode }}</span>
                                @if($stat->sumber_data)
                                    &bull; {{ $stat->sumber_data }}
                                @endif
                            </div>
                            @if(!empty($stat->data_series) && is_array($stat->data_series) && count($stat->data_series) > 0)
                                <button type="button"
                                        onclick='openStatChart(@json($stat->judul), @json($stat->satuan), @json($stat->data_series))'
                                        class="px-3 py-1 rounded-full bg-blue-50 hover:bg-[#1A56DB] text-[#1A56DB] hover:text-white font-bold transition border border-blue-200 cursor-pointer flex-shrink-0">
                                    <i class="fas fa-chart-area mr-1"></i> Grafik
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center shadow-sm">
                <i class="fas fa-chart-bar text-3xl text-slate-300 mb-3 block"></i>
                <h2 class="text-base font-bold text-[#0B2545] mb-1">Data Statistik Tidak Ditemukan</h2>
                <p class="text-xs text-slate-500 m-0">Coba ubah kata kunci pencarian atau pilih kategori lain.</p>
            </div>
        @endif
    </div>
</section>

<!-- Chart Modal -->
<div id="stat-chart-modal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 shadow-2xl border border-slate-200">
        <div class="flex items-start justify-between gap-3 mb-4">
            <div>
                <div class="text-[10px] font-bold text-[#1A56DB] uppercase tracking-wider">Grafik Tren Indikator</div>
                <h3 id="modal-chart-title" class="text-base font-black text-[#0B2545] m-0"></h3>
            </div>
            <button type="button" onclick="closeStatChart()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center border-0 cursor-pointer">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        <div class="relative h-72 w-full">
            <canvas id="stat-chart-canvas"></canvas>
        </div>
    </div>
</div>

<script>
    var activeStatChart = null;
    function openStatChart(title, satuan, seriesData) {
        document.getElementById('modal-chart-title').textContent = title + (satuan ? ' (' + satuan + ')' : '');
        document.getElementById('stat-chart-modal').classList.remove('hidden');

        var labels = [];
        var seriesGroups = {};

        seriesData.forEach(function (pt) {
            if (labels.indexOf(pt.label) === -1) {
                labels.push(pt.label);
            }
            var sName = pt.series_label || 'Provinsi Lampung';
            if (!seriesGroups[sName]) {
                seriesGroups[sName] = {};
            }
            seriesGroups[sName][pt.label] = pt.value;
        });

        var colors = ['#1A56DB', '#059669', '#D97706', '#DC2626', '#7C3AED'];
        var datasets = Object.keys(seriesGroups).map(function (name, idx) {
            var c = colors[idx % colors.length];
            return {
                label: name,
                data: labels.map(function (lbl) { return seriesGroups[name][lbl] ?? null; }),
                borderColor: c,
                backgroundColor: c + '22',
                borderWidth: 2,
                tension: 0.3,
                fill: Object.keys(seriesGroups).length === 1
            };
        });

        var ctx = document.getElementById('stat-chart-canvas').getContext('2d');
        if (activeStatChart) {
            activeStatChart.destroy();
        }
        activeStatChart = new Chart(ctx, {
            type: 'line',
            data: { labels: labels, datasets: datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
                scales: { y: { beginAtZero: false } }
            }
        });
    }

    function closeStatChart() {
        document.getElementById('stat-chart-modal').classList.add('hidden');
    }
</script>
@endsection
