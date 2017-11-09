<?php

		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbName = "fusioncharts_phpsample";

		$conn = new mysqli($servername, $username, $password, $dbName);

		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		}
		$tableName="sales";

		$query = "SELECT * FROM $tableName";

		$result = $conn->query($query);

		$jsonArray = array();

		if ($result->num_rows > 0) {
		  	while($row = $result->fetch_assoc()) {
		    	$jsonArrayItem['Data'] = $row['sale_date'];
		    	$jsonArrayItem['Valor'] = $row['price'];
		    	array_push($jsonArray, $jsonArrayItem);
		  	}
		}
		$conn->close();

		header('Content-type: application/json');

	function cleanData(&$str) {
	    $str = preg_replace("/\t/", "\\t", $str);
	    $str = preg_replace("/\r?\n/", "\\n", $str);
	    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
	}


	$filename = $tableName."_" . date('d-m-Y') . ".csv";

	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/csv");

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