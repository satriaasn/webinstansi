@extends(getTheme('layouts.app'))
@section('title', 'Tanda Terima Permohonan Informasi - PPID Bappeda Provinsi Lampung')

@push('meta')
    @include('metadefault')
@endpush

@section('content')
<section class="bg-slate-50 py-12 md:py-16 font-sans min-h-[650px] flex items-center">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 w-full">

        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden print:border-0 print:shadow-none">
            
            <!-- Success Header -->
            <div class="bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-800 text-white p-8 text-center relative">
                <div class="w-16 h-16 rounded-full bg-white/20 text-white flex items-center justify-center text-3xl mx-auto mb-3 shadow-inner">
                    <i class="fas fa-check"></i>
                </div>
                <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight mb-1">
                    Permohonan Berhasil Dikirim!
                </h1>
                <p class="text-xs sm:text-sm text-emerald-100 font-light max-w-md mx-auto">
                    Terima kasih, permohonan informasi publik Anda telah kami terima dan segera ditindaklanjuti oleh tim PPID Bappeda Provinsi Lampung.
                </p>
            </div>

            <!-- Receipt Card Body -->
            <div class="p-6 sm:p-8 space-y-6">

                <!-- Ticket Code Highlight -->
                <div class="bg-slate-50 border-2 border-dashed border-blue-300 rounded-2xl p-5 text-center">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">
                        Nomor Tiket Registrasi (Simpan Kode Ini)
                    </span>
                    <div class="flex items-center justify-center gap-3 my-1">
                        <span class="text-2xl sm:text-3xl font-black text-blue-900 font-mono tracking-widest">
                            {{ $permohonan->nomor_tiket }}
                        </span>
                        <button type="button" onclick="navigator.clipboard.writeText('{{ $permohonan->nomor_tiket }}'); alert('Nomor tiket berhasil disalin ke clipboard!');" 
                                class="px-2.5 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded-lg text-xs font-bold transition flex items-center gap-1 shadow-sm" title="Salin Nomor Tiket">
                            <i class="fas fa-copy"></i>
                            <span class="hidden sm:inline">Salin</span>
                        </button>
                    </div>
                    <span class="text-[11px] text-slate-500 block mt-1">
                        Gunakan kode tiket di atas untuk mengecek status permohonan Anda kapan saja.
                    </span>
                </div>

                <!-- Tanda Terima Table -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden text-xs">
                    <div class="bg-slate-100 px-4 py-2.5 font-bold text-slate-700 border-b border-slate-200 flex justify-between items-center">
                        <span>BUKTI TANDA TERIMA PERMOHONAN</span>
                        <span class="text-[10px] text-slate-500 font-normal">{{ date('d/m/Y H:i') }} WIB</span>
                    </div>
                    <table class="w-full">
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="px-4 py-2.5 text-slate-500 font-medium w-1/3 bg-slate-50/50">Nama Pemohon</td>
                                <td class="px-4 py-2.5 text-slate-900 font-bold">{{ $permohonan->nama_pemohon }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2.5 text-slate-500 font-medium bg-slate-50/50">Kategori</td>
                                <td class="px-4 py-2.5 text-slate-800">{{ $permohonan->kategori_pemohon }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2.5 text-slate-500 font-medium bg-slate-50/50">Email Pemohon</td>
                                <td class="px-4 py-2.5 text-slate-800">{{ $permohonan->email }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2.5 text-slate-500 font-medium bg-slate-50/50">WhatsApp / Telp</td>
                                <td class="px-4 py-2.5 text-slate-800">{{ $permohonan->no_telepon }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2.5 text-slate-500 font-medium bg-slate-50/50">Informasi Dimohon</td>
                                <td class="px-4 py-2.5 text-slate-800 leading-relaxed">{{ $permohonan->rincian_informasi }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2.5 text-slate-500 font-medium bg-slate-50/50">Status Awal</td>
                                <td class="px-4 py-2.5">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold text-[11px]">
                                        Menunggu Verifikasi Petugas
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Info Notice -->
                <div class="flex items-start gap-3 p-4 rounded-xl bg-blue-50 border border-blue-200 text-xs text-blue-900">
                    <i class="fas fa-info-circle text-blue-600 text-sm mt-0.5 flex-shrink-0"></i>
                    <div class="leading-relaxed">
                        Pemberitahuan bukti tanda terima registrasi telah dikirimkan ke email <strong>{{ $permohonan->email }}</strong>. Petugas PPID Bappeda akan memverifikasi dan merespon permohonan Anda selambat-lambatnya sesuai jangka waktu standar layanan keterbukaan informasi.
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2 print:hidden">
                    <a href="{{ route('permohonan-informasi.tracking', ['tiket' => $permohonan->nomor_tiket]) }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow transition text-decoration-none">
                        <i class="fas fa-search"></i>
                        <span>Lacak Status Permohonan Ini</span>
                    </a>

                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button type="button" onclick="window.print()" 
                                class="w-1/2 sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-3 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs transition border border-slate-300">
                            <i class="fas fa-print"></i>
                            <span>Cetak Bukti</span>
                        </button>
                        <a href="{{ url('/') }}" 
                           class="w-1/2 sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-3 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs transition border border-slate-300 text-decoration-none">
                            <i class="fas fa-home"></i>
                            <span>Beranda</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>
@endsection

