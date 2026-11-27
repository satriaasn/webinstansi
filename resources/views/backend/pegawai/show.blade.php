@extends('layouts.backend')
@section('title', 'View Pegawai')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/pegawai/table') }}">Pegawai</a>
            <span class="breadcrumb-item active">Preview Pegawai</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            @include('backend.partials.preview_layout', [
                'title' => $pegawai->nama_pegawai,
                'subtitle' => $pegawai->jabatan ?: null,
                'active' => $pegawai->active,
                'badgeText' => $pegawai->klasifikasi_pegawai ?: 'Pegawai',
                'backUrl' => url('dashboard/pegawai/table'),
                'editUrl' => url('dashboard/pegawai/' . Hashids::encode($pegawai->id) . '/edit'),
                'image' => $pegawai->picture,
                'fields' => [
                    ['label' => 'NIP', 'value' => $pegawai->nip, 'code' => true],
                    ['label' => 'Jabatan', 'value' => $pegawai->jabatan],
                    ['label' => 'Golongan', 'value' => $pegawai->golongan],
                    ['label' => 'Klasifikasi', 'value' => $pegawai->klasifikasi_pegawai],
                ],
                'htmlContent' => $pegawai->deskripsi,
                'contentTitle' => 'Deskripsi / Profil Pegawai',
            ])
        </div>
    </div>
@endsection
