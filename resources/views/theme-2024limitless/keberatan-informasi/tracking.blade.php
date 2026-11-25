@extends(getTheme('layouts.app'))
@section('title', 'Lacak Status Keberatan Informasi')

@section('content')
<section class="bg-gradient-to-r from-[#072146] via-[#09356E] to-[#0B4182] py-10 text-white font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="inline-block px-3 py-1 rounded-full bg-[#F59E0B] text-slate-950 font-black text-[10px] tracking-wider uppercase mb-2.5 shadow">
                PPID BAPPEDA LAMPUNG
            </div>
            <h1 class="text-xl sm:text-3xl font-black text-white m-0">Lacak Status Keberatan Informasi</h1>
            <p class="text-blue-100/90 text-xs sm:text-sm mt-1.5 mb-0">Masukkan Nomor Registrasi Keberatan atau Nomor Permohonan Informasi untuk melihat status pengajuan Anda.</p>
        </div>
        <a href="{{ route('keberatan-informasi.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#F59E0B] hover:bg-amber-500 text-slate-950 text-xs font-black transition text-decoration-none self-start">
            <i class="fas fa-plus text-[10px]"></i>
            <span>Ajukan Keberatan Baru</span>
        </a>
    </div>
</section>

<section class="py-10 bg-slate-50 font-sans min-h-[420px]">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
            <form action="{{ route('keberatan-informasi.tracking') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="nomor" value="{{ $nomor }}" required
                       placeholder="Masukkan Nomor Registrasi (Contoh: KBR-2026-0001)"
                       class="flex-1 px-4 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#1A56DB] hover:bg-[#1344B5] text-white font-bold text-xs shadow border-0 cursor-pointer">
                    <i class="fas fa-search mr-1"></i> Cek Status
                </button>
            </form>
        </div>

        @if($searched)
            @if($keberatan)
                @php $badge = $keberatan->status_badge; @endphp
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-slate-100">
                        <div>
                            <div class="text-[11px] text-slate-400 font-semibold">Nomor Registrasi Keberatan</div>
                            <div class="text-lg font-black text-[#0B2545]">{{ $keberatan->nomor_registrasi_keberatan }}</div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold"
                              style="background:{{ $badge['bg'] }}; color:{{ $badge['color'] }}; border:1px solid {{ $badge['border'] }};">
                            {{ $badge['label'] }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <div class="text-slate-400 font-medium">Nama Pengaju</div>
                            <div class="font-bold text-[#0B2545]">{{ $keberatan->nama }}</div>
                        </div>
                        <div>
                            <div class="text-slate-400 font-medium">Nomor Permohonan Informasi</div>
                            <div class="font-bold text-[#0B2545]">{{ $keberatan->nomor_permohonan_informasi ?: '-' }}</div>
                        </div>
                        <div>
                            <div class="text-slate-400 font-medium">Tanggal Pengajuan</div>
                            <div class="font-bold text-[#0B2545]">{{ $keberatan->created_at->format('d M Y, H:i') }} WIB</div>
                        </div>
                        <div>
                            <div class="text-slate-400 font-medium">Tanggal Respon</div>
                            <div class="font-bold text-[#0B2545]">{{ $keberatan->tanggal_respon ? $keberatan->tanggal_respon->format('d M Y, H:i') . ' WIB' : 'Belum direspon' }}</div>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 text-xs">
                        <div class="font-bold text-[#0B2545] mb-1">Alasan Keberatan</div>
                        <p class="text-slate-600 m-0">{{ $keberatan->alasan_keberatan }}</p>
                    </div>

                    @if($keberatan->tanggapan)
                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-200 text-xs">
                            <div class="font-bold text-[#1A56DB] mb-1">Tanggapan PPID Bappeda</div>
                            <p class="text-slate-700 m-0">{{ $keberatan->tanggapan }}</p>
                        </div>
                    @endif
                </div>
            @else
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 text-center text-xs text-slate-500">
                    <i class="fas fa-search text-2xl text-slate-300 mb-2 block"></i>
                    Data keberatan dengan nomor <strong>{{ $nomor }}</strong> tidak ditemukan.
                </div>
            @endif
        @endif
    </div>
</section>
@endsection
