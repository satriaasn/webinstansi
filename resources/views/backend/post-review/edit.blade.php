@extends('layouts.backend')
@section('title', 'Moderation Review')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/post-review/table') }}">Reviews</a>
            <span class="breadcrumb-item active">Moderation</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/post-review/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
                            class="fa fa-reply"></i> Back</a>
                </div>
            </div>

            <h4>Ulasan untuk: {{ $review->post->title }}</h4>
            <hr/>

            <div class="alert alert-info">
                <strong>Pengulas:</strong> {{ $review->guest_name }} <br>
                <strong>Email:</strong> {{ $review->guest_email ?? 'Tidak ada' }} <br>
                <strong>Tanggal:</strong> {{ $review->created_at }}
            </div>

            {!! Form::model($review, [
                'method' => 'PATCH',
                'url' => ['/dashboard/post-review', Hashids::encode($review->id)],
                'class' => 'form-horizontal'
            ]) !!}
            
            <div class="row">
                <div class="col-md-2 form-group">
                    {!! Form::label('rating', 'Rating Bintang', ['class' => 'control-label required']) !!}
                    {!! Form::number('rating', null, ['class' => 'form-control', 'required' => 'required', 'min' => 1, 'max' => 5 ]) !!}
                </div>
                <div class="col-md-3 form-group">
                    {!! Form::label('status', 'Status Persetujuan', ['class' => 'control-label required']) !!}
                    {!! Form::select('status', ['pending' => 'Pending', 'approved' => 'Approved (Tayang)', 'spam' => 'Spam'], null, ['class' => 'form-control', 'required' => 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('comment', 'Komentar Ulasan', ['class' => 'control-label required']) !!}
                {!! Form::textarea('comment', null, ['class' => 'form-control', 'rows' => 5, 'required' => 'required' ]) !!}
            </div>

            <div class="row form-group">
                <div class="col-md-12">
                    <hr/>
                    {!! Form::submit('Simpan Perubahan', ['class' => 'btn btn-success pull-right']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
