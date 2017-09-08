@extends('layouts.app')
@section('content')
<div class="login-outer">
    <div class="login_form">
        <div class="login-panel">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">Login </div>
                <div class="panel-body">
                    @if ( count( $errors ) > 0 )
                    <div class="alert alert-danger text-left">
                        @foreach ($errors->all() as $error)
                           <div>{{ $error }}</div>
                       @endforeach
                    </div>   
                     @endif
                   
                    @if(Session::has('success_msg'))
                    <div class="alert alert-success text-left">
                        <ul>
                            <li>
                                {{ Session::get('success_msg')  }}
                                {{ Session::forget('success_msg') }}
                            </li>
                        </ul>
                    </div>
                    @endif 
                    
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-sm-12 input-div">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter your email">
                                
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-sm-12 input-div">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Enter your password">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-default btn-login">Login</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <a class="blue" href="{{ url('/forgot-password') }}">Forgot Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
