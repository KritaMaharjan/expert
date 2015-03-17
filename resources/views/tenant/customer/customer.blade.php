@extends('tenant.layouts.main')

@section('heading')
Customers
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-cog"></i> Customers</li>
@stop


@section('content')
{{--<link href="{{assets('assets/plugins/iCheck/all.css')}}" rel="stylesheet" type="text/css" />
<link href="{{assets('assets/plugins/iCheck/minimal/blue.css')}}" rel="stylesheet" type="text/css" />--}}

 <input name="postcode" id="postcode" value=""/>
            <input name="town" id="town" value=""/>

  <div class="row">
		<div class="col-md-12 mainContainer">
      
	    	<div class="box box-solid">
          <p class="align-right btn-inside">
            <a class="btn btn-primary" data-toggle="modal" data-url="#customer-modal-data" data-target="#fb-modal">
                 <i class="fa fa-plus"></i> Add new Customer
                 
            </a>
           
         </p>
         
		    <div class="box-body">
		      <table id="table-customer" class="table table-hover">
               <thead>
                   <tr>
                     <th>ID</th>
                     <th>Customer name</th>
                     <th>Email</th>
                     <th>Added Date</th>
                     <th>Action</th>
                   </tr>
               </thead>
             </table>
		    </div><!-- /.box-body -->
		  </div><!-- /.box -->
	  	</div>

        <div id="customer-modal-data" class="hide">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">Add New Customer</h3>
            </div>
            @include('tenant.customer.createCustomer')
                   </div><!-- /.box-body -->
               
        </div>
    </div>
	  	
    </div>

 <script>
$(function() {



 var cache = {};
        $("#postcode").autocomplete({
            minLength: 0,
            source: function(request, response) {
                var term = request.term;
                var token = '{{csrf_token()}}';
                if (term in cache) {
                    response(cache[ term ]);
                    return;
                }

                $.ajax({
                    url: appUrl+"postal/suggestions",
                    type: "get",
                    dataType: "json",
                    data: {'data': term,'_token':token},
                    success: function(data) {
                      console.log(data);
                        cache[ term ] = data;
                        items1 = $.map(data, function(item) {

                            return   {label: item.postcode +' , ' +item.legal_town ,
                                value: item.postcode,
                                town :item.legal_town ,
                                id: item.id}


                        });
                        response(items1);
                    }
                });
            },
             appendTo: '#customer-modal-data',
            search: function(event, ui) {
               
            },
            response: function(event, ui) {
               
            },
            create: function(event, ui) {
            },
            open: function(event, ui) {
               
            },
            focus: function(event, ui) {

            },
            _resizeMenu: function() {
                this.menu.element.outerWidth(200);
            },
            select: function(event, ui) {
                console.log(ui);
                 var label = ui.item.town;
              
                $('#town').val(label);
 

                

            }
        });

});
</script>

    {{--Load JS--}}
    {{FB::registerModal()}}
   
    {{FB::js('assets/js/customer.js')}}
       
	@stop

