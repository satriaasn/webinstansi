@extends('layouts.backend')
@section('title', 'Update Status Pendaftar')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/pendaftar-sosial') }}">Pendaftar Layanan</a>
            <span class="breadcrumb-item active">Update Status</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="icon ion-ios-compose-outline"></i>
        <div>
            <h4>Update Status & Catatan</h4>
            <p class="mg-b-0">Formulir Pendaftar: <strong>{{ $pendaftaran->nomor_registrasi }}</strong> ({{ $pendaftaran->nama_lengkap }})</p>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="card bd-0 shadow-base">
            <div class="card-body">
                {!! Form::model($pendaftaran, [
                    'method' => 'PATCH',
                    'url' => ['/dashboard/pendaftar-sosial', Vinkla\Hashids\Facades\Hashids::encode($pendaftaran->id)],
                    'class' => 'form-horizontal',
                    'files' => true
                ]) !!}

                <div class="form-group row {{ $errors->has('status') ? 'has-error' : '' }}">
                    {!! Form::label('status', 'Status Pendaftaran*', ['class' => 'col-md-3 col-form-label']) !!}
                    <div class="col-md-5">
                        {!! Form::select('status', [
                            'menunggu' => 'Menunggu Verifikasi',
                            'diproses' => 'Sedang Diproses',
                            'diterima' => 'Diterima',
                            'ditolak'  => 'Ditolak',
                            'selesai'  => 'Selesai'
                        ], null, ['class' => 'form-control select2', 'required' => 'required']) !!}
                        {!! $errors->first('status', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('catatan_petugas') ? 'has-error' : '' }}">
                    {!! Form::label('catatan_petugas', 'Catatan Petugas', ['class' => 'col-md-3 col-form-label']) !!}
                    <div class="col-md-7">
                        {!! Form::textarea('catatan_petugas', null, ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Masukkan catatan (misal: "Dokumen kurang lengkap, harap upload ulang KTP"). Catatan ini dapat dilihat oleh pendaftar saat cek status.']) !!}
                        {!! $errors->first('catatan_petugas', '<p class="help-block text-danger">:message</p>') !!}
                        <small class="form-text text-muted">Catatan ini akan dilihat oleh pendaftar pada halaman Cek Status.</small>
                    </div>
                </div>

                <div class="form-group row mt-4">
                    <div class="col-md-offset-3 col-md-7 offset-md-3">
                        {!! Form::submit('Simpan Perubahan', ['class' => 'btn btn-primary']) !!}
                        <a href="{{ url('/dashboard/pendaftar-sosial') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
