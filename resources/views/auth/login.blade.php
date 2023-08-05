@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-4 text-center mt-5 m-auto">
        <h4><strong class="text-danger">S</strong>ysteme <strong class="text-danger">I</strong>nformatisé de <strong class="text-danger">G</strong>estion d'<strong class="text-danger">A</strong>vancement des <strong class="text-danger">P</strong>ersonnels (SIGAP) <span class="text-danger fw-bold"></span></h4>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="mt-5">
                {{-- <div class="card-header">{{ __('Login') }}</div> --}}
                {{-- <div class="card-header"></div> --}}

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            {{-- <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label> --}}
                            {{-- <label for="email" class="col-md-4 col-form-label text-md-end">Login</label> --}}

                            <div class="input-group col-md-6">
                                <span class="input-group-text fs-4"><i class="bi bi-person-check"></i></span>
                                <input id="login" placeholder="{{ __('Login') }}" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autofocus>

                                @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            {{-- <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label> --}}

                            <div class="input-group col-md-6">
                                <span class="input-group-text fs-4"><i class="bi bi-key-fill"></i></span>
                                <input id="password" placeholder="{{ __('Password') }}" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
