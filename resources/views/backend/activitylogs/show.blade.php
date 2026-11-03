@extends('layouts.backend')
@section('title', 'View Activity Logs')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/activitylogs') }}">Activity Logs</a>
            <span class="breadcrumb-item active">View Activity Logs</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/activitylogs/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
                            class="fa fa-reply"></i> Back</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th>Activity</th>
                        <td>{{ $activitylog->description }}</td>
                    </tr>
                    <tr>
                        <th>Actor</th>
                        <td>
                            @if ($activitylog->causer)
                                <a href="{{ url('dashboard/users/' . Hashids::encode($activitylog->causer->id)) }}">{{ $activitylog->causer->name }}</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>{{ $activitylog->created_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
