@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">
        <div class="login-wrapper wd-300 wd-xs-400 pd-25 pd-xs-40 bg-white rounded shadow-base">
            <div class="signin-logo tx-center tx-28 tx-bold tx-inverse">
                <img src="{{ berkas( getSetting('logo')) }}" width="200">
            </div>
            <div class="tx-center mg-b-60">Forgot Password</div>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email" value="{{ old('email') }}" required placeholder="Enter your email">
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-info btn-block">Send Password Reset Link</button>
            </form>
            <div class="mg-t-60 tx-center">&copy; 2018. {{ getSetting('web_owner') }}. All Rights Reserved</div>
        </div>
    </div>
@endsection
