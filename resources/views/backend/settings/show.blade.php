@extends('layouts.backend')
@section('title', 'View Settings')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/settings') }}">Settings</a>
            <span class="breadcrumb-item active">View Settings</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/settings/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
                            class="fa fa-reply"></i> Back</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th>Key</th>
                        <td>{{ $setting->key }}</td>
                    </tr>
                    <tr>
                        <th>Value</th>
                        <td>{{ $setting->value }}</td>
                    </tr>
                    <tr>
                        <th>Usage</th>
                        <td><code>setting('{{ $setting->key }}')</code></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
