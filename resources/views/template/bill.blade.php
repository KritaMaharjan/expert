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
     
  </style>


      <table id="print" width="100%">
          <tr bgcolor="#FFFF00"  style="line-height:.5;"><td colspan="4"><h1>Kvittering</h1></td></tr>
   <tr bgcolor="#FFFF00">
    <th>Innbetalt till konto</th>
       <th style="font-size:11px;">Belop</th>
       <th style="font-size:11px;">Betalerens kontonummer</th>
       <th style="font-size:11px;">Blankettnr</th>           
   </tr>
   <tr bgcolor="#FFFF00">
    <td>{{$data}}</td>
    <td><p class="border-block" bgcolor="#ffffff"></p></td>
    <td><p class="border-block" bgcolor="#ffffff"></p></td>
    <td><p class="border-block" bgcolor="#ffffff"></p></td>
   </tr>
   <tr>
    <td colspan="2">
     <table>
      <tbody>
       <tr><td colspan="2" style="font-size:11px;">Betalingsinformasjon</td></tr>
       <br />
       <tr>
        <td style="text-indent:15px;">Kundenr:</td>
        <td>4785007</td>
       </tr>
       <tr>
        <td style="text-indent:15px;">Fakturanr:</td>
        <td>4785007</td>
       </tr>
       <tr>
        <td style="text-indent:15px;">Fakturadato:</td>
        <td>4785007</td>
       </tr>
      </tbody>
     </table>
    </td>
    <td colspan="2">
     <table>
      <tbody>
       <tr><td style="font-size:13px;">GIRO</td>
        <td style="font-size:11px;">Betalings-first</td>
        <td><p class="border-block" bgcolor="#ffffff"></p></td>
       </tr>
       <br />
       <tr>
        <td style="font-size:11px;" colspan="3">Underskrift ved girering</td>         
       </tr>
       <tr style="margin-top:10px;">
        <td colspan="3">
         <p class="fix-size"></p>
        </td>         
       </tr>       
      </tbody>
     </table>
    </td>      
   </tr>
   
   <tr>         
    <td colspan="2"><p style="font-size:11px;">Betalt av</p>
     <table class="border" cellpadding="2">
      <tbody>       
       <tr>
        <td style="text-indent:15px;">Andreas Bratholmen</td>
       </tr>
       <tr>
        <td style="text-indent:15px;">Helleveien 199</td>
       </tr>
       <tr>
        <td style="text-indent:15px;">5039 Bergen</td>
       </tr>
       

      </tbody>
     </table>
    </td>
    <td colspan="2"><p style="font-size:11px;">Betalt til</p>
     <table class="border" cellpadding="2">
      <tbody>       
       <tr>
        <td style="text-indent:15px;">Telio Telecom AS</td>
       </tr>
       <tr>
        <td style="text-indent:15px;">Pb.54 Skoyen</td>
       </tr>
       <tr>
        <td style="text-indent:15px;">0212 Oslo</td>
       </tr>
       

      </tbody>
     </table>
    </td>      
   </tr>
   
   <tr  bgcolor="#FFFF00">
       <td colspan="2">dfdfd</td>
       <td colspan="2">dfdfd</td>      
   </tr>
  </table>