@extends('layouts.backend')
@section('title', 'Reply Contact')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/contact') }}">Contact</a>
            <span class="breadcrumb-item active">Reply Contact</span>
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

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th> Name</th>
                        <td> {{ $contact->name }} </td>
                    </tr>
                    <tr>
                        <th> Email</th>
                        <td> {{ $contact->email }} </td>
                    </tr>
                    <tr>
                        <th> Subject</th>
                        <td> {{ $contact->subject }} </td>
                    </tr>
                    <tr>
                        <th> Message</th>
                        <td> {{ $contact->message }} </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <hr/>

            {!! Form::model($contact, [
                'method' => 'POST',
                'url' => ['dashboard/contact/actreply', Hashids::encode($contact->id)],
                'class' => 'form-horizontal',
                'files' => true
            ]) !!}
            <div class="row form-group {{ $errors->has('reply') ? 'has-error' : ''}}">
                {!! Form::label('reply', 'Reply Message', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    {!! Form::textarea('reply', null, ['class' => 'form-control text-editor' , 'required' => 'required' ]) !!}
                    {!! $errors->first('reply', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <hr/>
                    {!! Form::submit('Reply Message', ['class' => 'btn btn-success pull-right']) !!}
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
