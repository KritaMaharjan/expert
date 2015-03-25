  <style>
    table, th, td {
      border-collapse: collapse;
  }
     th, td {
      padding: 10px;
  }
     h1{
      font-size:20px;
      font-weight:600;
      line-height:2;
     }         
     .border{border:1px solid #dbdbdb;}
     .border-block{border:1px solid #dbdbdb;line-height:2;}
     .fix-size{border:1px solid #dbdbdb;line-height:4;}
     .sm-box{line-height:1.5;}
     .footer{border-bottom: 3px solid #FFFF00;}
  </style>

      <table id="print">
          <tr bgcolor="#FFFF00"><td colspan="4"><h1 style="text-indent: 5px;">Receipt</h1></td></tr>
          <tr bgcolor="#FFFF00">
              <th> <span style="text-indent: 10px;">Paid till account</span></th>
              <th style="font-size:11px;">Amounts</th>
              <th style="font-size:11px;">Payer account number</th>
              <th style="font-size:11px;">Blankettnr</th>
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
               <tr><td colspan="2" style="font-size:11px;">Payment information</td></tr>
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
              <tr><td style="font-size:11px;">Signature by Giro</td>         
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
            <table><tr><td>Customer Identification (CID)</td></tr></table>
            <table cellpadding="5"><tr style="text-align: right;">
              <td>478507204539453</td>
              </tr>
            </table>
          </td>
          <td width="20%" style="border-right:1px solid #fff000;">
            <table><tr><td>Crowns</td></tr></table>
            <table  cellpadding="5"><tr style="text-align: right;">
              <td>296</td>
              </tr>
            </table>
          </td>
          <td width="11%">
            <table><tr><td>Ore</td></tr></table>
            <table  cellpadding="5"><tr>
              <td>56 &lt; 6 &gt;</td>
              </tr>
            </table>
          </td>
          <td width="39%">
            <table><tr><td>To account</td></tr></table>
            <table  cellpadding="5"><tr>
              <td>60050625977</td>
              </tr>
            </table>
          </td>          
        </tr>
      </table>