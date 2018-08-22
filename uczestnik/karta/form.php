<?php
	session_start();
	require_once "../update_session.php";

	use fpdi\fpdi;
	require_once('src/tFPDF.php');
	require_once('src/FPDF_TPL.php');
	require_once('src/FPDF.php');
	require_once('src/FPDI.php');
	require_once('src/pdf_parser.php');
	require_once('src/fpdi_pdf_parser.php');

	$pdf = new FPDI();

	$pdf->setSourceFile('kartaUczestnikaTemplate.pdf'); //zwraca liczbę stron w dokumencie 

	$templateId = $pdf->importPage(1);  //zwraca id strony
	$pdf->AddPage('L');
	$pdf->useTemplate($templateId);

	$pdf->AddFont('Lato','','LatoRegular.ttf',true);
	$pdf->AddFont('Cardiff','','cardif_b.ttf',true);
	
	$pdf->Image('znak-roku-2017.jpg', 264, 3, 23, 0, 'JPG');

	$pdf->SetFont('Cardiff','',12);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetXY(249.8, 17.6);
	$pdf->Cell(10.5 ,5,'2018',0,0,'L', true);
	
	$pdf->SetXY(191, 31);
	$pdf->Cell(80 ,6,'',0,0,'L', true);
	$pdf->SetXY(221, 99);
	$pdf->Cell(55 ,6,'',0,0,'L', true);

	$pdf->SetFont('Lato','',12);

//######################################################################

	function set_text ($axis_x, $axis_y, $current_size, $max_width, $text, $mode) {
		global $pdf;
		$pdf->SetFontSize($current_size);

		while($pdf->GetStringWidth($text) > $max_width) {
			$current_size -= 0.1;
			$axis_y += 0.01;
			$pdf->SetFontSize($current_size);
		}

		$pdf->SetXY($axis_x, $axis_y);

		if ($mode == 0) $pdf->Write(7, $text);
		elseif ($mode == 1) $pdf->Cell($max_width + 2, 6, $text, 1, 0, 'L');
		else $pdf->Cell(129, 6, $text, 0, 0, 'C');	
	}

//######################################################################

	if ($_SESSION['second_name'])
		$second_name = $_SESSION['second_name'].'  ';
	else 
		$second_name = '';
	$pdf->SetXY(185,37.4);
	$pdf->Write(7, mb_strtoupper($_SESSION['name'].'  '.$second_name.$_SESSION['surname'], 'UTF-8'));

//######################################################################

	set_text(212, 44.1, 12, 71, mb_strtoupper($_SESSION['address_street'], 'UTF-8'), 0);

//######################################################################

	$address = mb_strtoupper($_SESSION['address_postcode'].'    '.$_SESSION['address_city'], 'UTF-8');
	set_text(156, 51.3, 12, 126, $address, 2);

//######################################################################

	$pdf->SetFontSize(12);
	$pdf->SetXY(173,57.4);
	$pdf->Write(7, substr(chunk_split($_SESSION['phone_number'], 3, '-'), 0, 11));

//######################################################################

	set_text(223, 57.5, 12, 60, $_SESSION['email'], 0);

//######################################################################

	$pdf->SetFontSize(12);
	if($_SESSION['birth_month'] <10) $month = '0'.$_SESSION['birth_month'];
	else $month = $_SESSION['birth_month'];
	$pdf->SetXY(180,63.9);
	$pdf->Write(7, $_SESSION['birth_day'].'.'.$month.'.'.$_SESSION['birth_year'].'r.');

//######################################################################

	if($_SESSION['nameday_month'] <10) $name_month = '0'.$_SESSION['nameday_month'];
	else $name_month = $_SESSION['nameday_month'];
	$pdf->SetXY(235,63.9);
	$pdf->Write(7, $_SESSION['nameday_day'].'.'.$name_month);

//######################################################################

	$pesel = str_split($_SESSION['pesel']);
	$pdf->SetXY(167.8,72.2);
	$pdf->Write(7, $pesel[0]);
	$pdf->SetXY(173.4,72.2);
	$pdf->Write(7, $pesel[1]);
	$pdf->SetXY(179,72.2);
	$pdf->Write(7, $pesel[2]);
	$pdf->SetXY(184.6,72.2);
	$pdf->Write(7, $pesel[3]);
	$pdf->SetXY(190.3,72.2);
	$pdf->Write(7, $pesel[4]);
	$pdf->SetXY(195.9,72.2);
	$pdf->Write(7, $pesel[5]);
	$pdf->SetXY(201.5,72.2);
	$pdf->Write(7, $pesel[6]);
	$pdf->SetXY(207.2,72.2);
	$pdf->Write(7, $pesel[7]);
	$pdf->SetXY(212.8,72.2);
	$pdf->Write(7, $pesel[8]);
	$pdf->SetXY(218.5,72.2);
	$pdf->Write(7, $pesel[9]);
	$pdf->SetXY(224.1,72.2);
	$pdf->Write(7, $pesel[10]);

//######################################################################

	$pdf->SetFontSize(10);
	$pdf->SetXY(182.2,78.7);
	$pdf->Write(7, $_SESSION['after_class']);

//######################################################################

	set_text(215.5, 78.7, 10, 69, $_SESSION['school'], 0);

//######################################################################

	set_text(172, 84.7, 10, 68, $_SESSION['parish'], 0);

//######################################################################

	set_text(258.5, 84.7, 10, 25, $_SESSION['diocese'], 0);
	
//######################################################################

	set_text(183, 90.6, 12, 100, $_SESSION['oaza_parish'], 0);

//######################################################################	

	function formation($xaxis_x, $xaxis_y, $axis_x, $axis_y, $session_var, $size1, $size2) {
		global $pdf;
		$pdf->SetXY($xaxis_x, $xaxis_y);
		$pdf->Write(7, 'x');

		$pdf->SetFontSize($size1);
		$pdf->SetXY($axis_x, $axis_y);
		$pdf->Write(7, $session_var);
		$pdf->SetFontSize($size2);
	}


	$pdf->SetFontSize(12);
	if($_SESSION['odb1']) { $pdf->SetXY(162.8,110.9); $pdf->Write(7, 'x'); }

	if($_SESSION['odb2']) { $pdf->SetXY(173.5,110.9); $pdf->Write(7, 'x'); }

	if($_SESSION['odb3']) { $pdf->SetXY(184.5,110.9); $pdf->Write(7, 'x'); }

	if($_SESSION['ond1'])
		formation(209.5, 110.9, 223.3, 110.7, $_SESSION['ond1_year'], 8, 12);

	if($_SESSION['ond2'])
		formation(232.6, 110.9, 248, 110.7, $_SESSION['ond2_year'], 8, 12);

	if($_SESSION['ond3'])
		formation(256.9, 110.9, 274, 110.7, $_SESSION['ond3_year'], 8, 12);

	if($_SESSION['onz1'])
		formation(162.6, 116.5, 177.5, 116.3, $_SESSION['onz1_year'], 8, 12);

	if($_SESSION['onz1bis'])
		formation(186.65, 116.5, 206.5, 116.3, $_SESSION['onz1bis_year'], 8, 12);

	if($_SESSION['deuter'])
		formation(214.8, 116.5, 278, 116.3, $_SESSION['deuter_year'], 8, 12);


	$pdf->SetFontSize(10);
	if($_SESSION['rek_ew']) { $pdf->SetXY(155.7,126.7); $pdf->Write(7, 'x'); }

	if($_SESSION['lk4']) { $pdf->SetXY(207.4,126.6); $pdf->Write(7, 'x'); }

	if($_SESSION['j8']) { $pdf->SetXY(246.6,126.6); $pdf->Write(7, 'x'); }

	if($_SESSION['erz']) { $pdf->SetXY(155.7,131.7); $pdf->Write(7, 'x'); }

	if($_SESSION['dnz']) { $pdf->SetXY(228.2,131.7); $pdf->Write(7, 'x'); }

	if($_SESSION['kkdc'])
		formation(155.7, 136.5, 224, 136.1, $_SESSION['kkdc_amt'], 8, 10);

	if($_SESSION['dw'])
		formation(206.1, 141.2, 241, 140.7, $_SESSION['dw_amt'], 8, 10);

	if($_SESSION['om'])
		formation(247.6, 141.2, 282.5, 140.7, $_SESSION['om_amt'], 8, 10);

	if($_SESSION['kwc_cz'])
		formation(205.65, 145.8, 228.5, 145.4, $_SESSION['kwc_cz_year'], 8, 10);

	if($_SESSION['kwc_k']) { $pdf->SetXY(239.1,145.8); $pdf->Write(7, 'x'); }

	if($_SESSION['kwc_not']) { $pdf->SetXY(261.6,145.8); $pdf->Write(7, 'x'); }

//######################################################################

	//nowa strona 
	$templateId = $pdf->importPage(2);
	$pdf->AddPage('L');
	$pdf->useTemplate($templateId);

	$downloadName = $_SESSION['name'].'_'.$_SESSION['surname'].'_'.'karta.pdf';

	//$pdf->Output($downloadName, 'D', true);
	$pdf->Output();
	//POBIERANIE WSZYSTKICH STRON PDF
	// $pageCount = $pdf->setSourceFile('template.pdf');
	// for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
	//     $templateId = $pdf->importPage($pageNo);
	//     //$size = $pdf->getTemplateSize($templateId);
	//     $pdf->AddPage('L');
	//     $pdf->useTemplate($templateId);
// }
?>