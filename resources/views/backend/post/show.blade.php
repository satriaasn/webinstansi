@extends('layouts.backend')
@section('title', 'View Post')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/post') }}">Post</a>
            <span class="breadcrumb-item active">View Post</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/post/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
                            class="fa fa-reply"></i> Back</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th> Category</th>
                        <td> {{ $post->postCategory->title }} </td>
                    </tr>
                    <tr>
                        <th> Title</th>
                        <td> {{ $post->title }} </td>
                    </tr>
                    <tr>
                        <th> Seotitle</th>
                        <td> {{ $post->seotitle }} </td>
                    </tr>
                    <tr>
                        <th> Content</th>
                        <td> {!! $post->content !!} </td>
                    </tr>
                    <tr>
                        <th> Tag</th>
                        <td> {{ $post->tag }} </td>
                    </tr>
                    <tr>
                        <th> Picture</th>
                        <td><a href="{{ berkas( $post->picture) }}"
                               id="quickview">{{ $post->picture }}</a></td>
                    </tr>
                    <tr>
                        <th> Headline</th>
                        <td> {{ $post->headline == 'Y' ? 'Headline' : 'Non Headline' }} </td>
                    </tr>
                    <tr>
                        <th> Active</th>
                        <td> {{ $post->active == 'Y' ? 'Active' : 'Non Active' }} </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
