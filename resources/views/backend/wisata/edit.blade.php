@extends('layouts.backend')
@section('title', 'Edit Wisata')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/wisata') }}">Gallery Wisata</a>
            <span class="breadcrumb-item active">Edit Wisata</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/wisata/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
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

            {!! Form::model($wisata, [
                'method' => 'PATCH',
                'url' => ['/dashboard/wisata', Hashids::encode($wisata->wisata_id)],
                'class' => 'form-horizontal'
            ]) !!}
            <div class="row form-group {{ $errors->has('wisata_nama') ? 'has-error' : ''}}">
                {!! Form::label('title', 'Nama', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::text('wisata_nama', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                    {!! $errors->first('wisata_nama', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('wisata_link') ? 'has-error' : ''}}">
                {!! Form::label('wisata_link', 'Link Url', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    {!! Form::text('wisata_link', null, ['class' => 'form-control' , 'required' => 'required' ]) !!}
                    {!! $errors->first('wisata_link', '<p class="help-block text-danger">:message</p>') !!}
                </div>
            </div>
            <div class="row form-group {{ $errors->has('picture') ? 'has-error' : ''}}">
                {!! Form::label('wisata_foto', 'Picture (Rekomendasi Ukuran '.$wisata->rekomendasi_ukuran.')', ['class' => 'col-md-12 control-label']) !!}
                <div class="col-md-12">
                    <div class="input-group">
                        {!! Form::text('wisata_foto', null, ('required' == 'required') ? ['class' => 'form-control', 'id' => 'input-filemanager', 'required' => 'required'] : ['class' => 'form-control']) !!}
                        <span class="input-group-btn">
									<a href="#"
                                       id="filemanager" class="btn btn-secondary"><i class="fa fa-file"></i> Browse</a>
								</span>
                    </div>
                </div>
                {!! $errors->first('wisata_foto', '<p class="help-block text-danger">:message</p>') !!}
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
    <script type="text/javascript">
        $(function () {
            $('.select2').select2({minimumResultsForSearch: Infinity});
        });
    </script>
@endpush
