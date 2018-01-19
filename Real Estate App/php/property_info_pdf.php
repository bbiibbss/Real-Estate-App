<?php
	require_once'../vendor/pdf/mpdf.php';
	require_once'visitClass.php';
	$visit= new VISIT();

	if(isset($_POST["submitUserDetails"])){
		$id=$_POST["id"];
		$name=$_POST["name"];
    	$description=$_POST["description"];
    	$photo=$_POST["photo"];
		$propertyType=$_POST["propertyType"];
		$propertyTypology=$_POST["propertyTypology"];
		$parish=$_POST["parish"];
		$address=$_POST["address"];
		$area=$_POST["area"];
		$bedrooms=$_POST["bedrooms"];
		$bathrooms=$_POST["bathrooms"];
		$latitude=$_POST["latitude"];
		$longitude=$_POST["longitude"];
		$businessType=$_POST["businessType"];
		$price=$_POST["price"];
		$manager=$_POST["manager"];
		$propertyStatus=$_POST["propertyStatus"];
	}

	$pdf = new mPDF();
	$stylesheet = file_get_contents('../css/pdfStylesheet.css');
	$pdf->WriteHTML($stylesheet,1);

	$html_header=('<table><tr><td style="width:40%;"><img class="logo" src="../images/logo.png"></td><td></td><td style="width:40%; text-align:right;">VerdeMar - Gestão Imobiliária<br>Rua da Tecnologia, Epsilon 1k,<br>Tecnoparque da Lagoa, Lagoa, Açores<br>+135 565 567 756<br>verdemar@mail.com</td></tr></table><hr>');
	$pdf->setAutoTopMargin='stretch';
	$pdf->setHTMLHeader($html_header);
	
	$pdf->WriteHTML('<br><br><br><br><h1>Ficha de propriedade | REF:'.$id.'</h1><br>');

	$pdf->WriteHTML('<table>
	<tr><td><h4>FOTOGRAFIA:</h4></td><td><img src="'.$photo.'"></td></tr>
	<tr><td><h4>ID:</h4></td><td>'.$id.'</td></tr>
	<tr><td><h4>NOME:</h4></td><td>'.$name.'</td></tr>
	<tr><td><h4>DESCRIÇÃO:</h4></td><td>'.$description.'</td></tr>
	<tr><td><h4>TIPO:</h4></td><td>'.$propertyType.'</td></tr>
	<tr><td><h4>TIPOLOGIA:</h4></td><td>'.$propertyTypology.'</td></tr>
	<tr><td><h4>LOCALIDADE:</h4></td><td>'.$parish.'</td></tr>
	<tr><td><h4>MORADA:</h4></td><td>'.$address.'</td></tr>
	<tr><td><h4>ÁREA:</h4></td><td>'.$area.' m<sup>2</sup></td></tr>
	<tr><td><h4>QUARTOS:</h4></td><td>'.$bedrooms.'</td></tr>
	<tr><td><h4>CASAS DE BANHO:</h4></td><td>'.$bathrooms.'</td></tr>
	<tr><td><h4>LATITUDE:</h4></td><td>'.$latitude.'</td></tr>
	<tr><td><h4>LONGITUDE:</h4></td><td>'.$longitude.'</td></tr>
	<tr><td><h4>TIPO DE NEGÓCIO:</h4></td><td>'.$businessType.'</td></tr>
	<tr><td><h4>PREÇO:</h4></td><td>'.$price.' ‎€</td></tr>
	<tr><td><h4>GESTOR RESPONSÀVEL:</h4></td><td>'.$manager.'</td></tr>
	<tr><td><h4>ESTADO:</h4></td><td>'.$propertyStatus.'</td></tr>
</table>');

	$pdf->SetFooter('Pág. {PAGENO}');
	
	$filename = "property_info_".$name."_".date('d-m-Y').".pdf";
	$content = $pdf->Output($filename,'D');
?>