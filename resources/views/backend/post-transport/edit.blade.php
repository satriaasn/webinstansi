@extends('layouts.backend')
@section('title', 'Edit Transport Data')
@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/post-transport/table') }}">Transport</a>
            <span class="breadcrumb-item active">Edit</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40 d-flex justify-content-between align-items-center">
                <h4 class="m-0"><i class="fa fa-bus text-primary"></i> Data Transport: <span class="text-muted">{{ $post->title }}</span></h4>
                <div class="card-options">
                    <a href="{{ url('dashboard/post-transport/table') }}" class="btn btn-outline-secondary btn-sm"><i class="fa fa-reply"></i> Kembali</a>
                </div>
            </div>
            
            <hr/>

            {!! Form::model($transport, [
                'method' => 'PATCH',
                'url' => ['/dashboard/post-transport', Hashids::encode($post->id)]
            ]) !!}
            
            <div class="row">
                <div class="col-lg-6">
                    <div class="card bd-0 shadow-base mb-4">
                        <div class="card-header bg-transparent">
                            <h6 class="card-title tx-uppercase tx-12 mg-b-0">Informasi Layanan & Rute</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="control-label tx-bold required">Mode Transportasi</label>
                                {!! Form::text('transport_mode', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Contoh: Bus Damri, Travel, Kapal Feri' ]) !!}
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="control-label tx-bold required">Titik Keberangkatan</label>
                                    {!! Form::text('route_origin', null, ['class' => 'form-control', 'placeholder' => 'Contoh: Bandar Lampung' ]) !!}
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label tx-bold required">Titik Tujuan</label>
                                    {!! Form::text('route_destination', null, ['class' => 'form-control', 'placeholder' => 'Contoh: Jakarta / Bakauheni' ]) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label tx-bold">Estimasi Harga Tiket</label>
                                {!! Form::text('estimated_price', null, ['class' => 'form-control', 'placeholder' => 'Contoh: Rp 200.000' ]) !!}
                            </div>
                            <div class="form-group">
                                <label class="control-label tx-bold">Deskripsi Rute / Jadwal</label>
                                {!! Form::textarea('route_description', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Jadwal keberangkatan setiap jam...' ]) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card bd-0 shadow-base mb-4 bg-light">
                        <div class="card-header bg-transparent">
                            <h6 class="card-title tx-uppercase tx-12 mg-b-0">Koordinat (Peta)</h6>
                        </div>
                        <div class="card-body">
                            <h6 class="tx-11 tx-uppercase tx-bold mg-b-10 text-primary">Titik Keberangkatan (Origin)</h6>
                            <div class="row mg-b-20">
                                <div class="col-md-6 form-group">
                                    <label class="control-label tx-11 tx-bold">Latitude</label>
                                    {!! Form::text('origin_latitude', null, ['class' => 'form-control form-control-sm' ]) !!}
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label tx-11 tx-bold">Longitude</label>
                                    {!! Form::text('origin_longitude', null, ['class' => 'form-control form-control-sm' ]) !!}
                                </div>
                            </div>

                            <h6 class="tx-11 tx-uppercase tx-bold mg-b-10 text-danger">Titik Tujuan (Destination)</h6>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="control-label tx-11 tx-bold">Latitude</label>
                                    {!! Form::text('destination_latitude', null, ['class' => 'form-control form-control-sm' ]) !!}
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label tx-11 tx-bold">Longitude</label>
                                    {!! Form::text('destination_longitude', null, ['class' => 'form-control form-control-sm' ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card bd-0 shadow-base mb-4">
                        <div class="card-header bg-transparent">
                            <h6 class="card-title tx-uppercase tx-12 mg-b-0 text-primary">Konten Terkait (TripAdvisor)</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <label class="control-label tx-bold">Hubungkan ke Konten Lain:</label>
                                {!! Form::select('related_posts[]', $all_related_options, $related_ids, ['class' => 'form-control select2', 'multiple' => 'multiple', 'style' => 'width:100%']) !!}
                                <small class="text-muted d-block mt-2">Pilih destinasi, akomodasi, dll agar konten ini saling terhubung dua arah.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-12 text-center">
                    <hr/>
                    <button type="submit" class="btn btn-success btn-lg px-5"><i class="fa fa-save"></i> Simpan Data Transport</button>
                    <a href="{{ url('dashboard/post-transport/table') }}" class="btn btn-secondary btn-lg ml-2">Batal</a>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function(){
        $('.select2').select2({
            placeholder: '--- Pilih Konten ---',
            allowClear: true
        });
    });
</script>
@endpush
