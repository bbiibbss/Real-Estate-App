<?php

	require('visitClass.php');
    $visit = new VISIT();

	if(isset($_POST["removeVisitBooked"])){
		$id = $_POST['visitId'];
	    
	    $stmt = $visit->runQuery("DELETE FROM visit WHERE id_visit=?");
		$stmt->bindValue(1, $id);
		$stmt->execute();
		if($stmt){
		  	echo "
			    <script type='text/javascript'>alert('Visita desmarcada'); window.location.replace(document.referrer);</script>
			";
	    }
	}


	if(isset($_POST["removeVisitRequest"])){
		$id = $_POST['visitId'];
	    
	    $stmt = $visit->runQuery("DELETE FROM visit_request WHERE id_visit_request=?");
		$stmt->bindValue(1, $id);
		$stmt->execute();
		if($stmt){
		  	echo "
			    <script type='text/javascript'>alert('Pedido de visita eliminado'); window.location.replace(document.referrer);</script>
			";
	    }
	}
?>