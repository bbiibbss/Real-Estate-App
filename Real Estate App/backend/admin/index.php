<?php
   
    require_once("../../php/session.php");
    
    require_once("../../php/userClass.php");
    $auth_user = new USER();
    
    require('../../php/propertyClass.php');
    $property = new Property();

    require('../../php/salesClass.php');
    $sales = new SALES();
    
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
      <a href="managers.php" class="navBarItem">Gestores</a>
      <a href="properties.php" class="navBarItem">Propriedades</a>
      <a href="../../php/logout.php?logout=true" class="navBarItem navBarItemLogin">LogOut</a>
      <a href="javascript:void(0);" class="navBarItemHome icon" onclick="topNavFunction()"><i class="fa fa-bars"></i></a>
   </div>
   
    <div class="page">
        <div class="tab">
            <div class="row">
                <div class="col col-3">
                    <button class="tablinks" onclick="openFeaturedPropertyTab(event, 'balanco')" id="defaultOpen">Balanço</button>
                </div>
                <div class="col col-3">
                    <button class="tablinks" onclick="openFeaturedPropertyTab(event, 'vendasPorGestor')">Vendas por gestor</button>
                </div>
                <div class="col col-3">
                    <button class="tablinks" onclick="openFeaturedPropertyTab(event, 'imoveisPorLocalizacao')">
                    Imóveis por localização</button>
                </div>
                <div class="col col-3">
                    <button class="tablinks" onclick="openFeaturedPropertyTab(event, 'imoveisPorTipoPorPreco')">
                    Imóveis por tipo/ preço</button>
                </div>
            </div>
        </div>

        <div id="balanco" class="tabcontent">
            <div class="row">
                <div class="col col-6">
                    <div id="chart-container"></div>
                </div>
                <div class="col col-6">
                    <div id="chart-container1"></div>
                </div>
            </div>
            
            <script src="../../js/jquery-3.2.1.js"></script>
            <script src="../../js/fusioncharts.js"></script>
            <script src="../../js/fusioncharts.charts.js"></script>
            <script src="../../js/themes/fusioncharts.theme.ocean.js"></script>
            <script src="../../js/app.js"></script>
        </div>
        <div id="vendasPorGestor" class="tabcontent">
            <div class="row">
                <div class="col col-2">
                    <b>Gestor</b>
                </div>
                <div class="col col-7">
                    <b>Por Mes</b>
                </div>
                <div class="col col-1">
                    <b>Ano</b>
                </div>
                <div class='col col-1'>
                </div>
                <div class='col col-1'>
                </div>
            </div>
            <div class="row">
                <div class="col col-2">
                </div>
                <div class="col col-7">
                    <div class="col col-1">JAN</div>
                    <div class="col col-1">FEV</div>
                    <div class="col col-1">MAR</div>
                    <div class="col col-1">ABR</div>
                    <div class="col col-1">MAI</div>
                    <div class="col col-1">JUN</div>
                    <div class="col col-1">JUL</div>
                    <div class="col col-1">AGO</div>
                    <div class="col col-1">SET</div>
                    <div class="col col-1">OUT</div>
                    <div class="col col-1">NOV</div>
                    <div class="col col-1">DEZ</div>
                </div>
                <div class="col col-1">
                    <?php echo(date("Y")); ?>
                </div>
                <div class='col col-1'>
                </div>
                <div class='col col-1'>
                </div>
            </div>
            <div class="row">
                <?php $sales->getSalesByManager(); ?>
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