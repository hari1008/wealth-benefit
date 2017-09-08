@extends('email.email-template')
@section('body')
    <div class="text-center">
        <h3 style="margin:0 0 25px 0;">Hello {{explode("@",$email)[0]}},</h3>
    </div>
    <p>Welcome to Benefit Wellness, please click on the link below to verify you email address.</p>
    <p><a href="{{ url('verify-email?token='.$token.'&email='.$email) }}">Verify Email</a><p>
    <p>Regards,</p>
    <p>Benefit Team</p>
@endsection
