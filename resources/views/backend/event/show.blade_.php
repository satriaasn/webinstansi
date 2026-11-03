@extends('layouts.backend')
@section('title', 'View Event')

@section('content')
<div class="br-pageheader">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
        <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
        <a class="breadcrumb-item" href="{{ url('dashboard/event') }}">Event</a>
        <span class="breadcrumb-item active">View Event</span>
    </nav>
</div>

<div class="br-pagebody">
    <div class="br-section-wrapper">
        <div class="mg-b-40">
            <div class="card-options">
                <a href="{{ url('dashboard/event/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
                        class="fa fa-reply"></i> Back</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <tbody>
                <tr>
                    <th> Nama Event</th>
                    <td> {{ $event->event_nama }}</td>
                </tr>
                <tr>
                    <th> SEO Event</th>
                    <td> {{ $event->event_seo }}</td>
                </tr>
                <tr>
                    <th> Tanggal Mulai</th>
                    <td> {{ \Carbon\Carbon::parse($event->event_tanggalmulai)->format('d/m/Y')}}</td>
                </tr>
                <tr>
                    <th> Tanggal Selesai</th>
                    <td> {{ \Carbon\Carbon::parse($event->event_tanggalselesai)->format('d/m/Y')}}</td>
                </tr>
                <tr>
                    <th> Lokasi Event</th>
                    <td> {{ $event->event_lokasi }}</td>
                </tr>
                <tr>
                    <th> Penyelenggara</th>
                    <td> {{ $event->event_penyelenggara }}</td>
                </tr>
                <tr>
                    <th> Kontak</th>
                    <td> {{ $event->event_kontak }}</td>
                </tr>
                <tr>
                    <th> Deskripsi</th>
                    <td> {!! $event->event_deskripsi !!}</td>
                </tr>

                @if(!empty($event->event_link_terkait))
                <tr>
                    <th> Link terkait</th>
                    <td> {{ $event->event_link_terkait }}</td>
                </tr>
                @endif
                <tr>
                    <th> Active</th>
                    <td> {{ $event->event_status == 'Y' ? 'Active' : 'Non Active' }}</td>
                </tr>
                @if(!empty($event->event_gambar))
                <tr>
                    <th> Gambar</th>
                    <td><a href="{{ berkas( $event->event_gambar) }}" id="quickview">{{
                            $event->event_gambar }}</a></td>
                </tr>
                @endif

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
