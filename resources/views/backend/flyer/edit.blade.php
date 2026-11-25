@extends('layouts.backend')
@section('title', 'Edit Flyer / Ucapan')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/flyer/table') }}">Flyer & Ucapan</a>
            <span class="breadcrumb-item active">Edit</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/flyer/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
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

            {!! Form::model($flyer, [
                'method' => 'PATCH',
                'url' => ['/dashboard/flyer', Hashids::encode($flyer->id)],
                'class' => 'form-horizontal',
                'enctype' => 'multipart/form-data'
            ]) !!}
            <div class="row form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                {!! Form::label('title', 'Judul Flyer / Ucapan', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('title', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('picture') ? 'has-error' : ''}}">
                {!! Form::label('picture', 'Gambar Flyer (kosongkan jika tidak diganti)', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    @if($flyer->picture)
                        <div class="mb-2">
                            <img src="{{ berkas($flyer->picture) ?: url('berkas/' . $flyer->picture) }}" alt="" style="max-height:140px;border-radius:8px;">
                        </div>
                    @endif
                    <input type="file" name="picture" class="form-control" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG, GIF, WEBP. Maks 4MB.</small>
                </div>
            </div>
            <div class="row form-group {{ $errors->has('url') ? 'has-error' : ''}}">
                {!! Form::label('url', 'Link Tujuan (Opsional)', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::text('url', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                {!! Form::label('description', 'Keterangan Singkat (Opsional)', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 2]) !!}
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
