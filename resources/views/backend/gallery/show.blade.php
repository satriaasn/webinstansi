@extends('layouts.backend')
@section('title', 'View Gallery')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/gallery') }}">Gallery</a>
            <span class="breadcrumb-item active">View Gallery</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/gallery/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
                            class="fa fa-reply"></i> Back</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th> Album</th>
                        <td> {{ $gallery->album->title }} </td>
                    </tr>
                    <tr>
                        <th> Title</th>
                        <td> {{ $gallery->title }} </td>
                    </tr>
                    <tr>
                        <th> Seotitle</th>
                        <td> {{ $gallery->seotitle }} </td>
                    </tr>
                    <tr>
                        <th> Picture</th>
                        <td><a href="{{ berkas( $gallery->picture) }}"
                               id="quickview">{{ $gallery->picture }}</a></td>
                    </tr>
                    <tr>
                        <th> Active</th>
                        <td> {{ $gallery->active == 'Y' ? 'Active' : 'Non Active' }} </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
