@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">
        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base">
            <div class="signin-logo tx-center tx-28 tx-bold tx-inverse">
                <img src="{{ berkas( getSetting('logo')) }}" width="200">
            </div>
            <div class="tx-center mg-b-60">Login to {{ getSetting('web_name') }}</div>
            @if(session('errorLogin'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alertSession">
                    {{ session('errorLogin') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                           value="{{ old('email') }}" required autofocus placeholder="Enter your email">
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                           name="password" required placeholder="Enter your password">
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
                    @endif
{{--                    <a href="{{ route('password.request') }}" class="tx-info tx-12 d-block mg-t-10">Forgot password?</a>--}}
                </div>
                <button type="submit" class="btn btn-info btn-block">Sign In</button>
            </form>
            <div class="mg-t-60 tx-center">&copy; 2018. {{ getSetting('web_owner') }}. All Rights Reserved</div>
        </div>
    </div>
@endsection
