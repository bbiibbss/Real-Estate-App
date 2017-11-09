<?php
	require_once'../vendor/pdf/mpdf.php';

	require_once'visitClass.php';
	$visit= new VISIT();

	require_once'propertyClass.php';
	$property= new PROPERTY();

	$pdf = new mPDF("", "A4");
	$stylesheet = file_get_contents('../css/pdfStylesheet.css');
	$pdf->WriteHTML($stylesheet,1);

	$html_header=('<table><tr><td style="width:40%;"><img class="logo" src="../images/logo.png"></td><td></td><td style="width:40%; text-align:right;">VerdeMar - Gestão Imobiliária<br>Rua da Tecnologia, Epsilon 1k,<br>Tecnoparque da Lagoa, Lagoa, Açores<br>+135 565 567 756<br>verdemar@mail.com</td></tr></table><hr>');
	$pdf->setAutoTopMargin='stretch';
	$pdf->setHTMLHeader($html_header);
	
	$pdf->WriteHTML('<h1>Número de propriedades por concelho</h1><br>');

	$pdf->WriteHTML(''.$property->getPropertiesNumberByCountyPDF().'');

	$pdf->SetFooter('Pág. {PAGENO}');
	
	$filename = "properties_by_county_" . date('d-m-Y') . ".pdf";
	$content = $pdf->Output($filename,'D');
?>