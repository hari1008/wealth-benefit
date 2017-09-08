@extends('email.email-template')
@section('body')
    <div class="text-center">
        <h3 style="margin:0 0 25px 0;">Dear {{$fullName}},</h3>
    </div>
    Your profile to become an Expert has been rejected by {{$orgName}} Admin.Please apply for this later.
@endsection
