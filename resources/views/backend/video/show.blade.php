@extends('layouts.backend')
@section('title', 'View Video')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/video') }}">Video</a>
            <span class="breadcrumb-item active">View Video</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/video/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
                            class="fa fa-reply"></i> Back</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th> Title</th>
                        <td> {{ $video->title }} </td>
                    </tr>
                    <tr>
                        <th> Youtube Url</th>
                        <?php $embed = "https://www.youtube.com/embed/".$video->youtube_id; ?>
                        <td><a href="{{ $embed }}" id="quickvideo"
                               class="fancybox.iframe">{{ $embed }}</a></td>
                    </tr>
                    <tr>
                        <th> Youtube Id</th>
                        <td> {{ $video->youtube_id }} </td>
                    </tr>
                    <tr>
                        <th> Picture</th>
                        <td><a href="{{ $video->picture }}"
                               id="quickview">{{ $video->picture }}</a></td>
                    </tr>
                    <tr>
                        <th> Active</th>
                        <td> {{ $video->active == 'Y' ? 'Active' : 'Non Active' }} </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
