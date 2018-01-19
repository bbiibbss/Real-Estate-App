<?php
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbName = "verde_mar";

		$conn = new mysqli($servername, $username, $password, $dbName);

		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		}

	
		$query = "SELECT SUM(price) AS total, YEAR(sale_date) AS year
					FROM sales AS sl JOIN property AS ppt
					ON sl.PK_property_id=ppt.property_id
					GROUP BY YEAR(sale_date)";

		$result = $conn->query($query);

		$jsonArray = array();

		if ($result->num_rows > 0) {
		  	while($row = $result->fetch_assoc()) {
		  		
		    	$jsonArrayItem['label'] = $row['year'];
		    	$jsonArrayItem['value'] = $row['total'];
		    	array_push($jsonArray, $jsonArrayItem);
		  	}
		}
		$conn->close();

		header('Content-type: application/json');
		
		echo json_encode($jsonArray);
	?>