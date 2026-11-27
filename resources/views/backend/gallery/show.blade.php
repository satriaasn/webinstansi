@extends('layouts.backend')
@section('title', 'View Gallery')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/gallery/table') }}">Gallery</a>
            <span class="breadcrumb-item active">Preview Gallery</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            @include('backend.partials.preview_layout', [
                'title' => $gallery->title,
                'subtitle' => 'Slug: ' . $gallery->seotitle,
                'active' => $gallery->active,
                'badgeText' => $gallery->album->title ?? 'Galeri Foto',
                'backUrl' => url('dashboard/gallery/table'),
                'editUrl' => url('dashboard/gallery/' . Hashids::encode($gallery->id) . '/edit'),
                'image' => $gallery->picture,
                'fields' => [
                    ['label' => 'Album', 'value' => $gallery->album->title ?? '-'],
                    ['label' => 'Judul Foto', 'value' => $gallery->title],
                    ['label' => 'Seotitle', 'value' => $gallery->seotitle],
                ],
            ])
        </div>
    </div>
@endsection
