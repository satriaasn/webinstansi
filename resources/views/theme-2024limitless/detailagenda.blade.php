@extends(getTheme('layouts.app'))
@section('title', $agenda->title)

@push('meta')
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($agenda->title), 250) }}"/>
    <meta property="og:title" content="@yield('title') - {{ getSetting('web_name') }}"/>
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($agenda->content), 250) }}"/>
    <meta property="og:image" content="{{ berkas( getSetting('logo')) }}"/>
    <meta property="og:image:secure_url" content="{{ berkas( getSetting('logo')) }}"/>
    <meta property="og:image:width" content="100"/>
    <meta property="og:image:height" content="100"/>
@endpush

@section('content')

@php
    $meta = is_array($agenda->metadata) ? $agenda->metadata : (json_decode($agenda->metadata, true) ?? []);
    $pesertaList = $meta['peserta'] ?? [];
    $bidangList = $meta['bidang_terkait'] ?? [];
    $suratMasuk = $meta['surat_masuk'] ?? null;
@endphp

<!-- Header Breadcrumb Banner (Tailwind CSS) -->
<div class="bg-gradient-to-r from-[#0B2545] to-blue-900 text-white py-10 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-blue-200 mb-3">
            <a href="{{ url('') }}" class="hover:text-white transition flex items-center gap-1"><i class="fas fa-home"></i> Beranda</a>
            <i class="fas fa-chevron-right text-[9px] text-blue-300"></i>
            <a href="{{ url('agenda/all') }}" class="hover:text-white transition">Agenda Kegiatan</a>
            <i class="fas fa-chevron-right text-[9px] text-blue-300"></i>
            <span class="text-white font-semibold">Detail Kegiatan</span>
        </nav>
        <div class="flex flex-wrap items-center gap-2 mb-3">
            @if(!empty($agenda->sumber_agenda))
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-500/30 text-blue-200 border border-blue-400/30">
                    <i class="fas fa-tag text-[10px] mr-1.5"></i> {{ $agenda->sumber_agenda }}
                </span>
            @endif
            @if(!empty($meta['nomor_agenda_gubernur']))
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-500/20 text-amber-200 border border-amber-400/30">
                    No. Agenda Gub: {{ $meta['nomor_agenda_gubernur'] }}
                </span>
            @endif
        </div>
        <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white max-w-4xl leading-tight">
            {{ $agenda->title }}
        </h1>
    </div>
</div>

<!-- Main Content (Tailwind CSS) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 font-sans">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Agenda Detail Body (8 cols) -->
        <article class="lg:col-span-8 space-y-6">
            
            <!-- Quick Info Cards -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-sm">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    
                    <!-- 1. Waktu & Tanggal -->
                    <div class="flex items-start gap-3.5 p-3.5 rounded-xl bg-blue-50/70 border border-blue-100">
                        <div class="w-10 h-10 rounded-lg bg-blue-600 text-white flex items-center justify-center flex-shrink-0">
                            <i class="far fa-calendar-alt text-base"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="text-[10px] font-bold text-blue-600 uppercase tracking-wider mb-0.5">Waktu & Jadwal</div>
                            <div class="text-xs font-bold text-slate-800">
                                {{ !empty($meta['tanggal_formatted']) ? $meta['tanggal_formatted'] : date('d F Y', strtotime($agenda->start)) }}
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                @if(!empty($meta['waktu_formatted']))
                                    {{ $meta['waktu_formatted'] }}
                                @else
                                    Pukul {{ date('H:i', strtotime($agenda->start)) }} WIB
                                    @if($agenda->end && $agenda->end != $agenda->start)
                                        s.d. {{ date('H:i', strtotime($agenda->end)) }} WIB
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- 2. Lokasi / Tempat (Dinamis dari API) -->
                    <div class="flex items-start gap-3.5 p-3.5 rounded-xl bg-amber-50/70 border border-amber-100">
                        <div class="w-10 h-10 rounded-lg bg-amber-600 text-white flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-location-dot text-base"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="text-[10px] font-bold text-amber-700 uppercase tracking-wider mb-0.5">Lokasi / Tempat</div>
                            <div class="text-xs font-bold text-slate-800 leading-snug break-words">
                                {{ $agenda->display_location }}
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5 truncate">
                                {{ $agenda->penyelenggara ?: 'Bappeda Provinsi Lampung' }}
                            </div>
                        </div>
                    </div>

                    <!-- 3. Pakaian / Dresscode -->
                    <div class="flex items-start gap-3.5 p-3.5 rounded-xl bg-indigo-50/70 border border-indigo-100 sm:col-span-2 lg:col-span-1">
                        <div class="w-10 h-10 rounded-lg bg-indigo-600 text-white flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shirt text-base"></i>
                        </div>
                        <div class="min-w-0">
                            <div class="text-[10px] font-bold text-indigo-700 uppercase tracking-wider mb-0.5">Pakaian Dinas</div>
                            <div class="text-xs font-bold text-slate-800">
                                {{ $agenda->pakaian ?: 'Batik Bebas Rapi / PSH' }}
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                Status: {{ $agenda->status_waktu ?: 'Terjadwal' }}
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Event Details Content: Deskripsi & Rincian Agenda -->
                <div class="mt-6 pt-6 border-t border-slate-100 space-y-6">
                    
                    <div>
                        <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <i class="fas fa-circle-info text-blue-600"></i> Deskripsi & Rincian Agenda
                        </h2>

                        <!-- Informasi Teknis Rincian Agenda -->
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/70 mb-4 text-xs">
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3">
                                <div>
                                    <dt class="text-slate-400 font-semibold uppercase text-[10px] tracking-wider">Penyelenggara</dt>
                                    <dd class="text-slate-700 font-bold mt-0.5">{{ $agenda->penyelenggara ?: 'Bappeda Provinsi Lampung' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-slate-400 font-semibold uppercase text-[10px] tracking-wider">Sumber Agenda</dt>
                                    <dd class="text-slate-700 font-bold mt-0.5">{{ $agenda->sumber_agenda ?: 'Internal' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-slate-400 font-semibold uppercase text-[10px] tracking-wider">Lokasi Kegiatan</dt>
                                    <dd class="text-slate-700 font-bold mt-0.5">{{ $agenda->display_location }}</dd>
                                </div>
                                <div>
                                    <dt class="text-slate-400 font-semibold uppercase text-[10px] tracking-wider">Ketentuan Pakaian</dt>
                                    <dd class="text-slate-700 font-bold mt-0.5">{{ $agenda->pakaian ?: 'Sesuai ketentuan dinas' }}</dd>
                                </div>
                                @if(!empty($bidangList))
                                    <div class="sm:col-span-2">
                                        <dt class="text-slate-400 font-semibold uppercase text-[10px] tracking-wider mb-1">Bidang / Unit Terkait</dt>
                                        <dd class="flex flex-wrap gap-1.5">
                                            @foreach($bidangList as $b)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-100 text-blue-800">
                                                    {{ $b['nama'] ?? $b }}
                                                </span>
                                            @endforeach
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <!-- Catatan Deskripsi -->
                        <div class="prose max-w-none text-slate-700 text-xs sm:text-sm leading-relaxed">
                            @if(!empty($agenda->content) && strip_tags($agenda->content) != strip_tags($agenda->display_location))
                                {!! $agenda->content !!}
                            @else
                                <p class="text-slate-500 italic bg-white p-3 rounded-lg border border-slate-100">
                                    Agenda resmi Badan Perencanaan Pembangunan Daerah Provinsi Lampung. Silakan hadir tepat waktu sesuai lokasi dan jadwal yang telah ditentukan.
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Disposisi / Peserta Ditugaskan (Jika Data Tersedia dari API) -->
                    @if(!empty($pesertaList))
                        <div class="pt-4 border-t border-slate-100">
                            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-3 flex items-center justify-between">
                                <span class="flex items-center gap-1.5">
                                    <i class="fas fa-users text-blue-600"></i> Disposisi Kehadiran / Peserta
                                </span>
                                <span class="text-[11px] font-semibold text-slate-400 lowercase">({{ count($pesertaList) }} peserta)</span>
                            </h3>

                            <div class="overflow-x-auto rounded-xl border border-slate-200">
                                <table class="min-w-full divide-y divide-slate-200 text-xs">
                                    <thead class="bg-slate-50 text-slate-600">
                                        <tr>
                                            <th class="px-3.5 py-2.5 text-left font-bold uppercase text-[10px] tracking-wider">Nama / Jabatan</th>
                                            <th class="px-3.5 py-2.5 text-left font-bold uppercase text-[10px] tracking-wider">Bidang</th>
                                            <th class="px-3.5 py-2.5 text-center font-bold uppercase text-[10px] tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 bg-white">
                                        @foreach($pesertaList as $p)
                                            <tr class="hover:bg-slate-50/80 transition">
                                                <td class="px-3.5 py-2.5 font-medium text-slate-800">
                                                    {{ $p['nama_penghadir'] ?? $p['nama_disposisi'] ?? $p['nama'] ?? '-' }}
                                                    @if(!empty($p['is_diwakilkan']))
                                                        <span class="text-[10px] text-amber-600 block">(Diwakilkan)</span>
                                                    @endif
                                                </td>
                                                <td class="px-3.5 py-2.5 text-slate-500">
                                                    {{ $p['bidang'] ?? '-' }}
                                                </td>
                                                <td class="px-3.5 py-2.5 text-center">
                                                    @php
                                                        $status = $p['status_kehadiran'] ?? 'PENDING';
                                                        $statusLabel = $p['status_kehadiran_label'] ?? 'Belum Terkonfirmasi';
                                                        $badgeClass = match($status) {
                                                            'HADIR' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                            'IZIN' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                            'TIDAK_HADIR' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                            default => 'bg-slate-100 text-slate-600 border-slate-200'
                                                        };
                                                    @endphp
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold border {{ $badgeClass }}">
                                                        {{ $statusLabel }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Action Button Back -->
                <div class="mt-8 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ url('agenda/all') }}" class="inline-flex items-center gap-2 text-xs font-bold text-blue-700 hover:text-blue-900 transition text-decoration-none">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Agenda
                    </a>
                    <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-xs text-slate-600 hover:bg-slate-50 transition">
                        <i class="fas fa-print"></i> Cetak Agenda
                    </button>
                </div>
            </div>

        </article>

        <!-- Sidebar (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            @include(getTheme('partials.sidebar'))
        </div>

    </div>
</div>

@endsection
