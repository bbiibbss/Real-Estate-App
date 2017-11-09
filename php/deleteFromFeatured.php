 <?php
 	require_once('databaseConnection.php');
	$conn;
	 require('propertyClass.php');
    
    $property = new Property();

	$id = $_POST['id'];
    
    $stmt = $property->runQuery("DELETE FROM featured WHERE PK_property_id=?");
	$stmt->bindValue(1, $id);
	$stmt->execute();
	if($stmt){
	  	echo "
		    <script type='text/javascript'>alert('Removido dos destaques'); window.location.replace(document.referrer);</script>
		";
    }
?>