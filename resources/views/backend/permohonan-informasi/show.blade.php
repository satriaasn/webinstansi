@extends('layouts.backend')
@section('title', 'Detail Permohonan Informasi - ' . $permohonan->nomor_tiket)

@section('content')
    <div class="br-pageheader font-sans">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/permohonan-informasi/table') }}">Permohonan Informasi</a>
            <span class="breadcrumb-item active">{{ $permohonan->nomor_tiket }}</span>
        </nav>
    </div>

    <!-- Page Title & Top Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 font-sans">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-2xl bg-blue-50 text-[#1A56DB] flex items-center justify-center text-xl shadow-xs flex-shrink-0">
                <i class="fas fa-file-shield"></i>
            </div>
            <div>
                <h1 class="text-lg sm:text-xl font-black text-slate-800 m-0 leading-tight">Detail Permohonan Informasi</h1>
                <p class="text-xs text-slate-500 m-0 mt-0.5">
                    Nomor Registrasi: <strong class="text-[#1A56DB]">{{ $permohonan->nomor_tiket }}</strong>
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ url('dashboard/permohonan-informasi/table') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition text-decoration-none shadow-xs">
                <i class="fas fa-arrow-left text-[11px]"></i> Kembali ke Daftar
            </a>
            <a href="#form-tindak-lanjut" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition text-decoration-none shadow-xs">
                <i class="fas fa-pen-to-square text-[11px]"></i> Update Status & Tanggapi
            </a>
            <a href="{{ url('permohonan-informasi/tracking?tiket=' . $permohonan->nomor_tiket) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-[#1A56DB] border border-blue-200 text-xs font-bold transition text-decoration-none shadow-xs">
                <i class="fas fa-arrow-up-right-from-square text-[11px]"></i> Buka Halaman Tracking Publik
            </a>
        </div>
    </div>

    <div class="font-sans">
        @if(Session::has('flash_message'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center justify-between shadow-sm mb-6">
                <div class="flex items-center gap-2 font-medium">
                    <i class="fas fa-check-circle text-emerald-600 text-sm"></i>
                    <span>{{ Session::get('flash_message') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 p-1">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        @endif

        <!-- Main 2-Column Responsive Layout -->
        <div class="flex flex-col lg:flex-row gap-6 items-start">
            
            <!-- ====================================================================
                 KOLOM KIRI (7/12): DATA PEMOHON & RINCIAN INFORMASI
                 ==================================================================== -->
            <div class="w-full lg:w-7/12 space-y-6">
                
                <!-- Card 1: Data Identitas Pemohon -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-[#1A56DB] flex items-center justify-center text-xs">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <h2 class="text-sm font-black text-slate-800 m-0">Data Identitas Pemohon</h2>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200">
                            {{ $permohonan->kategori_pemohon ?: 'Perorangan' }}
                        </span>
                    </div>

                    <div class="p-5">
                        <div class="divide-y divide-slate-100 text-xs">
                            <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-1">
                                <div class="font-bold text-slate-500">Nama Pemohon</div>
                                <div class="sm:col-span-2 font-black text-slate-900 text-sm">{{ $permohonan->nama_pemohon }}</div>
                            </div>
                            <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-1">
                                <div class="font-bold text-slate-500">NIK / Identitas</div>
                                <div class="sm:col-span-2 font-mono font-bold text-slate-800">{{ $permohonan->nik }}</div>
                            </div>
                            <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-1">
                                <div class="font-bold text-slate-500">Alamat Email</div>
                                <div class="sm:col-span-2">
                                    <a href="mailto:{{ $permohonan->email }}" class="text-[#1A56DB] hover:underline font-bold inline-flex items-center gap-1.5">
                                        <i class="fas fa-envelope text-[11px]"></i> {{ $permohonan->email }}
                                    </a>
                                </div>
                            </div>
                            <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-1">
                                <div class="font-bold text-slate-500">No. WhatsApp / HP</div>
                                <div class="sm:col-span-2">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $permohonan->no_telepon) }}" target="_blank" class="text-emerald-600 hover:text-emerald-700 hover:underline font-bold inline-flex items-center gap-1.5">
                                        <i class="fab fa-whatsapp text-sm text-emerald-500"></i> {{ $permohonan->no_telepon }}
                                    </a>
                                </div>
                            </div>
                            <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-1">
                                <div class="font-bold text-slate-500">Pekerjaan / Instansi</div>
                                <div class="sm:col-span-2 font-semibold text-slate-800">
                                    {{ $permohonan->pekerjaan ?: '-' }}
                                    @if($permohonan->instansi)
                                        <span class="text-slate-400 mx-1">/</span> <strong class="text-slate-900">{{ $permohonan->instansi }}</strong>
                                    @endif
                                </div>
                            </div>
                            <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-1">
                                <div class="font-bold text-slate-500">Alamat Lengkap</div>
                                <div class="sm:col-span-2 text-slate-700 leading-relaxed">{{ $permohonan->alamat }}</div>
                            </div>
                            <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-1 items-center">
                                <div class="font-bold text-slate-500">Berkas Kartu Identitas (KTP)</div>
                                <div class="sm:col-span-2">
                                    @if(!empty($permohonan->file_ktp))
                                        <a href="{{ berkas($permohonan->file_ktp) ?: url('berkas/' . $permohonan->file_ktp) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-[#1A56DB] border border-blue-200 font-bold hover:bg-blue-100 transition text-decoration-none">
                                            <i class="fas fa-id-card text-xs"></i> Lihat & Unduh Berkas KTP
                                        </a>
                                    @else
                                        <span class="text-slate-400 italic">Tidak ada berkas KTP</span>
                                    @endif
                                </div>
                            </div>
                            @if(!empty($permohonan->file_pendukung))
                                <div class="py-2.5 grid grid-cols-1 sm:grid-cols-3 gap-1 items-center">
                                    <div class="font-bold text-slate-500">Dokumen Pendukung</div>
                                    <div class="sm:col-span-2">
                                        <a href="{{ berkas($permohonan->file_pendukung) ?: url('berkas/' . $permohonan->file_pendukung) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 border border-slate-300 font-bold hover:bg-slate-200 transition text-decoration-none">
                                            <i class="fas fa-paperclip text-xs"></i> Unduh Dokumen Pendukung
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card 2: Rincian Permohonan Informasi -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">
                                <i class="fas fa-file-lines"></i>
                            </div>
                            <h2 class="text-sm font-black text-slate-800 m-0">Rincian Informasi yang Dimohonkan</h2>
                        </div>
                    </div>

                    <div class="p-5 space-y-4 text-xs">
                        <div>
                            <label class="font-bold text-slate-500 uppercase tracking-wider block mb-1.5">Rincian Informasi Dibutuhkan:</label>
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 leading-relaxed whitespace-pre-line text-xs font-medium">
                                {{ $permohonan->rincian_informasi }}
                            </div>
                        </div>

                        <div>
                            <label class="font-bold text-slate-500 uppercase tracking-wider block mb-1.5">Tujuan Penggunaan Informasi:</label>
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 leading-relaxed whitespace-pre-line text-xs font-medium">
                                {{ $permohonan->tujuan_penggunaan }}
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                            <div>
                                <label class="font-bold text-slate-500 uppercase tracking-wider block mb-1">Cara Memperoleh:</label>
                                <div class="font-bold text-slate-800 bg-slate-100 px-3 py-2 rounded-lg border border-slate-200">
                                    {{ $permohonan->cara_memperoleh }}
                                </div>
                            </div>
                            <div>
                                <label class="font-bold text-slate-500 uppercase tracking-wider block mb-1">Cara Penyerahan:</label>
                                <div class="font-bold text-slate-800 bg-slate-100 px-3 py-2 rounded-lg border border-slate-200">
                                    {{ $permohonan->cara_penyerahan }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ====================================================================
                 KOLOM KANAN (5/12): STATUS, TINDAK LANJUT & FORM UPDATE
                 ==================================================================== -->
            <div class="w-full lg:w-5/12 space-y-6">
                
                <!-- Card 3: Status Terkini & Notifikasi Email -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-xs">
                                <i class="fas fa-bell"></i>
                            </div>
                            <h2 class="text-sm font-black text-slate-800 m-0">Status & Notifikasi</h2>
                        </div>
                        <div>{!! $permohonan->status_badge !!}</div>
                    </div>

                    <div class="p-5 text-xs">
                        <div class="divide-y divide-slate-100">
                            <div class="py-2.5 flex items-center justify-between">
                                <span class="font-medium text-slate-500">Tanggal Pengajuan:</span>
                                <span class="font-bold text-slate-800">{{ $permohonan->created_at->format('d/m/Y H:i') }} WIB</span>
                            </div>
                            <div class="py-2.5 flex items-center justify-between">
                                <span class="font-medium text-slate-500">Terakhir Direspon:</span>
                                <span class="font-bold text-slate-800">{{ $permohonan->tanggal_respon ? $permohonan->tanggal_respon->format('d/m/Y H:i') . ' WIB' : 'Belum direspon' }}</span>
                            </div>
                            <div class="py-2.5 flex items-center justify-between">
                                <span class="font-medium text-slate-500">Petugas Respon:</span>
                                <span class="font-bold text-slate-800">{{ $permohonan->responder ? $permohonan->responder->name : '-' }}</span>
                            </div>
                            <div class="py-2.5 flex items-center justify-between">
                                <span class="font-medium text-slate-500">Notifikasi Email:</span>
                                <div>
                                    @if($permohonan->email_notifikasi_terkirim)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-2xs">
                                            <i class="fas fa-check text-[9px]"></i> Terkirim ({{ $permohonan->tanggal_email_terakhir ? $permohonan->tanggal_email_terakhir->format('d/m/Y H:i') : '' }})
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                            <i class="fas fa-minus text-[8px]"></i> Belum Terkirim
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Langsung Kirim Email Notifikasi -->
                        <div class="mt-4 p-4 rounded-xl bg-blue-50/60 border border-blue-100 text-center">
                            <p class="text-[11px] text-slate-600 mb-3 leading-relaxed">
                                Kirimkan pemberitahuan status dan tanggapan resmi ke email pemohon:
                            </p>
                            <a href="{{ url('dashboard/permohonan-informasi/' . Hashids::encode($permohonan->id) . '/send-email') }}" 
                               class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#1A56DB] hover:bg-blue-700 text-white font-bold text-xs shadow-sm hover:shadow transition text-decoration-none"
                               onclick="return confirm('Kirimkan email notifikasi status terkini ke {{ $permohonan->email }}?')">
                                <i class="fas fa-paper-plane text-xs"></i> Kirim Notifikasi Email Sekarang
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Form Tindak Lanjut & Berikan Tanggapan -->
                <div id="form-tindak-lanjut" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden scroll-mt-24">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-xs">
                                <i class="fas fa-pen-to-square"></i>
                            </div>
                            <h2 class="text-sm font-black text-slate-800 m-0">Tindak Lanjut & Update Status</h2>
                        </div>
                    </div>

                    <div class="p-5 text-xs">
                        {!! Form::open(['url' => 'dashboard/permohonan-informasi/' . Hashids::encode($permohonan->id) . '/update-status', 'method' => 'post', 'files' => true, 'class' => 'space-y-4']) !!}
                        
                        <div>
                            <label class="required font-bold text-slate-700 block mb-1">Status Permohonan</label>
                            <select name="status" class="form-control" required>
                                <option value="pending" {{ $permohonan->status == 'pending' ? 'selected' : '' }}>⏳ Menunggu Verifikasi (Pending)</option>
                                <option value="diproses" {{ $permohonan->status == 'diproses' ? 'selected' : '' }}>⚙️ Sedang Diproses</option>
                                <option value="selesai" {{ $permohonan->status == 'selesai' ? 'selected' : '' }}>✅ Diterima / Selesai</option>
                                <option value="ditolak" {{ $permohonan->status == 'ditolak' ? 'selected' : '' }}>❌ Ditolak / Tidak Dapat Dipenuhi</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Catatan / Tanggapan Resmi PPID</label>
                            <textarea name="tanggapan" rows="4" class="form-control" placeholder="Tuliskan keterangan balasan, penjelasan pemenuhan informasi, tautan dokumen, atau alasan bila ditolak...">{{ old('tanggapan', $permohonan->tanggapan) }}</textarea>
                            <small class="text-slate-400 text-[11px] block mt-1">Catatan ini akan tampil di tracking publik pemohon dan dikirim via email.</small>
                        </div>

                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Unggah Berkas Jawaban (Opsional)</label>
                            <input type="file" name="file_lampiran_jawaban" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-[#1A56DB] hover:file:bg-blue-100" accept=".pdf,.doc,.docx,.zip,.rar,.png,.jpg,.jpeg">
                            <small class="text-slate-400 text-[11px] block mt-1">Format: PDF, Word, ZIP, RAR (Maks. 10MB)</small>
                            @if(!empty($permohonan->file_lampiran_jawaban))
                                <div class="mt-2 p-2.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between">
                                    <span class="font-semibold text-slate-700 flex items-center gap-1.5">
                                        <i class="fas fa-file-pdf text-rose-500"></i> File terlampir
                                    </span>
                                    <a href="{{ berkas($permohonan->file_lampiran_jawaban) ?: url('berkas/' . $permohonan->file_lampiran_jawaban) }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-blue-50 text-[#1A56DB] font-bold text-[11px] hover:bg-blue-100 transition text-decoration-none">
                                        Unduh
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="pt-3 border-t border-slate-100">
                            <label class="flex items-start gap-2.5 cursor-pointer">
                                <input type="checkbox" name="kirim_email" value="1" checked class="mt-0.5 rounded text-[#1A56DB] focus:ring-blue-500">
                                <span class="text-xs text-slate-700 font-semibold leading-snug">
                                    Kirim otomatis notifikasi ke email pemohon setelah update disimpan
                                </span>
                            </label>
                        </div>

                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm hover:shadow transition">
                            <i class="fas fa-save text-xs"></i> Simpan Pembaruan Status
                        </button>

                        {!! Form::close() !!}
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
