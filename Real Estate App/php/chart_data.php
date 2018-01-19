<?php
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbName = "verde_mar";

		$conn = new mysqli($servername, $username, $password, $dbName);

		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		}

		$year= date("Y",time());
	

		$query = "SELECT SUM(price) AS total, MONTH(sale_date) AS month
					FROM sales AS sl JOIN property AS ppt
					ON sl.PK_property_id=ppt.property_id
					WHERE YEAR(sale_date) = $year GROUP BY MONTH(sale_date)";

		$result = $conn->query($query);

		$jsonArray = array();

		if ($result->num_rows > 0) {
		  	while($row = $result->fetch_assoc()) {
		  		if($row['month']==1){
		  			$month="Janeiro";
		  		}
		  		else if($row['month']==2){
		  			$month="Fevereiro";
		  		}
		  		else if($row['month']==3){
		  			$month="Março";
		  		}
		  		else if($row['month']==4){
		  			$month="Abril";
		  		}
		  		else if($row['month']==5){
		  			$month="Maio";
		  		}
		  		else if($row['month']==6){
		  			$month="Junho";
		  		}
		  		else if($row['month']==7){
		  			$month="Julho";
		  		}
		  		else if($row['month']==8){
		  			$month="Agosto";
		  		}
		  		else if($row['month']==9){
		  			$month="Setembro";
		  		}
		  		else if($row['month']==10){
		  			$month="Outubro";
		  		}
		  		else if($row['month']==11){
		  			$month="Novebro";
		  		}
		  		else if($row['month']==12){
		  			$month="Dezembro";
		  		}
		    
		    	$jsonArrayItem['label'] = $month;
		    	$jsonArrayItem['value'] = $row['total'];
		    	array_push($jsonArray, $jsonArrayItem);
		  	}
		}
		$conn->close();

		header('Content-type: application/json');
		
		echo json_encode($jsonArray);
	?>