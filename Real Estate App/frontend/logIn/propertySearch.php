<?php
    require_once("../../php/session.php");
    
    require_once("../../php/userClass.php");
    $auth_user = new USER();

    require('../../php/propertyClass.php');
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
    <title>Propriedades</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/stylesheet.css">
    <link rel="stylesheet" href="../../css/gridStyle.css">
    <script type="text/javascript" src="../../js/topNav.js"></script>
    <script src='../../js/priceFilter.js'></script>
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
            <div class="col col-2 scrollmenu">
                <h3><i class="fa fa-search"></i> Pesquisa</h3>
                <br>
                <button class="accordion">Tipo de negócio:</button>
                <div class="panel">
                    <?php
                        $property->getBusinessTypeFilters();
                    ?>
                </div>
                <br>
                <button class="accordion">Tipo da propriedade:</button>
                <div class="panel">
                    <?php
                        $property->getPropertyTypeFilters();
                    ?>
                </div>
                <br>
                <button class="accordion">Tipologia da propriedade:</button>
                <div class="panel">
                    <?php
                        $property->getPropertyTypologyFilters();
                    ?> 
                </div>
                <br>
                <button class="accordion">Intervalo de preço:</button>
                <div class="panel">
                    Preço mínimo:<br>
                    <input onchange="filterSystem(<?php echo($property->minPrice());?>, <?php echo($property->maxPrice());?>);" type="number" id="minPrice" name="minPrice" value="" min="<?php echo($property->minPrice());?>" max="<?php echo($property->maxPrice());?>">
                    <br><br>
                    Preço máximo:<br>
                    <input onchange="filterSystem(<?php echo($property->minPrice());?>, <?php echo($property->maxPrice());?>);" type="number" id="maxPrice" name="maxPrice" value="" min="<?php echo($property->minPrice());?>" max="<?php echo($property->maxPrice());?>">
                    <br><br>
                </div>
                <br>
                <button class="accordion">Localização:</button>
                <div class="panel">
                    <button class="accordion">Ilha:</button>
                    <div class="panel">
                        <?php
                            $property->getIslandFilters();
                        ?> 
                    </div>
                    <button class="accordion">Concelho:</button>
                    <div class="panel">
                        <?php
                            $property->getCountyFilters();
                        ?>
                    </div>
                    <button class="accordion">Freguesia:</button>
                    <div class="panel">
                        <?php
                            $property->getParishFilters();
                        ?> 
                    </div>
                </div>
            </div>
       
            <!-- Page content -->
            <div class="w3-content col col-10" style="padding: 0 0 0 20px; margin-left: 20%">
                <div class="row">
                    <div class="col col-10">
                        <div id="map" style="width:100%;height:300px;">
                            <script>
                                function myMap() {
                                    var myCenter = new google.maps.LatLng(38.749397, -28.307904);
                                    var mapCanvas = document.getElementById("map");
                                    var mapOptions = {
                                        center: myCenter,
                                        zoom: 7,
                                        mapTypeId:google.maps.MapTypeId.HYBRID,
                                        overviewMapControl: true
                                    };
                                    var map = new google.maps.Map(mapCanvas, mapOptions);
                                    <?php
                                        $property->addGoogleMapsMarker();
                                    ?>
                                }
                            </script>
                            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAj28YGlN6ptMn2xZvYkdDnagqRW33LMO0&callback=myMap"></script>
                        </div>
                    </div>
                    <div class="col col-2">
                        <?php
                            $property->getLabels();
                        ?>
                    </div>
                    <div class="row" style="padding: 0 50px;">
                        <div class="col col-12">
                            <div class="w3-container w3-margin-top">
                                <h2>Propriedades</h2>
                                <hr>
                            </div>
                            <?php     
                                $property->getAllPropertiesLogin($user_id);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src='../../js/filters.js'></script>
    <script src='../../js/checkboxFilter.js'></script>
    <script src='../../js/accordion.js'></script>

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