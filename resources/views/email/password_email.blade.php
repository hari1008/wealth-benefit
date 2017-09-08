@extends('email.email-template')
@section('body')
    <div class="text-center">
        <h3 style="margin:0 0 25px 0;">Hello,</h3>
    </div>
    <p>Congratulations!!! Your profile has been created successfully as subadmin.</p>
<p>Your Password is : {{$password}} </p>
@endsection
