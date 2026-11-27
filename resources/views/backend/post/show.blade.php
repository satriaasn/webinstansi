@extends('layouts.backend')
@section('title', 'View Post')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/post/table') }}">Post</a>
            <span class="breadcrumb-item active">Preview Post</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            @include('backend.partials.preview_layout', [
                'title' => $post->title,
                'subtitle' => 'Slug: ' . $post->seotitle,
                'active' => $post->active,
                'badgeText' => $post->postCategory->title ?? 'Berita',
                'backUrl' => url('dashboard/post/table'),
                'editUrl' => url('dashboard/post/' . Hashids::encode($post->id) . '/edit'),
                'image' => $post->picture,
                'fields' => [
                    ['label' => 'Kategori', 'value' => $post->postCategory->title ?? '-'],
                    ['label' => 'Headline', 'value' => $post->headline == 'Y' ? 'Ya (Headline)' : 'Tidak'],
                    ['label' => 'Tag', 'value' => $post->tag],
                ],
                'htmlContent' => $post->content,
                'contentTitle' => 'Isi Berita / Artikel',
            ])
        </div>
    </div>
@endsection
