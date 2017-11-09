<?php
	
	require_once('propertyClass.php');
    $property = new PROPERTY();
	
	$stmt = $property->runQuery("SELECT '0-100' AS `range`,
                SUM(CASE WHEN price BETWEEN 0 AND 100 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '100-200' AS `range`,
                SUM(CASE WHEN price BETWEEN 100 AND 200 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '200-300' AS `range`,
                SUM(CASE WHEN price BETWEEN 200 AND 300 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '300-400' AS `range`,
                SUM(CASE WHEN price BETWEEN 300 AND 400 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '400-500' AS `range`,
                SUM(CASE WHEN price BETWEEN 400 AND 500 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '500-600' AS `range`,
                SUM(CASE WHEN price BETWEEN 500 AND 600 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '600-700' AS `range`,
                SUM(CASE WHEN price BETWEEN 600 AND 700 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '700-800' AS `range`,
                SUM(CASE WHEN price BETWEEN 700 AND 800 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '800-900' AS `range`,
                SUM(CASE WHEN price BETWEEN 800 AND 900 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '900-1000' AS `range`,
                SUM(CASE WHEN price BETWEEN 900 AND 1000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '2000-3000' AS `range`,
                SUM(CASE WHEN price BETWEEN 2000 AND 3000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '3000-4000' AS `range`,
                SUM(CASE WHEN price BETWEEN 3000 AND 4000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '4000-5000' AS `range`,
                SUM(CASE WHEN price BETWEEN 4000 AND 5000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '5000-6000' AS `range`,
                SUM(CASE WHEN price BETWEEN 5000 AND 6000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '6000-7000' AS `range`,
                SUM(CASE WHEN price BETWEEN 6000 AND 7000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '7000-8000' AS `range`,
                SUM(CASE WHEN price BETWEEN 7000 AND 8000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '8000-9000' AS `range`,
                SUM(CASE WHEN price BETWEEN 8000 AND 9000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '9000-10000' AS `range`,
                SUM(CASE WHEN price BETWEEN 9000 AND 10000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '10000-20000' AS `range`,
                SUM(CASE WHEN price BETWEEN 10000 AND 20000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '20000-30000' AS `range`,
                SUM(CASE WHEN price BETWEEN 20000 AND 30000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '30000-40000' AS `range`,
                SUM(CASE WHEN price BETWEEN 30000 AND 40000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '40000-50000' AS `range`,
                SUM(CASE WHEN price BETWEEN 40000 AND 50000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '50000-60000' AS `range`,
                SUM(CASE WHEN price BETWEEN 50000 AND 60000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '60000-70000' AS `range`,
                SUM(CASE WHEN price BETWEEN 60000 AND 70000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '70000-80000' AS `range`,
                SUM(CASE WHEN price BETWEEN 70000 AND 80000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '80000-90000' AS `range`,
                SUM(CASE WHEN price BETWEEN 80000 AND 90000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '90000-100000' AS `range`,
                SUM(CASE WHEN price BETWEEN 90000 AND 100000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '100000-200000' AS `range`,
                SUM(CASE WHEN price BETWEEN 100000 AND 200000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '200000-300000' AS `range`,
                SUM(CASE WHEN price BETWEEN 200000 AND 300000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '300000-400000' AS `range`,
                SUM(CASE WHEN price BETWEEN 300000 AND 400000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '400000-500000' AS `range`,
                SUM(CASE WHEN price BETWEEN 400000 AND 500000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '500000-600000' AS `range`,
                SUM(CASE WHEN price BETWEEN 500000 AND 600000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '600000-7000000' AS `range`,
                SUM(CASE WHEN price BETWEEN 600000 AND 700000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '700000-800000' AS `range`,
                SUM(CASE WHEN price BETWEEN 700000 AND 800000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '800000-900000' AS `range`,
                SUM(CASE WHEN price BETWEEN 800000 AND 900000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '900000-1000000' AS `range`,
                SUM(CASE WHEN price BETWEEN 900000 AND 1000000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT ' > 1000000' AS `range`,
                SUM(CASE WHEN price > 1000000 THEN 1 ELSE 0 END) AS `total` FROM property");
	$stmt->execute();

	$jsonArray = array();

	if($stmt->rowCount() > 0) {
		foreach ($stmt AS $row) {
			$jsonArrayItem['Intervalo de Preco:'] = $row['range'];
			$jsonArrayItem['Numero de Propriedades:'] = $row['total'];
			array_push($jsonArray, $jsonArrayItem);
		}
	}

	header('Content-type: application/json');

	function cleanData(&$str) {
	    $str = preg_replace("/\t/", "\\t", $str);
	    $str = preg_replace("/\r?\n/", "\\n", $str);
	    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
	}
	
	$filename = "property_number_by_price_range_" . date('d-m-Y') . ".xls";

	header("Content-Encoding: UTF-8");
	header("Content-Type: application/vnd.ms-excel;charset=UTF-8");
	header("Content-Disposition: attachment; filename=\"$filename\"");

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