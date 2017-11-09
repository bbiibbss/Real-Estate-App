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
	
	$pdf->WriteHTML('<br><br><br><br><h1>Ficha de cliente | REF:'.$id.'</h1><br>');

	$pdf->WriteHTML('<h2>Informações Pessoais:</h2>');
	$pdf->WriteHTML('<table class="personalInfo"><tr><td><b>ID:</b></td><td>'.$id.'</td></tr><tr><td><b>NOME:</b></td><td>'.$firstName.' '.$lastName.'</td></tr><tr><td><b>EMAIL:</b></td><td>'.$email.'</td></tr><tr><td><b>CONTACTO:</b></td><td>'.$phone.'</td></tr></table>');
	
	$pdf->WriteHTML('<br><br><br><h2>Preferências:</h2>');

	$pdf->WriteHTML('<table class="personalInfo"><tr><td><b>TIPOS DE NEGÓCIO:</b></td><td>'.$businessTypes.'</td></tr><tr><td><b>TIPOS DE PROPRIEDADE:</b></td><td>'.$propertyTypes.'</td></tr><tr><td><b>TIPOLOGIAS DE PROPRIEDADE:</b></td><td>'.$propertyTypologies.'</td></tr><tr><td><b>LOCALIDADES:</b></td><td>'.$parishes.'</td></tr><tr><td><b>VALOR MÍNIMO:</b></td><td>'.$minValue.'</td></tr><tr><td><b>VALOR MÁXIMO:</b></td><td>'.$maxValue.'</td></tr></table>');
	
	$pdf->SetFooter('Pág. {PAGENO}');
	
	$pdf->addPage();
	$pdf->WriteHTML('<br><br><br><h2>Visitas:</h2>');

	$pdf->WriteHTML(''.$visit->getVisitPdf($id).'');
	
	$filename = $firstName."_".$lastName."_client_info_".date('d_m_Y').".pdf";
	$content = $pdf->Output($filename,'D');
?>