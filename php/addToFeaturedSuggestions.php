 <?php
 	require_once('databaseConnection.php');
    require_once("session.php");
	require('propertyClass.php');
    
    $property = new Property();

	$id = $_POST['id'];
	$userId = $_SESSION['user_session'];

    $stmt = $property->runQuery("SELECT * FROM featured WHERE PK_property_id=?");
    $stmt->bindValue(1, $id);
    $stmt->execute();
    $row=$stmt->fetch(PDO::FETCH_ASSOC);

    $stmt1 = $property->runQuery("SELECT * FROM featured_suggestions WHERE PK_property_id=?");
    $stmt1->bindValue(1, $id);
    $stmt1->execute();
    $row=$stmt1->fetch(PDO::FETCH_ASSOC);
    if($stmt->rowCount() != 0){
    	echo "
		    <script type='text/javascript'>alert('ERRO! Esta propriedade já se encontra em destaque'); window.location.replace(document.referrer);</script>
		   ";
    }
    else if($stmt1->rowCount() != 0){
        echo "
            <script type='text/javascript'>alert('ERRO! Esta propriedade já foi sugerida e encontra-se a aguardar aprovação'); window.location.replace(document.referrer);</script>
           ";
    }
    else{
        $stmt = $property->runQuery("INSERT INTO featured_suggestions (PK_property_id, PK_fs_user_id) VALUES (?, ?)");
    	$stmt->bindValue(1, $id);
    	$stmt->bindValue(2, $userId);
    	$stmt->execute();
    	if($stmt){
    	    echo "
    		    <script type='text/javascript'>alert('Adicionada às sugestões.'); window.location.replace(document.referrer);</script>
    		";
        }
    }
?>