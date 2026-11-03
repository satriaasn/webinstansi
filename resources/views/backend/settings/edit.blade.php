@extends('layouts.backend')
@section('title', 'Edit Settings')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/settings') }}">Settings</a>
            <span class="breadcrumb-item active">Edit Settings</span>
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

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            {!! Form::model($setting, [
                'method' => 'PATCH',
                'url' => ['/dashboard/settings', Hashids::encode($setting->id)],
                'class' => 'form-horizontal',
                'files' => true
            ]) !!}

            @include ('backend.settings.form', ['formMode' => 'edit'])

            {!! Form::close() !!}
        </div>
    </div>
@endsection
