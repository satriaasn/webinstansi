@extends('layouts.backend')
@section('title', 'View Wisata')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/wisata') }}">Wisata</a>
            <span class="breadcrumb-item active">View Wisata</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/wisata/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
                            class="fa fa-reply"></i> Back</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th> Nama</th>
                        <td> {{ $wisata->wisata_nama }} </td>
                    </tr>
                    <tr>
                        <th> Link Url</th>
                        <td> {{ $wisata->wisata_link }} </td>
                    </tr>
                    <tr>
                        <th> Type</th>
                        <td> {{ $wisata->type }} </td>
                    </tr>
                    <tr>
                        <th> Rekomendasi Ukuran</th>
                        <td> {{ $wisata->rekomendasi_ukuran }} </td>
                    </tr>
                    <tr>
                        <th> Picture</th>
                        <td><a href="{{ berkas( $wisata->wisata_foto) }}"
                               id="quickview">{{ $wisata->wisata_foto }}</a></td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
