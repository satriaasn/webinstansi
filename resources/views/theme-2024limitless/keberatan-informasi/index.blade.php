@extends(getTheme('layouts.app'))
@section('title', 'Pernyataan Keberatan Atas Permohonan Informasi')

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
                    LAYANAN PPID BAPPEDA
                </div>
                <h1 class="text-xl sm:text-3xl font-black text-white leading-tight m-0">
                    Pernyataan Keberatan Atas Permohonan Informasi
                </h1>
                <p class="text-blue-100/90 text-xs sm:text-sm mt-2 mb-0 max-w-2xl">
                    Formulir resmi pengajuan keberatan atas permohonan informasi publik pada PPID Pembantu Bappeda Provinsi Lampung.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('keberatan-informasi.tracking') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 text-white text-xs font-bold border border-white/20 transition text-decoration-none">
                    <i class="fas fa-search text-[10px]"></i>
                    <span>Lacak Status Keberatan</span>
                </a>
                <a href="{{ route('permohonan-informasi.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#F59E0B] hover:bg-amber-500 text-slate-950 text-xs font-black transition text-decoration-none">
                    <i class="fas fa-file-alt text-[10px]"></i>
                    <span>Form Permohonan Informasi</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Form Section -->
<section class="py-10 bg-slate-50 font-sans">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-2xl p-4 text-xs">
                <div class="font-bold mb-1.5 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Mohon lengkapi data berikut:</span>
                </div>
                <ul class="list-disc pl-5 mb-0 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
            <form action="{{ route('keberatan-informasi.submit') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Info Nomor Registrasi Otomatis -->
                <div class="bg-blue-50/70 border border-blue-200 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <div class="text-[11px] font-bold text-[#1A56DB] uppercase tracking-wider">Nomor Registrasi Keberatan (Otomatis)</div>
                        <div class="text-base font-black text-[#0B2545]">{{ $nomorRegistrasi }}</div>
                    </div>
                    <span class="text-[11px] text-slate-500">Nomor registrasi akan dicatat otomatis saat formulir dikirim.</span>
                </div>

                <!-- 1. Informasi Pengaju Keberatan -->
                <div>
                    <label for="informasi_pengaju_keberatan" class="block text-xs font-bold text-[#0B2545] mb-1.5">
                        Informasi Pengaju Keberatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="informasi_pengaju_keberatan" id="informasi_pengaju_keberatan" required
                           value="{{ old('informasi_pengaju_keberatan', 'Pemohon Informasi') }}"
                           placeholder="Contoh: Pemohon Informasi / Kuasa Pemohon"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]">
                </div>

                <!-- 2. Nomor Permohonan Informasi -->
                <div>
                    <label for="nomor_permohonan_informasi" class="block text-xs font-bold text-[#0B2545] mb-1.5">
                        Nomor Permohonan Informasi <span class="text-slate-400 font-normal">(Nomor tiket permohonan sebelumnya jika ada)</span>
                    </label>
                    <input type="text" name="nomor_permohonan_informasi" id="nomor_permohonan_informasi"
                           value="{{ old('nomor_permohonan_informasi') }}"
                           placeholder="Contoh: PPID-2026-0001"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]">
                </div>

                <!-- 3. Tujuan Penggunaan Informasi -->
                <div>
                    <label for="tujuan_penggunaan_informasi" class="block text-xs font-bold text-[#0B2545] mb-1.5">
                        Tujuan Penggunaan Informasi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="tujuan_penggunaan_informasi" id="tujuan_penggunaan_informasi" rows="3" required
                              placeholder="Jelaskan tujuan penggunaan informasi yang dimohonkan..."
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]">{{ old('tujuan_penggunaan_informasi') }}</textarea>
                </div>

                <hr class="border-slate-200 my-2">
                <div class="text-xs font-black text-[#1A56DB] uppercase tracking-wider">Identitas Pengaju Keberatan</div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- 4. Nama -->
                    <div>
                        <label for="nama" class="block text-xs font-bold text-[#0B2545] mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" required value="{{ old('nama') }}"
                               placeholder="Masukkan nama lengkap Anda"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]">
                    </div>

                    <!-- 5. Nomor Telepon -->
                    <div>
                        <label for="nomor_telepon" class="block text-xs font-bold text-[#0B2545] mb-1.5">
                            Nomor Telepon / WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nomor_telepon" id="nomor_telepon" required value="{{ old('nomor_telepon') }}"
                               placeholder="Contoh: 0812xxxxxxxx"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]">
                    </div>
                </div>

                <!-- 6. Pekerjaan -->
                <div>
                    <label for="pekerjaan" class="block text-xs font-bold text-[#0B2545] mb-1.5">
                        Pekerjaan
                    </label>
                    <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan') }}"
                           placeholder="Contoh: Mahasiswa / Wartawan / Swasta / PNS"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]">
                </div>

                <!-- 7. Alamat Lengkap -->
                <div>
                    <label for="alamat_lengkap" class="block text-xs font-bold text-[#0B2545] mb-1.5">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" required
                              placeholder="Tuliskan alamat lengkap tempat tinggal saat ini..."
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]">{{ old('alamat_lengkap') }}</textarea>
                </div>

                <hr class="border-slate-200 my-2">
                <div class="text-xs font-black text-[#1A56DB] uppercase tracking-wider">Detail Keberatan</div>

                <!-- 8. Alasan Keberatan -->
                <div>
                    <label for="alasan_keberatan" class="block text-xs font-bold text-[#0B2545] mb-1.5">
                        Alasan Keberatan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alasan_keberatan" id="alasan_keberatan" rows="3" required
                              placeholder="Contoh: Permohonan informasi ditolak / Informasi berkala tidak disediakan / Permintaan informasi tidak ditanggapi / Biaya yang dikenakan tidak wajar..."
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]">{{ old('alasan_keberatan') }}</textarea>
                </div>

                <!-- 9. Kasus Posisi -->
                <div>
                    <label for="kasus_posisi" class="block text-xs font-bold text-[#0B2545] mb-1.5">
                        Kasus Posisi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="kasus_posisi" id="kasus_posisi" rows="4" required
                              placeholder="Uraikan kronologi atau kasus posisi pengajuan keberatan Anda..."
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#1A56DB]">{{ old('kasus_posisi') }}</textarea>
                </div>

                <div class="pt-4 flex flex-wrap items-center justify-between gap-3">
                    <span class="text-[11px] text-slate-500">Pastikan seluruh data bertanda (<span class="text-red-500">*</span>) sudah terisi dengan benar.</span>
                    <button type="submit"
                            class="px-6 py-3 rounded-full bg-[#1A56DB] hover:bg-[#1344B5] text-white font-black text-xs shadow-md transition inline-flex items-center gap-2 border-0 cursor-pointer">
                        <i class="fas fa-paper-plane text-[11px]"></i>
                        <span>Kirim Pernyataan Keberatan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
