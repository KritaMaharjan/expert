@extends('tenant.layouts.main')

@section('heading')
System Settings
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-cog"></i> Setting</li>
    <li><i class="fa fa-cog"></i> System</li>
@stop

@section('content')
<div class="box box-solid">
	<div class="row">
        <div class="col-md-6">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom no-shadow">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#business" data-toggle="tab">Your Business</a></li>
              <li><a href="#fix-it" data-toggle="tab">Fix It Now</a></li>
              <li><a href="#vacation" data-toggle="tab">Vacation</a></li>
              <li><a href="#global" data-toggle="tab">Global Setting</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="business">
              	@include('tenant.setting.businessForm')

              </div><!-- /.tab-pane -->
              <div class="tab-pane" id="fix-it">
              	@include('tenant.setting.fixForm')

              </div><!-- /.tab-pane -->

               <div class="tab-pane" id="vacation">
                @include('tenant.setting.vacation')

              </div><!-- /.tab-pane -->

              <div class="tab-pane" id="global">
                @include('tenant.setting.global')

              </div><!-- /.tab-pane -->

            </div><!-- /.tab-content -->
          </div><!-- nav-tabs-custom -->
        </div><!-- /.col -->
    </div>

</div>
@stop
