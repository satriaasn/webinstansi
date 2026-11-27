@extends('layouts.backend')
@section('title', 'Edit Struktur Organisasi')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/struktur-organisasi/table') }}">Struktur Organisasi</a>
            <span class="breadcrumb-item active">Edit</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-20">
                <a href="{{ url('dashboard/struktur-organisasi/table') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-reply"></i> Back
                </a>
            </div>

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form action="{{ url('dashboard/struktur-organisasi/' . Hashids::encode($item->id)) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                @include('backend.struktur-organisasi._form', ['submitLabel' => 'Update'])
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>$(function () { $('.select2').select2(); });</script>
@endpush
