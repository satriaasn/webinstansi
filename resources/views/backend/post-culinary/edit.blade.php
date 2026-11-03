@extends('layouts.backend')
@section('title', 'Edit Culinary Data')
@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/post-culinary/table') }}">Culinary</a>
            <span class="breadcrumb-item active">Edit</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40 d-flex justify-content-between align-items-center">
                <h4 class="m-0"><i class="fa fa-cutlery text-primary"></i> Data Kuliner: <span class="text-muted">{{ $post->title }}</span></h4>
                <div class="card-options">
                    <a href="{{ url('dashboard/post-culinary/table') }}" class="btn btn-outline-secondary btn-sm"><i class="fa fa-reply"></i> Kembali</a>
                </div>
            </div>
            
            <hr/>

            {!! Form::model($culinary, [
                'method' => 'PATCH',
                'url' => ['/dashboard/post-culinary', Hashids::encode($post->id)]
            ]) !!}
            
            <div class="row">
                <div class="col-lg-6">
                    <div class="card bd-0 shadow-base mb-4">
                        <div class="card-header bg-transparent">
                            <h6 class="card-title tx-uppercase tx-12 mg-b-0">Informasi Kuliner</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="control-label tx-bold required">Tipe Kuliner</label>
                                {!! Form::text('cuisine_type', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Contoh: Seafood, Tradisional Lampung, Cafe' ]) !!}
                            </div>
                            <div class="form-group">
                                <label class="control-label tx-bold">Menu Andalan (Signature Dish)</label>
                                {!! Form::text('signature_dish', null, ['class' => 'form-control', 'placeholder' => 'Contoh: Seruit Lampung, Pindang Patin' ]) !!}
                            </div>
                            <div class="form-group">
                                <label class="control-label tx-bold">Range Harga</label>
                                {!! Form::text('price_range', null, ['class' => 'form-control', 'placeholder' => 'Contoh: Rp 25.000 - Rp 150.000' ]) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card bd-0 shadow-base mb-4 bg-light">
                        <div class="card-header bg-transparent">
                            <h6 class="card-title tx-uppercase tx-12 mg-b-0">Koordinat Lokasi</h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info tx-12">
                                <strong>Tips Google Maps:</strong> Klik kanan di titik peta Google Maps untuk menyalin Latitude & Longitude.
                            </div>
                            <div class="row mg-t-15">
                                <div class="col-md-6 form-group">
                                    <label class="control-label tx-bold">Latitude</label>
                                    {!! Form::text('latitude', null, ['class' => 'form-control', 'placeholder' => '-5.xxxxxx' ]) !!}
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="control-label tx-bold">Longitude</label>
                                    {!! Form::text('longitude', null, ['class' => 'form-control', 'placeholder' => '105.xxxxxx']) !!}
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
                    <button type="submit" class="btn btn-success btn-lg px-5"><i class="fa fa-save"></i> Simpan Data Kuliner</button>
                    <a href="{{ url('dashboard/post-culinary/table') }}" class="btn btn-secondary btn-lg ml-2">Batal</a>
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
