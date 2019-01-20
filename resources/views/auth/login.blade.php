@extends('layouts.auth')

@section('content')
<div class="container-scroller">
    <div class=" page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth login-full-bg">
            <div class="row w-100">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-dark text-left p-5">
                        <h2>Login</h2>
                        <form class="pt-5" method="POST" action="{{ route('login') }}">
                            @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                    <i class="fas fa-user"></i>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                    <i class="fas fa-key"></i>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="mt-5">
                                    <button class="btn btn-block btn-warning btn-lg font-weight-medium" type="submit">Login</button>
                                </div>
                                <div class="mt-3 text-center">
                                    @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="auth-link text-white">Forgot password?</a>
                                        @endif
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
@endsection
