@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">
        <div class="login-wrapper wd-300 wd-xs-400 pd-25 pd-xs-40 bg-white rounded shadow-base">
            <div class="signin-logo tx-center tx-28 tx-bold tx-inverse">
                <img src="{{ berkas( getSetting('logo')) }}" width="200">
            </div>
            <div class="tx-center mg-b-60">Verify Your Email Address</div>
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    A fresh verification link has been sent to your email address.
                </div>
            @endif
            <div class="alert alert-info" role="alert">
                Before proceeding, please check your email for a verification link.<br/>
                If you did not receive the email, <a href="{{ route('verification.resend') }}">click here to request
                    another.</a>
            </div>
            <div class="mg-t-60 tx-center">&copy; 2018. {{ getSetting('web_owner') }}. All Rights Reserved</div>
        </div>
    </div>
@endsection
