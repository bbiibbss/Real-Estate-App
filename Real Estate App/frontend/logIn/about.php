<?php
   
    require_once("../../php/session.php");
    
    require_once("../../php/userClass.php");
    $auth_user = new USER();
    
    
    $user_id = $_SESSION['user_session'];
    
    $stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:id");
    $stmt->execute(array(":id"=>$user_id));
    
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="../../images/logo_icon.jpg">
    <title>VerdeMar - Gestão Imobiliária</title>
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
        <a href="account.php" class="navBarItem">Conta</a>
        <a href="../../php/logout.php?logout=true" class="navBarItem navBarItemLogin">LogOut</a>
        <a class="navBarItem navBarItemLogin">Bem vindo <?php print($userRow['first_name']); ?></a>
        <a href="javascript:void(0);" class="navBarItemHome icon" onclick="topNavFunction()"><i class="fa fa-bars"></i></a>
    </div>


   
    <div class="page w3-content w3-card-2 w3-white">
        <div class="row">
            <div class="col col-6">
                <img class="logo" src="../../images/logo.png"> 
            </div>
            <div class="col col-6">
                <h3>Quem somos</h3>
                <h6>A Verde Mar, VM- Sociedade de Mediação Imobiliária e Gestão de Condomínios Lda, abriu as suas portas em 2002, no Centro da Cidade de Ponta Delgada.</h6>
                <h6>A dedicação aos nossos clientes e o nosso profissionalismo são as nossas imagens de marca.
                <h6>Contamos com uma equipa de Consultores Imobiliários qualificados para lhes indicarem as soluções adequadas para a venda ou Arrendamento do seu Imóvel. </h6>
                <h6>Em Dezembro de 2010, criámos uma nova área de negócios, HOUSELIFE Condomínios, tendo como actividade a administração e gestão de Condomínios.</h6>
                <h6>Contacte-nos para um atendimento 100% personalizado.</h6>
            </div>
        </div>
        <div class="w3-container w3-margin-top">
            <h3>As nossas instalações</h3>
        </div>
        <div class="w3-row-padding">
            <div class="row w3-large w3-center">
                <div class="col col-4">
                    <img class="company" src="../../images/1.png">
                </div>
                <div class="col col-4">
                    <img class="company" src="../../images/2.png">
                </div>
                <div class="col col-4">
                    <img class="company" src="../../images/3.png">
                </div>
            </div>
        </div>
        <div class="w3-container w3-margin-top">
            <h3>Contactos</h3>
        </div>
        <div class="w3-row-padding  w3-margin-bottom">
            <div class="row w3-large w3-center" style="margin:0px 0 80px 0">
                <div class="col col-4"><i class="fa fa-map-marker icone"></i> Rua da Tecnologia, Epsilon 2k, Tecnoparque da Lagoa, Lagoa, Açores</div>
                <div class="col col-4"><i class="fa fa-phone icone"></i><b> +135</b> 296 123 123</div>
                <div class="col col-4"><i class="fa fa-envelope icone"></i> verdemar@mail.com</div>
            </div>
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