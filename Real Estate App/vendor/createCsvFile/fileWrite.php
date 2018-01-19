<?php
 
	$host = 'localhost';
	$user = 'root';
	$password = '';
	$database = 'fusioncharts_phpsample';
	$pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
	
	$tableName="sales";
	
	$stmt = $pdo->prepare("SELECT * FROM $tableName");
	$stmt->execute();
	
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	 
	$columnNames = array();
	if(!empty($rows)){
	    $firstRow = $rows[0];
	    foreach($firstRow as $colName => $val){
	        $columnNames[] = $colName;
	    }
	}
	 
	$fileName = ''.$tableName.'.csv';
	 
	header('Content-Type: application/excel');
	header('Content-Disposition: attachment; filename="' . $fileName . '"');
	 
	$fp = fopen('php://output', 'w');
	 
	fputcsv($fp, $columnNames);
	 
	foreach ($rows as $row) {
	    fputcsv($fp, $row, "\t");
	}
	 
	fclose($fp);

?>