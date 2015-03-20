<?php 
namespace App\Http\Controllers\Tenant\Pdf;
use App\Http\Controllers\Tenant\BaseController;
use TCPDF;
use FB;
use Session;
use RecursiveIteratorIterator;

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
			    h1 {
			        color: navy;
			        font-family: times;
			        font-size: 24pt;
			        text-decoration: underline;
			    }
			    p.first {
			        color: #003300;
			        font-family: helvetica;
			        font-size: 12pt;
			    }
			    p.first span {
			        color: #006600;
			        font-style: italic;
			    }
			    p#second {
			        color: rgb(00,63,127);
			        font-family: times;
			        font-size: 12pt;
			        text-align: justify;
			    }
			    p#second > span {
			        background-color: #FFFFAA;
			    }
			    table.first {
			        color: #003300;
			        font-family: helvetica;
			        font-size: 8pt;
			        border-collapse: collapse;
			        
			    }
			    tr{
			      height: 40pt;


			    }
			   
			    div.test {
			        color: #CC0000;
			        background-color: #FFFF66;
			        font-family: helvetica;
			        font-size: 10pt;
			        border-style: solid solid solid solid;
			        border-width: 2px 2px 2px 2px;
			        border-color: green #FF00FF blue red;
			        text-align: center;
			    }
			    .lowercase {
			        text-transform: lowercase;
			    }
			    .uppercase {
			        text-transform: uppercase;
			    }
			    .capitalize {
			        text-transform: capitalize;
			    }
			</style>




			<table class="first">
			 <tr cols="4" bgcolor="#FFFF00">
			   <td height="4">
			      Kvittering
			      <br/>
			      <span style="margin-left:500px;">
			      Innbetalt till konto
			      <br/>
			      60050625977
			    </span>
			   </td>
			   <td></td>
			   <td>dfd</td>
			   <td>dfdf</td>
			  
			 </tr>
			 <tr >
			  <td colspan="2">dfdfd</td>
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
			    h1 {
			        color: navy;
			        font-family: times;
			        font-size: 24pt;
			        text-decoration: underline;
			    }
			    p.first {
			        color: #003300;
			        font-family: helvetica;
			        font-size: 12pt;
			    }
			    p.first span {
			        color: #006600;
			        font-style: italic;
			    }
			    p#second {
			        color: rgb(00,63,127);
			        font-family: times;
			        font-size: 12pt;
			        text-align: justify;
			    }
			    p#second > span {
			        background-color: #FFFFAA;
			    }
			    table.first {
			        color: #003300;
			        font-family: helvetica;
			        font-size: 8pt;
			        border-collapse: collapse;
			        
			    }
			    tr{
			      height: 40pt;


			    }
			   
			    div.test {
			        color: #CC0000;
			        background-color: #FFFF66;
			        font-family: helvetica;
			        font-size: 10pt;
			        border-style: solid solid solid solid;
			        border-width: 2px 2px 2px 2px;
			        border-color: green #FF00FF blue red;
			        text-align: center;
			    }
			    .lowercase {
			        text-transform: lowercase;
			    }
			    .uppercase {
			        text-transform: uppercase;
			    }
			    .capitalize {
			        text-transform: capitalize;
			    }
			</style>




			<table class="first">
			 <tr cols="4" bgcolor="#FFFF00">
			   <td height="4">
			      Kvittering
			      <br/>
			      <span style="margin-left:500px;">
			      Innbetalt till konto
			      <br/>
			      60050625977
			    </span>
			   </td>
			   <td></td>
			   <td>dfd</td>
			   <td>dfdf</td>
			  
			 </tr>
			 <tr >
			  <td colspan="2">dfdfd</td>
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
					$this->DeleteFileOrFolder($path);
				}
			}

			return \Response::json(array('status'=>'true'));
		} else {
			return \Response::json(array('status'=>'false'));
		}
     }


     function DeleteFileOrFolder($path)
		{
		    if (is_dir($path) === true)
		    {
		        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);

		        foreach ($files as $file)
		        {
		            if (in_array($file->getBasename(), array('.', '..')) !== true)
		            {
		                if ($file->isDir() === true)
		                {
		                    rmdir($file->getPathName());
		                }

		                else if (($file->isFile() === true) || ($file->isLink() === true))
		                {
		                    unlink($file->getPathname());
		                }
		            }
		        }

		        return rmdir($path);
		    }

		    else if ((is_file($path) === true) || (is_link($path) === true))
		    {
		        return unlink($path);
		    }

		    return false;
		}



     


    

}