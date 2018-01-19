
<?php
    if(isset($_POST['submitFirstName'])) {
        $firstname = $_POST['firstname'];

        if($firstname == $userRow["first_name"]){
            echo "<script type='text/javascript'>alert('Este já é o seu nome!! Insira um valor diferente'); window.location.replace(document.referrer);</script>"; 
        }
        else{
            $stmt = $user->runQuery("UPDATE users SET first_name='$firstname' WHERE user_id=:id");
            $stmt->execute(array(":id"=>$user_id));
            if ($stmt) {
                echo "<script type='text/javascript'>alert('Campo atualizado com sucesso!'); window.location.replace(document.referrer);</script>";
            }
            else {
                echo "<script type='text/javascript'>alert('ERRO! Este campo não foi atualizado'); window.location.replace(document.referrer);</script>";
            }
        }
    }
?>

<?php
    if(isset($_POST['submitLastName'])) {
        $lastname = $_POST['lastname'];

        if($lastname == $userRow["last_name"]){
            echo "<script type='text/javascript'>alert('Este já é o seu apelido!! Insira um valor diferente'); window.location.replace(document.referrer);</script>"; 
        }
        else{
            $stmt = $user->runQuery("UPDATE users SET last_name='$lastname' WHERE user_id=:id");
            $stmt->execute(array(":id"=>$user_id));
            if ($stmt) {
                echo "<script type='text/javascript'>alert('Campo atualizado com sucesso!'); window.location.replace(document.referrer);</script>";
            }
            else {
                echo "<script type='text/javascript'>alert('ERRO! Este campo não foi atualizado'); window.location.replace(document.referrer);</script>";
            }
        }
    }
?>

<?php
    if(isset($_POST['submitEmail'])) {
        $email = $_POST['email'];

        if($email == $userRow["email"]){
            echo "<script type='text/javascript'>alert('Este já é o seu email!! Insira um valor diferente'); window.location.replace(document.referrer);</script>"; 
        }
        else{
            $stmt = $user->runQuery("UPDATE users SET email='$email' WHERE user_id=:id");
            $stmt->execute(array(":id"=>$user_id));
            if ($stmt) {
                echo "<script type='text/javascript'>alert('Campo atualizado com sucesso!'); window.location.replace(document.referrer);</script>";
            }
            else {
                echo "<script type='text/javascript'>alert('ERRO! Este campo não foi atualizado'); window.location.replace(document.referrer);</script>";
            }
        }
    }
?>

<?php
    if(isset($_POST['submitPhoneNumber'])) {
        $phoneNumber = $_POST['phoneNumber'];

        if($phoneNumber == $userRow["phone_number"]){
            echo "<script type='text/javascript'>alert('Este já é o seu número de telefone!! Insira um valor diferente'); window.location.replace(document.referrer);</script>"; 
        }
        else{
            $stmt = $user->runQuery("UPDATE users SET phone_number='$phoneNumber' WHERE user_id=:id");
            $stmt->execute(array(":id"=>$user_id));
            if ($stmt) {
                echo "<script type='text/javascript'>alert('Campo atualizado com sucesso!'); window.location.replace(document.referrer);</script>";
            }
            else {
                echo "<script type='text/javascript'>alert('ERRO! Este campo não foi atualizado'); window.location.replace(document.referrer);</script>";
            }
        }
    }
?>

<?php
    if(isset($_POST['submitPass'])) {
        $oldPassword =md5($_POST['oldPassword']);
        $password =md5($_POST['password']);
        $passwordRepeat =md5($_POST['passwordRepeat']);

        if($oldPassword != $userRow["password"]){
            echo "<script type='text/javascript'>alert('Password errada! Insira a sua password atual!'); window.location.replace(document.referrer);</script>"; 
        }
        else if($password == $userRow["password"]){
            echo "<script type='text/javascript'>alert('Esta já é a sua password!! Insira um valor diferente'); window.location.replace(document.referrer);</script>"; 
        }
        else if($password != $passwordRepeat){
            echo "<script type='text/javascript'>alert('ERRO! As passwords não são iguais!'); window.location.replace(document.referrer);</script>"; 
        }
        else{
            $stmt = $user->runQuery("UPDATE users SET password='$password' WHERE user_id=:id");
            $stmt->execute(array(":id"=>$user_id));
            if ($stmt) {
                echo "<script type='text/javascript'>alert('Campo atualizado com sucesso!'); window.location.replace(document.referrer);</script>";
            }
            else {
                echo "<script type='text/javascript'>alert('ERRO! Este campo não foi atualizado<br> Tente outra vez mais tarde'); window.location.replace(document.referrer);</script>";
            }
        }
    }
?>



<?php

    if(isset($_POST['submitPreferences'])){

        if(!empty($_POST['businessType'])){
            $arrBusinessType = array();
            foreach($_POST['businessType'] as $selected){
                array_push($arrBusinessType, $selected."</br>");
            }
            $businessType = implode(" ", $arrBusinessType);
        }
        else{
            $businessType="";
        }

        if(!empty($_POST['propertyType'])){
            $arrPropertyType=array();
            foreach($_POST['propertyType'] as $selected){
                array_push($arrPropertyType, $selected."</br>");
            }
            $propertyType = implode(" ", $arrPropertyType);
        }
        else{
            $propertyType="";
        }

        if(!empty($_POST['propertyTypology'])){
            $arrPropertyTypology=array();
            foreach($_POST['propertyTypology'] as $selected){
                array_push($arrPropertyTypology, $selected."</br>");
            }
            $propertyTypology = implode(" ", $arrPropertyTypology);
        }
        else{
            $propertyTypology="";
        }

        if(!empty($_POST['parish'])){
            $arrParish=array();
            foreach($_POST['parish'] as $selected){
                array_push($arrParish, $selected."</br>");
            }
            $parish = implode(" ", $arrParish);
        }
        else{
            $parish="";
        }

        if(isset($_POST['minPrice'])){
            $minPrice = $_POST['minPrice'];
        }
        else{
            $minPrice = "";
        }

        if(isset($_POST['maxPrice'])){
            $maxPrice = $_POST['maxPrice'];
        }
        else{
            $maxPrice="";
        }


        $stmt = $user->runQuery("SELECT * FROM preferences WHERE PK_user_id=?");
        $stmt->bindParam(1, $user_id);
        $stmt->execute();

        if($stmt->rowCount() == 1){
            $stmt1 = $user->runQuery("UPDATE preferences SET PK_user_id=?, business_types=?, property_types=?, property_typologies=?, parishes=?, max_value=?, min_value=? WHERE PK_user_id=?");
            $stmt1->bindParam(1, $user_id);
            $stmt1->bindParam(2, $businessType);
            $stmt1->bindParam(3, $propertyType);
            $stmt1->bindParam(4, $propertyTypology);
            $stmt1->bindParam(5, $parish);
            $stmt1->bindParam(6, $maxPrice);
            $stmt1->bindParam(7, $minPrice);
            $stmt1->bindParam(8, $user_id);
            $stmt1->execute();
            if($stmt1){
                echo "<script type='text/javascript'>alert('Preferâncias editadas'); window.location.replace(document.referrer);</script>";
            }
        }
        else{
            $stmt2 = $user->runQuery("INSERT INTO preferences (PK_user_id, business_types, property_types, property_typologies, parishes, max_value, min_value) VALUES (?,?,?,?,?,?,?)");
            $stmt2->bindParam(1, $user_id);
            $stmt2->bindParam(2, $businessType);
            $stmt2->bindParam(3, $propertyType);
            $stmt2->bindParam(4, $propertyTypology);
            $stmt2->bindParam(5, $parish);
            $stmt2->bindParam(6, $maxPrice);
            $stmt2->bindParam(7, $minPrice);
            $stmt2->execute();
            if($stmt2){
                echo "<script type='text/javascript'>alert('Preferâncias criadas'); window.location.replace(document.referrer);</script>";
            }
        }
    }
?>


