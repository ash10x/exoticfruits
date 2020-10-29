@extends('layouts.auth')
@php

    $logo=asset(Storage::url('uploads/logo/'));
@endphp
@section('page-title')
    {{__('Forgot Password')}}
@endsection
@section('content')
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand">
                        <img class="img-fluid logo-img" src="{{$logo.'/logo.png'}} " alt="">
                    </div>
                    <div class="card card-primary">
                        <div class="card-header"><h4>{{__('Reset Password')}}</h4></div>
                        <div class="card-body">
                            {{Form::open(array('route'=>'password.update','method'=>'post','id'=>'loginForm'))}}
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group">
                                {{Form::label('email',__('Email Address'))}}
                                {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter Your Email')))}}
                                @error('email')
                                <span class="invalid-email text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                {{Form::label('password',__('Password'))}}
                                {{Form::password('password',array('class'=>'form-control','placeholder'=>__('Enter Your Password')))}}
                                @error('password')
                                <span class="invalid-password text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                {{Form::label('password_confirmation',__('Confirm Password'))}}
                                {{Form::password('password_confirmation',array('class'=>'form-control','placeholder'=>__('Enter Your Password')))}}
                                @error('password_confirmation')
                                <span class="invalid-password_confirmation text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group mb-0 text-center">
                                {{Form::submit(__('Reset Password'),array('class'=>'btn btn-primary btn-block','id'=>'resetBtn'))}}
                            </div>
                            {{Form::close()}}
                        </div>
                    </div>
                    <div class="simple-footer">
                        {{(Utility::getValByName('footer_text')) ? Utility::getValByName('footer_text') :  __('Copyright AccountGo') }} {{ date('Y') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
