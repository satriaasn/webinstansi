@extends('layouts.backend')
@section('title', 'View Download')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/download/table') }}">Download</a>
            <span class="breadcrumb-item active">Preview Dokumen</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            @include('backend.partials.preview_layout', [
                'title' => $download->title,
                'subtitle' => 'Slug: ' . $download->seotitle,
                'active' => $download->active,
                'badgeText' => $download->downloadCategory->title ?? 'Dokumen',
                'backUrl' => url('dashboard/download/table'),
                'editUrl' => url('dashboard/download/' . Hashids::encode($download->id) . '/edit'),
                'pdfFile' => $download->file,
                'fields' => [
                    ['label' => 'Kategori', 'value' => $download->downloadCategory->title ?? '-'],
                    ['label' => 'Nama File', 'value' => $download->file, 'code' => true],
                ],
                'htmlContent' => $download->content,
                'contentTitle' => 'Keterangan Dokumen',
            ])
        </div>
    </div>
@endsection
