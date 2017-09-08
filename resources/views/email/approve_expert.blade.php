@extends('email.email-template')
@section('body')
    <div class="text-center">
        <h3 style="margin:0 0 25px 0;">Dear {{$fullName}},</h3>
    </div>
    Congratulations!!! Your profile has been updated to Expert.
@endsection
