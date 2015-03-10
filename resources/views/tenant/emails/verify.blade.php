@extends('tenant.layouts.min')

@section('content')

<h2>Verify Your Email Address</h2>

<div>
    Thanks for creating an account with <strong>FastBooks</strong>.
    Please follow the link below to verify your email address
    {{ URL::to('tenant/register/verify/' . $activation_key) }}.<br/>

</div>

@endsection
