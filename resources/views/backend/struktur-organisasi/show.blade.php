@extends('layouts.backend')
@section('title', 'Preview Struktur Organisasi')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/struktur-organisasi/table') }}">Struktur Organisasi</a>
            <span class="breadcrumb-item active">Preview</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            @include('backend.partials.preview_layout', [
                'title' => $item->jabatan,
                'subtitle' => $item->nama ? $item->nama . ($item->nip ? ' • NIP. ' . $item->nip : '') : null,
                'active' => $item->active,
                'badgeText' => strtoupper($item->tipe_node),
                'backUrl' => url('dashboard/struktur-organisasi/table'),
                'editUrl' => url('dashboard/struktur-organisasi/' . Hashids::encode($item->id) . '/edit'),
                'image' => $item->foto,
                'fields' => [
                    ['label' => 'Nama Pejabat', 'value' => $item->nama],
                    ['label' => 'NIP', 'value' => $item->nip, 'code' => true],
                    ['label' => 'Pangkat / Golongan', 'value' => $item->pangkat],
                    ['label' => 'TMT Pangkat', 'value' => $item->tmt_pangkat],
                    ['label' => 'TMT Jabatan', 'value' => $item->tmt_jabatan],
                    ['label' => 'Atasan / Parent', 'value' => $item->parent->jabatan ?? 'Root (Pimpinan Tertinggi)'],
                ],
                'htmlContent' => $item->deskripsi ? nl2br(e($item->deskripsi)) : null,
                'contentTitle' => 'Tugas & Fungsi',
            ])
        </div>
    </div>
@endsection
