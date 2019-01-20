@extends('layouts.auth')

@section('content')
                        <div class="container-scroller">
                            <div class=" page-body-wrapper full-page-wrapper">
                                <div class="content-wrapper d-flex align-items-center auth register-full-bg">
                                    <div class="row w-100">
                                        <div class="col-lg-4 mx-auto">
                                            <div class="auth-form-light text-left p-5">  <h2>{{ __('Reset Password') }}</h2>
                                                @if (session('status'))
                                                    <div class="alert alert-success" role="alert">
                                                        {{ session('status') }}
                                                    </div>
                                                @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">{{ __('Email address or Phone number') }}</label>
                            <input type="email" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            <i class="fas fa-user"></i>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="mt-5">
                            <button class="btn btn-block btn-warning btn-lg font-weight-medium" type="submit">   {{ __('Send Password Reset Link') }}</button>
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
