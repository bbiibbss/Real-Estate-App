 <?php
 	require_once('databaseConnection.php');
	$conn;
	 require('userClass.php');
    
    $user = new User();

    $id = $_POST['id'];
	$stmt = $user->runQuery("UPDATE users SET PK_user_type_id=? WHERE user_id=?");
	$stmt->bindValue(1, 1);
	$stmt->bindParam(2, $id);
	$stmt->execute();
	if($stmt){
		$stmt1 = $user->runQuery("SELECT user_id FROM users WHERE PK_user_type_id=?");
		$stmt1->bindValue(1,2);
		$stmt1->execute();

		if($stmt1->rowCount() >= 1) {
			$arr=array();
			foreach ($stmt1 AS $row) {
				array_push($arr, $row["user_id"]);
			}

			$randomid=$arr[array_rand($arr,1)];
			
			if($stmt1){
				$stmt2 = $user->runQuery("UPDATE property SET PK_user_id=? WHERE PK_user_id=?");
				$stmt2->bindParam(1, $randomid);
				$stmt2->bindParam(2, $id);
				$stmt2->execute();
				if($stmt2){
					echo "
						<script type='text/javascript'>alert('Gestor eliminado! As propriedades ao encargo deste gestor passam a estar ao encargo do gestor ID: ".$randomid."'); window.location.replace(document.referrer);</script>
					";
				}
				else{
					echo "
						<script type='text/javascript'>alert('Ocorreu um ERRO! Tente novamente mais tarde'); window.location.replace(document.referrer);</script>
					";
				}
			}
		}
    }
?>