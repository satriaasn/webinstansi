@extends('layouts.backend')
@section('title', 'Edit Theme')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/theme') }}">Theme</a>
            <span class="breadcrumb-item active">Edit Theme</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/theme/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
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

            {!! Form::model($theme, [
                'method' => 'PATCH',
                'url' => ['/dashboard/theme', Hashids::encode($theme->id)],
                'class' => 'form-horizontal'
            ]) !!}
            <div class="row form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                {!! Form::label('title', 'Title', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::text('title', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                    {!! $errors->first('title', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('folder') ? 'has-error' : ''}}">
                {!! Form::label('folder', 'Folder', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::text('folder', null, ['class' => 'form-control' , 'id' => 'seotitle' , 'required' => 'required' ]) !!}
                    {!! $errors->first('folder', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('picture') ? 'has-error' : ''}}">
                {!! Form::label('picture', 'Picture', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::text('picture', null, ['class' => 'form-control', 'id' => 'picture', 'required' => 'required', 'placeholder' => 'Nama file gambar tema (misal: theme.jpg)']) !!}
                </div>
                {!! $errors->first('picture', '<p class="help-block text-danger">:message</p>') !!}
            </div>
            @if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin'))
                <div class="row form-group {{ $errors->has('active') ? 'has-error' : ''}}">
                    {!! Form::label('active', 'Active', ['class' => 'col-md-12 control-label']) !!}
                    <div class="col-md-12">
                        <select class="form-control select2" name="active" required>
                            <option value="{{ $theme->active }}">
                                Selected {{ $theme->active == 'Y' ? 'Active' : 'Non Active' }}</option>
                            <option value="Y">Active</option>
                            <option value="N">Non Active</option>
                        </select>
                        {!! $errors->first('active', '<p class="help-block text-danger">:message</p>') !!}
                    </div>
                </div>
            @else
                {!! Form::hidden('active', null) !!}
            @endif
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

@push('scripts')
    <script type="text/javascript">
        $(function () {
            $('.select2').select2({minimumResultsForSearch: Infinity});
        });
    </script>
@endpush
