@extends('layouts.backend')
@section('title', 'Edit Prioritas Pembangunan')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/prioritas/table') }}">Prioritas Pembangunan</a>
            <span class="breadcrumb-item active">Edit</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/prioritas/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
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

            {!! Form::model($prioritas, [
                'method' => 'PATCH',
                'url' => ['/dashboard/prioritas', Hashids::encode($prioritas->id)],
                'class' => 'form-horizontal'
            ]) !!}
            <div class="row form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                {!! Form::label('title', 'Judul Prioritas Pembangunan', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('title', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                {!! Form::label('description', 'Deskripsi Singkat', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
                    {!! $errors->first('description', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('icon') ? 'has-error' : ''}}">
                {!! Form::label('icon', 'Icon FontAwesome', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::text('icon', null, ['class' => 'form-control']) !!}
                    <small class="text-muted">Contoh: <code>fas fa-road</code>, <code>fas fa-users</code>, <code>fas fa-school</code>, <code>fas fa-seedling</code></small>
                </div>
                <div class="col-md-6">
                    {!! Form::label('urutan', 'Urutan Tampil', ['class' => 'control-label']) !!}
                    {!! Form::number('urutan', null, ['class' => 'form-control', 'min' => 0]) !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('active') ? 'has-error' : ''}}">
                {!! Form::label('active', 'Status', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::select('active', ['Y' => 'Aktif', 'N' => 'Non Aktif'], null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Update</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
