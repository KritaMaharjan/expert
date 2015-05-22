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

      <table id="purring-detail">
        <tr>
          <td colspan="3" class="center">{!! (isset($data['company_details']['logo']))? '<img src ="'.tenant()->folder('system')->url($data['company_details']['logo']).' "/>' : "<h1>Logo</h1>" !!}</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td><h2>PURRING</h2></td>
        </tr>
        <tr>
          <td>
            <p>{{ $data['customer'] }}<br />
            {{ $data['customer_details']['street_name'] }} {{ $data['customer_details']['street_number'] }}<br />
            {{ $data['customer_details']['postcode'] }} {{ $data['customer_details']['town'] }}<br />
            {{--Country--}}</p>
          </td>
          <td>
            <p><strong>Tlf </strong>{{ $data['company_details']['telephone'] }}<br />
              <strong>Fax </strong>{{ $data['company_details']['fax'] }}<br />
              <strong>Epost </strong>{{ $data['company_details']['service_email'] }}<br />
              <strong>Org.nr.</strong> {{ $data['company_details']['company_number'] }}<br />
              <strong>Account Number</strong> {{ $data['company_details']['account_no'] }}<br />
              <strong>Swift -</strong> {{ $data['company_details']['swift_num'] }}<br />
              <strong>IBAN -</strong> {{ $data['company_details']['iban_num'] }}
            </p>
          </td>
          <td>
            <p><strong>Note payment:</strong> <br />
              <strong>Customer number</strong> {{ $data['customer_details']['id'] }}<br />
              <strong>Var ref.</strong> {{ $data['invoice_number'] }}<br />
              <strong>Invoice date</strong> {{ date('d-m-y', strtotime($data['invoice_date'])) }}<br />
              <strong>Due date</strong> {{ date('d-m-y', strtotime($data['due_date'])) }}<br />
              <strong>Currency:</strong> {{ $data['currency'] }}
            </p>
          </td>
        </tr>
      </table><br /><br /><br /><br />

      <table id="inv-tab" cellpadding="4">
        <thead>
          <tr>
            <th style="font-size:9px;"><b>Invoice number</b></th>
            <th style="font-size:9px;"><b>Description</b></th>
            <th style="font-size:9px;"><b>Invoice date</b></th>
            <th style="font-size:9px;"><b>Due date</b></th>
            <th style="font-size:9px;"><b>Total</b></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><small>{{ $data['invoice_number'] }}</small></td>
            <td><small>PURRING</small></td>
            <td><small>{{ date('d-m-y', strtotime($data['invoice_date'])) }}</small></td>
            <td><small>{{ date('d-m-y', strtotime($data['due_date'])) }}</small></td>
            <td><small>{{ $data['remaining'] }}</small></td>
          </tr>
        </tbody>

      </table>
      <br /><br />
        <table>
          <tr>
            <td width="50%"></td>
            <td>
              <table id="inv-tab2" cellpadding="4" width="100%" style="float:right">
                <tr>
                  <th style="font-size:9px;"><b>late fee</b></th>
                  <th style="font-size:9px;"><b>Paid amounts</b></th>
                  <th style="font-size:9px;"><b>Gross</b></th>
                </tr>
                <tr>
                  <td><small>{{ $data['late_fee'] }}</small></td>
                  <td><small>{{ $data['paid'] }}</small></td>
                  <td><small>{{ $data['gross'] }}</small></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      <br /><br /><br />

      <div>
        <p style="font-size:8px"><b style="font-size:9px;">Terms</b><br />
            Har du nylig betalt kan du se vekk ifra kravet.
        </p>
      </div>
      <br />
      <br />
      <br />
      <br />
      <br />
      <br />


      <table id="print">
          <tr bgcolor="#FFFF00"><td colspan="4"><h1 style="text-indent: 5px;">Receipt</h1></td></tr>
          <tr bgcolor="#FFFF00">
              <th> <span style="text-indent: 10px;">Paid till account</span></th>
              <th style="font-size:9px;">Amounts</th>
              <th style="font-size:9px;">Payer account number</th>
              <th style="font-size:9px;">Blankettnr</th>
          </tr>
      </table>
      <table cellpadding="4">
          <tr bgcolor="#FFFF00" >
            <td> <span style="text-indent: 10px;">9879879879789</span></td>
            <td><p class="border-block" bgcolor="#ffffff">&nbsp; {{ $data['amount'] }}</p></td>
            <td><p class="border-block" bgcolor="#ffffff">{{ $data['customer_payment_number'] }}</p></td>
            <td><p class="border-block" bgcolor="#ffffff"></p></td>
          </tr>
      </table>
      <table cellpadding="5">
          <tr>
            <td colspan="2">
             <table>
              <tbody>
               <tr><td colspan="2" style="font-size:9px;">Payment information</td></tr>
               <br />
               <tr>
                <td style="text-indent:15px;">Kundenr:</td>
                <td>4785007</td>
               </tr>
               <tr>
                <td style="text-indent:15px;">Invoice:</td>
                <td>{{ $data['invoice_number']}}</td>
               </tr>
               <tr>
                <td style="text-indent:15px;">Invoice date:</td>
                <td><?php echo date('d-m-y', strtotime($data['invoice_date'])) ?></td>
               </tr>
              </tbody>
             </table>
            </td>
            <td colspan="2"><table cellpadding="0">
              <tbody>
               <tr>
                <td style="font-size:13px;">GIRO</td>
                <td style="font-size:11px;">Payment first</td>
                <td class="border-block" bgcolor="#ffffff"></td>
               </tr>
              </tbody>
             </table>
            <table cellpadding="0">
              <tr><td style="font-size:9px;">Signature by Giro</td>
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
          <td><table><tr><td>Paid</td></tr></table>
             <table class="border" cellpadding="2">
              <tbody>
               <tr>
                <td style="text-indent:15px;">{{ $data['customer_details']['name'] }}</td>
               </tr>
               <tr>
                <td style="text-indent:15px;">{{ $data['customer_details']['street_address'] or '' }} {{ $data['customer_details']['street_number'] or '' }}</td>
               </tr>
               <tr>
                <td style="text-indent:15px;">{{ $data['customer_details']['postcode'] or ''}} {{ $data['customer_details']['town'] or '' }}</td>
               </tr>
              </tbody>
             </table>
            </td>
            <td><table><tr><td>Paid to</td></tr></table>
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
                    <td style="text-indent:15px;">{{ $data['company_details']['country'] }}</td>
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
                  <td width="50px">Charge account</td>
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
                    Receipt back
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
                  <table><tr><td>Note Payment</td></tr></table>
                  <table cellpadding="5"><tr style="text-align: right;">
                    <td>{{ $data['invoice_number'] }}</td>
                    </tr>
                  </table>
                </td>
                <td width="20%" style="border-right:1px solid #fff000;">
                  <table><tr><td>Crowns</td></tr></table>
                  <table  cellpadding="5"><tr style="text-align: right;">
                    <td>{{ $data['currency'] }}</td>
                    </tr>
                  </table>
                </td>
                <td width="11%">
                  <table><tr><td>Ore</td></tr></table>
                  <table  cellpadding="5"><tr>
                    <td>{{ $data['amount'] * 100 }}</td>
                    </tr>
                  </table>
                </td>
                <td width="39%">
                  <table><tr><td>To account</td></tr></table>
                  <table  cellpadding="5"><tr>
                    <td>{{ $data['customer_payment_number'] }}</td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>