<?php
use fpdi\fpdi;

require_once('src/tFPDF.php');
require_once('src/FPDF_TPL.php');
require_once('src/FPDF.php');
require_once('src/FPDI.php');
require_once('src/pdf_parser.php');
require_once('src/fpdi_pdf_parser.php');

$pdf = new FPDI();

$pdf->setSourceFile('kartaAnimatoraTemplate.pdf'); //zwraca liczbę stron w dokumencie 

$templateId = $pdf->importPage(1);  //zwraca id strony
$pdf->AddPage('L');
$pdf->useTemplate($templateId);

//USTAWIENIE CZCIONKI - folder font/unifont
$pdf->AddFont('Lato','','LatoRegular.ttf',true);
$pdf->SetFont('Lato','',12);

$pdf->Image('znak-roku-2017.jpg', 265, 2, 25, 0, 'JPG');

$pdf->SetXY(185,37);
$pdf->Write(7, 'JAN TECHNER');

$pdf->SetXY(216,43.8);
$pdf->Write(7, 'GRUNWALDZKA 37B/10');

$pdf->SetXY(175,50.6);
$pdf->Write(7, '60-783   POZNAŃ ');

$pdf->SetXY(173,57.4);
$pdf->Write(7, '667-657-441');

$pdf->SetXY(225,57.4);
$pdf->Write(7, 'jantechner@live.com');

//nowa strona 
$templateId = $pdf->importPage(2);
$pdf->AddPage('L');
$pdf->useTemplate($templateId);

//ONŻ I
$pdf->SetXY(9.5,19.7);
$pdf->Write(7, 'x');
//ONŻ II
$pdf->SetXY(9.5,24.4);
$pdf->Write(7, 'x');
//TRIDUUM
$pdf->SetXY(9.5,29.1);
$pdf->Write(7, 'x');
//ONŻ III
$pdf->SetXY(9.5,33.8);
$pdf->Write(7, 'x');

$pdf->SetFontSize(8);

//ROK - ONŻ I
$pdf->SetXY(35,19.4);
$pdf->Write(7, '2012');

//ROK - ONŻ II
$pdf->SetXY(37,24.1);
$pdf->Write(7, '2013');

$downloadName = 'JAN'.'_'.'TECHNER'.'_'.'karta.pdf';

$pdf->Output($downloadName, 'D', true);

//POBIERANIE WSZYSTKICH STRON PDF
// $pageCount = $pdf->setSourceFile('template.pdf');
// for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
//     $templateId = $pdf->importPage($pageNo);
//     //$size = $pdf->getTemplateSize($templateId);
//     $pdf->AddPage('L');
//     $pdf->useTemplate($templateId);
// }
?>