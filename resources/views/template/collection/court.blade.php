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
          <td colspan="3">{!! (isset($data['company_details']['logo']) && file_exists(tenant()->folder('system')->url($data['company_details']['logo'])) )? '<img src ="'.tenant()->folder('system')->url($data['company_details']['logo']).' "/>' : "" !!}</td>
        </tr>
        <tr>
          <td width="60%"></td>
          <td width="40%">
              <table>
                <tr>
                  <td><p><strong>Date:</strong> {{ date('d-m-y') }}<br />
                         <strong>Org.nr:</strong> {{ $data['company_details']['company_number'] }}<br />
                         <strong>Telefon:</strong> {{ $data['company_details']['telephone'] }}<br />
                         <strong>Kontonummer:</strong> Account number<br />
                         <strong>Saksbehandler:</strong> Username
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
          <td><p>Name of court<br />
                 Street address<br />
                 Town and postal code</p>
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
          <td align="center"><h1 class="uppercase"><b>Begjæring om forliksklage</b></h1></td>              
        </tr>
        <tr>
          <td align="center">Tvisteloven §6-3</td>
        </tr><br /><br />
        <tr>
          <td>
            <table>              
              <tr>
                <td>Kravet gjelder: </td>
              </tr>
              <tr>
                <td>Hovedstol faktura: {{ $data['invoice_number'] }} </td>
              </tr>
              <tr>
                <td>Renter: 9,50% ifraBILL {{ $data['due_date'] }} til betaling finner sted</td>
              </tr>
              <tr>
                <td>Purregebyr: Fees,- {{ $data['remaining'] }}</td>
              </tr>
              <tr>
                <td>Skriving av denne begjæring: 860,-</td>
              </tr>
              <tr>
                <td>Rettsgebyr Forliksklage: 860,-</td>
              </tr>
              <tr>
                <td>Møtegebyr: 430</td>
              </tr>
              <tr>
                <td><b>Total:</b> {{ $data['amount'] }} {{ $data['currency'] }} + renter</td>
              </tr><br /><br /><br />
              <tr>
                <td><b>Saksøker:</b> {{ $data['company_details']['company_name'] }}, {{ $data['company_details']['address'] }}</td>
              </tr><br /><br />
              <tr>
                <td><b>Saksøkte:</b> {{ $data['customer'] }}, {{ $data['customer_details']['street_name'] }} {{ $data['customer_details']['street_number'] }}</td>
              </tr><br /><br /><br />
              <tr>
                <td>Det innleveres herved en Forliksklage framot {{ $data['customer'] }}.</td>
              </tr><br /><br /><br />
              <tr>
                <td>Det legges ned påstand om følgende:</td>
              </tr>
              <tr>
                <td>Saksøkt dømmes innen 14 dager å betale .<b>følgende:</b> </td>
              </tr><br /><br />
              <tr>
                <td>Hovedstol faktura: {{ $data['invoice_number'] }}</td>
              </tr>
              <tr>
                <td>Renter: 9,50% ifra  til betaling finner sted</td>
              </tr>
              <tr>
                <td>Purregebyr: {{ $data['remaining'] }} {{ $data['currency'] }}</td>
              </tr>
              <tr>
                <td>Skriving av denne Begjæring: 860</td>
              </tr>
              <tr>
                <td>Rettsgebyr Forliksklage: 860</td>
              </tr>
              <tr>
                <td>Møtegebyr: 430</td>
              </tr>
              <tr>
                <td>Total: {{ $data['amount'] }} {{ $data['currency'] }} + renter</td>
              </tr>
              <tr>
                <td>Kort redegjørelse:</td>
              </tr><br /><br />
              <tr>
                <td>User defined text inserted here</td>
              </tr><br /><br /><br /><br />
              <tr>
                <td>Vi ber om å bli underettet om når Forliksmøtet avholdes.<br /> Dersom vilkårene er tilstede eller innklagede uteblir kreves avsagt uteblivelsesdom.</td>
              </tr><br /><br /><br />
              <tr>
                <td>Med hilsen for,</td>
              </tr><br /><br /><br /><br />
              <tr>
                <td>Business name</td>
              </tr><br /><br />
              <tr>
                <td>Vedlegg:</td>
              </tr>
              <tr>
                <td>List of attachments</td>
              </tr>

            </table>
          </td>
        </tr>
      </table>

      