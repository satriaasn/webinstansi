@extends('layouts.backend')
@section('title', 'Detail Keberatan Informasi')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/keberatan-informasi/table') }}">Keberatan Informasi</a>
            <span class="breadcrumb-item active">{{ $keberatan->nomor_registrasi_keberatan }}</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-20 d-flex justify-content-between align-items-center">
                <a href="{{ url('dashboard/keberatan-informasi/table') }}" class="btn btn-secondary btn-sm"><i class="fa fa-reply"></i> Kembali</a>
                @php $b = $keberatan->status_badge; @endphp
                <span style="display:inline-block;padding:5px 14px;border-radius:9999px;font-size:12px;font-weight:700;background:{{ $b['bg'] }};color:{{ $b['color'] }};border:1px solid {{ $b['border'] }};">
                    {{ $b['label'] }}
                </span>
            </div>

            <div class="row">
                <div class="col-md-7">
                    <h5 class="tx-bold mb-3">Data Pengajuan Keberatan</h5>
                    <table class="table table-bordered">
                        <tr><th width="220">No. Registrasi Keberatan</th><td><strong>{{ $keberatan->nomor_registrasi_keberatan }}</strong></td></tr>
                        <tr><th>Informasi Pengaju Keberatan</th><td>{{ $keberatan->informasi_pengaju_keberatan ?: '-' }}</td></tr>
                        <tr><th>No. Permohonan Informasi</th><td>{{ $keberatan->nomor_permohonan_informasi ?: '-' }}</td></tr>
                        <tr><th>Tujuan Penggunaan Informasi</th><td>{{ $keberatan->tujuan_penggunaan_informasi }}</td></tr>
                        <tr><th>Nama Lengkap</th><td>{{ $keberatan->nama }}</td></tr>
                        <tr><th>Alamat Lengkap</th><td>{{ $keberatan->alamat_lengkap }}</td></tr>
                        <tr><th>Pekerjaan</th><td>{{ $keberatan->pekerjaan ?: '-' }}</td></tr>
                        <tr><th>Nomor Telepon</th><td>{{ $keberatan->nomor_telepon }}</td></tr>
                        <tr><th>Alasan Keberatan</th><td>{{ $keberatan->alasan_keberatan }}</td></tr>
                        <tr><th>Kasus Posisi</th><td>{{ $keberatan->kasus_posisi }}</td></tr>
                        <tr><th>Tanggal Pengajuan</th><td>{{ $keberatan->created_at ? $keberatan->created_at->format('d M Y H:i') : '-' }}</td></tr>
                    </table>
                </div>

                <div class="col-md-5">
                    <h5 class="tx-bold mb-3">Tindak Lanjut &amp; Respon PPID</h5>
                    <div class="card p-3 bg-light">
                        <form action="{{ route('dashboard.keberatan-informasi.update-status', Hashids::encode($keberatan->id)) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="font-weight-bold">Status Keberatan</label>
                                <select name="status" class="form-control" required>
                                    <option value="pending" {{ $keberatan->status == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                    <option value="diproses" {{ $keberatan->status == 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                    <option value="selesai" {{ $keberatan->status == 'selesai' ? 'selected' : '' }}>Selesai / Ditindaklanjuti</option>
                                    <option value="ditolak" {{ $keberatan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <label class="font-weight-bold">Tanggapan / Keputusan Atasan PPID</label>
                                <textarea name="tanggapan" rows="5" class="form-control" placeholder="Tuliskan tanggapan atau hasil tindak lanjut keberatan...">{{ $keberatan->tanggapan }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm mt-3">
                                <i class="fa fa-save"></i> Simpan Tanggapan
                            </button>
                        </form>
                        @if($keberatan->tanggal_respon)
                            <div class="mt-3 text-muted" style="font-size:12px;">
                                Terakhir direspon: {{ $keberatan->tanggal_respon->format('d M Y H:i') }}
                                @if($keberatan->responden)
                                    oleh {{ $keberatan->responden->name }}
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
