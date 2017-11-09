<?php
    session_start();
    require_once("../../php/userClass.php");
    $login = new USER();

    if(isset($_POST['submit'])) {
        $email = $_POST['email'];
        $pass = md5($_POST['password']);
            
        if($login->doLogin($email,$pass)) {
            $login->redirect('../logIn/index.php');
        }
        else {
            $error =  "Credenciais erradas!<br>Insira um email e uma password válidos";
        }   
    }

    if($login->is_loggedin()!=""){
        $login->redirect('../logIn/index.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="../../images/logo_icon.jpg">
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/stylesheet.css">
    <link rel="stylesheet" href="../../css/gridStyle.css">
    <script type="text/javascript" src="../../js/topNav.js"></script>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="topnav" id="myTopnav">
        <a href="index.php" class="navBarItemHome"><i class="fa fa-home home"></i></a>
        <a href="propertySearch.php" class="navBarItem">Imóveis</a>
        <a href="about.php" class="navBarItem">Sobre Nós</a>
        <a href="login.php" class="navBarItem navBarItemLogin">Login</a>
        <a href="javascript:void(0);" class="navBarItemHome icon" onclick="topNavFunction()"><i class="fa fa-bars"></i></a>
    </div>


    <div class="page w3-content w3-container w3-card-2 w3-white" style="padding-left:15%;padding-right:15%;">

        <div class="row">
            <form method="post">
                <div class="container">
                    <?php
                        if(isset($error)) {
                    ?>
                            <div class="danger">
                                <span><?php echo $error; ?></span>
                            </div>
                    <?php
                        }
                    ?>
                    <label>Email</label><br>
                    <input type="text" name="email" required>
                    <br><br>
                    <label>Password</label><br>
                    <input type="password" name="password" required>
                    <button type="submit" name="submit">Login</button>
                </div>
                <span class="signUp">Ainda não tem uma <a href="signUpForm.php">conta?</a></span>
            </form>
        </div>
    </div>
    


     <!-- Footer -->
    <footer>
        <div>
        VerdeMar - Gestão Imobiliária
        </div>
        <div class="w3-large">
            <i class="socialMediaIcon fa fa-facebook-official w3-hover-opacity"></i>
            <i class="socialMediaIcon fa fa-instagram w3-hover-opacity"></i>
            <i class="socialMediaIcon fa fa-twitter w3-hover-opacity"></i>
            <i class="socialMediaIcon fa fa-linkedin w3-hover-opacity"></i>
        </div>
    </footer> 
</body>
</html>