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
     

    
      </style>

   
      <table width="800px">
        <tr>
            <td colspan="3">{!! (isset($data['company_details']['logo']) && file_exists(tenant()->folder('system')->url($data['company_details']['logo'])) )? '<img src ="'.tenant()->folder('system')->url($data['company_details']['logo']).' "/>' : "" !!}</td>
        </tr>
        <tr>
          <td width="43.3%"></td>
          <td width="56.7%">
            <table>
              <tr>
                <td><p><strong>Dato:</strong> {{ date('d-m-y') }}<br />
                       <strong>Org.nr:</strong> {{ $data['company_details']['company_number'] }}<br />
                       <strong>Telefon:</strong> {{ $data['company_details']['telephone'] }}
                    </p>
                </td>
                <td><p><strong>Forfallsdato:</strong> {{ format_date($data['due_date']) }}<br />
                       <strong>Kontonr:</strong> {{ $data['company_details']['account_no'] }}<br />
                       <strong>Saksnr:</strong> {{ $data['invoice_number'] }}
                    </p><br />                  
                </td>
              </tr>  
              <tr>
                <td colspan="2"><p>Saksbehandler: {{ $current_user->fullname }}<br />
                                   E-post: {{ $current_user->email }}<br />
                                   Nettsted: {{ $data['company_details']['website'] }}
                                </p>                  
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br />
      <br />
      <table>
        <tr>
          <td><p>{{ $data['customer'] }}<br />
            {{ $data['customer_details']['street_name'] }} {{ $data['customer_details']['street_number'] }}<br />
            {{ $data['customer_details']['postcode'] }} {{ $data['customer_details']['town'] }}<br />
            Norway</p>
          </td>
          <td><P><b style="font-size:10px">{{ $data['company_details']['company_name'] }}</b><br />
                    {{ $data['company_details']['address'] }}<br />
                    {{ $data['company_details']['postal_code'] }} {{ $data['company_details']['town'] }}<br />
                    {{--{{ $data['company_details']['country'] }}--}}
                    Norway
              </P>
          </td>
        </tr>
      </table>
      <br /><br /><br />

      <table>
        <tr>
          <td colspan="2" align="center"><h1 class="uppercase" style="margin-bottom:2px;"><b>BETALINGSOPPFORDRING</b></h1></td>              
        </tr>
        <tr>
          <td colspan="2" align="center">Varsel etter Tvangsfullbyrdelsesloven § 4-18 og Tvisteloven § 5.2</td>
        </tr><br /><br />
        <tr>
          <td colspan="2">
            <table>
              <tr>
                <th width="80%"><b style="font-size:10px">Hovedstol</b></th>
                <th width="20%"><b style="font-size:10px">Beløp</b></th>
              </tr>
              <tr>
                <td width="80%"><p>Faktura nr: {{ $data['invoice_number'] }}</p></td>
                <td width="20%">{{ $data['amount'] }} {{ $data['currency'] }}</td>
              </tr>
              <tr>
                <td width="80%"><p>9,50 % rente fra Interest date til og med {{ $data['due_date'] }}: </p></td>
                <td width="20%">{{ $data['interest'] }} {{ $data['currency'] }}</td>
              </tr>
              <tr>
                <td width="80%"><p>Purregebyr ihht regelverk:</p></td>
                <td width="20%">{{ $data['fee'] }} {{ $data['currency'] }}</td>
              </tr>
              <tr>
                <td width="80%"><p>Innbetalt:</p></td>
                <td width="20%">{{ $data['paid'] }} {{ $data['currency'] }}</td>
              </tr>
              <tr>
                <td><b>Å betale:</b></td>
                <td><b>{{ $data['remaining'] }} {{ $data['currency'] }}</b></td>
              </tr><br />
              <tr>
                <td colspan="2" style="border-top:1px solid #444;">Dersom kravet er betalt, vennligst se bort fra dette varselet.</td>
              </tr><br /><br />
              <tr>
                <td colspan="2">Totalbeløpet bes innbetalt innen 14 dager og senest den <b>DUE DATE</b>. En eventuell innsigelse mot kravet må fremsettes skriftlig innen samme frist.<br /><br />
                Vi gjør oppmerksom på at kravet i sin helhet, inkludert renter og sakskostnader, må være betalt innen forfallsdato. Unnlatt betaling vil medføre at reglene i Konkurslovens § 63 blir iverksatt eller tvangsfullbyrdelse vil bli begjært, jamfør Tvangsfullbyrdelsesloven § 4-18. Dette vil medføre ytterligere omkostninger for Dem.<br /><br />

                Lovbestemt forsinkelsesrente er beregnet fra forfall og løper videre til kravet blir betalt.
                <br />
                <br />
                <br />
                </td>
              </tr>   
            </table>
          </td>
        </tr>
      </table>

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
            <td><p class="border-block" bgcolor="#ffffff">&nbsp; {{ $data['customer_payment_number'] }}</p></td>
            <td><p class="border-block" bgcolor="#ffffff"></p></td>
          </tr>
      </table>
      <table cellpadding="5">
          <tr>
            <td colspan="2">
             <table>
              <tbody>
               <tr><td colspan="2" style="font-size:9px;">Betalingsinformasjon</td></tr>
               <br />
               <tr>
                <td style="text-indent:15px;"><b>Faktura</b></td>
                <td>{{ $data['invoice_number']}}</td>
               </tr>
               <tr>
                <td style="text-indent:15px;"><b>Kundenummer</b></td>
                <td>4785007</td>
               </tr>               
              </tbody>
             </table>
            </td>
            <td colspan="2"><table cellpadding="0">
              <tbody>
               <tr>
                <td style="font-size:13px;">GIRO</td>
                <td><b>Betalings frist</b></td>
                <td class="border-block" bgcolor="#ffffff">{{ $data['due_date'] }}</td>
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
                <td style="text-indent:15px;">{{ $data['customer_details']['street_address'] or '' }} {{ $data['customer_details']['street_number'] or '' }}</td>
               </tr>
               <tr>
                <td style="text-indent:15px;">{{ $data['customer_details']['postcode'] or '' }} {{ $data['customer_details']['town'] or '' }}</td>
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
                   {{--<tr>
                    <td style="text-indent:15px;">{{ $data['company_details']['telephone'] }}</td>
                    </tr>
                   <tr>
                    <td style="text-indent:15px;">Email: {{ $data['company_details']['service_email'] or 'Mangler informasjon, se instillinger' }}</td>
                    </tr>
                   <tr>
                    <td style="text-indent:15px;">Website: {{ $data['company_details']['website'] or 'Mangler informasjon, se instillinger' }}</td>
                    </tr>--}}
                    <tr>
                        <td style="text-indent:15px;">Norway</td>
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
              <td>{{ $data['invoice_number'] }}</td>
              </tr>
            </table>
          </td>
          <td width="20%" style="border-right:1px solid #fff000;">
            <table><tr><td><b>Kroner</b></td></tr></table>
            <table  cellpadding="5"><tr style="text-align: right;">
              <td>{{ $data['currency'] }}</td>
              </tr>
            </table>
          </td>
          <td width="11%">
            <table><tr><td><b>Øre</b></td></tr></table>
            <table  cellpadding="5"><tr>
              <td>{{ $data['amount'] * 100 }}</td>
              </tr>
            </table>
          </td>
          <td width="39%">
            <table><tr><td><b>Til konto</b></td></tr></table>
            <table  cellpadding="5"><tr>
              <td>{{ $data['customer_payment_number'] }}</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
