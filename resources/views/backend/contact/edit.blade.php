@extends('layouts.backend')
@section('title', 'Edit Contact')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/contact') }}">Contact</a>
            <span class="breadcrumb-item active">Edit Contact</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/contact/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
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

            {!! Form::model($contact, [
                'method' => 'PATCH',
                'url' => ['/dashboard/contact', Hashids::encode($contact->id)],
                'class' => 'form-horizontal'
            ]) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="row form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        {!! Form::label('name', 'Name', ['class' => 'col-md-12 control-label required']) !!}
                        <div class="col-md-12">
                            {!! Form::text('name', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                            {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                        {!! Form::label('email', 'Email', ['class' => 'col-md-12 control-label required']) !!}
                        <div class="col-md-12">
                            {!! Form::text('email', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                            {!! $errors->first('email', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group {{ $errors->has('subject') ? 'has-error' : ''}}">
                {!! Form::label('subject', 'Subject', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    {!! Form::text('subject', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                    {!! $errors->first('subject', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('message') ? 'has-error' : ''}}">
                {!! Form::label('message', 'Message', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    {!! Form::textarea('message', null, ['class' => 'form-control text-editor' , 'required' => 'required' ]) !!}
                    {!! $errors->first('message', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('read') ? 'has-error' : ''}}">
                {!! Form::label('read', 'Read', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    <select class="read form-control select2" id="read" name="read">
                        <option value="{{ $contact->read }}">
                            Selected {{ $contact->read == 'Y' ? 'Read' : 'Unread' }}</option>
                        <option value="Y">Read</option>
                        <option value="N">Unread</option>
                    </select>
                    {!! $errors->first('read', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <hr/>
                    {!! Form::submit('Update', ['class' => 'btn btn-success pull-right']) !!}
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
