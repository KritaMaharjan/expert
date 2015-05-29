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


      <table class="invoice-table-container">
        <tr>
          <td colspan="3">{!! (isset($data['company_details']['logo']))? '<img src ="'.tenant()->folder('system')->url($data['company_details']['logo']).' "/>' : "" !!}</td>
        </tr>
        <tr>
          <td></td>
          <td><p>Centco Corporate Services<br />
                Middelthunsgate 25B<br />
                0368
          </p></td>
          <td style="vertical-align:top;"><h3 style="margin:0;">Faktura <small>00172</small></h3> </td>
        </tr>
        <br />
        <tr>
          <td style="vertical-align:top;">
            <p>Remy Andre Johansen<br />
            Mannsverk 63 BERGEN 5094<br />
            Norway</p>
          </td>
          <td>
            <p><strong>Tlf</strong> {{ $data['company_details']['telephone'] }}<br />
              <strong>Fax</strong> {{ $data['company_details']['fax'] }}<br />
              <strong>Epost</strong> {{ $data['company_details']['service_email'] }}<br />
              <strong>Org.nr.</strong> {{ $data['company_details']['company_number'] }}<br />
              <strong>Kontonummer</strong> {{ $data['company_details']['account_no'] }}<br />
              <strong>Swift</strong> {{ $data['company_details']['swift_num'] }}<br />
              <strong>IBAN</strong> {{ $data['company_details']['iban_num'] }}
            </p>
          </td>
          <td>
            <p><strong>Merk betaling</strong> <br />
              <strong>Kundenummer</strong> {{ $data['customer_details']['id'] }}<br />
              <strong>Vår ref.</strong> {{ $data['invoice_number'] }}<br />
              <strong>Fakturadato</strong> {{ date('d-m-y', strtotime($data['invoice_date'])) }}<br />
              <strong>Forfallsdato</strong> {{ date('d-m-y', strtotime($data['due_date'])) }}<br />
              <strong>Valuta</strong> {{ $data['currency'] }}
            </p>
          </td>
        </tr>
      </table><br /><br /><br /><br />

      <table id="inv-tab" class="invoice-table-container" cellpadding="4">
        <thead>
          <tr>
            <th style="font-size:14px;padding:6px 0px;"><b>Kode</b></th>
            <th style="font-size:14px;padding:6px 0px;"><b>Navn</b></th>
            <th style="font-size:14px;padding:6px 0px;"><b>Antall</b></th>
            <th style="font-size:14px;padding:6px 0px;"><b>Pris</b></th>
            <th style="font-size:14px;padding:6px 0px;"><b>MVA</b></th>
            <th style="font-size:14px;padding:6px 0px;"><b>Total</b></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td></td>
            <td>NUF New registration</td>
            <td>1</td>
            <td>1,399.00</td>
            <td>0.00</td>
            <td>1,399.00</td>
          </tr>
        </tbody>

      </table>
      <br /><br />
        <table class="invoice-table-container">
          <tr>
            <td width="52%"></td>
            <td>
              <table id="inv-tab2" cellpadding="4" width="100%" style="float:right">
                <tr>
                  <th style="font-size:14px;"><b></b></th>
                  <th style="font-size:14px;"><b>Netto</b></th>
                  <th style="font-size:14px;"><b>MVA</b></th>
                  <th style="font-size:14px;"><b>Brutto</b></th>
                </tr>
                <tr>
                  <td><b>Sum</b></td>
                  <td>1,399.00</td>
                  <td>0.00</td>
                  <td>1,399.00</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      <br /><br /><br />

      <div class="invoice-table-container">
        <p style="font-size:14px"><b style="font-size:14px;">Notes</b><br />
            Så fort faktura er betalt vil vi påbegynne registreringen.
        </p>
      </div>
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />



       <div id="print">
                <div class="header-wrap clearfix">
                  <header class="col-md-12 col-sm-12">
                    <div class="row"><h1>Kvittering</h1></div>
                    <div class="row">
                      <div class="col-md-3 pad-0 col-sm-3 col-xs-3">
                        <p>Innbetalt till konto
                           <span class="block mg-left-30">{{ $data['company_details']['account_no'] }}</span>
                        </p>
                      </div>
                      <div class="col-md-3 col-sm-3 col-xs-3">
                        <label>Beløp</label>
                        <span class="block-f-width">&nbsp;{{ $data['amount'] }}</span>
                      </div>
                      <div class="col-md-3 col-sm-3 pad-0 col-xs-3">
                        <label>Betalerens kontonummer</label>
                        <span class="block-f-width">&nbsp;</span>                        
                      </div>
                      <div class="col-md-3 col-sm-3 pad-right-0 col-xs-3">
                        <label>Blankettnummer</label>
                        <span class="block-f-width">&nbsp;</span>                        
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
                                <label class="col-md-5 col-sm-5 col-xs-5 font-mid">Fakturanr</label>
                                <span class="col-md-7 col-sm-7 col-xs-7">{{ $data['invoice_number']}}</span>
                              </div>
                              <div class="row">
                                <label class="col-md-5 font-mid col-sm-5 col-xs-5">Kundenummer</label>
                                <span class="col-md-7 col-sm-7 col-xs-7">{{ format_id($data['customer_details']['id'], 4) }}</span>
                              </div>                              
                            </div>
                          </div>
                          <div class="info-paid">
                            <h3>Betalt av</h3>
                            <div class="info-payer border">
                              <p>{{ $data['customer_details']['name'] }}</p>
                              <p>{{ $data['customer_details']['street_number'] or '' }} {{ $data['customer_details']['street_address'] or '' }}</p>
                              <p>{{ $data['customer_details']['town'] or '' }}</p>
                              <p>{{ $data['customer_details']['address'] or '' }}</p>
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
                                <label class="col-md-6 col-sm-5 col-xs-5">Betalings first</label>
                                <span class="font-mid border col-md-6 col-sm-7 col-xs-7">{{ format_date($data['due_date']) }}</span>
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
                                <p>{{ $data['company_details']['telephone'] }}</p>
                                <p>Email: {{ $data['company_details']['service_email'] or 'Mangler informasjon, se instillinger' }}</p>
                                <p>Website: {{ $data['company_details']['website'] or 'Mangler informasjon, se instillinger' }}</p>
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
                      <span class="block-f-width width-30"></span>
                      <span class="block-f-width width-30"></span>
                      <span class="block-f-width width-30"></span>
                      <span class="block-f-width width-30"></span>
                      <span class="block-f-width width-30"></span>
                      <span class="block-f-width width-30"></span>
                      <span class="block-f-width width-30"></span>
                      <span class="block-f-width width-30"></span>
                      <span class="block-f-width width-30"></span>
                      <span class="block-f-width width-30"></span>
                      <span class="block-f-width width-30"></span>

                    </div>
                  </div>
                  <div class="col-md-4 align-right col-sm-4 col-xs-4">
                    <label>Kvittering tilbake</label>
                    <span class="block-f-width width-30"></span>
                    
                  </div>
                </section>
                </div>
                <div class="footer-wrap">
                  <footer class="clearfix">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-4 box1 col-sm-4 col-xs-4">
                          <h3>Merk betaling</h3>
                          <p class="align-right font-mid">
                            {{ $data['customer_payment_number'] }}
                          </p>
                        </div>
                        <div class="col-md-2 box2 col-sm-2 col-xs-2">
                          <h3>Kroner</h3>
                          <p class="align-right font-mid">
                            296
                          </p>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2">
                          <h3>Øre</h3>
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
                  <a href="<?php echo tenant()->url('invoice/bill/'.$data['id'].'/download');?>" style="margin-right: 5px;" class="btn btn-primary"><i class="fa fa-download"></i> Generate PDF</a>
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
