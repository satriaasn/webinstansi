@extends(getTheme('layouts.app'))
@section('title', 'Lacak Status Permohonan Informasi - PPID Bappeda Provinsi Lampung')

@push('meta')
    @include('metadefault')
@endpush

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-[#002256] via-[#002B5C] to-[#013575] text-white py-12 md:py-16 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-blue-200 mb-3" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ url('permohonan-informasi') }}" class="hover:text-white transition text-blue-200">Layanan PPID</a>
            <span>/</span>
            <span class="text-white font-semibold">Pelacakan Status</span>
        </nav>

        <div class="max-w-3xl">
            <div class="inline-block px-3 py-1 rounded-full bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider mb-3">
                Tracking Online
            </div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-white tracking-tight leading-tight mb-2">
                Lacak Status Permohonan Informasi
            </h1>
            <p class="text-blue-100 text-xs sm:text-sm leading-relaxed font-light">
                Pantau perkembangan dan tindak lanjut permohonan informasi publik Anda secara transparan dan akurat.
            </p>
        </div>
    </div>
</section>

<!-- Content Body -->
<section class="bg-slate-50 py-10 md:py-14 font-sans min-h-[600px]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Search Box Card -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm mb-8">
            <form action="{{ route('permohonan-informasi.tracking') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                    <div class="md:col-span-8">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nomor Tiket Permohonan <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-ticket-alt"></i>
                            </span>
                            <input type="text" name="tiket" value="{{ $tiket }}" required 
                                   placeholder="Contoh: INF-202611-ABCD"
                                   class="w-full pl-10 pr-3.5 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm font-semibold uppercase text-slate-900 placeholder-slate-400 tracking-wider">
                        </div>
                    </div>
                    <div class="md:col-span-4 flex items-end">
                        <button type="submit" class="w-full py-3 px-6 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow transition flex items-center justify-center gap-2">
                            <i class="fas fa-search text-xs"></i>
                            <span>Lacak Permohonan</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @if($searched)
            @if($permohonan)
                <!-- Result Found Card -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
                    <!-- Result Header -->
                    @php
                        $colorData = $permohonan->getStatusColorClass();
                    @endphp
                    <div class="p-6 sm:p-8 border-b border-slate-200 {{ $colorData['bg'] }} {{ $colorData['border'] }}">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Nomor Tiket Registrasi</span>
                                <div class="flex items-center gap-2">
                                    <span class="text-xl sm:text-2xl font-black text-slate-900 tracking-wider">{{ $permohonan->nomor_tiket }}</span>
                                    <button type="button" onclick="navigator.clipboard.writeText('{{ $permohonan->nomor_tiket }}'); alert('Nomor tiket berhasil disalin!');" 
                                            class="px-2 py-1 bg-white/80 hover:bg-white text-slate-700 rounded text-xs font-semibold shadow-sm border border-slate-300" title="Salin Tiket">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                <span class="text-xs text-slate-600 mt-1 block">
                                    Diajukan pada: <strong>{{ $permohonan->created_at->format('d F Y, H:i') }} WIB</strong>
                                </span>
                            </div>

                            <div class="flex flex-col items-start sm:items-end">
                                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Status Terkini</span>
                                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full {{ $colorData['bg'] }} {{ $colorData['text'] }} border {{ $colorData['border'] }} font-extrabold text-xs sm:text-sm tracking-wide shadow-sm">
                                    <i class="fas {{ $colorData['icon'] }} text-xs"></i>
                                    <span>{{ $permohonan->status_label }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Step Timeline -->
                    <div class="p-6 sm:p-8 border-b border-slate-100 bg-slate-50/50">
                        <div class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-6">Tahapan Proses Permohonan</div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 relative">
                            <!-- Step 1 -->
                            <div class="flex sm:flex-col items-center sm:items-center gap-3 sm:gap-2 text-left sm:text-center">
                                <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-xs shadow flex-shrink-0">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900">1. Diajukan</div>
                                    <div class="text-[10px] text-slate-500">{{ $permohonan->created_at->format('d/m/Y') }}</div>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            @php
                                $step2Passed = in_array($permohonan->status, ['diproses', 'selesai', 'ditolak']);
                            @endphp
                            <div class="flex sm:flex-col items-center sm:items-center gap-3 sm:gap-2 text-left sm:text-center">
                                <div class="w-8 h-8 rounded-full {{ $step2Passed ? 'bg-emerald-500 text-white' : 'bg-amber-400 text-slate-900 animate-pulse' }} flex items-center justify-center font-bold text-xs shadow flex-shrink-0">
                                    @if($step2Passed)
                                        <i class="fas fa-check"></i>
                                    @else
                                        <span>2</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900">2. Verifikasi Berkas</div>
                                    <div class="text-[10px] text-slate-500">{{ $step2Passed ? 'Lolos Verifikasi' : 'Dalam Antrean' }}</div>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            @php
                                $step3Active = $permohonan->status == 'diproses';
                                $step3Passed = in_array($permohonan->status, ['selesai', 'ditolak']);
                            @endphp
                            <div class="flex sm:flex-col items-center sm:items-center gap-3 sm:gap-2 text-left sm:text-center">
                                <div class="w-8 h-8 rounded-full {{ $step3Passed ? 'bg-emerald-500 text-white' : ($step3Active ? 'bg-blue-600 text-white animate-pulse' : 'bg-slate-200 text-slate-600') }} flex items-center justify-center font-bold text-xs shadow flex-shrink-0">
                                    @if($step3Passed)
                                        <i class="fas fa-check"></i>
                                    @else
                                        <span>3</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900">3. Pemrosesan Data</div>
                                    <div class="text-[10px] text-slate-500">{{ $step3Passed ? 'Selesai Diproses' : ($step3Active ? 'Sedang Diproses' : 'Menunggu') }}</div>
                                </div>
                            </div>

                            <!-- Step 4 -->
                            @php
                                $step4Done = $permohonan->status == 'selesai';
                                $step4Rejected = $permohonan->status == 'ditolak';
                            @endphp
                            <div class="flex sm:flex-col items-center sm:items-center gap-3 sm:gap-2 text-left sm:text-center">
                                <div class="w-8 h-8 rounded-full {{ $step4Done ? 'bg-emerald-500 text-white' : ($step4Rejected ? 'bg-rose-500 text-white' : 'bg-slate-200 text-slate-600') }} flex items-center justify-center font-bold text-xs shadow flex-shrink-0">
                                    @if($step4Done)
                                        <i class="fas fa-check-double"></i>
                                    @elseif($step4Rejected)
                                        <i class="fas fa-times"></i>
                                    @else
                                        <span>4</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900">4. Keputusan / Berkas</div>
                                    <div class="text-[10px] text-slate-500">{{ $step4Done ? 'Selesai & Diserahkan' : ($step4Rejected ? 'Ditolak' : 'Menunggu') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Body -->
                    <div class="p-6 sm:p-8 space-y-6">
                        <!-- Official Response from PPID if exists -->
                        @if(!empty($permohonan->tanggapan))
                            <div class="p-5 rounded-xl bg-blue-50 border border-blue-200">
                                <div class="flex items-center gap-2 text-blue-900 font-bold text-xs uppercase tracking-wider mb-2">
                                    <i class="fas fa-comment-dots text-blue-600"></i>
                                    <span>Tanggapan / Catatan Resmi PPID:</span>
                                </div>
                                <div class="text-xs sm:text-sm text-slate-800 leading-relaxed">
                                    {!! nl2br(e($permohonan->tanggapan)) !!}
                                </div>

                                <!-- Download Button if Admin attached a file -->
                                @if(!empty($permohonan->file_lampiran_jawaban))
                                    <div class="mt-4 pt-4 border-t border-blue-200/60 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div class="text-xs text-blue-900 font-semibold">
                                            <i class="fas fa-file-pdf text-red-500 mr-1.5"></i>
                                            <span>Dokumen Lampiran Jawaban Permohonan</span>
                                        </div>
                                        <a href="{{ route('permohonan-informasi.download-jawaban', ['tiket' => $permohonan->nomor_tiket]) }}" 
                                           class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow transition text-decoration-none">
                                            <i class="fas fa-download"></i>
                                            <span>Unduh Berkas Jawaban</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Summary of Requested Info -->
                        <div>
                            <div class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Rincian Permohonan</div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                                    <span class="text-slate-500 font-semibold block mb-1">Informasi yang Dimohon:</span>
                                    <p class="text-slate-800 font-medium leading-relaxed">{{ $permohonan->rincian_informasi }}</p>
                                </div>
                                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                                    <span class="text-slate-500 font-semibold block mb-1">Tujuan Penggunaan:</span>
                                    <p class="text-slate-800 font-medium leading-relaxed">{{ $permohonan->tujuan_penggunaan }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Applicant masked info for privacy -->
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-slate-600">
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase">Pemohon</span>
                                    <strong class="text-slate-800">{{ Str::mask($permohonan->nama_pemohon, '*', 3, -2) }}</strong>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase">Kategori</span>
                                    <strong class="text-slate-800">{{ $permohonan->kategori_pemohon }}</strong>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase">Cara Peroleh</span>
                                    <strong class="text-slate-800">{{ $permohonan->cara_memperoleh }}</strong>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase">Penyerahan</span>
                                    <strong class="text-slate-800">{{ $permohonan->cara_penyerahan }}</strong>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @else
                <!-- Result Not Found -->
                <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm text-center mb-8">
                    <div class="w-14 h-14 rounded-full bg-rose-50 text-rose-500 mx-auto flex items-center justify-center text-2xl mb-4">
                        <i class="fas fa-search-minus"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Permohonan Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto mb-5 leading-relaxed">
                        Nomor tiket <strong class="text-slate-800 font-mono">{{ $tiket }}</strong> tidak ditemukan dalam sistem kami. Mohon pastikan kode tiket yang Anda masukkan sudah benar.
                    </p>
                    <a href="{{ url('permohonan-informasi') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-blue-600 text-white font-bold text-xs shadow hover:bg-blue-700 transition text-decoration-none">
                        <i class="fas fa-plus"></i>
                        <span>Buat Permohonan Baru</span>
                    </a>
                </div>
            @endif
        @endif

        <!-- Help Info Box -->
        <div class="rounded-2xl p-6 bg-blue-50/70 border border-blue-200/70 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 text-xs text-slate-700">
            <div>
                <strong class="text-slate-900 block mb-0.5 font-bold">Butuh Bantuan Pelayanan Informasi?</strong>
                <span class="text-slate-500">Hubungi petugas PPID Bappeda Provinsi Lampung pada jam kerja operasional.</span>
            </div>
            <div class="flex items-center gap-3 flex-shrink-0">
                <a href="tel:0721470411" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-slate-300 font-semibold text-slate-800 hover:bg-slate-50 text-decoration-none">
                    <i class="fas fa-phone text-blue-600"></i>
                    <span>(0721) 470411</span>
                </a>
                <a href="mailto:bappeda@lampungprov.go.id" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-slate-300 font-semibold text-slate-800 hover:bg-slate-50 text-decoration-none">
                    <i class="fas fa-envelope text-blue-600"></i>
                    <span>Email PPID</span>
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
