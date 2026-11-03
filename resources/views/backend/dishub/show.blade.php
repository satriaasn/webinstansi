@extends('layouts.backend')
@section('title', $module['title'])

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/dishub/' . $module['slug'] . '/table') }}">{{ $module['title'] }}</a>
            <span class="breadcrumb-item active">Detail</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-30">
                <a href="{{ url('dashboard/dishub/' . $module['slug'] . '/table') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-reply"></i> Back
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                    @foreach($module['fields'] as $field)
                        <tr>
                            <th width="240">{{ $field['label'] }}</th>
                            <td>{{ $item->{$field['name']} }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
