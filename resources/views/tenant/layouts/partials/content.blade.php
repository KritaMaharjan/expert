    <section class="content-header">
       <h1> @yield('heading')</h1>
        <ol class="breadcrumb">
              @section('breadcrumb')
                  <li><a href="{{ tenant_route('tenant.index')}}" data-push="true"><i class="fa fa-dashboard"></i> @lang('menu.dashboard') </a></li>
              @show
        </ol>
    </section>

    <section class="content clearfix">
        <div class="col-lg-12">
            <div class="row">
                  @if(Session::has('message'))
                      <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                  @endif  
                  
                  @yield('content')
            </div>
         </div>
    </section>
