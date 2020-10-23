@extends('layout._auth')

@section('content')
{{--    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>{{strtoupper('Sean Agro')}}</b></a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Please Sign in</p>

            <form action="{{url('/login')}}" method="post">
                {{csrf_field()}}
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible " id="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <label><b><i class="icon fa fa-ban"></i></b> {{$errors->first()}}</label>
                </div>
                @endif
                
                <div class="form-group has-feedback @if($errors->has('txt_uname')) has-error @endif">
                    <input type="text" class="form-control" name="txt_uname" placeholder="Username" style="text-transform: uppercase;">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span> --}}
                    {{-- @if($errors->has('txt_uname'))
                    <span class="help-block">{{$errors->first('txt_uname')}}</span>
                    @endif --}}{{-- 
                </div>
                <div class="form-group has-feedback @if($errors->has('txt_pass')) has-error @endif">
                    <input type="password" class="form-control" name="txt_pass" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span> --}}
                    {{-- @if($errors->has('txt_pass'))
                    <span class="help-block">{{$errors->first('txt_pass')}}</span>
                    @endif --}}
{{--                 </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                </div>
            </form>

        </div>
    </div> --}}

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form action="{{url('/login')}}" method="post" class="login100-form validate-form">
                    {{csrf_field()}}
                    {{-- @foreach ($errors->all() as $error)

                    <div class="alert alert-danger alert-dismissible " id="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <label><b><i class="icon fa fa-ban"></i></b>{{ $error }}</label>
                    </div>

                    @endforeach --}}

                    <div class="w-full text-center p-t-27 p-b-70">
                        <img src="{{url('images/guihulngan.png')}}" class="img-circle" alt="logo">
                    </div>
                    
                    <span class="login100-form-title p-b-20" style="margin-top: -8%;">
                       <strong>Account Login</strong>
                    </span>
                    <div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="Type user name">
                        <input id="first-name" style="text-transform: uppercase;" class="input100" type="text" name="txt_uname"  placeholder="User name">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="Type password">
                        <input class="input100" type="password" name="txt_pass" placeholder="PASSWORD">
                        <span class="focus-input100"></span>
                    </div>
                    
                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Sign in
                        </button>
                    </div>

                    <div class="w-full text-center p-t-27 p-b-70">
                        <span class="txt1">
                            Forgot
                        </span>

                        <a href="#" class="txt2">
                            User name / password?
                        </a>
                    </div>

                    {{-- <div class="w-full text-center">
                        <a href="#" class="txt3">
                            Sign Up
                        </a>
                    </div> --}}
                </form>

                <div class="login100-more" style="background-image: url('images/acc.png');"></div>
            </div>
        </div>
    </div>  


@endsection