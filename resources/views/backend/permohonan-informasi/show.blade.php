@extends('layouts.backend')
@section('title', 'Detail Permohonan Informasi - ' . $permohonan->nomor_tiket)

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/permohonan-informasi/table') }}">Permohonan Informasi</a>
            <span class="breadcrumb-item active">{{ $permohonan->nomor_tiket }}</span>
        </nav>
    </div>

    <div class="br-pagetitle d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <i class="icon ion-ios-paper-outline"></i>
            <div>
                <h4>Detail Permohonan Informasi</h4>
                <p class="mg-b-0">Nomor Registrasi: <strong class="tx-inverse">{{ $permohonan->nomor_tiket }}</strong></p>
            </div>
        </div>
        <div>
            <a href="{{ url('dashboard/permohonan-informasi/table') }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left mr-1"></i> Kembali ke Daftar
            </a>
            <a href="{{ url('permohonan-informasi/tracking?tiket=' . $permohonan->nomor_tiket) }}" target="_blank" class="btn btn-outline-info btn-sm">
                <i class="fa fa-external-link mr-1"></i> Buka Halaman Tracking Publik
            </a>
        </div>
    </div>

    <div class="br-pagebody">
        @if(Session::has('flash_message'))
            <div class="alert alert-success alert-bordered pd-y-15 mb-3" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-flex align-items-center">
                    <i class="fa fa-check-circle tx-24 mr-2"></i>
                    <span>{{ Session::get('flash_message') }}</span>
                </div>
            </div>
        @endif

        <div class="row">
            <!-- Kolom Kiri: Rincian Data Pemohon & Informasi (7 cols) -->
            <div class="col-lg-7">
                <!-- Card 1: Data Pemohon -->
                <div class="card mb-3 shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0 tx-14 font-weight-bold tx-inverse">
                            <i class="fa fa-user-circle mr-1 text-primary"></i> Data Identitas Pemohon
                        </h6>
                        <span class="badge badge-light border text-muted px-2 py-1">{{ $permohonan->kategori_pemohon }}</span>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped mb-0 tx-13">
                            <tr>
                                <td width="35%" class="font-weight-bold bg-light">Nama Pemohon</td>
                                <td><strong class="tx-inverse">{{ $permohonan->nama_pemohon }}</strong></td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold bg-light">NIK / No. Identitas</td>
                                <td>{{ $permohonan->nik }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold bg-light">Email</td>
                                <td>
                                    <a href="mailto:{{ $permohonan->email }}" class="tx-primary font-weight-bold">
                                        {{ $permohonan->email }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold bg-light">No. Telepon / WhatsApp</td>
                                <td>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $permohonan->no_telepon) }}" target="_blank" class="tx-success">
                                        <i class="fa fa-whatsapp mr-1"></i> {{ $permohonan->no_telepon }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold bg-light">Pekerjaan / Instansi</td>
                                <td>
                                    {{ $permohonan->pekerjaan ?: '-' }}
                                    @if($permohonan->instansi)
                                        / <span class="font-weight-bold">{{ $permohonan->instansi }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold bg-light">Alamat Lengkap</td>
                                <td>{{ $permohonan->alamat }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold bg-light">Berkas Kartu Identitas</td>
                                <td>
                                    @if(!empty($permohonan->file_ktp))
                                        <a href="{{ berkas($permohonan->file_ktp) ?: url('berkas/' . $permohonan->file_ktp) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-id-card-o mr-1"></i> Lihat Berkas KTP
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada berkas</span>
                                    @endif
                                </td>
                            </tr>
                            @if(!empty($permohonan->file_pendukung))
                                <tr>
                                    <td class="font-weight-bold bg-light">Dokumen Pendukung</td>
                                    <td>
                                        <a href="{{ berkas($permohonan->file_pendukung) ?: url('berkas/' . $permohonan->file_pendukung) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fa fa-paperclip mr-1"></i> Unduh Dokumen Pendukung
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <!-- Card 2: Rincian Permohonan Informasi -->
                <div class="card mb-3 shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="card-title mb-0 tx-14 font-weight-bold tx-inverse">
                            <i class="fa fa-file-text-o mr-1 text-primary"></i> Rincian Informasi yang Dimohonkan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="font-weight-bold text-muted tx-11 tx-uppercase">Rincian Informasi:</label>
                            <div class="p-3 bg-light rounded tx-13 border">
                                {!! nl2br(e($permohonan->rincian_informasi)) !!}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="font-weight-bold text-muted tx-11 tx-uppercase">Tujuan Penggunaan:</label>
                            <div class="p-3 bg-light rounded tx-13 border">
                                {!! nl2br(e($permohonan->tujuan_penggunaan)) !!}
                            </div>
                        </div>

                        <div class="row row-sm">
                            <div class="col-sm-6 mb-2">
                                <label class="font-weight-bold text-muted tx-11 tx-uppercase">Cara Memperoleh:</label>
                                <div class="tx-13 font-weight-bold">{{ $permohonan->cara_memperoleh }}</div>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <label class="font-weight-bold text-muted tx-11 tx-uppercase">Cara Penyerahan:</label>
                                <div class="tx-13 font-weight-bold">{{ $permohonan->cara_penyerahan }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Status & Tindak Lanjut (5 cols) -->
            <div class="col-lg-5">
                <!-- Card 3: Status Terkini & Notifikasi Email -->
                <div class="card mb-3 shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0 tx-14 font-weight-bold tx-inverse">
                            <i class="fa fa-bell-o mr-1 text-warning"></i> Status & Notifikasi
                        </h6>
                        <div>{!! $permohonan->status_badge !!}</div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center pb-2 mb-2 border-bottom tx-12">
                            <span class="text-muted">Tanggal Pengajuan:</span>
                            <span class="font-weight-bold">{{ $permohonan->created_at->format('d/m/Y H:i') }} WIB</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pb-2 mb-2 border-bottom tx-12">
                            <span class="text-muted">Terakhir Direspon:</span>
                            <span class="font-weight-bold">{{ $permohonan->tanggal_respon ? $permohonan->tanggal_respon->format('d/m/Y H:i') . ' WIB' : 'Belum direspon' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pb-2 mb-2 border-bottom tx-12">
                            <span class="text-muted">Petugas Respon:</span>
                            <span class="font-weight-bold">{{ $permohonan->responder ? $permohonan->responder->name : '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom tx-12">
                            <span class="text-muted">Notifikasi Email:</span>
                            <span>
                                @if($permohonan->email_notifikasi_terkirim)
                                    <span class="badge badge-success"><i class="fa fa-check"></i> Terkirim ({{ $permohonan->tanggal_email_terakhir ? $permohonan->tanggal_email_terakhir->format('d/m/Y H:i') : '' }})</span>
                                @else
                                    <span class="badge badge-secondary"><i class="fa fa-minus"></i> Belum Terkirim</span>
                                @endif
                            </span>
                        </div>

                        <!-- Tombol Langsung Kirim Email Notifikasi -->
                        <div class="p-3 bg-light rounded text-center border">
                            <p class="tx-12 text-muted mb-2">Kirim pemberitahuan status dan tanggapan resmi ke email pemohon:</p>
                            <a href="{{ url('dashboard/permohonan-informasi/' . Hashids::encode($permohonan->id) . '/send-email') }}" 
                               class="btn btn-info btn-block"
                               onclick="return confirm('Kirimkan email notifikasi status terkini ke {{ $permohonan->email }}?')">
                                <i class="fa fa-paper-plane mr-1"></i> Kirim Notifikasi Email ke Pemohon
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Form Update Status & Tanggapan -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="card-title mb-0 tx-14 font-weight-bold tx-inverse">
                            <i class="fa fa-pencil-square-o mr-1 text-primary"></i> Tindak Lanjut & Berikan Tanggapan
                        </h6>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['url' => 'dashboard/permohonan-informasi/' . Hashids::encode($permohonan->id) . '/update-status', 'method' => 'post', 'files' => true]) !!}
                        
                        <div class="form-group">
                            <label class="font-weight-bold tx-12 text-muted tx-uppercase">Status Permohonan <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="pending" {{ $permohonan->status == 'pending' ? 'selected' : '' }}>⏳ Menunggu Verifikasi (Pending)</option>
                                <option value="diproses" {{ $permohonan->status == 'diproses' ? 'selected' : '' }}>⚙️ Sedang Diproses</option>
                                <option value="selesai" {{ $permohonan->status == 'selesai' ? 'selected' : '' }}>✅ Diterima / Selesai</option>
                                <option value="ditolak" {{ $permohonan->status == 'ditolak' ? 'selected' : '' }}>❌ Ditolak / Tidak Dapat Dipenuhi</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold tx-12 text-muted tx-uppercase">Catatan / Tanggapan Resmi PPID</label>
                            <textarea name="tanggapan" rows="4" class="form-control" placeholder="Tuliskan keterangan balasan, penjelasan pemenuhan informasi, atau alasan penolakan bila ditolak...">{{ old('tanggapan', $permohonan->tanggapan) }}</textarea>
                            <small class="text-muted">Catatan ini akan tampil di halaman pelacakan pemohon dan dikirim via email.</small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold tx-12 text-muted tx-uppercase">Unggah File Lampiran Jawaban (Opsional)</label>
                            <input type="file" name="file_lampiran_jawaban" class="form-control-file" accept=".pdf,.doc,.docx,.zip,.rar,.png,.jpg,.jpeg">
                            <small class="text-muted d-block mt-1">Format: PDF, Word, ZIP, RAR (Maks. 10MB)</small>
                            @if(!empty($permohonan->file_lampiran_jawaban))
                                <div class="mt-2 p-2 bg-light border rounded tx-12 d-flex justify-content-between align-items-center">
                                    <span><i class="fa fa-file-pdf-o text-danger mr-1"></i> File terlampir</span>
                                    <a href="{{ berkas($permohonan->file_lampiran_jawaban) ?: url('berkas/' . $permohonan->file_lampiran_jawaban) }}" target="_blank" class="btn btn-xs btn-outline-primary">
                                        Unduh
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="form-group border-top pt-3">
                            <label class="ckbox">
                                <input type="checkbox" name="kirim_email" value="1" checked>
                                <span>Kirim otomatis notifikasi ke email pemohon setelah update disimpan</span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block font-weight-bold py-2">
                            <i class="fa fa-save mr-1"></i> Simpan Pembaruan Status
                        </button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
