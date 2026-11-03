@extends('layouts.backend')
@section('title', 'View Pegawai')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/pegawai') }}">Pegawai</a>
            <span class="breadcrumb-item active">View Pegawai</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/pegawai/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
                            class="fa fa-reply"></i> Back</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th style="width:150px;"> Klasifikasi Pegawai</th>
                        <td> {{ $pegawai->klasifikasi_pegawai }} </td>
                    </tr>
                    <tr>
                        <th> NIP</th>
                        <td> {{ $pegawai->nip }} </td>
                    </tr>
                    <tr>
                        <th> Nama Pegawai</th>
                        <td> {{ $pegawai->nama_pegawai }} </td>
                    </tr>
                    <tr>
                        <th> Jabatan</th>
                        <td> {{ $pegawai->jabatan }} </td>
                    </tr>
                    <tr>
                        <th> Golongan</th>
                        <td> {{ $pegawai->golongan }} </td>
                    </tr>
                    @if($pegawai->picture != '')
                        <tr>
                            <th> Picture</th>
                            <td><a href="{{ berkas( $pegawai->picture) }}"
                                   id="quickview">{{ $pegawai->picture }}</a></td>
                        </tr>
                    @endif
                    <tr>
                        <th> Deskripsi</th>
                        <td> {!! $pegawai->deskripsi !!} </td>
                    </tr>
                    <tr>
                        <th> Active</th>
                        <td> {{ $pegawai->active == 'Y' ? 'Active' : 'Non Active' }} </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
