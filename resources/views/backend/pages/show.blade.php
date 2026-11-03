@extends('layouts.backend')
@section('title', 'View Pages')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/pages') }}">Pages</a>
            <span class="breadcrumb-item active">View Pages</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/pages/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
                            class="fa fa-reply"></i> Back</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th> Title</th>
                        <td> {{ $pages->title }} </td>
                    </tr>
                    <tr>
                        <th> Seotitle</th>
                        <td> {{ $pages->seotitle }} </td>
                    </tr>
                    <tr>
                        <th> Content</th>
                        <td> {!! $pages->content !!} </td>
                    </tr>
                    <tr>
                        <th> Picture</th>
                        <td><a href="{{ berkas( $pages->picture) }}"
                               id="quickview">{{ $pages->picture }}</a></td>
                    </tr>
                    <tr>
                        <th> Active</th>
                        <td> {{ $pages->active == 'Y' ? 'Active' : 'Non Active' }} </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
