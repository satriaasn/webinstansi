@extends('layouts.backend')
@section('title', 'View Pages')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/pages/table') }}">Pages</a>
            <span class="breadcrumb-item active">Preview Pages</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            @include('backend.partials.preview_layout', [
                'title' => $pages->title,
                'subtitle' => 'Slug: ' . $pages->seotitle,
                'active' => $pages->active,
                'badgeText' => 'Halaman Statis',
                'backUrl' => url('dashboard/pages/table'),
                'editUrl' => url('dashboard/pages/' . Hashids::encode($pages->id) . '/edit'),
                'image' => $pages->picture,
                'fields' => [
                    ['label' => 'Judul Halaman', 'value' => $pages->title],
                    ['label' => 'Seotitle', 'value' => $pages->seotitle],
                ],
                'htmlContent' => $pages->content,
                'contentTitle' => 'Konten Halaman',
            ])
        </div>
    </div>
@endsection
