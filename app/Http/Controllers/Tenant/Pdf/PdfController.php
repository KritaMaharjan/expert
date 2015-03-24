<?php 
namespace App\Http\Controllers\Tenant\Pdf;
use App\Http\Controllers\Tenant\BaseController;
use TCPDF;
use FB;
use Session;


class PdfController extends BaseController {

	public function index()
    {
    	
    	return view('tenant.pdf.pdf');
    }

    public function create_pdf(){

    	
		/**
		 * Creates an example PDF TEST document using TCPDF
		 * @package com.tecnick.tcpdf
		 * @abstract TCPDF - Example: XHTML + CSS
		 * @author PRADEEP BISTA
		 * @since 2010-05-25
		 */

		// Include the main TCPDF library (search for installation path).
		

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('AuthorName');
		$pdf->SetTitle('Title of pdf');
		$pdf->SetSubject('Subject');
		$pdf->SetKeywords('kewords');
        
		
		$header_logo = PDF_HEADER_LOGO;
		$header_logo_width = PDF_HEADER_LOGO_WIDTH;
		$header_tittle = 'Invoice';
		$header_string ='mashbooks.app';
		// set default header data
		$pdf->SetHeaderData($header_logo, $header_logo_width, $header_tittle, $header_string);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setCellHeightRatio(1.5);
		$pdf->SetCellPadding(3);

		// set some language-dependent strings (optional)
		/*if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
		    $pdf->setLanguageArray($l);
		}
*/
		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', '', 10);

		// add a page
		$pdf->AddPage();

		/* NOTE:
		 * *********************************************************
		 * You can load external XHTML using :
		 *
		 * $html = file_get_contents('/path/to/your/file.html');
		 *
		 * External CSS files will be automatically loaded.
		 * Sometimes you need to fix the path of the external CSS.
		 * *********************************************************
		 */

		// define some HTML content with style

		
    
	   // $html= file_get_contents(base_path('resources/views/tenant/pdf/pdf.html'));
	    $html = '
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
         	<tr bgcolor="#FFFF00"  style="line-height:.5;"><td colspan="4" style="padding:20px;"><h1>Kvittering</h1></td></tr>
			<tr bgcolor="#FFFF00">
				<th>Innbetalt till konto</th>
			   	<th style="font-size:11px;">Belop</th>
			    <th style="font-size:11px;">Betalerens kontonummer</th>
			    <th style="font-size:11px;">Blankettnr</th>			   			  
			</tr>
			<tr bgcolor="#FFFF00">
				<td>60050625977</td>
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
		</table>';
	 
	
	

		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

		// reset pointer to the last page
		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('invoce_005.pdf', 'I');
		
		//define path to download
		$path = base_path();
		
		$pdf->Output($path.'invoce_005.pdf', 'F');

		//============================================================+
		// END OF FILE
		//============================================================+
 
    }


     public function sendEmailPdf(){


     		/**
		 * Creates an example PDF TEST document using TCPDF
		 * @package com.tecnick.tcpdf
		 * @abstract TCPDF - Example: XHTML + CSS
		 * @author PRADEEP BISTA
		 * @since 2010-05-25
		 */

		// Include the main TCPDF library (search for installation path).
		

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('AuthorName');
		$pdf->SetTitle('Title of pdf');
		$pdf->SetSubject('Subject');
		$pdf->SetKeywords('kewords');
        
		
		$header_logo = PDF_HEADER_LOGO;
		$header_logo_width = PDF_HEADER_LOGO_WIDTH;
		$header_tittle = 'Invoice';
		$header_string ='mashbooks.app';
		// set default header data
		$pdf->SetHeaderData($header_logo, $header_logo_width, $header_tittle, $header_string);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		/*if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
		    $pdf->setLanguageArray($l);
		}
*/
		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', '', 10);

		// add a page
		$pdf->AddPage();

		/* NOTE:
		 * *********************************************************
		 * You can load external XHTML using :
		 *
		 * $html = file_get_contents('/path/to/your/file.html');
		 *
		 * External CSS files will be automatically loaded.
		 * Sometimes you need to fix the path of the external CSS.
		 * *********************************************************
		 */

		// define some HTML content with style

		$html = '
	    <style>
	    table {
			display: table;
		}
    	h1{
    		font-size:20px;
    		font-weight:600;
    		margin:0;
    	}	        
	    	
    	.border-block{border:1px solid #dbdbdb;line-height:2;}
		</style>


     	<table id="print" width="100%" cellpadding="10">
         	<tbody>
	         	<tr bgcolor="#FFFF00"  style="line-height:.5;"><td colspan="4"><h1>Kvittering</h1></td></tr>
				<tr bgcolor="#FFFF00" style="line-height:1.3;"><td>Innbetalt till konto					  	
			      		60050625977</td>
				   	<td style="font-size:11px;">Belop<p class="border-block" bgcolor="#ffffff"></p></td>
				    <td style="font-size:11px;">Betalerens kontonummer<p class="border-block" bgcolor="#ffffff"></p></td>
				    <td style="font-size:11px;">Blankettnr<p class="border-block" bgcolor="#ffffff"></p></td>			   			  
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
					<td colspan="2">dfdfd</td>				  
				</tr>
				
				<tr>
					<td colspan="2">dfdfd</td>
					<td colspan="2">dfdfd</td>				  
				</tr>
				
				<tr  bgcolor="#FFFF00">
				    <td colspan="2">dfdfd</td>
				    <td colspan="2">dfdfd</td>				  
				</tr>
			 </tbody>
		</table>';
	 
		
	
		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

		// reset pointer to the last page
		$pdf->lastPage();
		
		//define path to download
		$permissions = intval( config('permissions.directory'), 8 );
		$session = Session::getId();

		$path = storage_path('temp/'.$session);
   
		if (!file_exists($path)) {
		    mkdir($path, 0777, true);
		}
		
		
		$pdf->Output($path.'/'.'invoce_005.pdf', 'F');
		$email = 'pradip@alucio.com';
		$fullname = 'Pradip bista';
		$attatchments = [ $path.'/'.'invoce_005.pdf' ];
		$link = '';
		$no_link ='';


		 $mail = \FB::sendEmail($email, $fullname, 'forgot_password', ['{{RESET_URL}}' => $link, '{{DONT_RESET_URL}}' => $no_link, '{{ USERNAME }}' => $fullname, '{{ NAME }}' => $fullname],$attatchments);
		
		if($mail) 
		{
			if(!empty($attatchments))
			{
				foreach($attatchments as $attatchment) 
				{
					@unlink($attatchment);
				}
			}

			return \Response::json(array('status'=>'true'));
		} else {
			return \Response::json(array('status'=>'false'));
		}
     }


     



     


    

}