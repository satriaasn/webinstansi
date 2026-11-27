@extends('layouts.backend')
@section('title', 'Detail Flyer / Ucapan')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/flyer/table') }}">Flyer & Ucapan</a>
            <span class="breadcrumb-item active">Preview</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            @include('backend.partials.preview_layout', [
                'title' => $flyer->title,
                'active' => $flyer->active,
                'badgeText' => 'Flyer & Ucapan',
                'backUrl' => url('dashboard/flyer/table'),
                'editUrl' => url('dashboard/flyer/' . Hashids::encode($flyer->id) . '/edit'),
                'image' => $flyer->picture,
                'fields' => [
                    ['label' => 'Judul', 'value' => $flyer->title],
                    ['label' => 'URL Tujuan', 'value' => $flyer->url, 'url' => $flyer->url],
                ],
                'htmlContent' => $flyer->description ? nl2br(e($flyer->description)) : null,
                'contentTitle' => 'Keterangan Flyer',
            ])
        </div>
    </div>
@endsection
