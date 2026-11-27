@extends('layouts.backend')
@section('title', 'View Agenda')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/agenda/table') }}">Agenda</a>
            <span class="breadcrumb-item active">Preview Agenda</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            @include('backend.partials.preview_layout', [
                'title' => $agenda->title,
                'subtitle' => 'Slug: ' . $agenda->seotitle,
                'active' => $agenda->active,
                'badgeText' => $agenda->sumber_agenda ?: 'Agenda Kegiatan',
                'backUrl' => url('dashboard/agenda/table'),
                'editUrl' => url('dashboard/agenda/' . Hashids::encode($agenda->id) . '/edit'),
                'fields' => [
                    ['label' => 'Mulai', 'value' => date('d M Y H:i', strtotime($agenda->start)) . ' WIB', 'icon' => 'far fa-calendar'],
                    ['label' => 'Selesai', 'value' => date('d M Y H:i', strtotime($agenda->end)) . ' WIB', 'icon' => 'far fa-clock'],
                    ['label' => 'Lokasi', 'value' => $agenda->display_location, 'icon' => 'fas fa-map-marker-alt'],
                    ['label' => 'Pakaian', 'value' => $agenda->pakaian],
                    ['label' => 'Penyelenggara', 'value' => $agenda->penyelenggara, 'full' => true],
                ],
                'htmlContent' => $agenda->content,
                'contentTitle' => 'Deskripsi & Rincian Agenda',
            ])
        </div>
    </div>
@endsection
