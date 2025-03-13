@extends('layouts.app')

@section('content')
<style>
    body{
        background-color: #F5EFE7;
    }
</style>
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 93vh;">
        <!-- デザイン部分 -->
        <div class="col-md-6 d-flex flex-column align-items-center justify-content-center text-center" style="background-color: #F5EFE7; padding: 2rem;">
            <h1 class="mb-3">Welcome back!</h1>
            <img src="{{ asset('images/noted.png') }}" alt="Noted" class="img-fluid mb-3" style="max-width: 60%;">
            <img src="{{ asset('images/About-Our-Team-1--Streamline-Free-Illustrations.svg.png') }}" alt="Team" class="img-fluid" style="max-width: 80%;">
        </div>

        <!-- フォーム部分 -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">{{ __('Login to Your Account') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn text-white w-50" style="background-color:  #3E5879;">
                                {{ __('Login') }}
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
