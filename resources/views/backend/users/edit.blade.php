@extends('layouts.backend')
@section('title', 'Edit Users')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/users') }}">Users</a>
            <span class="breadcrumb-item active">Edit Users</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/users/table') }}" class="btn btn-secondary btn-sm" title="Back"><i
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

            {!! Form::model($user, [
                'method' => 'PATCH',
                'url' => ['/dashboard/users', Hashids::encode($user->id)],
                'enctype' => 'multipart/form-data',
                'class' => 'form-horizontal'
            ]) !!}

            @include ('backend.users.form', ['formMode' => 'edit'])

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
