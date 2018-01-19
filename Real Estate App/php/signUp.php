<?php

    require_once('userClass.php');
    $user = new USER();

    $stmt = $user->runQuery("SELECT * FROM users");
    $stmt->execute();
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if($stmt->rowCount() == 0){
        $userType = 3;
    }
    else{
        $userType = 1;
    }

    $erro=array();

    if(isset($_POST['submitData'])) {
        $firstname = trim($_POST['firstname']); 
        $lastname = trim($_POST['lastname']); 
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $passwordRepeat = trim($_POST['passwordRepeat']);
        $phone = trim($_POST['phoneNumber']);

        if ($firstname=="") {
            $error[] = "Insira o seu nome"; 
        }
        if ($lastname=="") {
            $error[] = "Insira o seu apelido"; 
        }

        if ($email=="") {
            $error[] = "Insira o seu endereço de email!"; 
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error[] = 'Insira um endereço de email válido!';
        }
        else if($password=="") {
            $error[] = "Insira a sua password";
        }
        else if($password!=$passwordRepeat) {
            $error[] = "As passwords não são iguais";
        }
        else {
            try {
                $stmt = $user->runQuery("SELECT email FROM users WHERE email=:email");
                $stmt->execute(array(':email'=>$email));
                $row=$stmt->fetch(PDO::FETCH_ASSOC);

                if($row['email']==$email) {
                    $error[] = "Este email já está a ser utilizado";
                }
                else {
                    if($user->register($firstname, $lastname, $email, $password, $phone)) {
                        echo "<script type='text/javascript'>alert('Utilizador criado com sucesso!!!'); window.location.href = '../frontend/logOut/index.php';</script>";
                    }
                }
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
?>