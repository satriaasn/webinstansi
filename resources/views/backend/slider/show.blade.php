@extends('layouts.backend')
@section('title', 'View Slider')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/slider/table') }}">Slider</a>
            <span class="breadcrumb-item active">Preview Slider</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            @include('backend.partials.preview_layout', [
                'title' => $slider->title ?: 'Slider #' . $slider->id,
                'subtitle' => $slider->seotitle ? 'Slug: ' . $slider->seotitle : null,
                'active' => $slider->active,
                'badgeText' => 'Slider Banner',
                'backUrl' => url('dashboard/slider/table'),
                'editUrl' => url('dashboard/slider/' . Hashids::encode($slider->id) . '/edit'),
                'image' => $slider->picture,
                'fields' => [
                    ['label' => 'Judul Slider', 'value' => $slider->title],
                    ['label' => 'Seotitle', 'value' => $slider->seotitle],
                    ['label' => 'Link URL Tujuan', 'value' => $slider->url, 'url' => $slider->url],
                ],
                'htmlContent' => $slider->content,
                'contentTitle' => 'Teks / Keterangan Slider',
            ])
        </div>
    </div>
@endsection
