<?php
require('pdf_js.php');

class PDF_AutoPrint extends PDF_JavaScript
{

}

$pdf=new PDF_AutoPrint();
//$pdf->AddPage();
//$pdf->SetFont('Arial','',20);
//$pdf->Text(90, 50, 'Print me!');
//Open the print dialog
$pdf->AutoPrint(true);
$pdf->Output();
?>
