@extends('tenant.layouts.main')

@section('heading')
Print Invoice
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-cog"></i> <a href="{{tenant_route('tenant.invoice.bill.index')}}">Invoice</a></li>
@stop

@section('content')
<div class="box box-solid">
<div class="box-body">
       <div id="print">
                <div class="header-wrap clearfix">
                  <header class="col-md-12 col-sm-12">
                    <div class="row"><h1>Kvittering</h1></div>
                    <div class="row">
                      <div class="col-md-3 pad-0 col-sm-3 col-xs-3">
                        <p>Innbetalt till konto
                           <span class="block mg-left-30">60050625977</span>
                        </p>
                      </div>
                      <div class="col-md-3 col-sm-3 col-xs-3">
                        <label>Belop</label>
                        <input type="text">
                      </div>
                      <div class="col-md-3 col-sm-3 pad-0 col-xs-3">
                        <label>Betalerens kontonummer</label>
                        <input type="text" class="full-width">
                      </div>
                      <div class="col-md-3 col-sm-3 pad-right-0 col-xs-3">
                        <label>Blankettnr</label>
                        <input type="text">
                      </div>

                    </div>
                  </header>
                </div>
                <div class="section-wrap">
                  <section class="clearfix">
                    <div class="col-md-12 pad-0">
                      <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <div class="information-box font-mid">
                            <h3>Betalingsinformasjon</h3>
                            <div class="info-ac">
                              <div class="row">
                                <label class="col-md-5 font-mid col-sm-5 col-xs-5">Kundenr:</label>
                                <span class="col-md-7 col-sm-7 col-xs-7">4785007</span>
                              </div>
                              <div class="row">
                                <label class="col-md-5 col-sm-5 col-xs-5 font-mid">Fakturanr:</label>
                                <span class="col-md-7 col-sm-7 col-xs-7">{{ $data['invoice_number']}}</span>
                              </div>
                              <div class="row">
                                <label class="col-md-5 col-sm-5 col-xs-5 font-mid">Fakturadato:</label>
                                <span class="col-md-7 col-sm-7 col-xs-7"><?php echo date('d-m-y', strtotime($data['invoice_date'])) ?></span>
                              </div>
                            </div>
                          </div>
                          <div class="info-paid">
                            <h3>Betalt av</h3>
                            <div class="info-payer border">
                              <p>{{ $data['customer_details']->name }}</p>
                              <p>{{ $data['customer_details']->street_number }}</p>
                              <p>{{ $data['customer_details']->address }}</p>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <div class="row clearfix">
                            <div class="col-md-5 col-sm-5 col-xs-5">
                              <h2>GIRO</h2>
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-7">
                              <div id="giro-block" class="row">
                                <label class="col-md-6 col-sm-5 col-xs-5">Betalings-first</label>
                                <span class="font-mid border col-md-6 col-sm-7 col-xs-7">30.09.2014</span>
                              </div>
                            </div>
                          </div>
                          <div class="signature-block">
                              <h3>Underskrift ved girering</h3>
                              <span class="border signaturebox"></span>
                            </div>
                            <div class="info-paid">
                              <h3>Betalt til</h3>
                              <div class="info-payer border">
                                <p>{{ $data['company_details']['company_name'] }}</p>
                                <p>{{ $data['company_details']['postal_code'] }} {{ $data['company_details']['town'] }}</p>
                                <p>{{ $data['company_details']['address'] }}</p>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
                <div class="section-wrap-yellow">
                <section class="clearfix">
                  <div class="col-md-8 col-sm-8 col-xs-8">
                    <label>Belast Konto</label>
                    <div class="input-boxes">
                      <input type="text" class="small-input">
                      <input type="text" class="small-input">
                      <input type="text" class="small-input">
                      <input type="text" class="small-input">
                      <input type="text" class="small-input">
                      <input type="text" class="small-input">
                      <input type="text" class="small-input">
                      <input type="text" class="small-input">
                      <input type="text" class="small-input">
                      <input type="text" class="small-input">
                      <input type="text" class="small-input">
                    </div>
                  </div>
                  <div class="col-md-4 align-right col-sm-4 col-xs-4">
                    <label>Kvittering tilbake</label>
                    <input type="text" class="small-input">
                  </div>
                </section>
                </div>
                <div class="footer-wrap">
                  <footer class="clearfix">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-4 box1 col-sm-4 col-xs-4">
                          <h3>Kundeidentifikasjon(KID)</h3>
                          <p class="align-right font-mid">
                            478507204539453
                          </p>
                        </div>
                        <div class="col-md-2 box2 col-sm-2 col-xs-2">
                          <h3>Kroner</h3>
                          <p class="align-right font-mid">
                            296
                          </p>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2">
                          <h3>Ore</h3>
                          <p class="font-mid">
                            56 < 6 >
                          </p>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                          <h3>Til konto</h3>
                          <p class="font-mid">
                            60050625977
                          </p>
                        </div>
                      </div>
                    </div>
                  </footer>
                </div>

              </div>

              <div class="row no-print">
                <div class="col-xs-12 align-center">
                  <a class="btn btn-default" href="#"  onclick=" window.print();" style="margin-right: 5px;"><i class="fa fa-print"></i> Print</a>
             {{--     <button class="btn btn-default" style="margin-right: 5px;"><i class="fa fa-credit-card"></i> Send an email</button>--}}
                  <a href="<?php echo tenant()->url('nvoice/bill/'.$data['id'].'/download');?>" style="margin-right: 5px;" class="btn btn-primary"><i class="fa fa-download"></i> Generate PDF</a>
                </div>
              </div>
  </div>
  </div>
<?php if(Input::get('print') == 'auto'):?>
<script>
        $(function(){
                window.print();
        });
</script>
<?php endif;?>
@stop
