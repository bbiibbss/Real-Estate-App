<?php
	
	require_once'../vendor/pdf/mpdf.php';


	if(isset($_POST["getManagerPDF"])){
		$id = $_POST['id'];
		$name = $_POST['name'];
		$jan = $_POST['Jan'];
	    $fev = $_POST['Feb'];
		$mar = $_POST['Mar'];
	   	$abr= $_POST['Apr'];
	   	$mai = $_POST['May'];
		$jun = $_POST['Jun'];
	   	$jul = $_POST['Jul'];
	   	$ago= $_POST['Aug'];
	    $set = $_POST['Sep'];
		$out= $_POST['Oct'];
	   	$nov = $_POST['Nov'];
	   	$dez = $_POST['Dec'];
		$total = $_POST['year'];
	}
	$year=date("Y");

	$pdf = new mPDF('c', 'A4-L');
	$stylesheet = file_get_contents('../css/pdfStylesheet.css');
	$pdf->WriteHTML($stylesheet,1);
	
	$html_header=('<table><tr><td style="width:40%;"><img class="logo" src="../images/logo.png"></td><td></td><td style="width:40%; text-align:right;">VerdeMar - Gestão Imobiliária<br>Rua da Tecnologia, Epsilon 1k,<br>Tecnoparque da Lagoa, Lagoa, Açores<br>+135 565 567 756<br>verdemar@mail.com</td></tr></table><hr>');
	$pdf->setAutoTopMargin='stretch';
	$pdf->setHTMLHeader($html_header);

	$pdf->WriteHTML('<h2> ID: '.$id.' || '.$name.'</h2>');
	
	$pdf->WriteHTML('<br><h3>Vendas em '.$year.'</h3>');

	$pdf->WriteHTML("<table style='width:100%; text-align:center;'>
						<tr>
							<th>Jan</th>
							<th>Fev</th>
							<th>Mar</th>
							<th>Abr</th>
							<th>Mai</th>
							<th>Jun</th>
							<th>Jul</th>
							<th>Ago</th>
							<th>Set</th>
							<th>Out</th>
							<th>Nov</th>
							<th>Dez</th>
							<th>".$year."</th>
						</tr>
						<tr>
							<td>".$jan." €</td>
							<td>".$fev." €</td>
							<td>".$mar." €</td>
							<td>".$abr." €</td>
							<td>".$mai." €</td>
							<td>".$jun." €</td>
							<td>".$jul." €</td>
							<td>".$ago." €</td>
							<td>".$set." €</td>
							<td>".$out." €</td>
							<td>".$nov." €</td>
							<td>".$dez." €</td>
							<td>".$total." €</td>
						</tr>
					</table>");
	
	$pdf->SetFooter('Pág. {PAGENO}');

	$filename = "sales_".$_POST["name"]."_" . date('d-m-Y') . ".pdf";
	$content = $pdf->Output($filename,'D');
?>