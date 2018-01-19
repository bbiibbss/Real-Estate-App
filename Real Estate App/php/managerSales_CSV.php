<?php

	$jsonArray = array();
	if(isset($_POST["getManagerCSV"])){
		$jsonArrayItem['ID'] = $_POST['id'];
		$jsonArrayItem['Nome'] = $_POST['name'];
		$jsonArrayItem['Jan'] = $_POST['Jan'];
	    $jsonArrayItem['Fev'] = $_POST['Feb'];
		$jsonArrayItem['Mar'] = $_POST['Mar'];
	   	$jsonArrayItem['Abr'] = $_POST['Apr'];
	   	$jsonArrayItem['Mai'] = $_POST['May'];
		$jsonArrayItem['Jun'] = $_POST['Jun'];
	   	$jsonArrayItem['Jul'] = $_POST['Jul'];
	   	$jsonArrayItem['Ago'] = $_POST['Aug'];
	    $jsonArrayItem['Set'] = $_POST['Sep'];
		$jsonArrayItem['Out'] = $_POST['Oct'];
	   	$jsonArrayItem['Nov'] = $_POST['Nov'];
	   	$jsonArrayItem['Dez'] = $_POST['Dec'];
		$jsonArrayItem['Total ('.date("Y").')'] = $_POST['year'];
		array_push($jsonArray, $jsonArrayItem);
	}

	header('Content-type: application/json');

	function cleanData(&$str) {
	    $str = preg_replace("/\t/", "\\t", $str);
	    $str = preg_replace("/\r?\n/", "\\n", $str);
	    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
	}


	$filename = "sales_".$_POST["name"]."_" . date('d-m-Y') . ".xls";

	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel");

	$flag = false;
	foreach($jsonArray as $row) {
		if(!$flag) {
	     	echo implode("\t", array_keys($row)) . "\r\n";
	     	$flag = true;
    	}
	    array_walk($row, __NAMESPACE__ . '\cleanData');
	    echo implode("\t", array_values($row)) . "\r\n";
  	}
	exit;
		
?>