@extends('layouts.backend')
@section('title', 'Create Menu Manager')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/menu') }}">Menu Manager</a>
            <span class="breadcrumb-item active">Create Menu Manager</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/menu/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
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

            {!! Form::open(['url' => '/dashboard/menu', 'class' => 'form-horizontal']) !!}
            <div class="row form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                {!! Form::label('name', 'Name', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    {!! Form::text('name', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                    {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('url') ? 'has-error' : ''}}">
                {!! Form::label('url', 'URL', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    {!! Form::text('url', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                    {!! $errors->first('url', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('target') ? 'has-error' : ''}}">
                {!! Form::label('target', 'Target', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    <select class="target form-control select2" id="target" name="target">
                        <option value="none">none</option>
                        <option value="_blank">_blank</option>
                    </select>
                    {!! $errors->first('target', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <hr/>
                    {!! Form::submit('Create', ['class' => 'btn btn-success pull-right']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ callassetspath('backend/lib/summernote/summernote-bs4.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ callassetspath('backend/lib/summernote/summernote-bs4.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('.select2').select2({minimumResultsForSearch: Infinity});

            $('.text-editor').summernote({
                height: 150,
                tooltip: false
            })
        });
    </script>
@endpush
