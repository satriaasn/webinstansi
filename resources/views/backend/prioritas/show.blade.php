@extends('layouts.backend')
@section('title', 'Detail Prioritas Pembangunan')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/prioritas/table') }}">Prioritas Pembangunan</a>
            <span class="breadcrumb-item active">Detail</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-20">
                <a href="{{ url('dashboard/prioritas/table') }}" class="btn btn-secondary btn-sm"><i class="fa fa-reply"></i> Back</a>
                <a href="{{ url('dashboard/prioritas/' . Hashids::encode($prioritas->id) . '/edit') }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit</a>
            </div>
            <table class="table table-bordered">
                <tr><th width="200">Urutan</th><td>{{ $prioritas->urutan }}</td></tr>
                <tr><th>Judul</th><td>{{ $prioritas->title }}</td></tr>
                <tr><th>Deskripsi</th><td>{{ $prioritas->description }}</td></tr>
                <tr><th>Icon</th><td><i class="{{ $prioritas->icon }}"></i> <code>{{ $prioritas->icon }}</code></td></tr>
                <tr><th>Status</th><td>{{ $prioritas->active == 'Y' ? 'Aktif' : 'Non Aktif' }}</td></tr>
            </table>
        </div>
    </div>
@endsection
