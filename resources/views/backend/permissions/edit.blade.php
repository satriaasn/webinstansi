@extends('layouts.backend')
@section('title', 'Edit Permissions')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/permissions') }}">Permissions</a>
            <span class="breadcrumb-item active">Edit Permissions</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/permissions/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
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

            {!! Form::model($permission, [
                'method' => 'PATCH',
                'url' => ['/dashboard/permissions', Hashids::encode($permission->id)],
                'class' => 'form-horizontal'
            ]) !!}

            @include ('backend.permissions.form', ['formMode' => 'edit'])

            {!! Form::close() !!}
        </div>
    </div>
@endsection
