@extends('layouts.backend')
@section('title', 'Edit Accommodation Data')
@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/post-accommodation/table') }}">Accommodations</a>
            <span class="breadcrumb-item active">Edit</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40 d-flex justify-content-between align-items-center">
                <h4 class="m-0"><i class="fa fa-home text-primary"></i> Data Akomodasi: <span class="text-muted">{{ $post->title }}</span></h4>
                <div class="card-options">
                    <a href="{{ url('dashboard/post-accommodation/table') }}" class="btn btn-outline-secondary btn-sm"><i class="fa fa-reply"></i> Kembali</a>
                </div>
            </div>
            
            <hr/>

            {!! Form::model($accommodation, [
                'method' => 'PATCH',
                'url' => ['/dashboard/post-accommodation', Hashids::encode($post->id)]
            ]) !!}
            
            <div class="row">
                <div class="col-lg-6">
                    <div class="card bd-0 shadow-base mb-4">
                        <div class="card-header bg-transparent">
                            <h6 class="card-title tx-uppercase tx-12 mg-b-0">Informasi Dasar</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="control-label tx-bold required">Tipe Akomodasi</label>
                                {!! Form::text('accommodation_type', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Contoh: Hotel Bintang 4, Homestay, Villa' ]) !!}
                            </div>
                            <div class="form-group">
                                <label class="control-label tx-bold">Bintang (Star Rating)</label>
                                {!! Form::select('star_rating', [0 => 'Pilih Rating', 1 => '1 Star', 2 => '2 Stars', 3 => '3 Stars', 4 => '4 Stars', 5 => '5 Stars'], null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                <label class="control-label tx-bold">Range Harga</label>
                                {!! Form::text('price_range', null, ['class' => 'form-control', 'placeholder' => 'Contoh: Rp 450.000 - Rp 1.200.000' ]) !!}
                            </div>
                            <div class="form-group">
                                <label class="control-label tx-bold">Fasilitas Utama</label>
                                {!! Form::textarea('facilities', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'WiFi, Kolam Renang, Sarapan, Parkir...' ]) !!}
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
                                <strong>Tips Google Maps:</strong> Klik kanan di titik peta Google Maps, lalu salin koordinatnya. Masukkan angka pertama ke Latitude dan angka kedua ke Longitude.
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
                    <button type="submit" class="btn btn-success btn-lg px-5"><i class="fa fa-save"></i> Simpan Akomodasi</button>
                    <a href="{{ url('dashboard/post-accommodation/table') }}" class="btn btn-secondary btn-lg ml-2">Batal</a>
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
