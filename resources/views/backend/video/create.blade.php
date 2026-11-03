@extends('layouts.backend')
@section('title', 'Create New')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/video') }}">Video</a>
            <span class="breadcrumb-item active">Create Video</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/video/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
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

            {!! Form::open(['url' => '/dashboard/video', 'class' => 'form-horizontal']) !!}
            <div class="row form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                {!! Form::label('title', 'Title', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::text('title', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                    {!! $errors->first('title', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('youtube_url') ? 'has-error' : ''}}">
                {!! Form::label('youtube_url', 'Youtube Url', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::text('youtube_url', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                    {!! $errors->first('youtube_url', '<p class="help-block text-danger">:message</p>') !!}
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

@push('scripts')
    <script type="text/javascript">
        $(function () {
            $('.select2').select2({minimumResultsForSearch: Infinity});
        });
    </script>
@endpush
