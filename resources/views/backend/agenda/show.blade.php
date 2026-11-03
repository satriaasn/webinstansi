@extends('layouts.backend')
@section('title', 'View Agenda')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/agenda') }}">Agenda</a>
            <span class="breadcrumb-item active">View Agenda</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/agenda/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
                            class="fa fa-reply"></i> Back</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th> Title</th>
                        <td> {{ $agenda->title }} </td>
                    </tr>
                    <tr>
                        <th> Seotitle</th>
                        <td> {{ $agenda->seotitle }} </td>
                    </tr>
                    <tr>
                        <th> Start</th>
                        <td> {{ date('d M Y H:i A', strtotime($agenda->start)) }} </td>
                    </tr>
                    <tr>
                        <th> End</th>
                        <td> {{ date('d M Y H:i A', strtotime($agenda->end)) }} </td>
                    </tr>
                    <tr>
                        <th> Content</th>
                        <td> {!! $agenda->content !!} </td>
                    </tr>
                    <tr>
                        <th> Active</th>
                        <td> {{ $agenda->active == 'Y' ? 'Active' : 'Non Active' }} </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
