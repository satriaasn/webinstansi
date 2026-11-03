@extends('layouts.backend')
@section('title', 'View Post Category')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/post-category') }}">Post Category</a>
            <span class="breadcrumb-item active">View Post Category</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/post-category/table') }}" class="btn btn-secondary btn-sm"
                       title="Back"><i class="fa fa-reply"></i> Back</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th> Title</th>
                        <td> {{ $postcategory->title }} </td>
                    </tr>
                    <tr>
                        <th> Seotitle</th>
                        <td> {{ $postcategory->seotitle }} </td>
                    </tr>
                    <tr>
                        <th> Active</th>
                        <td> {{ $postcategory->active == 'Y' ? 'Active' : 'Non Active' }} </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
