@extends('layouts.backend')
@section('title', 'View Download')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/download') }}">Download</a>
            <span class="breadcrumb-item active">View Download</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/download/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
                            class="fa fa-reply"></i> Back</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th> Category</th>
                        <td> {{ $download->downloadCategory->title }} </td>
                    </tr>
                    <tr>
                        <th> Title</th>
                        <td> {{ $download->title }} </td>
                    </tr>
                    <tr>
                        <th> Seotitle</th>
                        <td> {{ $download->seotitle }} </td>
                    </tr>
                    <tr>
                        <th> Content</th>
                        <td> {!! $download->content !!} </td>
                    </tr>
                    <tr>
                        <th> File</th>
                        <td><a href="{{ berkas( $download->file) }}"
                               target="_blank">{{ $download->file }}</a></td>
                    </tr>
                    <tr>
                        <th> Active</th>
                        <td> {{ $download->active == 'Y' ? 'Active' : 'Non Active' }} </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
