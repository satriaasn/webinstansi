@extends('layouts.backend')
@section('title', 'Edit Destination Guide')
@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/post-destination/table') }}">Destinations</a>
            <span class="breadcrumb-item active">Edit Guide</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-30 d-flex justify-content-between align-items-center">
                <h4 class="m-0"><i class="fa fa-map-marker text-primary"></i> Travel Guide: <span class="text-muted">{{ $post->title }}</span></h4>
                <div class="card-options">
                    <a href="{{ url('dashboard/post-destination/table') }}" class="btn btn-outline-secondary btn-sm"><i class="fa fa-reply"></i> Kembali</a>
                </div>
            </div>
            
            <div class="ht-60 bg-gray-100 pd-x-20 d-flex align-items-center justify-content-center shadow-base">
                <ul class="nav nav-outline active-primary align-items-center flex-column flex-md-row" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#destinasi" role="tab"><i class="fa fa-info-circle"></i> Info Destinasi</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#related" role="tab"><i class="fa fa-link"></i> Konten Terkait (TripAdvisor)</a></li>
                </ul>
            </div>

            {!! Form::model($destination, [
                'method' => 'PATCH',
                'url' => ['/dashboard/post-destination', Hashids::encode($post->id)],
                'class' => 'mg-t-20'
            ]) !!}

            <div class="tab-content br-profile-body">
                {{-- TAB 1: DESTINASI --}}
                <div class="tab-pane fade show active" id="destinasi">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card pd-20 pd-xs-30 shadow-base bd-0">
                                <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-20">Informasi Lokasi Utama</h6>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="tx-bold required">Kota / Kabupaten</label>
                                        {!! Form::text('city', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Contoh: Pesawaran' ]) !!}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="tx-bold">Provinsi</label>
                                        {!! Form::text('region', null, ['class' => 'form-control', 'placeholder' => 'Lampung' ]) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="tx-bold required">Alamat Lengkap</label>
                                    {!! Form::textarea('address', null, ['class' => 'form-control', 'rows' => 2, 'required' => 'required']) !!}
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="tx-bold">Jam Operasional</label>
                                    {!! Form::text('opening_hours', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label class="tx-bold">Harga Tiket Masuk</label>
                                    {!! Form::text('ticket_price', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label class="tx-bold">Kontak / WhatsApp</label>
                                    {!! Form::text('contact_info', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="card pd-20 shadow-base bd-0 bg-gray-100">
                                <h6 class="tx-uppercase tx-bold tx-13 mg-b-15">Titik Koordinat Utama</h6>
                                <div class="form-group">
                                    <label class="tx-11 tx-bold tx-uppercase">Latitude</label>
                                    {!! Form::text('latitude', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label class="tx-11 tx-bold tx-uppercase">Longitude</label>
                                    {!! Form::text('longitude', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="alert alert-info tx-11 mb-0">
                                    <strong>Tips:</strong> Masukkan koordinat pusat destinasi wisata ini.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB: KONTEN TERKAIT --}}
                <div class="tab-pane fade" id="related">
                    <div class="card pd-20 pd-xs-30 shadow-base bd-0">
                        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-20"><i class="fa fa-link"></i> Pembagian Konten (Bidirectional Linking)</h6>
                        <div class="alert alert-info tx-13 mb-4">
                            <strong>Multi-select Universal:</strong> Anda dapat memilih beberapa konten dari berbagai kategori (Akomodasi, Kuliner, Transportasi, atau Destinasi lain). Data yang dipilih di sini akan otomatis saling terhubung satu sama lain.
                        </div>
                        <div class="form-group">
                            <label class="tx-bold">Pilih Konten Terkait:</label>
                            {!! Form::select('related_posts[]', $all_related_options, $related_ids, ['class' => 'form-control select2', 'multiple' => 'multiple', 'style' => 'width:100%']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mg-t-30">
                <div class="col-md-12 text-center">
                    <hr/>
                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-base"><i class="fa fa-save"></i> Simpan Hubungan Destinasi</button>
                    <a href="{{ url('dashboard/post-destination/table') }}" class="btn btn-secondary btn-lg ml-2">Batal</a>
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
            placeholder: '--- Pilih Item ---',
            allowClear: true
        });
    });
</script>
@endpush
