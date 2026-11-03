@extends('layouts.backend')
@section('title', ($item ? 'Edit ' : 'Tambah ') . $module['title'])

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/dishub/' . $module['slug'] . '/table') }}">{{ $module['title'] }}</a>
            <span class="breadcrumb-item active">{{ $item ? 'Edit' : 'Tambah' }}</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="mg-b-40">
                <div class="card-options">
                    <a href="{{ url('dashboard/dishub/' . $module['slug'] . '/table') }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-reply"></i> Back
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form action="{{ $action }}" method="post" class="form-horizontal">
                @csrf
                @if($method !== 'POST')
                    @method($method)
                @endif

                @foreach($module['fields'] as $field)
                    <div class="row form-group">
                        <label class="col-md-12 control-label">{{ $field['label'] }}</label>
                        <div class="col-md-12">
                            @php
                                $value = old($field['name'], $item->{$field['name']} ?? '');
                            @endphp

                            @if($field['type'] === 'textarea')
                                <textarea name="{{ $field['name'] }}" class="form-control" rows="4" {{ !empty($field['required']) ? 'required' : '' }}>{{ $value }}</textarea>
                            @elseif($field['type'] === 'select')
                                <select name="{{ $field['name'] }}" class="form-control select2" {{ !empty($field['required']) ? 'required' : '' }}>
                                    <option value="">Pilih {{ $field['label'] }}</option>
                                    @foreach($field['options'] as $optionValue => $optionLabel)
                                        <option value="{{ $optionValue }}" {{ (string) $value === (string) $optionValue ? 'selected' : '' }}>
                                            {{ $optionLabel }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <input
                                    type="{{ in_array($field['type'], ['number', 'date'], true) ? $field['type'] : 'text' }}"
                                    name="{{ $field['name'] }}"
                                    class="form-control"
                                    value="{{ $field['type'] === 'date' && !empty($value) ? \Illuminate\Support\Carbon::parse($value)->format('Y-m-d') : $value }}"
                                    {{ !empty($field['required']) ? 'required' : '' }}
                                >
                            @endif
                            @if(!empty($field['help']))
                                <small class="text-muted d-block mt-2">{{ $field['help'] }}</small>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="row form-group">
                    <div class="col-md-12">
                        <hr/>
                        <button type="submit" class="btn btn-success pull-right">{{ $item ? 'Update' : 'Create' }}</button>
                    </div>
                </div>
            </form>
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
