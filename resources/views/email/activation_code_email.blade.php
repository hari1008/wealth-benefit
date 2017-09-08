@extends('email.email-template')
@section('body')
    <div class="text-center">
        <h3 style="margin:0 0 25px 0;">Hello {{$username}},</h3>
    </div>
    <p>Your Activation code is : {{$activation_code}} </p>
@endsection
