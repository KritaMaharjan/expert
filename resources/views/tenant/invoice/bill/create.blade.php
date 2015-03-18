@extends('tenant.layouts.main')

@section('heading') Create Bill @stop

@section('breadcrumb')
    @parent
    <li><a data-push="true" href="{{tenant_route('tenant.invoice.index')}}"><i class="fa fa-cog"></i> Invoice</a></li>
    <li><i class="fa fa-money"></i> Bill</li>
@stop

@section('content')

<!-- Main content -->
<section class="invoice">
  <!-- title row -->
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header">
        FastBooks
        <small class="pull-right">Date: 3/6/2015</small>
      </h2>
    </div><!-- /.col -->
  </div>
  <!-- info row -->
  <div class="row invoice-info">

    <div class="col-sm-5 invoice-col col-xs-6">
      <form>
        <div class="form-group clearfix">
          <label>Bill no.</label>
          <input type="text" class="form-control" />
        </div>
        <div class="form-group clearfix">
          <label>Select customer</label>
          <select class="select-single form-control">
            <option>a</option>
            <option>b</option>
            <option>c</option>
          </select>
          <p class="align-right mg-adj">
            <a href="#">Add customer</a>
        </p>
        </div>
      </form>

      <address>
        <strong>John Doe</strong><br>
        795 Folsom Ave, Suite 600<br>
        San Francisco, CA 94107<br>
        Phone: (555) 539-1037<br/>
        Email: john.doe@example.com
      </address>
    </div><!-- /.col -->
     <div class="col-sm-7 invoice-col col-xs-6">
      <address class="address-info">
        <strong>FastBooks</strong><br>
        795 Folsom Ave, Suite 600<br>
        Norway, CA 94107<br>
        Phone: (804) 123-5432<br/>
        Email: info@fastbooks.com
      </address>

      <form class="right-from">
        <div class="form-group clearfix">
          <label>Invoice date</label>
          <input type="text" class="form-control" />
        </div>
        <div class="form-group clearfix">
          <label>Invoice number</label>
          <input type="text" class="form-control" />
        </div>
        <div class="form-group clearfix">
          <label>Kid</label>
          <input type="text" class="form-control" />
        </div>
        <div class="form-group clearfix">
          <label>Customer id</label>
          <input type="text" class="form-control" />
        </div>
        <div class="form-group clearfix">
          <label>Due date</label>
          <input type="text" class="form-control" />
        </div>
        <div class="form-group clearfix">
          <label>Account no.</label>
          <input type="text" class="form-control" />
        </div>
      </form>

    </div><!-- /.col -->
  </div><!-- /.row -->



  <!-- Table row -->
  <div class="row">
    <div class="col-xs-12 table-responsive pad-0-40">
      <table class="table table-striped invoice-table">
        <thead>
          <tr>
            <th width="40%">Product name</th>
            <th width="10%">Quantity</th>
            <th width="15%">Price</th>
            <th width="10%">VAT %</th>
            <th width="10%">Currency</th>
            <th width="15%">Total</th>
          </tr>
        </thead>
        <tbody>
          <tr class="position-r">
            <td>
              <div class="action-buttons">
                <div class="delete">
                  <a title="Delete line" class="invoice-delete fa fa-close btn-danger" href="#"></a>
                </div>
              </div>
              <input type="text"/>
            </td>
            <td><input type="text" /></td>
            <td><input type="text" /></td>
            <td><input type="text" /></td>
            <td><select>
                  <option selected="selected">NOK</option>
                  <option>GBP</option>
                  <option>EUR</option>
                  <option>USD</option>
                  <option>AUD</option>
                  <option>NZD</option>
                  <option>CHF</option>
                  <option>PLN</option>
                  <option>DKK</option>
                  <option>SEK</option>
                  <option>CNY</option>
                </select>
            </td>
            <td><input type="text" class="no-border no-bg"></td>
          </tr>



        </tbody>
      </table>
      <span class="btn-table-bottom">
        <a href="javascript:;" class="add-btn btn btn-success" title="Add a product"><i class="fa fa-plus"></i> Add a product</a>
      </span>
    </div><!-- /.col -->
  </div><!-- /.row -->

  <div class="row">
    <!-- accepted payments column -->

    <div class="col-xs-6 pull-right pad-0-40">
      <p class="lead">Amount Due 2/22/2015</p>
      <div class="table-responsive">
        <table class="table">
          <tr>
            <th style="width:50%">Subtotal:</th>
            <td></td>
          </tr>
          <tr>
            <th>Tax (%)</th>
            <td></td>
          </tr>
          <tr>
            <th>Shipping:</th>
            <td></td>
          </tr>
          <tr>
            <th>Total:</th>
            <td></td>
          </tr>
        </table>
      </div>
    </div><!-- /.col -->
  </div><!-- /.row -->

  <!-- this row will not appear when printing -->
  <div class="row no-print">
    <div class="col-xs-12">
      <button class="btn btn-primary pull-right" style="margin-right: 5px;">Submit</button>
    </div>
  </div>
</section><!-- /.content -->
<div class="clearfix"></div>


    <script src="assets/plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>
    <script src='assets/plugins/fastclick/fastclick.min.js'></script>
    <script src="assets/js/app.min.js" type="text/javascript"></script>
    <script src="assets/js/select2.js" type="text/javascript"></script>

    <script type="text/javascript">
    (function(){
      var invoice_tr_html = $('.invoice-table .position-r').html();
      var invoice_tr_html_wrap = '<tr class="position-r">'+ invoice_tr_html +'</tr>';
      var invoice_tr = $('.invoice-table .position-r');
      var add_btn = $('.add-btn');

      add_btn.on('click',function(){
        invoice_tr.after(invoice_tr_html_wrap);
      });
      invoice_tr.on('mouseover',function(){
       $(this).find('.action-buttons').show();
      });

      invoice_tr.on('mouseout',function(){
        $(this).find('.action-buttons').hide();
      });

       $(".select-single").select2({
        theme: "classic"
        });

    })();
    </script>
@stop


