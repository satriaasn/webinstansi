@extends('layouts.backend')
@section('title', 'View Theme')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/theme') }}">Theme</a>
            <span class="breadcrumb-item active">View Theme</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/theme/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
                            class="fa fa-reply"></i> Back</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th> Title</th>
                        <td> {{ $theme->title }} </td>
                    </tr>
                    <tr>
                        <th> Folder</th>
                        <td> {{ $theme->folder }} </td>
                    </tr>
                    <tr>
                        <th> Picture</th>
                        <td><img class="img-fluid img-thumbnail"
                                 src="{{ berkas( $theme->picture) }}"></td>
                    </tr>
                    <tr>
                        <th> Active</th>
                        <td> {{ $theme->active == 'Y' ? 'Active' : 'Non Active' }} </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
