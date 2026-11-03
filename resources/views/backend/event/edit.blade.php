@extends('layouts.backend')
@section('title', 'Edit Event')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/event') }}">Event</a>
            <span class="breadcrumb-item active">Edit Event</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/event/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
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

            {!! Form::model($event, [
                'method' => 'PATCH',
                'url' => ['/dashboard/event', Hashids::encode($event->event_kode)],
                'class' => 'form-horizontal'
            ]) !!}
            <div class="row form-group {{ $errors->has('event_nama') ? 'has-error' : ''}}">
                {!! Form::label('event_nama', 'Nama Event', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::text('event_nama', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                    {!! $errors->first('event_nama', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>

            <div class="row form-group {{ $errors->has('event_seo') ? 'has-error' : ''}}">
                {!! Form::label('event_seo', 'Seo Event', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::text('event_seo', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                    {!! $errors->first('event_seo', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>

            <div class="row form-group {{ $errors->has('event_tanggalmulai') ? 'has-error' : ''}}">
                {!! Form::label('event_tanggalmulai', 'Tanggal Mulai', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                        {!! Form::text('event_tanggalmulai', null, ['class' => 'form-control fc-datepicker', 'required' => 'required' ]) !!}
                        <span class="input-group-addon" data-target="#datetimepicker2"
                              data-toggle="datetimepicker"><span class="fa fa-calendar-o"></span></span>
                    </div>
                    {!! $errors->first('event_tanggalmulai', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>

            <div class="row form-group {{ $errors->has('event_tanggalselesai') ? 'has-error' : ''}}">
                {!! Form::label('event_tanggalselesai', 'Tanggal selesai', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                        {!! Form::text('event_tanggalselesai', null, ['class' => 'form-control fc-datepicker', 'required' => 'required' ]) !!}
                        <span class="input-group-addon" data-target="#datetimepicker2"
                              data-toggle="datetimepicker"><span class="fa fa-calendar-o"></span></span>
                    </div>
                    {!! $errors->first('event_tanggalselesai', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>


            <div class="row form-group {{ $errors->has('event_lokasi') ? 'has-error' : ''}}">
                {!! Form::label('event_lokasi', 'Lokasi', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::text('event_lokasi', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                    {!! $errors->first('event_lokasi', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('event_penyelenggara') ? 'has-error' : ''}}">
                {!! Form::label('event_penyelenggara', 'Penyelenggara', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::text('event_penyelenggara', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                    {!! $errors->first('event_penyelenggara', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('event_kontak') ? 'has-error' : ''}}">
                {!! Form::label('event_kontak', 'Kontak', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::text('event_kontak', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                    {!! $errors->first('event_kontak', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>

            <div class="row form-group {{ $errors->has('event_gambar') ? 'has-error' : ''}}">
                {!! Form::label('event_gambar', 'Unggah Gambar', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    <div class="input-group">
                        {!! Form::text('event_gambar', null, ('required' == 'required') ? ['class' => 'form-control', 'id' => 'input-filemanager'] : ['class' => 'form-control']) !!}
                        <span class="input-group-btn">
									<a href="#"
                                       id="filemanager" class="btn btn-secondary"><i class="fa fa-file"></i> Pilih</a>
								</span>
                    </div>
                </div>
                {!! $errors->first('event_gambar', '<p class="help-block text-danger">:message</p>') !!}
            </div>


            <div class="row form-group {{ $errors->has('event_deskripsi') ? 'has-error' : ''}}">
                {!! Form::label('event_deskripsi', 'Deskripsi Event', ['class' => 'col-md-12 control-label required']) !!}
                <div class="col-md-12">
                    {!! Form::textarea('event_deskripsi', null, ['class' => 'form-control', 'id' => 'content' ]) !!}
                    {!! $errors->first('event_deskripsi', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>

            <div class="row form-group {{ $errors->has('event_link_terkait') ? 'has-error' : ''}}">

                {!! Form::label('event_link_terkait', 'Link Terkait (akan diarahkan ke link ini ketika klik pada selengkapnya)', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::text('event_link_terkait', null, ['class' => 'form-control' ]) !!}
                    {!! $errors->first('event_link_terkait', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>

            <div class="row form-group {{ $errors->has('event_status') ? 'has-error' : ''}}">
                {!! Form::label('event_status', 'Status', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    <select class="form-control select2" name="active" required>
                        <option value="{{ $event->event_status }}">
                            Selected {{ $event->event_status == 'Y' ? 'Active' : 'Non Active' }}</option>
                        <option value="Y">Active</option>
                        <option value="N">Non Active</option>
                    </select>
                    {{--                        {!! Form::select('jenis', array('Dinas' => 'Dinas', 'Sekretariat' => 'Sekretariat', 'Badan' => 'Badan'), $opd->jenis, ['class' => 'form-control select2', 'required' => 'required']); !!}--}}
                    {!! $errors->first('event_status', '<p class="help-block text-danger">:message</p>') !!}
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

@push('scripts')
    <script src="{{ callassetspath('backend/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ callassetspath('backend/lib/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript">
        $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
        });


        $('#event_nama').on('input', function () {
            var permalink;
            permalink = $.trim($(this).val());
            permalink = permalink.replace(/\s+/g, ' ');
            $('#event_seo').val(permalink.toLowerCase());
            $('#event_seo').val($('#event_seo').val().replace(/\W/g, ' '));
            $('#event_seo').val($.trim($('#event_seo').val()));
            $('#event_seo').val($('#event_seo').val().replace(/\s+/g, '-'));
        });

        $('#event_seo').on('input', function () {
            var permalink;
            permalink = $(this).val();
            permalink = permalink.replace(/\s+/g, ' ');
            $('#event_seo').val(permalink.toLowerCase());
            $('#event_seo').val($('#event_seo').val().replace(/\W/g, ' '));
            $('#event_seo').val($('#event_seo').val().replace(/\s+/g, '-'));
        });

        CKEDITOR.replace('editor');
        $(function () {
            $('.select2').select2({minimumResultsForSearch: Infinity});

            tinymce.init({
                selector: ".text-editor-tiny",
                editor_deselector: "mceNoEditor",
                skin: "lightgray",
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                    "table contextmenu directionality emoticons paste textcolor responsivefilemanager",
                    "code fullscreen youtube autoresize codesample"
                ],
                menubar: false,
                toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent table",
                toolbar2: "| fontsizeselect | styleselect | link unlink anchor | responsivefilemanager image media youtube | forecolor backcolor | code codesample ",
                image_advtab: true,
                fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
                relative_urls: false,
                convert_urls: false,
                base_url: "",
                remove_script_host: false,
                external_filemanager_path: "{{ url('filemanager') }}/",
                filemanager_title: "File Manager",
                filemanager_access_key: "",
                external_plugins: {
                    "filemanager": "{{ asset('filemanager/plugin.min.js') }}"
                }
            });
        });
    </script>
@endpush
