 <?php
 	require_once('databaseConnection.php');
	$conn;
	 require('propertyClass.php');
    
    $property = new Property();

	$id = $_POST['id'];
    $stmt = $property->runQuery("SELECT * FROM featured WHERE PK_property_id=?");
    $stmt->bindValue(1, $id);
    $stmt->execute();
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if($stmt->rowCount() != 0){
    	echo "
		    <script type='text/javascript'>alert('ERRO! Esta propriedade já se encontra em destaque'); window.location.replace(document.referrer);</script>
		   ";
    }
    else{
    	$stmt = $property->runQuery("DELETE FROM featured_suggestions WHERE PK_property_id=?");
		$stmt->bindValue(1, $id);
		$stmt->execute();

    	$stmt1 = $property->runQuery("INSERT INTO featured (PK_property_id) VALUES (?)");
	    $stmt1->bindValue(1, $id);
	    $stmt1->execute();
	    if($stmt1){
	    	echo "
		    	<script type='text/javascript'>alert('Adicionada aos destaques'); window.location.replace(document.referrer);</script>
		    ";
	    }
    }
?>