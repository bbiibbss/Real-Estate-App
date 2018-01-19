<?php
	require_once'../vendor/pdf/mpdf.php';
	require_once'visitClass.php';
	$visit= new VISIT();

	if(isset($_POST["submitUserDetails"])){
		$id=$_POST["id"];
		$firstName=$_POST["firstName"];
		$lastName=$_POST["lastName"];
		$email=$_POST["email"];
		$phone=$_POST["phone"];

		$parishes = str_replace('</br>', '<br>', $_POST["parishes"]);
		$businessTypes = str_replace('</br>', '<br>', $_POST["businessTypes"]);
		$propertyTypes = str_replace('</br>', '<br>', $_POST["propertyTypes"]);
		$propertyTypologies = str_replace('</br>', '<br>', $_POST["propertyTypologies"]);
		$maxValue=$_POST["maxValue"];
		$minValue=$_POST["minValue"];
	}

	$pdf = new mPDF();
	$stylesheet = file_get_contents('../css/pdfStylesheet.css');
	$pdf->WriteHTML($stylesheet,1);

	$html_header=('<table><tr><td style="width:40%;"><img class="logo" src="../images/logo.png"></td><td></td><td style="width:40%; text-align:right;">VerdeMar - Gestão Imobiliária<br>Rua da Tecnologia, Epsilon 1k,<br>Tecnoparque da Lagoa, Lagoa, Açores<br>+135 565 567 756<br>verdemar@mail.com</td></tr></table><hr>');
	$pdf->setAutoTopMargin='stretch';
	$pdf->setHTMLHeader($html_header);
	
	$pdf->WriteHTML('<br><br><br><br><h1>VISITAS</h1><br>');

	$pdf->WriteHTML(''.$visit->getAllVisitsPdf().'');
	
	$pdf->SetFooter('Pág. {PAGENO}');
	
	$filename = "visits_".date('d-m-Y').".pdf";

	$content = $pdf->Output($filename,'D');
?>