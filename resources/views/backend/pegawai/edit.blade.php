@extends('layouts.backend')
@section('title', 'Edit Pegawai')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/pegawai') }}">Pegawai</a>
            <span class="breadcrumb-item active">Edit Pegawai</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/pegawai/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
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

            {!! Form::model($pegawai, [
                'method' => 'PATCH',
                'url' => ['/dashboard/pegawai', Hashids::encode($pegawai->id)],
                'class' => 'form-horizontal',
                'enctype' => 'multipart/form-data'
            ]) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="row form-group {{ $errors->has('klasifikasi_pegawai') ? 'has-error' : ''}}">
                        {!! Form::label('klasifikasi_pegawai', 'Klasifikasi Pegawai', ['class' => 'col-md-12 control-label required']) !!}
                        <div class="col-md-12">
                            <select class="form-control select2" name="klasifikasi_pegawai" required>
                                <option value="{{ $pegawai->klasifikasi_pegawai }}">
                                    Selected {{ $pegawai->klasifikasi_pegawai }}</option>
                                <option value="Pemimpin">Pemimpin</option>
                                <option value="Staff">Staff</option>
                            </select>
                            {!! $errors->first('klasifikasi_pegawai', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row form-group {{ $errors->has('nip') ? 'has-error' : ''}}">
                        {!! Form::label('nip', 'NIP', ['class' => 'col-md-12 control-label required']) !!}
                        <div class="col-md-12">
                            {!! Form::text('nip', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                            {!! $errors->first('nip', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="row form-group {{ $errors->has('nama_pegawai') ? 'has-error' : ''}}">
                        {!! Form::label('nama_pegawai', 'Nama Pegawai', ['class' => 'col-md-12 control-label required']) !!}
                        <div class="col-md-12">
                            {!! Form::text('nama_pegawai', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                            {!! $errors->first('nama_pegawai', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row form-group {{ $errors->has('jabatan') ? 'has-error' : ''}}">
                        {!! Form::label('jabatan', 'Jabatan', ['class' => 'col-md-12 control-label']) !!}
                        <div class="col-md-12">
                            {!! Form::text('jabatan', null, ['class' => 'form-control' , 'required' => 'required'  ]) !!}
                            {!! $errors->first('jabatan', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row form-group {{ $errors->has('golongan') ? 'has-error' : ''}}">
                        {!! Form::label('golongan', 'Golongan', ['class' => 'col-md-12 control-label']) !!}
                        <div class="col-md-12">
                            {!! Form::text('golongan', null, ['class' => 'form-control' , 'required' => 'required'  ]) !!}
                            {!! $errors->first('golongan', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group {{ $errors->has('deskripsi') ? 'has-error' : ''}}">
                {!! Form::label('deskripsi', 'Deskripsi', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::textarea('deskripsi', null, ['class' => 'form-control text-editor-tiny'  ]) !!}
                    {!! $errors->first('deskripsi', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('file') ? 'has-error' : ''}}">
                {!! Form::label('picture', 'Change Picture', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    <input type="file" name="picture" id="picture" accept="image/*">
                </div>
                {!! $errors->first('picture', '<p class="help-block text-danger">:message</p>') !!}
            </div>
            @if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin'))
                <div class="row form-group {{ $errors->has('active') ? 'has-error' : ''}}">
                    {!! Form::label('active', 'Active', ['class' => 'col-md-12 control-label']) !!}
                    <div class="col-md-12">
                        <select class="form-control select2" name="active" required>
                            <option value="{{ $pegawai->active }}">
                                Selected {{ $pegawai->active == 'Y' ? 'Active' : 'Non Active' }}</option>
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
 <script src="{{ callassetspath('backend/lib/summernote/summernote-bs4.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('.select2').select2({minimumResultsForSearch: Infinity});

            $('#deskripsi').summernote(
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
        });
    </script>
@endpush
