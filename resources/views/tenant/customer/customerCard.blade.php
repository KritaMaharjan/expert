{{--Load JS--}}
{{FB::registerModal()}}
{{FB::js('assets/js/customer.js')}}

@extends('tenant.layouts.main')

@section('heading')
Customers
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-cog"></i> Customers</li>
    <li><i class="fa fa-cog"></i> Customer Card</li>
@stop


@section('content')

        <div class="row">  
            <div class="col-md-4">
              <!-- general form elements -->
              <div class="box box-solid">
                <div class="box-header">
                  <h3 class="box-title">Customer Card</h3>
                  <div class="icon-block">
                    <a href="javascript:;" data-toggle="modal" data-url="{{tenant()->url('customer/edit/'.$customer['id'])}}" data-target="#fb-modal" title="Edit"><i class="fa fa-edit"></i></a>
                    <a href="{{ URL::route('customer.delete', $customer->id) }}" onclick="return confirm('Do you really want to delete customer?')" title="Delete"><i class="fa fa-trash-o"></i></a>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="customer-info">
                    <p><strong>{{$customer['name']}}</strong></p>
                    <p><strong>{{$customer->dob}}</strong></p>
                    <p class="customer-address">
                      <strong>{{$customer->street_name}}  {{$customer->street_number}}</strong><br />
                      <strong>{{$customer->postcode}} {{$customer->town}}</strong><br />
                      <strong></strong>
                    </p>
                    <p><strong>{{$customer->telephone}}</strong> <small>(Telephone)</small><br />
                       <strong>{{$customer->mobile}}</strong> <small>(Mobile)</small>
                    </p>
                   <a href="#" data-toggle="modal" data-target="#compose-modal">{{$customer->email}}</a>

                    <div class="form-group radio-box">
                      <label>
                        <input type="radio" name="r1" class="minimal minimal_status" <?php if($customer->status == 1) echo 'checked=checked '; ?> /> Active
                      </label>
                      <label>
                        <input type="radio" name="r1" class="minimal minimal_status" <?php if($customer->status == 0) echo 'checked=checked '; ?> /> Inactive
                      </label>
                      
                    </div>



                  </div>


                </div>

              </div><!-- /.box -->
             
            </div>
            <div class="col-md-6">
             <div class="box box-solid">
                <div class="box-header">
                  <h3 class="box-title">Invoices/Offers</h3>
                  <div class="btn-top-ryt">
                    <a href="#" class="btn btn-primary btn-block btn-flat">New Offer
                    </a>
                    <a href="#" class="btn btn-primary btn-block btn-flat">New Bill
                    </a>
                  </div>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12 col-sm-12">                 
                        <div class="table-responsive">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Sum</th>
                                <th>Due date</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td><a href="#" class="link">14105</a></td>
                                <td>1600,-</td>
                                <td>15-01-14</td>
                                <td>Collection</td>
                              </tr>
                              <tr>
                                <td><a href="#" class="link2">14106</a></td>
                                <td>499,-</td>
                                <td>31-02-14</td>
                                <td>Overdue</td>
                              </tr>
                              <tr>
                                <td><a href="#" class="link">14108</a></td>
                                <td>458.87</td>
                                <td>15-03-14</td>
                                <td>Paid</td>
                              </tr>
                              <tr>
                                <td><a href="#" class="link2">14109</a></td>
                                <td>455</td>
                                <td>15-03-14</td>
                                <td>Unpaid</td>
                              </tr>
                              <tr>
                                <td><a href="#" class="link">14250</a></td>
                                <td>399</td>
                                <td>15-03-14</td>
                                <td>Offer</td>
                              </tr>
                            </tbody>
                          </table>
                          <div class="total-block">
                            <span>Total Offers: <strong>399</strong></span>
                            <span>Total Bills: <strong>3012.47</strong></span>
                          </div>
                        </div><!-- /.col -->
                    </div>
                  </div>
                  
                </div>

            </div>
             
             
          </div>
          </div> 

          <div class="row">
            <div class="col-md-10">
              <div class="mail-wrap-section clearfix">
                <div class="col-md-5 bg-white">
                  <div class="box box-solid">
                    <div class="box-header">
                      <h3 class="box-title">Customers message</h3>                  
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <div class="row mailbox">
                        <div class="col-md-12 col-sm-12">
                            <div class="row pad pad-top-0">
                              
                              <div class="col-sm-12 search-form pad-5">
                                <form class="text-right" action="#">
                                  <div class="input-group">
                                    <input type="text" placeholder="Search" class="form-control input-sm">
                                    <div class="input-group-btn">
                                      <button class="btn btn-sm btn-primary" name="q" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div><!-- /.row -->

                            <div class="table-responsive">
                              <!-- THE MESSAGES -->
                              <table class="table table-mailbox">
                                <tbody><tr class="unread">
                                  <td class="small-col"><div class="icheckbox_minimal-blue" style="position: relative;" aria-checked="false" aria-disabled="false"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div></td>
                                  <td class="small-col"><i class="fa fa-envelope"></i></td>
                                  <td class="name">
                                    <a href="#">John Doe
                                      <small class="subject">Aspergers syn...</small>
                                    </a>
                                  </td>
                                  <td class="time">12:30 PM</td>
                                </tr>
                                <tr>
                                  <td class="small-col"><div class="icheckbox_minimal-blue" style="position: relative;" aria-checked="false" aria-disabled="false"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div></td>
                                  <td class="small-col"><i class="fa fa-location-arrow"></i></td>
                                  <td class="name"><a href="#">Ron Johnson
                                    <small class="subject">Welcome to...</small>
                                    </a>
                                  </td>
                                  <td class="time">15-12-14</td>
                                </tr>
                                <tr>
                                  <td class="small-col"><div class="icheckbox_minimal-blue" style="position: relative;" aria-checked="false" aria-disabled="false"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div></td>
                                  <td class="small-col"><i class="fa fa-reply"></i></td>
                                  <td class="name"><a href="#">John Doe</a>
                                  <small class="subject"><strong>RE:</strong> Urgent! Please read</small>
                                  </td>
                                  <td class="time">15-12-14</td>
                                </tr>
                                
                              </tbody></table>
                            </div><!-- /.table-responsive -->
                          </div><!-- /.col (RIGHT) -->
                    </div>


                  </div><!-- /.box -->
                </div><!-- bg-white -->
                </div>
                <div class="col-md-7 bg-white">
                  <div class="box box-solid">
                    <div class="box-header block-header">
                      <h3 class="box-title"><strong>Aspergers syn...</strong>
                      </h3>
                      <p><small class="color-blue">Sent: </small> Mon 3/2/2015 3:52 AM</p>
                      <p><small class="color-blue">To: </small> John@abc.com</p>
                      <hr>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <p>Hello John,<br>
                          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum egestas pellentesque quam, lobortis ultrices felis. Praesent venenatis vulputate leo. Donec efficitur libero vel lectus finibus sollicitudin. Pellentesque pharetra eleifend viverra. Nulla in volutpat turpis. Ut dolor tellus, aliquam ut tristique id, suscipit quis libero. In tristique id lacus vel ornare. Quisque mauris leo, hendrerit ultrices dolor ac, suscipit tristique nunc. 


                    </p></div>


                  </div><!-- /.box -->
                </div><!-- bg-white -->

              </div>
              
            </div>
            <div id="customer-modal-data" class="hide">
      <div class="box box-solid">
          <div class="box-header">
              <h3 class="box-title">Update Customer</h3>
          </div>
          <div class="">
           
          </div>
      </div>
    </div>
 

          </div>

          <script type="text/javascript">
          
          $( ".minimal_status" ).click(function() {
            
            if($('.minimal_status').is(':checked')){
              $('.minimal_status').attr('disabled', 'disabled');
              $(this).removeAttr('disabled');

            }

        });

          </script>
@stop