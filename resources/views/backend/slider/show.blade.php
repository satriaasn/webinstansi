@extends('layouts.backend')
@section('title', 'View Slider')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/slider') }}">Slider</a>
            <span class="breadcrumb-item active">View Slider</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/slider/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
                            class="fa fa-reply"></i> Back</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th> Title</th>
                        <td> {{ $slider->title }} </td>
                    </tr>
                    <tr>
                        <th> Seotitle</th>
                        <td> {{ $slider->seotitle }} </td>
                    </tr>
                    <tr>
                        <th> Content</th>
                        <td> {{ $slider->content }} </td>
                    </tr>
                    <tr>
                        <th> Url</th>
                        <td> {{ $slider->url }} </td>
                    </tr>
                    <tr>
                        <th> Picture</th>
                        <td><a href="{{ berkas( $slider->picture) }}"
                               id="quickview">{{ $slider->picture }}</a></td>
                    </tr>
                    <tr>
                        <th> Active</th>
                        <td> {{ $slider->active == 'Y' ? 'Active' : 'Non Active' }} </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
