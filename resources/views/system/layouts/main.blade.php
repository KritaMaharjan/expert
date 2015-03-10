@if (!Request::ajax())
    @section('head')
        @include('system.layouts.partials.head')
    @show

    @section('sidebar')
        @include('system.layouts.partials.sidebar')
    @show
@endif

@include('system.layouts.partials.content')

@if (!Request::ajax())

    @section('footer')
        @include('system.layouts.partials.footer')
    @show
@endif


