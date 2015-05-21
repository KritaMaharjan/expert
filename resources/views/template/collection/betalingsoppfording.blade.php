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
            <td colspan="3" class="center">{!! (isset($data['company_details']['logo']))? '<img src ="'.tenant()->folder('system')->url($data['company_details']['logo']).' "/>' : "<h1>Logo</h1>" !!}</td>
        </tr>
        <tr>
          <td></td>
          <td width="50%">
            <table>
              <tr>
                <td><p><strong>Date:</strong> {{ date('d-m-y') }}<br />
                       <strong>Org.nr:</strong> {{ $data['company_details']['company_number'] }}<br />
                       <strong>Telefon:</strong> {{ $data['company_details']['telephone'] }}
                    </p>
                </td>
                <td><p><strong>Due date:</strong> {{ format_date($data['due_date']) }}<br />
                       <strong>Account no:</strong> {{ $data['company_details']['account_no'] }}<br />
                       <strong>Case number:</strong> {{ $data['invoice_number'] }}
                    </p>                  
                </td>
              </tr>  
              <tr>
                <td colspan="2"><p>Fullname: {{ $current_user->fullname }}<br />
                                   E-post: {{ $current_user->email }}<br />
                                   Website: {{ $data['company_details']['website'] }}
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
          <td colspan="2" align="center"><h1 class="uppercase" style="margin-bottom:2px;"><b>Payment solicitation</b></h1></td>              
        </tr>
        <tr>
          <td colspan="2" align="center">Notification pursuant to the Enforcement Act § 4-18 and Dispute Act § 5.2</td>
        </tr><br /><br />
        <tr>
          <td colspan="2">
            <table>
              <tr>
                <th width="80%"><b style="font-size:10px">Principal</b></th>
                <th width="20%"><b style="font-size:10px">Amounts</b></th>
              </tr>
              <tr>
                <td width="80%"><p>Invoice number: {{ $data['invoice_number'] }}</p></td>
                <td width="20%">{{ $data['amount'] }} {{ $data['currency'] }}</td>
              </tr>
              <tr>
                <td width="80%"><p>9.50% rate of Interest date even {{ $data['due_date'] }}: </p></td>
                <td width="20%">{{ $data['interest'] }} {{ $data['currency'] }}</td>
              </tr>
              <tr>
                <td width="80%"><p>Reminder fee according to regulations:</p></td>
                <td width="20%">{{ $data['fee'] }} {{ $data['currency'] }}</td>
              </tr>
              <tr>
                <td width="80%"><p>Paid:</p></td>
                <td width="20%">{{ $data['paid'] }} {{ $data['currency'] }}</td>
              </tr>
              <tr>
                <td><b>To pay:</b></td>
                <td>{{ $data['remaining'] }} {{ $data['currency'] }}</td>
              </tr><br />
              <tr>
                <td colspan="2" style="border-top:1px solid #444;">If the claim is paid, please disregard this notice.</td>
              </tr><br /><br />
              <tr>
                <td colspan="2">The total amount requested paid within 14 days and no later than the DUE DATE. A possible objection to the claim must be submitted in writing within the same period.<br /><br />
                Please note that the claim in full, including interest and legal costs must be paid by the due date. Failure to pay will result in the rules of the Bankruptcy Code § 63 are implemented or enforcement will be filed, cf. Enforcement Act § 4-18. This will entail additional costs for you.<br /><br />

                Statutory penalty interest is calculated from the due date and are valid until the claim is paid.
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
                <td>Payment deadline</td>
                <td class="border-block" bgcolor="#ffffff">{{ $data['due_date'] }}</td>
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
                <td style="text-indent:15px;">{{ $data['customer_details']['postcode'] or '' }} {{ $data['customer_details']['town'] or '' }}</td>
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
