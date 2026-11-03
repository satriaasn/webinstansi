@extends(getTheme('layouts.app'))
@section('title', 'Formulir Permohonan Informasi Publik - PPID Bappeda Provinsi Lampung')

@push('meta')
    @include('metadefault')
@endpush

@section('content')
<!-- Page Header Banner -->
<section class="bg-gradient-to-r from-[#002256] via-[#002B5C] to-[#013575] text-white py-12 md:py-16 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-blue-200 mb-3" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span class="text-blue-300">Layanan PPID</span>
            <span>/</span>
            <span class="text-white font-semibold">Permohonan Informasi</span>
        </nav>

        <div class="max-w-3xl">
            <div class="inline-block px-3 py-1 rounded-full bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider mb-3">
                Layanan Informasi Publik (PPID)
            </div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-white tracking-tight leading-tight mb-3">
                Formulir Permohonan Informasi Publik
            </h1>
            <p class="text-blue-100 text-xs sm:text-sm leading-relaxed font-light">
                Masyarakat berhak memperoleh informasi publik sesuai ketentuan Undang-Undang No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik. Setiap permohonan yang masuk akan diproses secara transparan dan dapat dilacak statusnya secara real-time.
            </p>
        </div>
    </div>
</section>

<!-- Content Body -->
<section class="bg-slate-50 py-10 md:py-14 font-sans min-h-[600px]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Quick Tracking Banner -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 mb-8 border border-blue-100 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-start sm:items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 text-lg">
                    <i class="fas fa-search"></i>
                </div>
                <div>
                    <h2 class="font-bold text-slate-800 text-sm">Sudah Pernah Mengajukan Permohonan?</h2>
                    <p class="text-xs text-slate-500">Lacak perkembangan status permohonan informasi Anda menggunakan Nomor Tiket.</p>
                </div>
            </div>
            <a href="{{ url('permohonan-informasi/tracking') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow transition flex-shrink-0 text-decoration-none">
                <span>Lacak Status Permohonan</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl p-4 sm:p-5 mb-8">
                <div class="flex items-center gap-2 font-bold text-sm mb-2 text-rose-900">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Terdapat data yang belum lengkap atau tidak valid:</span>
                </div>
                <ul class="text-xs list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Main Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="bg-slate-900 text-white px-6 py-4 border-b border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-clipboard-list text-amber-400"></i>
                    <span class="font-bold text-sm tracking-wide">Formulir Pengajuan Permohonan</span>
                </div>
                <span class="text-[11px] text-slate-400 font-medium">Bappeda Provinsi Lampung</span>
            </div>

            <form action="{{ route('permohonan-informasi.submit') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
                @csrf

                <!-- SECTION 1: Kategori & Identitas Pemohon -->
                <div>
                    <div class="flex items-center gap-2 pb-3 mb-5 border-b border-slate-200">
                        <span class="w-6 h-6 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center">1</span>
                        <h2 class="text-sm sm:text-base font-extrabold text-slate-900 uppercase tracking-wide">Identitas Pemohon Informasi</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Kategori Pemohon -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Kategori Pemohon <span class="text-rose-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 hover:border-blue-400 cursor-pointer bg-slate-50 transition">
                                    <input type="radio" name="kategori_pemohon" value="Perorangan" class="text-blue-600 focus:ring-blue-500" {{ old('kategori_pemohon', 'Perorangan') == 'Perorangan' ? 'checked' : '' }}>
                                    <span class="text-xs font-semibold text-slate-800">Perorangan / Individu</span>
                                </label>
                                <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 hover:border-blue-400 cursor-pointer bg-slate-50 transition">
                                    <input type="radio" name="kategori_pemohon" value="Kelompok Orang" class="text-blue-600 focus:ring-blue-500" {{ old('kategori_pemohon') == 'Kelompok Orang' ? 'checked' : '' }}>
                                    <span class="text-xs font-semibold text-slate-800">Kelompok Masyarakat</span>
                                </label>
                                <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 hover:border-blue-400 cursor-pointer bg-slate-50 transition">
                                    <input type="radio" name="kategori_pemohon" value="Badan Hukum" class="text-blue-600 focus:ring-blue-500" {{ old('kategori_pemohon') == 'Badan Hukum' ? 'checked' : '' }}>
                                    <span class="text-xs font-semibold text-slate-800">Badan Hukum / Organisasi</span>
                                </label>
                            </div>
                        </div>

                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Nama Lengkap Pemohon <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nama_pemohon" value="{{ old('nama_pemohon') }}" required 
                                   placeholder="Contoh: Budi Santoso"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-xs sm:text-sm text-slate-800 placeholder-slate-400">
                        </div>

                        <!-- NIK / No. KTP -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Nomor Identitas (NIK / KTP) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nik" value="{{ old('nik') }}" required 
                                   placeholder="16 digit NIK sesuai KTP"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-xs sm:text-sm text-slate-800 placeholder-slate-400">
                        </div>

                        <!-- Email Aktif -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Alamat Email Aktif <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required 
                                   placeholder="email@domain.com"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-xs sm:text-sm text-slate-800 placeholder-slate-400">
                            <small class="text-[11px] text-slate-500 mt-1 block">Nomor tiket dan notifikasi perkembangan status akan dikirimkan ke email ini.</small>
                        </div>

                        <!-- No. Telepon / WhatsApp -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Nomor Telepon / WhatsApp <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" required 
                                   placeholder="Contoh: 081234567890"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-xs sm:text-sm text-slate-800 placeholder-slate-400">
                        </div>

                        <!-- Pekerjaan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Pekerjaan / Profesi
                            </label>
                            <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" 
                                   placeholder="Contoh: Mahasiswa, Peneliti, Swasta, Wartawan"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-xs sm:text-sm text-slate-800 placeholder-slate-400">
                        </div>

                        <!-- Nama Lembaga / Instansi -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Nama Lembaga / Instansi (Opsional)
                            </label>
                            <input type="text" name="instansi" value="{{ old('instansi') }}" 
                                   placeholder="Contoh: Universitas Lampung / Media / LSM"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-xs sm:text-sm text-slate-800 placeholder-slate-400">
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Alamat Lengkap Sesuai KTP / Domisili <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="alamat" rows="2" required 
                                      placeholder="Tuliskan alamat lengkap beserta RT/RW, Kelurahan, Kecamatan, Kabupaten/Kota"
                                      class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-xs sm:text-sm text-slate-800 placeholder-slate-400">{{ old('alamat') }}</textarea>
                        </div>

                        <!-- Upload File KTP -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Upload Scan / Foto Kartu Identitas (KTP / SIM / Paspor) <span class="text-rose-500">*</span>
                            </label>
                            <input type="file" name="file_ktp" required accept=".jpg,.jpeg,.png,.pdf" 
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50 text-xs text-slate-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                            <small class="text-[11px] text-slate-500 mt-1 block">Format file: JPG, PNG, atau PDF. Ukuran berkas maksimal 3 MB.</small>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: Rincian Informasi yang Dimohonkan -->
                <div>
                    <div class="flex items-center gap-2 pb-3 mb-5 border-b border-slate-200">
                        <span class="w-6 h-6 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center">2</span>
                        <h2 class="text-sm sm:text-base font-extrabold text-slate-900 uppercase tracking-wide">Rincian Informasi Publik yang Dimohon</h2>
                    </div>

                    <div class="space-y-5">
                        <!-- Rincian Informasi -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Rincian Informasi yang Dibutuhkan <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="rincian_informasi" rows="4" required 
                                      placeholder="Jelaskan secara spesifik data atau informasi apa yang Anda butuhkan (contoh: Dokumen Laporan Kinerja Bappeda 2024, Data Statistik Pembangunan Daerah, dll)"
                                      class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-xs sm:text-sm text-slate-800 placeholder-slate-400">{{ old('rincian_informasi') }}</textarea>
                        </div>

                        <!-- Tujuan Penggunaan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Tujuan Penggunaan Informasi <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="tujuan_penggunaan" rows="3" required 
                                      placeholder="Jelaskan untuk keperluan apa informasi tersebut akan digunakan (contoh: Riset Tugas Akhir Skripsi, Penelitian Akademik, Evaluasi Kebijakan Publik, dll)"
                                      class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-xs sm:text-sm text-slate-800 placeholder-slate-400">{{ old('tujuan_penggunaan') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Cara Memperoleh -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Cara Memperoleh Informasi <span class="text-rose-500">*</span>
                                </label>
                                <select name="cara_memperoleh" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-xs sm:text-sm text-slate-800 bg-white">
                                    <option value="Mendapatkan Salinan Dokumen (Softcopy / Digital)" {{ old('cara_memperoleh') == 'Mendapatkan Salinan Dokumen (Softcopy / Digital)' ? 'selected' : '' }}>Mendapatkan Salinan Dokumen (Softcopy / Digital)</option>
                                    <option value="Melihat / Membaca / Mendengarkan / Mencatat" {{ old('cara_memperoleh') == 'Melihat / Membaca / Mendengarkan / Mencatat' ? 'selected' : '' }}>Melihat / Membaca / Mendengarkan / Mencatat</option>
                                    <option value="Mendapatkan Salinan Dokumen Cetak (Hardcopy)" {{ old('cara_memperoleh') == 'Mendapatkan Salinan Dokumen Cetak (Hardcopy)' ? 'selected' : '' }}>Mendapatkan Salinan Dokumen Cetak (Hardcopy)</option>
                                </select>
                            </div>

                            <!-- Cara Penyerahan -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Cara Penyerahan / Pengiriman <span class="text-rose-500">*</span>
                                </label>
                                <select name="cara_penyerahan" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-xs sm:text-sm text-slate-800 bg-white">
                                    <option value="Email" {{ old('cara_penyerahan') == 'Email' ? 'selected' : '' }}>Email (Pengiriman Daring)</option>
                                    <option value="Mengambil Langsung di Kantor Bappeda" {{ old('cara_penyerahan') == 'Mengambil Langsung di Kantor Bappeda' ? 'selected' : '' }}>Mengambil Langsung di Kantor Bappeda</option>
                                    <option value="WhatsApp / Tautan Download" {{ old('cara_penyerahan') == 'WhatsApp / Tautan Download' ? 'selected' : '' }}>WhatsApp / Tautan Download</option>
                                    <option value="Pos / Kurir" {{ old('cara_penyerahan') == 'Pos / Kurir' ? 'selected' : '' }}>Pos / Kurir</option>
                                </select>
                            </div>
                        </div>

                        <!-- Dokumen Pendukung -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Dokumen Pendukung (Opsional)
                            </label>
                            <input type="file" name="file_pendukung" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.zip,.rar" 
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 bg-slate-50 text-xs text-slate-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-700 file:text-white hover:file:bg-slate-800">
                            <small class="text-[11px] text-slate-500 mt-1 block">Contoh: Surat Pengantar Penelitian dari Kampus, Surat Tugas Lembaga, Proposal Riset. Format PDF/Doc/Zip, Maks. 5 MB.</small>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: Pernyataan & Submit -->
                <div class="pt-4 border-t border-slate-200">
                    <label class="flex items-start gap-3 p-4 rounded-xl bg-amber-50 border border-amber-200 text-xs text-slate-800 mb-6 cursor-pointer">
                        <input type="checkbox" required class="mt-0.5 rounded text-amber-500 focus:ring-amber-400">
                        <span class="leading-relaxed">
                            Saya menyatakan bahwa data yang saya isikan adalah benar, dan informasi yang saya peroleh akan dipergunakan secara bertanggung jawab sesuai dengan peraturan perundang-undangan yang berlaku.
                        </span>
                    </label>

                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-xs text-slate-500 text-center sm:text-left">
                            <i class="fas fa-shield-alt text-emerald-600 mr-1"></i> Data Anda aman dan terlindungi oleh ketentuan privasi PPID.
                        </div>
                        <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-[#F59E0B] hover:bg-amber-500 text-slate-950 font-black text-sm tracking-wide shadow-lg transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <span>Kirim Permohonan Informasi</span>
                            <i class="fas fa-paper-plane text-xs"></i>
                        </button>
                    </div>
                </div>

            </form>
        </div>

    </div>
</section>
@endsection

