@extends('tenant.layouts.main')

@section('heading') Create Bill @stop

@section('breadcrumb')
    @parent
    <li><a data-push="true" href="{{tenant_route('tenant.invoice.index')}}"><i class="fa fa-cog"></i> Invoice</a></li>
    <li><i class="fa fa-money"></i> Bill</li>
@stop

@section('content')

<!-- Main content -->
<div class="row">
<div class="col-xs-12 mainContainer">
<div class="box box-solid">

<div class="box-body">
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
</div>
</div>
</div><!-- /.content -->
</div>
<div class="clearfix"></div>
    {{FB::js('assets/plugins/slimScroll/jquery.slimScroll.min.js')}}
    {{FB::js('assets/plugins/fastclick/fastclick.min.js')}}
    {{FB::js('assets/js/select2.js')}}
    {{FB::js('assets/js/create-bill.js')}}
@stop


