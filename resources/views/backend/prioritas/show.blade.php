@extends('layouts.backend')
@section('title', 'Detail Prioritas Pembangunan')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/prioritas/table') }}">Prioritas Pembangunan</a>
            <span class="breadcrumb-item active">Preview</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            @include('backend.partials.preview_layout', [
                'title' => $prioritas->title,
                'active' => $prioritas->active,
                'badgeText' => 'Prioritas #' . $prioritas->urutan,
                'backUrl' => url('dashboard/prioritas/table'),
                'editUrl' => url('dashboard/prioritas/' . Hashids::encode($prioritas->id) . '/edit'),
                'fields' => [
                    ['label' => 'Urutan Tampil', 'value' => $prioritas->urutan],
                    ['label' => 'Icon Class', 'value' => $prioritas->icon, 'icon' => $prioritas->icon, 'code' => true],
                ],
                'htmlContent' => $prioritas->description ? nl2br(e($prioritas->description)) : null,
                'contentTitle' => 'Deskripsi Prioritas',
            ])
        </div>
    </div>
@endsection
