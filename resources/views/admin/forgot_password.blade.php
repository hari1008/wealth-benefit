@extends('layouts.app')
<!-- Main Content -->
@section('content')
<div class="login-outer">
    <div class="login_form">
        <div class="login-panel">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                        {{Session::forget('status')}}
                    </div>
                    @endif 
                    @if(Session::has('success'))
                    <div class="alert alert-success text-left">
                        <ul>
                            <li>
                                {{Session::get('success')}}
                                {{Session::forget('success')}}
                            </li>
                        </ul>
                    </div>
                    @endif 
                    @if(Session::has('error'))
                    <div class="alert alert-danger text-left">
                        <ul>
                            <li>{{Session::get('error')}}</li>
                            {{Session::forget('error')}}
                        </ul>
                    </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{url('forgot-password')}}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-default btn-login">
                                    Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
