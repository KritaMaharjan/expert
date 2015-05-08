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

   
      <table>
        <tr>
          <td></td>
          <td width="50%">
            <table>
              <tr>
                <td><p>Date: date<br />
                       Org.nr: Company number<br />
                       Telefon: Phone number                        
                    </p>
                </td>
                <td><p>Due date: Due date<br />
                       Account no: Account no.<br />
                       Case number: case number                      
                    </p>                  
                </td>
              </tr>  
              <tr>
                <td colspan="2"><p>Fullname: Fullname of user<br />
                                   E-post: Email address<br />
                                   Website: Website                  
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
          <td><p>Firstname Lastname<br />
                 Street address + Number<br />
                 Postal code and town<br />
                 Country
              </p>
          </td>
          <td><P><b style="font-size:10px">Business name</b><br />
                    Street + Number<br />
                    Postalcode + Town<br />
                    Country
                  
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
                <td width="80%"><p>Invoice number: Invoice number</p></td>
                <td width="20%">amount NOK</td>
              </tr>
              <tr>
                <td width="80%"><p>9.50% rate of Interest date even Interest date: </p></td>
                <td width="20%">interest NOK</td>
              </tr>
              <tr>
                <td width="80%"><p>Reminder fee according to regulations:</p></td>
                <td width="20%">fees NOK</td>
              </tr>
              <tr>
                <td width="80%"><p>Paid:</p></td>
                <td width="20%">paid NOK</td>
              </tr>
              <tr>
                <td><b>To pay:</b></td>
                <td>sum NOK</td>
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
            <td><p class="border-block" bgcolor="#ffffff"></p></td>
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
                <td>Payment first</td>
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
            <table><tr><td>Customer Payment Number</td></tr></table>
            <table cellpadding="5"><tr style="text-align: right;">
              <td>{{ $data['customer_payment_number'] }}</td>
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
