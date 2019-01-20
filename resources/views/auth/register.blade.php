@extends('layouts.auth')

@section('content')
    <div class="container-scroller">
        <div class=" page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth register-full-bg">
                <div class="row w-100">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <h2>{{ __('Register') }}</h2>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ __('Company name') }}</label>
                            <input type="text" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                            <i class="fas fa-user"></i>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('Email Address') }}</label>
                            <input type="email" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            <i class="fas fa-envelope-open"></i>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="phone">{{ __('Phone number') }}</label>
                            <input type="phone" id="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required>
                            <i class="fas fa-phone"></i>
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="state">{{ __('State') }}</label>
                                <select name="state" id="state" class="form-control">
                                    <option value="1" selected>Lagos</option>
                                    <option value="2">Rivers</option>
                                </select>
                                @if ($errors->has('state'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-sm-6">
                                <label for="city">{{ __('City') }}</label>
                                <select name="city" id="city" class="form-control">
                                    <option value="1" selected>Oshodi</option>
                                    <option value="2">Obiapkor</option>
                                </select>
                                @if ($errors->has('city'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="address">{{ __('Address') }}</label>
                            <input type="text" id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" required>
                            @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input type="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                            <i class="fas fa-key"></i>
                        @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required>
                            <i class="fas fa-key"></i>
                        </div>


                        <div class="mt-5">
                            <button class="btn btn-block btn-warning btn-lg font-weight-medium" type="submit">  {{ __('Register') }}</button>
                        </div>
                        <div class="mt-2 text-center">
                            <a href="{{url('login')}}" class="auth-link text-black">Already have an account? <span class="font-weight-medium">Sign in</span></a>
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
