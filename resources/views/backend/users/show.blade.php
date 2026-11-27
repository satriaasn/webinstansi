@extends('layouts.backend')
@section('title', 'View User')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ url('dashboard/users/table') }}">Users</a>
            <span class="breadcrumb-item active">Preview User</span>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            @include('backend.partials.preview_layout', [
                'title' => $user->name,
                'subtitle' => '@' . $user->username,
                'active' => $user->active,
                'badgeText' => 'Akun Pengguna',
                'backUrl' => url('dashboard/users/table'),
                'editUrl' => url('dashboard/users/' . Hashids::encode($user->id) . '/edit'),
                'image' => $user->picture,
                'fields' => [
                    ['label' => 'Username', 'value' => $user->username, 'code' => true],
                    ['label' => 'Nama Lengkap', 'value' => $user->name],
                    ['label' => 'Email', 'value' => $user->email],
                ],
            ])
        </div>
    </div>
@endsection
