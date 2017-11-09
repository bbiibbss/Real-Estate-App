 <?php
 	require('databaseConnection.php');
	require('propertyClass.php');
    
    $property = new Property();

	$id = $_POST['id'];
    
    $stmt = $property->runQuery("DELETE FROM property WHERE property_id=?");
	$stmt->bindValue(1, $id);
	$stmt->execute();
	if($stmt){
	  	echo "
		    <script type='text/javascript'>
		    	alert('Propriedade removida');
		    	window.location.replace(document.referrer);
		    </script>
		";
    }
?>