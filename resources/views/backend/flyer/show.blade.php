@extends('layouts.backend')
@section('title', 'Detail Flyer / Ucapan')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/flyer/table') }}">Flyer & Ucapan</a>
            <span class="breadcrumb-item active">Detail</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-20">
                <a href="{{ url('dashboard/flyer/table') }}" class="btn btn-secondary btn-sm"><i class="fa fa-reply"></i> Back</a>
                <a href="{{ url('dashboard/flyer/' . Hashids::encode($flyer->id) . '/edit') }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit</a>
            </div>
            <table class="table table-bordered">
                <tr><th width="200">Judul</th><td>{{ $flyer->title }}</td></tr>
                <tr><th>Gambar</th><td><img src="{{ berkas($flyer->picture) ?: url('berkas/' . $flyer->picture) }}" alt="" style="max-height:240px;border-radius:8px;"></td></tr>
                <tr><th>URL</th><td>{{ $flyer->url ?: '-' }}</td></tr>
                <tr><th>Keterangan</th><td>{{ $flyer->description ?: '-' }}</td></tr>
                <tr><th>Status</th><td>{{ $flyer->active == 'Y' ? 'Aktif' : 'Non Aktif' }}</td></tr>
            </table>
        </div>
    </div>
@endsection
