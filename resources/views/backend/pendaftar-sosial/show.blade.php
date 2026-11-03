@extends('layouts.backend')
@section('title', 'Detail Pendaftar Layanan Sosial')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/pendaftar-sosial') }}">Pendaftar Layanan</a>
            <span class="breadcrumb-item active">Detail</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="icon ion-ios-person-outline"></i>
        <div>
            <h4>Detail Pendaftar Layanan</h4>
            <p class="mg-b-0">Informasi lengkap pendaftar layanan sosial.</p>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="card bd-0 shadow-base">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Detail Formulir</h6>
                <a href="{{ url('dashboard/pendaftar-sosial') }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tbody>
                            <tr><th width="35%">Nomor Registrasi</th><td><strong>{{ $pendaftaran->nomor_registrasi }}</strong></td></tr>
                            <tr><th>Status</th><td><span class="badge badge-{{ $pendaftaran->status_badge }}">{{ $pendaftaran->status_label }}</span></td></tr>
                            <tr><th>Layanan Dituju</th><td>{{ $pendaftaran->layanan->nama ?? '-' }}</td></tr>
                            <tr><th>Tanggal Daftar</th><td>{{ $pendaftaran->created_at->format('d M Y H:i:s') }}</td></tr>
                            <tr><th>Nama Lengkap</th><td>{{ $pendaftaran->nama_lengkap }}</td></tr>
                            <tr><th>NIK</th><td>{{ $pendaftaran->nik }}</td></tr>
                            <tr><th>Jenis Kelamin</th><td>{{ ucfirst($pendaftaran->jenis_kelamin) }}</td></tr>
                            <tr><th>Tempat, Tgl Lahir</th><td>{{ $pendaftaran->tempat_lahir }}, {{ $pendaftaran->tanggal_lahir ? $pendaftaran->tanggal_lahir->format('d M Y') : '' }}</td></tr>
                            <tr><th>Agama</th><td>{{ $pendaftaran->agama }}</td></tr>
                            <tr><th>Pendidikan Terakhir</th><td>{{ $pendaftaran->pendidikan_terakhir }}</td></tr>
                            <tr><th>No. Telepon</th><td>{{ $pendaftaran->no_telepon }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tbody>
                            <tr><th width="35%">Alamat Lengkap</th><td>{{ $pendaftaran->alamat_lengkap }}</td></tr>
                            <tr><th>Kec / Desa</th><td>{{ $pendaftaran->kecamatan }} / {{ $pendaftaran->kelurahan_desa }}</td></tr>
                            <tr><th>Kab / Kota</th><td>{{ $pendaftaran->kabupaten_kota }}</td></tr>
                            <tr><th>Pekerjaan</th><td>{{ $pendaftaran->data_tambahan['pekerjaan'] ?? '-' }}</td></tr>
                            <tr><th>Alasan Permohonan</th><td>{{ $pendaftaran->data_tambahan['alasan_permohonan'] ?? '-' }}</td></tr>
                            
                            @if($pendaftaran->nama_wali)
                            <tr><th colspan="2" class="bg-light"><strong>Data Wali</strong></th></tr>
                            <tr><th>Nama Wali</th><td>{{ $pendaftaran->nama_wali }}</td></tr>
                            <tr><th>Hubungan</th><td>{{ $pendaftaran->hubungan_wali }}</td></tr>
                            <tr><th>No. HP Wali</th><td>{{ $pendaftaran->no_telepon_wali }}</td></tr>
                            @endif

                            @if($pendaftaran->catatan_petugas)
                            <tr><th colspan="2" class="bg-light"><strong>Catatan Petugas</strong></th></tr>
                            <tr><td colspan="2"><div class="alert alert-warning mg-b-0">{{ $pendaftaran->catatan_petugas }}</div></td></tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                @if(!empty($pendaftaran->data_tambahan))
                <div class="pd-t-20 mt-4 border-top">
                    <h6 class="tx-14 tx-uppercase tx-inverse tx-bold mg-b-15">Data Tambahan Formulir (Spesifik Layanan)</h6>
                    <div class="row">
                        @foreach($pendaftaran->data_tambahan as $key => $val)
                            @if(in_array($key, ['pekerjaan', 'alasan_permohonan'])) @continue @endif
                            <div class="col-md-4 mg-b-10">
                                <span class="tx-11 tx-uppercase tx-gray-500 d-block">{{ str_replace('_', ' ', $key) }}</span>
                                <strong>{{ $val }}</strong>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="pd-t-20 mt-4 border-top">
                    <h6 class="tx-14 tx-uppercase tx-inverse tx-bold mg-b-15">Dokumen Tersertakan (PDF)</h6>
                    <div class="row">
                        @php
                            $docs = [
                                'KTP' => $pendaftaran->file_ktp,
                                'Kartu Keluarga' => $pendaftaran->file_kk,
                                'Surat Keterangan' => $pendaftaran->file_surat_keterangan,
                                'Dokumen Pendukung' => $pendaftaran->file_dokumen_pendukung,
                                'Pas Foto / Doc' => $pendaftaran->file_foto,
                            ];
                        @endphp
                        @foreach($docs as $lbl => $file)
                            @if($file)
                                <div class="col-md-2 col-sm-4 mg-b-10">
                                    <div class="card bd-0 text-center">
                                        <div class="card-body pd-10 pd-t-20 bg-light rounded">
                                            <i class="fa fa-file-pdf-o tx-danger tx-40 mg-b-10"></i>
                                            <p class="tx-11 mg-b-10">{{ $lbl }}</p>
                                            <a href="{{ Storage::disk('public')->url($file) }}" target="_blank" class="btn btn-sm btn-outline-danger btn-block">Buka</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="pd-t-20 mt-4 border-top text-center">
                    <a href="{{ url('dashboard/pendaftar-sosial/'.Vinkla\Hashids\Facades\Hashids::encode($pendaftaran->id).'/edit') }}" class="btn btn-primary"><i class="fa fa-pencil"></i> Update Status & Catatan</a>
                </div>
            </div>
        </div>
    </div>
@endsection
