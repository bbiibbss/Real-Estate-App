<?php
	require_once('userClass.php');
    $user = new USER();

	if(isset($_POST["submitVisitRequest"])){
		$propertyId = $_POST["propertyId"];
	    $userId = $_POST["userId"];

	    if(!empty($_POST["observations"])){
	    	$observations = $_POST["observations"];
	    }
	    else{
	    	$observations = "";
	    }
	    
	    if(!empty($_POST["visitDate"])){
	    	$visitDate = $_POST["visitDate"];
			$day= date("d", strtotime($visitDate));
			$month= date("M", strtotime($visitDate));
			$year= date("Y", strtotime($visitDate));
			$hour= date("h", strtotime($visitDate));
			$minute= date("i", strtotime($visitDate));
	    }
	    else{
	    	$visitDate = "";
	    }
	    $stmt = $user->runQuery("SELECT * FROM visit AS vs JOIN property as ppt ON vs.PK_property_id=ppt.property_id WHERE PK_client_id=? AND PK_property_id=?");
		$stmt->bindValue(1, $userId);
		$stmt->bindValue(2, $propertyId);
		$stmt->execute();
		if($stmt->rowCount() >= 1) {
			echo "<script type='text/javascript'>alert('ERRO! Já tem ua visita marcada para esta propriedade! Consulte as visitas marcadas na sua área de cliente!'); window.location.replace(document.referrer);</script>";
		}
		else{
			$stmt = $user->runQuery("SELECT * FROM visit_request AS vs JOIN property as ppt ON vs.PK_property_id=ppt.property_id WHERE PK_client_id=? AND PK_property_id=?");
			$stmt->bindValue(1, $userId);
			$stmt->bindValue(2, $propertyId);
			$stmt->execute();
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			$propertyName=$row["property_name"];
			if($stmt->rowCount() >= 1) {
				$stmt = $user->runQuery("UPDATE visit_request SET PK_property_id=?, PK_client_id=?, date_time=?, observations=?");
				    $stmt->bindValue(1, $propertyId);
				    $stmt->bindValue(2, $userId);
				    $stmt->bindValue(3, $visitDate);
				    $stmt->bindValue(4, $observations);
				    $stmt->execute();
				    if($stmt){
				    	echo "<script type='text/javascript'>alert('A sua visita para a propriedade ".$propertyName." foi remarcada para o dia ".$day." de ".$month." de ".$year." às ".$hour."H".$minute." '); window.location.replace(document.referrer);</script>";
				    }
			}
			else{
			    $stmt = $user->runQuery("INSERT INTO visit_request (PK_property_id, PK_client_id, date_time, observations) VALUES (?, ?, ?, ?)");
			    $stmt->bindValue(1, $propertyId);
			    $stmt->bindValue(2, $userId);
			    $stmt->bindValue(3, $visitDate);
				$stmt->bindValue(4, $observations);
				$stmt->execute();

				if ($stmt) {
				    echo "<script type='text/javascript'>alert('A sua visita para a propriedade ".$propertyName." foi requisitada para o dia ".$day." de ".$month." de ".$year." às ".$hour."H".$minute."! Aguarde resposta de um dos nossos agentes'); window.location.replace(document.referrer);</script>";
		        }
		        else {
		            echo "<script type='text/javascript'>alert('Ocorreu um ERRO! Tente mais tarde'); window.location.replace(document.referrer);</script>";
		        }
		    }
		}
	}

	if(isset($_POST["updateDateTime"])){
		$propertyId = $_POST["propertyId"];
		$userId = $_POST["userId"];
	    $visitId=$_POST["visitId"];
		$visitDate=$_POST["visitDate"];

		$stmt = $user->runQuery("SELECT DATE_FORMAT(date_time, '%Y-%m-%dT%H:%i') AS visit_date FROM visit_request WHERE id_visit_request=?");
		$stmt->bindValue(1, $visitId);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		if($visitDate == $row["visit_date"]) {
			echo "
		    	<script type='text/javascript'>
		    		alert('A visita já está requisitada para esta data e horas! Insira uma data e hora diferentes');
		   			window.location.replace(document.referrer);
		   		</script>
		   	";
        }
        else{
        	$stmt = $user->runQuery("UPDATE visit_request SET date_time=? WHERE id_visit_request=? AND PK_property_id=? AND PK_client_id=?");
			$stmt->bindValue(1, $visitDate);
		    $stmt->bindValue(2, $visitId);
		    $stmt->bindValue(3, $propertyId);
		    $stmt->bindValue(4, $userId);
			$stmt->execute();
			if($stmt){
		    	echo "
		    		<script type='text/javascript'>
		    			alert('Data e hora alteradas!');
		    			window.location.replace(document.referrer);
		    		</script>
		    	";
			}
        }
	}

	if(isset($_POST["updateObservations"])){
		$propertyId = $_POST["propertyId"];
		$userId = $_POST["userId"];
	    $visitId=$_POST["visitId"];
	    $observations=$_POST["observations"];

		$stmt = $user->runQuery("SELECT observations AS obs FROM visit_request WHERE id_visit_request=?");
		$stmt->bindValue(1, $visitId);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		if($observations == $row["obs"]) {
			echo "
		    	<script type='text/javascript'>
		    		alert('Insira um valor diferente!');
		   			window.location.replace(document.referrer);
		   		</script>
		   	";
        }
        else{
        	$stmt = $user->runQuery("UPDATE visit_request SET observations=? WHERE id_visit_request=? AND PK_property_id=? AND PK_client_id=?");
		    $stmt->bindValue(1, $observations);
		    $stmt->bindValue(2, $visitId);
		    $stmt->bindValue(3, $propertyId);
		    $stmt->bindValue(4, $userId);
			$stmt->execute();
			if($stmt){
		    	echo "
			    	<script type='text/javascript'>
			    		alert('Observações alteradas! ');
			    		window.location.replace(document.referrer);
			    	</script>
			    ";
			}
        }
	}
	

	if(isset($_POST["bookVisit"])){
		$propertyId = $_POST["propertyId"];
	    $userId = $_POST["userId"];
	    if(!empty($_POST["observations"])){
	    	$observations = $_POST["observations"];
	    }
	    else{
	    	$observations = "";
	    }
	    if(!empty($_POST["dateTime"])){
	    	$visitDate = $_POST["dateTime"];
	    }
	    else{
	    	$visitDate = "";
	    }
	    $stmt = $user->runQuery("SELECT * FROM visit_request AS vs JOIN property as ppt ON vs.PK_property_id=ppt.property_id WHERE PK_client_id=? AND PK_property_id=?");
		$stmt->bindValue(1, $userId);
		$stmt->bindValue(2, $propertyId);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		$requestVisitId=$row["id_visit_request"];
		if($stmt->rowCount() >= 1) {
			$stmt = $user->runQuery("INSERT INTO visit (PK_property_id, PK_client_id, date_time, client_observations) VALUES (?, ?, ?, ?)");
			$stmt->bindValue(1, $propertyId);
			$stmt->bindValue(2, $userId);
			$stmt->bindValue(3, $visitDate);
		    $stmt->bindValue(4, $observations);
		    $stmt->execute();
		    if($stmt){
		    	$stmt = $user->runQuery("DELETE FROM visit_request WHERE id_visit_request=?");
				$stmt->bindValue(1, $requestVisitId);
			    $stmt->execute();
			    echo "<script type='text/javascript'>alert('Visita marcada!'); window.location.replace(document.referrer);</script>";
			}
		}
	}


	if(isset($_POST["editBookVisit"])){
		$propertyId = $_POST["propertyId"];
	    $userId = $_POST["userId"];
	    $clientObs = $_POST["clientObservations"];
	    
	    if(!empty($_POST["managerObservations"])){
	    	$observations = $_POST["managerObservations"];
	    }
	    else{
	    	$observations = "";
	    }
	    if(!empty($_POST["visitDate"])){
	    	$visitDate = $_POST["visitDate"];
	    }
	    else{
	    	$visitDate = "";
	    }
	    $stmt = $user->runQuery("SELECT * FROM visit_request AS vs JOIN property as ppt ON vs.PK_property_id=ppt.property_id WHERE PK_client_id=? AND PK_property_id=?");
		$stmt->bindValue(1, $userId);
		$stmt->bindValue(2, $propertyId);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		$requestVisitId=$row["id_visit_request"];
		if($stmt->rowCount() >= 1) {
			$stmt = $user->runQuery("INSERT INTO visit (PK_property_id, PK_client_id, date_time, manager_observations, client_observations) VALUES(?,?,?,?,?)");
			$stmt->bindValue(1, $propertyId);
			$stmt->bindValue(2, $userId);
			$stmt->bindValue(3, $visitDate);
		    $stmt->bindValue(4, $observations);
		    $stmt->bindValue(5, $clientObs);
		    $stmt->execute();
		    if($stmt){
		    	$stmt = $user->runQuery("DELETE FROM visit_request WHERE id_visit_request=?");
				$stmt->bindValue(1, $requestVisitId);
			    $stmt->execute();
			    echo "<script type='text/javascript'>alert('Visita marcada!'); window.location.replace(document.referrer);</script>";
			}
		}
	}


?>
