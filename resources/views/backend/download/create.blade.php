@extends('layouts.backend')
@section('title', 'Create Download')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/download') }}">Download</a>
            <span class="breadcrumb-item active">Create Download</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/download/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
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

            {!! Form::open(['url' => '/dashboard/download', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
            <div class="row form-group {{ $errors->has('download_category_id') ? 'has-error' : ''}}">
                {!! Form::label('download_category_id', 'Category', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    <select class="form-control select2" name="download_category_id" required>
                        @foreach($download_categorys as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('download_category_id', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                {!! Form::label('title', 'Title', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::text('title', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                    {!! $errors->first('title', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('seotitle') ? 'has-error' : ''}}">
                {!! Form::label('seotitle', 'Seotitle', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::text('seotitle', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                    {!! $errors->first('seotitle', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('content') ? 'has-error' : ''}}">
                {!! Form::label('content', 'Content', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    {!! Form::textarea('content', null, ['class' => 'form-control' , 'id' => 'content' ]) !!}
                    {!! $errors->first('content', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('file') ? 'has-error' : ''}}">
                {!! Form::label('file', 'File', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    <input type="file" name="file" id="file" accept=".pdf">
                </div>
                {!! $errors->first('file', '<p class="help-block text-danger">:message</p>') !!}
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
    <script src="{{ callassetspath('backend/lib/summernote/summernote-bs4.min.js')}}"></script>
    <script type="text/javascript">

        $(function () {
            $('.select2').select2({minimumResultsForSearch: Infinity});
        });

        $('#content').summernote(
            {
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'myVideo']],

                    //['popovers', ['lfm']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                buttons: {
                    myVideo: function (context) {
                        var ui = $.summernote.ui;
                        var button = ui.button({
                            contents: '<i class="note-icon-video"/>',
                            tooltip: 'video',
                            click: function () {

                                var div = document.createElement('div');
                                div.classList.add('embed-container');
                                var iframe = document.createElement('iframe');
                                iframe.src = prompt('Enter video url:');

                                const str = iframe.src;
                                const res = str.split("=");
                                const res2 = res[1].split("&");
                                const embeddedUrl = "https://www.youtube.com/embed/" + res2[0];
                                iframe.src = embeddedUrl;

                                iframe.setAttribute('frameborder', 0);
                                iframe.setAttribute('width', '100%');
                                iframe.setAttribute('height', '400px');
                                iframe.setAttribute('allowfullscreen', true);
                                div.appendChild(iframe);
                                context.invoke('editor.insertNode', div);
                            }
                        });
                        return button.render();
                    }
                },

                callbacks: {
                    onChange: function (contents, $editable) {
                        console.log('onChange:', contents, $editable);
                        $('#content_value').val(contents);
                        $editable.find('iframe[src^="//"]').each(function () {
                            $(this).attr('src', 'https:' + $(this).attr('src'));
                        });
                    }
                },
                height: 300,
            });

        $('form').on('submit', function () {
            if ($('#content').summernote('isEmpty')) {
                $('#content').val('');
            } else {
                $('#content').val($('#content').summernote('code'));
            }
        });
    </script>
@endpush
