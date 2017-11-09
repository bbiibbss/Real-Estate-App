<?php
   
    require_once("../../php/session.php");

    require_once('../../php/visitClass.php');
    $visit = new VISIT();
    
    require_once("../../php/userClass.php");
    $auth_user = new USER();
    
    require_once('../../php/propertyClass.php');
    $property = new Property();
    
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
        <a href="index.php" class="navBarItemHome"><i class="fa fa-bar-chart"></i></a>
        <a href="users.php" class="navBarItem">Utilizadores</a>
        <a href="properties.php" class="navBarItem">Propriedades</a>
        <a href="../../php/logout.php?logout=true" class="navBarItem navBarItemLogin">LogOut</a>
        <a href="javascript:void(0);" class="navBarItemHome icon" onclick="topNavFunction()"><i class="fa fa-bars"></i></a>
    </div>
   
    <div class="page">
         <div class="tab">
            <div class="row">
                <div class="col col-4">
                    <button class="tablinks" onclick="openFeaturedPropertyTab(event, 'hoje')" id="defaultOpen">Hoje</button>
                </div>
                <div class="col col-4">
                    <button class="tablinks" onclick="openFeaturedPropertyTab(event, 'imoveisPorLocalizacao')">
                    Imóveis por localização</button>
                </div>
                <div class="col col-4">
                    <button class="tablinks" onclick="openFeaturedPropertyTab(event, 'imoveisPorTipoPorPreco')">
                    Imóveis por tipo/ preço</button>
                </div>
            </div>
        </div>

        <div id="hoje" class="tabcontent">
            <div class="row">
                <?php echo($visit->getAllVisitsByManagerByDay($user_id)); ?>
            </div>
        </div>
        <div id="imoveisPorLocalizacao" class="tabcontent">
            <div class="row">
                <div class="col col-4">
                    <?php $property->getPropertiesNumberByIsland(); ?>
                </div>
                <div class="col col-4">
                    <?php $property->getPropertiesNumberByCounty(); ?>
                </div>
                <div class="col col-4">
                    <?php $property->getPropertiesNumberByParish(); ?>
                </div>
            </div>
        </div>
        <div id="imoveisPorTipoPorPreco" class="tabcontent">
            <div class="row">
                <div class="col col-6">
                    <?php $property->getPropertiesNumberByType(); ?>
                </div>
                <div class="col col-6">
                    <?php $property->getPropertiesNumberByRange(); ?>
                </div>
            </div>      
        </div>
        <script src='../../js/openFeaturedPropertyTab.js'></script>
        <script src='../../js/accordion.js'></script>
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