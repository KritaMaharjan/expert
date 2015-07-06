@section('head')
    @include('tenant.layouts.partials.min.head')
    @include('tenant.layouts.partials.min.header')
@show

@yield('content')

@section('footer')
    @include('tenant.layouts.partials.min.footer')
@show
