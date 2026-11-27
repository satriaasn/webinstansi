@extends('layouts.backend')
@section('title', 'View Video')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/video/table') }}">Video</a>
            <span class="breadcrumb-item active">Preview Video</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            @include('backend.partials.preview_layout', [
                'title' => $video->title,
                'subtitle' => 'YouTube ID: ' . $video->youtube_id,
                'active' => $video->active,
                'badgeText' => 'Video YouTube',
                'backUrl' => url('dashboard/video/table'),
                'editUrl' => url('dashboard/video/' . Hashids::encode($video->id) . '/edit'),
                'youtubeId' => $video->youtube_id,
                'fields' => [
                    ['label' => 'YouTube ID', 'value' => $video->youtube_id, 'code' => true],
                    ['label' => 'Embed URL', 'value' => 'https://www.youtube.com/embed/' . $video->youtube_id, 'url' => 'https://www.youtube.com/watch?v=' . $video->youtube_id],
                ],
            ])
        </div>
    </div>
@endsection
