  <style>
    table, th, td {
      border-collapse: collapse;
  }
     th, td {
      padding: 10px;
      font-size: 9px;
  }
     h1{
      font-size:15px;
      font-weight:600;
      line-height:2;
     }
     small{
      font-size: 8px;
     }
     .border{border:1px solid #dbdbdb;}
     .border-block{border:1px solid #dbdbdb;line-height:2;}
     .fix-size{border:1px solid #dbdbdb;line-height:4;}
     .sm-box{line-height:1.5;}
     .footer{border-bottom: 3px solid #FFFF00;}
     .center{text-align: center;}
     .right{text-align: right;}
   
     table#inv-tab th,table#inv-tab2 th{
        border-bottom: 1px solid #333;
     }
  </style>


        <table width="100%">
        <tr>
          <td colspan="3">{!! (isset($data['company_details']['logo']) && file_exists(tenant()->folder('system')->url($data['company_details']['logo'])) )? '<img src ="'.tenant()->folder('system')->url($data['company_details']['logo']).' "/>' : "" !!}</td>
        </tr>
        <tr>
          <td></td>
          <td><p>Centco Corporate Services<br />
                Middelthunsgate 25B<br />
                0368
          </p></td>
          <td style="vertical-align:top;"><h3 style="margin:0;">Faktura <small>00172</small></h3> </td>
        </tr>
        <tr>
          <td style="vertical-align:top;">
            <p>Remy Andre Johansen<br />
            Mannsverk 63 BERGEN 5094<br />
            Norway</p>
          </td>
          <td>
            <p><strong>Tlf</strong> {{ $data['company_details']['telephone'] }}<br />
              <strong>Fax </strong> {{ $data['company_details']['fax'] }}<br />
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

      <table id="inv-tab" cellpadding="4" width="100%">
        <thead>
          <tr>
            <th style="font-size:10px;padding:6px 0px;"><b>Kode</b></th>
            <th style="font-size:10px;padding:6px 0px;"><b>Navn</b></th>
            <th style="font-size:10px;padding:6px 0px;"><b>Antall</b></th>
            <th style="font-size:10px;padding:6px 0px;"><b>Pris</b></th>
            <th style="font-size:10px;padding:6px 0px;"><b>MVA</b></th>
            <th style="font-size:10px;padding:6px 0px;"><b>Total</b></th>
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
        <table width="100%">
          <tr>
            <td width="32.5%"></td>
            <td width="67.5%">
              <table id="inv-tab2" cellpadding="4" width="100%" style="float:right">
                <tr>
                  <th style="font-size:10px;"><b></b></th>
                  <th style="font-size:10px;"><b>Netto</b></th>
                  <th style="font-size:10px;"><b>MVA</b></th>
                  <th style="font-size:10px;"><b>Brutto</b></th>
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

      <div>
        <p style="font-size:10px"><b style="font-size:10px;">Notes</b><br />
            Så fort faktura er betalt vil vi påbegynne registreringen.
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            
        </p>
      </div>
      

      <table id="print">
          <tr bgcolor="#FFFF00"><td colspan="4"><h1 style="text-indent: 5px;"><b>Kvittering</b></h1></td></tr>
          <tr bgcolor="#FFFF00">
              <th> <span style="text-indent: 10px;"><b>Innbetalt til konto</b></span></th>
              <th style="font-size:10px;"><b>Beløp</b></th>
              <th style="font-size:10px;"><b>Betalerens kontonummer</b></th>
              <th style="font-size:10px;"><b>Blankettnummer</b></th>
          </tr>  
      </table>
      <table cellpadding="4">
          <tr bgcolor="#FFFF00" > 
            <td> <span style="text-indent: 10px;">9879879879789</span></td>
            <td><p class="border-block" bgcolor="#ffffff" >&nbsp; {{ $data['amount'] }}</p></td>
            <td><p class="border-block" bgcolor="#ffffff"></p></td>
            <td><p class="border-block" bgcolor="#ffffff"></p></td>
          </tr>
      </table>
      <table cellpadding="5">
          <tr>
            <td colspan="2">
             <table>
              <tbody>
               <tr><td colspan="2" style="font-size:10px;">Betalingsinformasjon</td></tr>
               <br />
               <tr>
                <td style="text-indent:15px;"><b>Faktura</b></td>
                <td>{{ $data['invoice_number'] }}</td>
               </tr>
               <tr>
                <td style="text-indent:15px;"><b>Kundenummer</b></td>
                <td>{{ format_id($data['customer_details']['id'], 4) }}</td>
               </tr>              
              </tbody>
             </table>
            </td>
            <td colspan="2"><table cellpadding="0">
              <tbody>
               <tr>
                <td style="font-size:13px;">GIRO</td>
                <td style="font-size:11px;"><b>Betalings frist</b></td>
                <td class="border-block" bgcolor="#ffffff">{{ date('d-m-y', strtotime($data['due_date'])) }}</td>
               </tr>               
              </tbody>
             </table>
            <table cellpadding="0">
              <tr><td><b>Underskrift ved girering</b></td>         
              </tr>
            </table>
            <table cellpadding="0">
              <tr>
                <td class="fix-size"></td>         
               </tr>  
            </table>
            </td>  
          </tr>
      </table>
      <table cellpadding="6">
        <tr>
          <td><table><tr><td><b>Betalt av</b></td></tr></table>
             <table class="border" cellpadding="2">
              <tbody>       
               <tr>
                <td style="text-indent:15px;">{{ $data['customer_details']['name'] }}</td>
               </tr>
               <tr>
                <td style="text-indent:15px;">{{ $data['customer_details']['street_number'] or '' }} {{ $data['customer_details']['street_address'] or '' }}</td>
               </tr>
               <tr>
                <td style="text-indent:15px;">{{ $data['customer_details']['town'] or '' }}</td>
               </tr>
               <tr>
                <td style="text-indent:15px;">{{ $data['customer_details']['address'] or ''}}</td>
               </tr>
              </tbody>
             </table>
            </td>
            <td><table><tr><td><b>Betalt til</b></td></tr></table>
                <table class="border" cellpadding="2">
                  <tbody>       
                   <tr>
                    <td style="text-indent:15px;">{{ $data['company_details']['company_name'] }}</td>
                   </tr>
                   <tr>
                    <td style="text-indent:15px;">{{ $data['company_details']['postal_code'] }} {{ $data['company_details']['town'] }}</td>
                    </tr>
                   <tr>
                    <td style="text-indent:15px;">{{ $data['company_details']['address'] }}</td>
                    </tr>
                   <tr>
                    <td style="text-indent:15px;">{{ $data['company_details']['telephone'] }}</td>
                    </tr>
                   <tr>
                    <td style="text-indent:15px;">Email: {{ $data['company_details']['service_email'] or 'Mangler informasjon, se instillinger' }}</td>
                    </tr>
                   <tr>
                    <td style="text-indent:15px;">Website: {{ $data['company_details']['website'] or 'Mangler informasjon, se instillinger' }}</td>
                    </tr>
                  </tbody>
                </table>
            </td>
        </tr>
      </table>
      <table cellpadding="3">
        <tr bgcolor="#FFFF00">
          <td width="75%">
              <table>
                <tr>
                  <td width="50px"><b>Belast konto</b></td>
                  <td width="30px"><p class="sm-box border" bgcolor="#ffffff"></p></td>
                  <td width="30px"><p class="sm-box border" bgcolor="#ffffff"></p></td>
                  <td width="30px"><p class="sm-box border" bgcolor="#ffffff"></p></td>
                  <td width="30px"><p class="sm-box border" bgcolor="#ffffff"></p></td>
                  <td width="30px"><p class="sm-box border" bgcolor="#ffffff"></p></td>
                  <td width="30px"><p class="sm-box border" bgcolor="#ffffff"></p></td>
                  <td width="30px"><p class="sm-box border" bgcolor="#ffffff"></p></td>
                  <td width="30px"><p class="sm-box border" bgcolor="#ffffff"></p></td>
                  <td width="30px"><p class="sm-box border" bgcolor="#ffffff"></p></td>
                </tr>
              </table>
          </td>
          
          <td width="25%">
            <table>
              <tr>
                <td width="120px">
                    <b>Kvittering tilbake</b>
                </td>
                <td width="30px"><p class="sm-box border" bgcolor="#ffffff"></p></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <table class="footer" cellpadding="6">
        <tr>
          <td width="30%" style="border-right:1px solid #ccc;">
            <table><tr><td><b>Merk betaling</b></td></tr></table>
            <table cellpadding="5"><tr style="text-align: right;">
              <td>{{ $data['customer_payment_number'] }}</td>
              </tr>
            </table>
          </td>
          <td width="20%" style="border-right:1px solid #fff000;">
            <table><tr><td><b>Kroner</b></td></tr></table>
            <table  cellpadding="5"><tr style="text-align: right;">
              <td>296</td>
              </tr>
            </table>
          </td>
          <td width="11%">
            <table><tr><td><b>Øre</b></td></tr></table>
            <table  cellpadding="5"><tr>
              <td>56 &lt; 6 &gt;</td>
              </tr>
            </table>
          </td>
          <td width="39%">
            <table><tr><td><b>Til konto</b></td></tr></table>
            <table  cellpadding="5"><tr>
              <td>60050625977</td>
              </tr>
            </table>
          </td>          
        </tr>
      </table>