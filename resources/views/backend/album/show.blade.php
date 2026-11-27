@extends('layouts.backend')
@section('title', 'View Album')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/album/table') }}">Album</a>
            <span class="breadcrumb-item active">Preview Album</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            @include('backend.partials.preview_layout', [
                'title' => $album->title,
                'subtitle' => 'Slug: ' . $album->seotitle,
                'active' => $album->active,
                'badgeText' => 'Album Foto',
                'backUrl' => url('dashboard/album/table'),
                'editUrl' => url('dashboard/album/' . Hashids::encode($album->id) . '/edit'),
                'image' => $album->picture,
                'fields' => [
                    ['label' => 'Judul Album', 'value' => $album->title],
                    ['label' => 'Seotitle', 'value' => $album->seotitle],
                ],
            ])
        </div>
    </div>
@endsection
