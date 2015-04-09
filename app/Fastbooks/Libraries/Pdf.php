<?php namespace App\Fastbooks\Libraries;

use TCPDF;

class Pdf {

    public $pdf;

    public $uploadPath;

    function __construct()
    {
        $this->uploadPath = public_path().'/' .tenant()->folder('invoice', true)->path();
        //$this->uploadPath = public_path() . '/assets/uploads/invoices/';
        $this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $this->setInfo();
        $this->setMargin();
    }

    function setInfo()
    {
        // set document information
        $this->pdf->SetCreator(PDF_CREATOR);
        $this->pdf->SetAuthor('Nicola Asuni');
        $this->pdf->SetTitle('TCPDF Example 002');
        $this->pdf->SetSubject('TCPDF Tutorial');
        $this->pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    }

    function setMargin()
    {
        // remove default header/footer
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);

        // set default monospaced font
        //  $this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $this->pdf->SetMargins($left = 5, $top = 5, $right = 5);

        // set auto page breaks
        $this->pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $this->pdf->setLanguageArray($l);
        }


        // set default font subsetting mode
        $this->pdf->setFontSubsetting(true);

        // Set font
        $this->pdf->SetFont('helvetica', '', 10, '', true);

        // add a page
        $this->pdf->AddPage();

    }

    public function generate($filename = '', $view, array $data = array(), $download = false, $save = false)
    {
        // set some text to print
        $html = view($view, $data);

        // print a block of text using Write()
        $this->pdf->writeHTML($html, true, false, true, false, '');
        // ---------------------------------------------------------
        //save PDF
        if ($save)
        {
            ob_clean();
            $this->pdf->Output($this->uploadPath . $filename . '.pdf', 'F');
            return $this->uploadPath.$filename.'.pdf';
        }

        //Close and output PDF document
        if ($download)
            $this->pdf->Output($filename . '.pdf', 'D');
        else
            $this->pdf->Output($this->uploadPath . $filename . '.pdf', 'I');
        return true;
    }

}