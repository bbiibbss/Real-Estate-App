 <?php
 	require_once('databaseConnection.php');
	$conn;
	 require('userClass.php');
    
    $user = new User();

	$id = $_POST['id'];
	$stmt = $user->runQuery("UPDATE users SET PK_user_type_id=? WHERE user_id=?");
	$stmt->bindValue(1, 2);
	$stmt->bindValue(2, $id);
	$stmt->execute();
	if($stmt){
	   	echo "
		<script type='text/javascript'>alert('Gestor criado'); window.location.replace(document.referrer);</script>
		";
    }
?>