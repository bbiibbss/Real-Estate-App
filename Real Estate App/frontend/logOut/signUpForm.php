<?php
    session_start();
    require_once('../../php/userClass.php');
    $user = new USER();

    require_once('../../php/propertyClass.php');
    $property = new PROPERTY();
    
    if($user->is_loggedin()!=""){
        $user->redirect('../logIn/index.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="../../images/logo_icon.jpg">
    <title>Criar conta</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../../css/stylesheet.css">
    <link rel="stylesheet" href="../../css/gridStyle.css">
    <script type="text/javascript" src="../../js/passwordValidation.js"></script>
    <script type="text/javascript" src="../../js/topNav.js"></script>
    <script src='../../js/previewFile.js'></script>
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


    <div class="page w3-content w3-card-2 w3-white" style="padding-left:15%;padding-right:15%;">
        <div class="row">
            <div class="col col-12">
            
                <!-- Page content -->
                <h2>Registe-se</h2>
                <br>
                
                <br>
                <form action="../../php/signUp.php" method="post">
                    Nome
                    <input type="text" name="firstname" pattern="[^0-9]+" required>
                    <br><br>
                    Apelido
                    <input type="text" name="lastname" pattern="[^0-9]+" required>
                    <br><br>
                    Email
                    <input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
                    <br><br>
                    Número de telefone
                    <input type="text" name="phoneNumber" pattern="[0-9]+" required>
                    <br><br>
                    Password <div class="tooltip"> <b>?</b><span class="tooltiptext">A password tem que ter:<br>8 caracteres,<br>uma letra maiúscula,<br>uma letra minúscula,<br>um número!</span></div>
                    <br>
                    <input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="A password tem que ter: 8 caracteres, uma letra maiúscula, uma letra minúscula, um número!" onkeyup="passwordChanged();" required>
                    <span id="strength"></span> <span id="forca"></span>
                    <br><br>
                    Repita a password
                    <input type="password" onkeyup="return validatePassword();" name="passwordRepeat" id="passwordRepeat" required><br>
                    <span id="simbolo"></span>
                    <span id="iguais"></span>
                    <br><br>
                    <button type='submit' name='submitData'>Submeter Dados</button>
                    <br><br><br><br><br>
                </form>
            </div>
        </div>
    </div>
    <script src='../../js/checkboxFilter.js'></script>


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