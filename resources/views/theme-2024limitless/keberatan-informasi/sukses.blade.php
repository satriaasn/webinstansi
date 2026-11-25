@extends(getTheme('layouts.app'))
@section('title', 'Keberatan Informasi Terkirim')

@section('content')
<section class="py-12 bg-slate-50 font-sans min-h-[500px]">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 text-center">
            <div class="w-16 h-16 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center text-3xl mx-auto mb-4">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-[#0B2545] mb-2">
                Pernyataan Keberatan Berhasil Dikirim!
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 mb-6">
                Terima kasih <strong>{{ $keberatan->nama }}</strong>. Pengajuan keberatan informasi Anda telah tercatat oleh PPID Bappeda Provinsi Lampung.
            </p>

            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5 mb-6">
                <div class="text-[11px] font-bold text-[#1A56DB] uppercase tracking-wider mb-1">Nomor Registrasi Keberatan Anda</div>
                <div class="text-2xl font-black text-[#0B2545] tracking-wide">{{ $keberatan->nomor_registrasi_keberatan }}</div>
                <div class="text-[11px] text-slate-500 mt-1">Simpan nomor registrasi ini untuk memantau status tindak lanjut keberatan Anda.</div>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('keberatan-informasi.tracking', ['nomor' => $keberatan->nomor_registrasi_keberatan]) }}"
                   class="px-5 py-2.5 rounded-full bg-[#1A56DB] hover:bg-[#1344B5] text-white font-bold text-xs shadow transition inline-flex items-center gap-2 text-decoration-none">
                    <i class="fas fa-search text-[10px]"></i>
                    <span>Lacak Status Keberatan</span>
                </a>
                <a href="{{ url('/') }}"
                   class="px-5 py-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition inline-flex items-center gap-2 text-decoration-none">
                    <i class="fas fa-home text-[10px]"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
