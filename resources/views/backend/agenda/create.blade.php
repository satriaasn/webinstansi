@extends('layouts.backend')
@section('title', 'Create Agenda')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/agenda') }}">Agenda</a>
            <span class="breadcrumb-item active">Create Agenda</span>
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

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            {!! Form::open(['url' => '/dashboard/agenda', 'class' => 'form-horizontal']) !!}
            <div class="row form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                {!! Form::label('title', 'Title', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    {!! Form::text('title', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                    {!! $errors->first('title', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('seotitle') ? 'has-error' : ''}}">
                {!! Form::label('seotitle', 'Seotitle', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    {!! Form::text('seotitle', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                    {!! $errors->first('seotitle', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('start') ? 'has-error' : ''}}">
                {!! Form::label('start', 'Start', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                        {!! Form::text('start', null, ['class' => 'form-control datetimepicker-input' , 'data-target' => '#datetimepicker' , 'required' => 'required' ]) !!}
                        <span class="input-group-addon" data-target="#datetimepicker" data-toggle="datetimepicker"><span
                                class="fa fa-calendar-o"></span></span>
                    </div>
                    {!! $errors->first('start', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('end') ? 'has-error' : ''}}">
                {!! Form::label('end', 'End', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                        {!! Form::text('end', null, ['class' => 'form-control datetimepicker-input' , 'data-target' => '#datetimepicker2' , 'required' => 'required' ]) !!}
                        <span class="input-group-addon" data-target="#datetimepicker2"
                              data-toggle="datetimepicker"><span class="fa fa-calendar-o"></span></span>
                    </div>
                    {!! $errors->first('end', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('content') ? 'has-error' : ''}}">
                {!! Form::label('content', 'Content', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    {!! Form::textarea('content', null, ['class' => 'form-control' , 'required' => 'required', 'id' => 'content' ]) !!}
                    {!! $errors->first('content', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            @if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin'))
                <div class="row form-group {{ $errors->has('active') ? 'has-error' : ''}}">
                    {!! Form::label('active', 'Active', ['class' => 'col-md-12 control-label']) !!}
                    <div class="col-md-12">
                        <select class="form-control select2" name="active" required>
                            <option value="Y">Active</option>
                            <option value="N">Non Active</option>
                        </select>
                        {!! $errors->first('active', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            @else
                {!! Form::hidden('active', 'N') !!}
            @endif
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

            $('#content').summernote({
                height: 250,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });

            $('form').on('submit', function () {
                if ($('#content').summernote('isEmpty')) {
                    $('#content').val('');
                } else {
                    $('#content').val($('#content').summernote('code'));
                }
            });
        });
    </script>
@endpush
