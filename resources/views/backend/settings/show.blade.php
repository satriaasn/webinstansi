@extends('layouts.backend')
@section('title', 'View Settings')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/settings/table') }}">Settings</a>
            <span class="breadcrumb-item active">Preview Settings</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            @php
                $isMediaSetting = in_array($setting->key, ['logo', 'favicon']);
            @endphp
            @include('backend.partials.preview_layout', [
                'title' => strtoupper(str_replace('_', ' ', $setting->key)),
                'subtitle' => "Helper: getSetting('{$setting->key}')",
                'badgeText' => 'Pengaturan Sistem',
                'backUrl' => url('dashboard/settings/table'),
                'editUrl' => url('dashboard/settings/' . Hashids::encode($setting->id) . '/edit'),
                'image' => $isMediaSetting ? $setting->value : null,
                'fields' => [
                    ['label' => 'Key', 'value' => $setting->key, 'code' => true],
                    ['label' => 'Value', 'value' => $setting->value, 'full' => !$isMediaSetting],
                    ['label' => 'Usage', 'value' => "setting('{$setting->key}')", 'code' => true],
                ],
            ])
        </div>
    </div>
@endsection
