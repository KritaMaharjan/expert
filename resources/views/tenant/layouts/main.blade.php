@if (!Request::ajax())
    @section('head')
        @include('tenant.layouts.partials.head')
    @show

    @section('sidebar')
        @include('tenant.layouts.partials.sidebar')
    @show
@endif


@include('tenant.layouts.partials.content')



@if (!Request::ajax())
    @section('footer')
        @include('tenant.layouts.partials.footer')
    @show
@endif
