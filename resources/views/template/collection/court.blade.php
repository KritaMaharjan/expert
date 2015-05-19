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
          <td colspan="2">{!! (isset($data['company_details']['logo']))? '<img src ="'.tenant()->folder('system')->url($data['company_details']['logo']).' "/>' : "<h1>Logo</h1>" !!}</td>
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
                         <strong>Case number:</strong> case number
                      </p>
                  </td>
                </tr>
                <tr>
                  <td colspan="2"><p>Fullname: {{ $data['customer'] }}<br />
                                     E-post: {{ $data['customer_details']['email'] }}<br />
                                     {{--Website: Website--}}
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
                      {{--Country--}}</p>
                    </td>
          {{--<td><P><b style="font-size:10px">Business name</b><br />
                    Street + Number<br />
                    Postalcode + Town<br />
                    Country
                  
              </P>
          </td>--}}
        </tr>
      </table>
      <br /><br /><br />

      <table>
        <tr>
          <td align="center"><h1 class="uppercase"><b>A request for conciliation proceedings</b></h1></td>              
        </tr>
        <tr>
          <td align="center">Disputes Act §6-3</td>
        </tr><br /><br />
        <tr>
          <td>
            <table>              
              <tr>
                <td>This requirement applies: </td>
              </tr>
              <tr>
                <td>Principal invoice: {{ $data['invoice_number'] }} </td>
              </tr>
              <tr>
                <td>Interest: 9.50% basis of bill DUE DATE {{ $data['due_date'] }} until payment</td>
              </tr>
              <tr>
                <td>Reminder fee: Fees,- {{ $data['remaining'] }}</td>
              </tr>
              <tr>
                <td>Writing this petition: 860,-</td>
              </tr>
              <tr>
                <td>Court Fees Settlement Complaint: 860,-</td>
              </tr>
              <tr>
                <td>Meeting fee: 430</td>
              </tr>
              <tr>
                <td><b>Total:</b> {{ $data['amount'] }} {{ $data['currency'] }} + Interest</td>
              </tr><br /><br /><br />
              <tr>
                <td><b>Plaintiff:</b> {{ $data['company_details']['company_name'] }}<br/>{{ $data['company_details']['address'] }}</td>
              </tr><br /><br />
              <tr>
                <td><b>Defendant:</b> {{ $data['customer'] }}<br/>{{ $data['customer_details']['street_name'] }} {{ $data['customer_details']['street_number'] }}</td>
              </tr><br /><br /><br />
              <tr>
                <td>It is submitted herewith a conciliation Appeals framot {{ $data['customer'] }}.</td>
              </tr><br /><br /><br />
              <tr>
                <td>Emphasis the claim following: </td>
              </tr>
              <tr>
                <td>Defendant sentenced within 14 days to pay. <b>Following:</b> </td>
              </tr><br /><br />
              <tr>
                <td>Principal invoice: {{ $data['invoice_number'] }}</td>
              </tr>
              <tr>
                <td>Interest: 9.50% advise the payment takes place</td>
              </tr>
              <tr>
                <td>Reminder fee: {{ $data['remaining'] }} {{ $data['currency'] }}</td>
              </tr>
              <tr>
                <td>Writing this petition: 860</td>
              </tr>
              <tr>
                <td>Court Fees Settlement Complaint: 860</td>
              </tr>
              <tr>
                <td>Meeting fee: 430</td>
              </tr>
              <tr>
                <td>Total: {{ $data['amount'] }} {{ $data['currency'] }} + interest</td>
              </tr>
              <tr>
                <td>A brief report:</td>
              </tr><br /><br />
              <tr>
                <td>User defined text inserted here</td>
              </tr><br /><br /><br /><br />
              <tr>
                <td>We ask to be under kit when conciliation meeting will be held.<br /> If the conditions are present or absent defendant required default trial.</td>
              </tr><br /><br /><br />
              <tr>
                <td>Yours for,</td>
              </tr><br /><br /><br /><br />
              <tr>
                <td>Business name</td>
              </tr><br /><br />
              <tr>
                <td>Attachments</td>
              </tr>
              <tr>
                <td>List of attachments</td>
              </tr>

            </table>
          </td>
        </tr>
      </table>

      