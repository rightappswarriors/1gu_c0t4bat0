@extends('layout._auth')

@section('content')
	<div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>{{strtoupper('Guihulngan')}}</b></a>
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
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    {{-- @if($errors->has('txt_uname'))
                    <span class="help-block">{{$errors->first('txt_uname')}}</span>
                    @endif --}}
                </div>
                <div class="form-group has-feedback @if($errors->has('txt_pass')) has-error @endif">
                    <input type="password" class="form-control" name="txt_pass" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    {{-- @if($errors->has('txt_pass'))
                    <span class="help-block">{{$errors->first('txt_pass')}}</span>
                    @endif --}}
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection