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
	}

	$pdf = new mPDF('','A4');

	$stylesheet = file_get_contents('../css/pdfStylesheet.css');
	$pdf->WriteHTML($stylesheet,1);

	$html_header=('<table><tr><td style="width:40%;"><img class="logo" src="../images/logo.png"></td><td></td><td style="width:40%; text-align:right;">VerdeMar - Gestão Imobiliária<br>Rua da Tecnologia, Epsilon 1k,<br>Tecnoparque da Lagoa, Lagoa, Açores<br>+135 565 567 756<br>verdemar@mail.com</td></tr></table><hr>');
	$pdf->setAutoTopMargin='stretch';
	$pdf->setHTMLHeader($html_header);


	$pdf->SetFooter(''.date("d-m-Y").'||Pág. {PAGENO}');
	$pdf->WriteHTML('<h1>GESTOR | REF:'.$id.' - '.$firstName.' '.$lastName.'</h1>');

	$pdf->WriteHTML('<h2>Informações Pessoais:</h2>');
	$pdf->WriteHTML('<table class="personalInfo"><tr><td><b>ID:</b></td><td>'.$id.'</td></tr><tr><td><b>NOME:</b></td><td>'.$firstName.' '.$lastName.'</td></tr><tr><td><b>EMAIL:</b></td><td>'.$email.'</td></tr><tr><td><b>CONTACTO:</b></td><td>'.$phone.'</td></tr></table>');

	$pdf->WriteHTML('<br><br><h2>Visitas:</h2>');
	$pdf->WriteHTML(''.$visit->getManagerVisitsPdf($id).'');	

	$filename = $firstName."_".$lastName."_manager_info_".date('d_m_Y').".pdf";
	$content = $pdf->Output($filename,'D');
?>